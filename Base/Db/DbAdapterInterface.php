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

namespace Base\Db;

/**
 * Database Adapter Interface
 *
 * Based on the main functions of PDO
 *
 * @package Base\Db
 */
interface DbAdapterInterface
{
    /**
     * Error Code
     *
     * @return mixed
     */
    public function errorCode();

    /**
     * Error Info
     *
     * @return mixed
     */
    public function errorInfo();

    /**
     * Exec
     *
     * @param  string $statement
     *
     * @return int number of rows were modified or deleted
     */
    public function exec(string $statement);

    /**
     * Select replicate Db and prepare the SQL
     * based on the selected Db connection
     *
     * @param  string $sql
     * @param  array|null  $options
     *
     * @return PDOStatement
     */
    public function prepare(string $statement, array $options = null);

    /**
     * Quote
     *
     * @param  string $string
     * @param  int $parameter_type
     *
     * @return string
     */
    public function quote(string $string, int $paramer_type = \PDO::PARAM_STR);

    /**
     * Query Data
     *
     * @param  string $statement
     *
     * @return PDOStatement|false
     */
    public function query(string $statement);

    /**
     * Get last Insert Id
     *
     * @param  string|null $name
     *
     * @return string
     */
    public function lastInsertId($name = null);

    /**
     * Initiates a transaction
     *
     * @return boolean
     */
    public function beginTransaction();

    /**
     * Commits a transaction
     *
     * @return boolean
     */
    public function commit();

    /**
     * Rolls back a transaction
     *
     * @return boolean
     */
    public function rollBack();

    /**
     * In a transaction
     *
     * @return boolean
     */
    public function inTransaction();
}
