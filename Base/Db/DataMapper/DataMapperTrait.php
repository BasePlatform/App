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

namespace Base\DataMapper;

use Base\Db\DbAdapterInterface;

/**
 * Data Mapper Trait
 *
 * @package Base\Db\DataMapper
 */
trait DataMapperTrait
{
    /**
     * @var string
     */
    protected $entityInterface;

    /**
     * @var DbAdapterInterface
     */
    protected $dbAdapter;

    /**
     * {@inheritdoc}
     */
    public function getEntityInterface(): string
    {
        return $this->entityInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function getDbAdapter(): DbAdapterInterface
    {
        return $this->dbAdapter;
    }
}
