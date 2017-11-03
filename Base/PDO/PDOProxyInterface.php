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

namespace Base\PDO;

use \PDO as PDO;

/**
 * PDO Proxy Interface
 *
 * @package Base\PDO
 */
interface PDOProxyInterface
{
    /**
     * Select replicate Db and prepare the SQL
     * based on the selected Db connection
     *
     * @param  string $sql
     * @return PDOStatement
     */
    public function prepare(string $sql);

    /**
     * Query Data
     *
     * @param  string $sql
     * @param  array $params
     *
     * @return PDOStatement|false
     */
    public function query(string $sql, array $params = []);
}
