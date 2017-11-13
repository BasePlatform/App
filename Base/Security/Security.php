<?php
/*
 * This file is part of the BasePlatform project.
 *
 * @link https://github.com/BasePlatform
 * @license https://github.com/BasePlatform/Base/blob/master/LICENSE.txt
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Base\Security;

use InvalidArgumentException;

/**
 * Security Class
 *
 * This class uses the security implementation of Yii Framework
 * Source: https://github.com/yiisoft/yii2/blob/master/framework/base/Security.php
 *
 * @package Base\Security
 */
class Security implements SecurityInterface
{
    const DEFAULT_PASSWORD_HASH_COST = 13;

    /**
     * @var int Default cost used for password hashing.
     * Allowed value is between 4 and 31.
     * @see generatePasswordHash()
     * @since 2.0.6
     */
    public $passwordHashCost;

    private $_useLibreSSL;

    private $_randomFile;

    /**
     * @param string $zoneId
     */
    public function __construct(int $passwordHashCost = null)
    {
        if (!$passwordHashCost) {
            $this->passwordHashCost = self::DEFAULT_PASSWORD_HASH_COST;
        } else {
            $this->passwordHashCost = $passwordHashCost;
        }
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * The PHP [crypt()](http://php.net/manual/en/function.crypt.php) built-in function
     * requires, for the Blowfish hash algorithm, a salt string in a specific format:
     * "$2a$", "$2x$" or "$2y$", a two digit cost parameter, "$", and 22 characters
     * from the alphabet "./0-9A-Za-z".
     *
     * @param int $cost the cost parameter
     * @return string the random salt value.
     * @throws InvalidArgumentException if the cost parameter is out of the range of 4 to 31.
     */
    protected function generateSalt(int $cost = 13): string
    {
        $cost = (int) $cost;
        if ($cost < 4 || $cost > 31) {
            throw new \InvalidArgumentException('Cost Must Be Between 4 and 31');
        }
        // Get a 20-byte random string
        $rand = $this->generateRandomKey(20);
        // Form the prefix that specifies Blowfish (bcrypt) algorithm and cost parameter.
        $salt = sprintf('$2y$%02d$', $cost);
        // Append the random salt data in the required base64 format.
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));
        return $salt;
    }

