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

namespace Base\Helper;

use RuntimeException;

/**
 * Helper for converting UTC Time, Date Time Format with ISO 8601
 *
 * @package Base\Helper
 */
class DateTimeHelper
{
    const DB_DATETIME_FORMAT = 'Y-m-d H:i:s';

    const DB_DATE_FORMAT = 'Y-m-d';

    const DB_TIME_FORMAT = 'H:i:s';

    /**
     * Create a DateTime or Formatted DateTime value of now time based on the timezone
     *
     * This function could be used for creating the datetime for inserting to DB by using $now = DateTimeHelper::now(DateTimeHelper::DB_DATETIME_FORMAT);
     *
     * @param  string $timezone default value is UTC
     * @param  string $outputFormat
     * @return mixed The DateTime|Formatted DateTime
     */
    public static function now(string $timeZone = 'UTC', string $outputFormat = null)
    {
        try {
            $result = new \DateTime('now', new \DateTimeZone($timeZone));
            return ($outputFormat) ? $result->format($outputFormat) : $result;
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Create Now DateTime');
        }
    }

    /**
     * Create a DateTime from Db String Value
     *
     * This function could be used for creating the datetime for inserting to DB by using $now = DateTimeHelper::now(DateTimeHelper::DB_DATETIME_FORMAT);
     *
     * @param  string $value
     * @param  string $format
     * @return \DateTime
     */
    public static function createFromDb(string $value, string $format = self::DB_DATETIME_FORMAT)
    {
        try {
            $result = \DateTime::createFromFormat($format, $value);
            return $result;
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Create DateTime from Database Value');
        }
    }

    /**
     * Convert to Db Format
     *
     * @param   string|\DateTime $value
     * @param   string $inputFormat
     * @param   string $inputTimeZone
     * @return  string|null
     */
    public static function toDb($value, string $inputFormat = DATE_ATOM, string $inputTimeZone = 'UTC')
    {
        try {
            $result = null;
            if (empty($value)) {
                return $result;
            }
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
                return $result;
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert to Database Format');
        }
    }

    /**
     * Convert to ISO 8601 Format
     *
     * @param   string|\DateTime $value
     * @param   string $outputTimeZone
     * @param   string $inputFormat
     * @param   string $inputTimeZone
     * @return  string|null
     */
    public static function toISO8601($value, string $outputTimeZone = 'UTC', string $inputFormat = self::DB_DATETIME_FORMAT, string $inputTimeZone = 'UTC')
    {
        try {
            $result = null;
            if (empty($value)) {
                return $result;
            }
            if ($value instanceof \DateTime) {
                $result = $value;
            } elseif (is_string($value)) {
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
                return $result;
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert to ISO8601 Format');
        }
    }

    /**
     * Convert Date Time between formats
     *
     * @param  string $value
     * @param  string $fromFormat
     * @param  string $toFormat
     * @return string New format value
     */
    public function convertDateTimeFormat(string $value, string $fromFormat, string $toFormat)
    {
        try {
            $result = \DateTime::createFromFormat($fromFormat, $value);
            if ($result) {
                return $result->format($toFormat);
            }
        } catch (\Exception $e) {
            throw new RuntimeException('Could Not Convert DateTime Format');
        }
    }
}
