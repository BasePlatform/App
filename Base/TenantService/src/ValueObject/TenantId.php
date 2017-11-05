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

namespace Base\TenantService\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * TenantId ValueObject
 *
 * @package Base\TenantService\ValueObject
 */
class TenantId implements TenantIdInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $name = '', string $domain = ''): TenantIdInterface
    {
        if (!empty($name)) {
            return new self($name.$domain);
        } else {
            $uuid = Uuid::uuid4()->toString();
            return new self($uuid.$domain);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->id;
    }
}