    /**
     * {@inheritdoc}
     */
    public function generateRandomKey(int $length = 32): string
    {
        if (!is_int($length)) {
            throw new \InvalidArgumentException('First Parameter ($length) Must Be An Integer');
        }
        if ($length < 1) {
            throw new \InvalidArgumentException('First Parameter ($length) Must Be Greater Than 0');
        }
        // always use random_bytes() if it is available
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        }
        // The recent LibreSSL RNGs are faster and likely better than /dev/urandom.
        // Parse OPENSSL_VERSION_TEXT because OPENSSL_VERSION_NUMBER is no use for LibreSSL.
        // https://bugs.php.net/bug.php?id=71143
        if ($this->_useLibreSSL === null) {
            $this->_useLibreSSL = defined('OPENSSL_VERSION_TEXT')
                && preg_match('{^LibreSSL (\d\d?)\.(\d\d?)\.(\d\d?)$}', OPENSSL_VERSION_TEXT, $matches)
                && (10000 * $matches[1]) + (100 * $matches[2]) + $matches[3] >= 20105;
        }
        // Since 5.4.0, openssl_random_pseudo_bytes() reads from CryptGenRandom on Windows instead
        // of using OpenSSL library. LibreSSL is OK everywhere but don't use OpenSSL on non-Windows.
        if ($this->_useLibreSSL
            || (
                DIRECTORY_SEPARATOR !== '/'
                && substr_compare(PHP_OS, 'win', 0, 3, true) === 0
                && function_exists('openssl_random_pseudo_bytes')
            )
        ) {
            $key = openssl_random_pseudo_bytes($length, $cryptoStrong);
            if ($cryptoStrong === false) {
                throw new \Exception(
                    'openssl_random_pseudo_bytes() Set $crypto_strong False. PHP Setup Is Insecure'
                );
            }
            if ($key !== false && $this->byteLength($key) === $length) {
                return $key;
            }
        }
        // mcrypt_create_iv() does not use libmcrypt. Since PHP 5.3.7 it directly reads
        // CryptGenRandom on Windows. Elsewhere it directly reads /dev/urandom.
        if (function_exists('mcrypt_create_iv')) {
            $key = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($this->byteLength($key) === $length) {
                return $key;
            }
        }
        // If not on Windows, try to open a random device.
        if ($this->_randomFile === null && DIRECTORY_SEPARATOR === '/') {
            // urandom is a symlink to random on FreeBSD.
            $device = PHP_OS === 'FreeBSD' ? '/dev/random' : '/dev/urandom';
            // Check random device for special character device protection mode. Use lstat()
            // instead of stat() in case an attacker arranges a symlink to a fake device.
            $lstat = @lstat($device);
            if ($lstat !== false && ($lstat['mode'] & 0170000) === 020000) {
                $this->_randomFile = fopen($device, 'rb') ?: null;
                if (is_resource($this->_randomFile)) {
                    // Reduce PHP stream buffer from default 8192 bytes to optimize data
                    // transfer from the random device for smaller values of $length.
                    // This also helps to keep future randoms out of user memory space.
                    $bufferSize = 8;
                    if (function_exists('stream_set_read_buffer')) {
                        stream_set_read_buffer($this->_randomFile, $bufferSize);
                    }
                    // stream_set_read_buffer() isn't implemented on HHVM
                    if (function_exists('stream_set_chunk_size')) {
                        stream_set_chunk_size($this->_randomFile, $bufferSize);
                    }
                }
            }
        }
        if (is_resource($this->_randomFile)) {
            $buffer = '';
            $stillNeed = $length;
            while ($stillNeed > 0) {
                $someBytes = fread($this->_randomFile, $stillNeed);
                if ($someBytes === false) {
                    break;
                }
                $buffer .= $someBytes;
                $stillNeed -= $this->byteLength($someBytes);
                if ($stillNeed === 0) {
                    // Leaving file pointer open in order to make next generation faster by reusing it.
                    return $buffer;
                }
            }
            fclose($this->_randomFile);
            $this->_randomFile = null;
        }
        throw new \Exception('Unable To Generate A Random Key');
    }

    /**
     * {@inheritdoc}
     */
    public function generateRandomString(int $length = 32): string
    {
        if (!is_int($length)) {
            throw new InvalidArgumentException('First Parameter ($length) Must Be An Integer');
        }
        if ($length < 1) {
            throw new InvalidArgumentException('First Parameter ($length) Must Be Greater Than 0');
        }
        $bytes = $this->generateRandomKey($length);
        return substr($this->base64UrlEncode($bytes), 0, $length);
    }

    /**
     * Returns the number of bytes in the given string.
     * This method ensures the string is treated as a byte array by using `mb_strlen()`.
     * @param string $string the string being measured for length
     * @return int the number of bytes in the given string.
     */
    protected function byteLength(string $string)
    {
        return mb_strlen($string, '8bit');
    }

    /**
     * Encodes string into "Base 64 Encoding with URL and Filename Safe Alphabet" (RFC 4648).
     *
     * > Note: Base 64 padding `=` may be at the end of the returned string.
     * > `=` is not transparent to URL encoding.
     *
     * @see https://tools.ietf.org/html/rfc4648#page-7
     * @param string $input the string to encode.
     * @return string encoded string.
     * @since 2.0.12
     */
    protected function base64UrlEncode(string $input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    /**
     * Performs string comparison using timing attack resistant approach.
     * @see http://codereview.stackexchange.com/questions/13512
     * @param string $expected string to compare.
     * @param string $actual user-supplied string.
     * @return bool whether strings are equal.
     */
    protected function compareString(string $expected, string $actual)
    {
        $expected .= "\0";
        $actual .= "\0";
        $expectedLength = $this->byteLength($expected);
        $actualLength = $this->byteLength($actual);
        $diff = $expectedLength - $actualLength;
        for ($i = 0; $i < $actualLength; $i++) {
            $diff |= (ord($actual[$i]) ^ ord($expected[$i % $expectedLength]));
        }
        return $diff === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePasswordHash(string $password, int $cost = null): string
    {
        if ($cost === null) {
            $cost = $this->passwordHashCost;
        }
        if (function_exists('password_hash')) {
            /* @noinspection PhpUndefinedConstantInspection */
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
        }
        $salt = $this->generateSalt($cost);
        $hash = crypt($password, $salt);
        // strlen() is safe since crypt() returns only ascii
        if (!is_string($hash) || strlen($hash) !== 60) {
            throw new \RuntimeException('Unknown Error Occurred While Generating Hash');
        }
        return $hash;
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword(string $password, string $hash): bool
    {
        if (!is_string($password) || $password === '') {
            throw new InvalidArgumentException('Password Must Be A String And Not Empty');
        }
        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            throw new InvalidArgumentException('Hash Is Invalid');
        }
        if (function_exists('password_verify')) {
            return password_verify($password, $hash);
        }
        $test = crypt($password, $hash);
        $n = strlen($test);
        if ($n !== 60) {
            return false;
        }
        return $this->compareString($test, $hash);
    }
}
