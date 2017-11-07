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

namespace Base\Formatter;

use RuntimeException;

/**
 * Formatter for converting UTC Time, Date Time Format with ISO 8601
 *
 * @package Base\Formatter
 */
class DateTimeFormatter
{
    const DB_DATETIME_FORMAT = 'Y-m-d H:i:s';

    const DB_DATE_FORMAT = 'Y-m-d';

    const DB_TIME_FORMAT = 'H:i:s';

    /**
     * Create a DateTime or Formatted DateTime value of now time based on the timezone
     *
     * This function could be used for creating the datetime for inserting to DB by using $now = DateTimeFormatter::now(DateTimeFormatter::DB_DATETIME_FORMAT);
     *
     * @param  string $outputFormat
     * @param  string $timezone default value is UTC
     * @return mixed The DateTime|Formatted DateTime
     */
    public static function now(string $outputFormat = null, string $timeZone = 'UTC')
    {
        try {
            $result = new \DateTime('now', new \DateTimeZone($timeZone));
            return ($outputFormat) ? $result->format($outputFormat) : $result;
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Create Now DateTime - Check Timezone Value or Output Format');
        }
    }

    /**
     * Create a DateTime or Formatted DateTime value of now time based on the timezone
     *
     * This function could be used for creating the datetime for inserting to DB by using $now = DateTimeFormatter::now(DateTimeFormatter::DB_DATETIME_FORMAT);
     *
     * @param  string $value
     * @return \DateTime
     */
    public static function createFromDb(string $value, string $type = 'datetime')
    {
        try {
            switch ($type) {
                case 'date':
                    $type = self::DB_DATE_FORMAT;
                    break;
                case 'time':
                    $type = self::DB_TIME_FORMAT;
                    break;
                default:
                    $type = self::DB_DATETIME_FORMAT;
                    break;
            }
            $result = \DateTime::createFromFormat($type, $value);
            return $result;
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Create DateTime from DB Value');
        }
    }

    /**
     * Convert to Db Format
     *
     * @param   string|\DateTime $value
     * @param   string $inputFormat
     * @param   string $inputTimeZone
     * @return  string
     */
    public static function toDb($value, string $inputFormat = DATE_ATOM, string $inputTimeZone = 'UTC')
    {
        try {
            $result = null;
            if ($value instanceof \DateTime) {
                $result = $value;
            } elseif (is_string($value) && !empty($value)) {
                if ($inputFormat == DATE_ATOM) {
                    $result = \DateTime::createFromFormat($inputFormat, $value);
                } else {
                    $result = \DateTime::createFromFormat($inputFormat, $value, new \DateTimeZone($inputTimeZone));
                }
            }
            if ($result) {
                $result->setTimeZone(new \DateTimeZone('UTC'));
                return $result->format(self::DB_DATETIME_FORMAT);
            } else {
                throw new RuntimeException('Invalid DateTime Input Value');
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert to DB Format');
        }
    }

    /**
     * Convert to ISO 8601 Format
     *
     * @param   string|\DateTime $value
     * @param   string $outputTimeZone
     * @param   string $inputFormat
     * @param   string $inputTimeZone
     * @return  string
     */
    public static function toISO8601($value, string $outputTimeZone = 'UTC', string $inputFormat = null, string $inputTimeZone = 'UTC')
    {
        try {
            $result = null;
            if ($value instanceof \DateTime) {
                $result = $value;
            } elseif (is_string($value) && !empty($value)) {
                if (!$inputFormat) {
                    $inputFormat = self::DB_DATETIME_FORMAT;
                }
                if ($inputFormat == DATE_ATOM) {
                    $result = \DateTime::createFromFormat($inputFormat, $value);
                } else {
                    $result = \DateTime::createFromFormat($inputFormat, $value, new \DateTimeZone($inputTimeZone));
                }
            }
            if ($result) {
                $result->setTimeZone(new \DateTimeZone($outputTimeZone));
                return $result->format(DATE_ATOM);
            } else {
                throw new RuntimeException('Invalid DateTime Input Value');
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert to ISO8601 Format');
        }
    }

    /**
     * Convert Date Time between formats
     *
     * @param  string $value
     * @param  string $from Old format
     * @param  string $to New format
     * @return string New format value
     */
    public function convertDateTimeFormat(string $value, string $from, string $to)
    {
        try {
            $myDateTime = \DateTime::createFromFormat($from, $value);
            if ($myDateTime) {
                return $myDateTime->format($to);
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert DateTime from DB Format to ISO8601');
        }
    }
}
