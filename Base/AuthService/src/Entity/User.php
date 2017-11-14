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

namespace Base\AuthService\Entity;

use Base\AuthService\ValueObject\ZoneInterface;
use Base\AuthService\Entity\UserIdentityInterface;
use Base\AuthService\Entity\UserProfileInterface;
use Base\Helper\DateTimeHelper;

/**
 * User Entity
 *
 * @package Base\AuthService\Entity
 */
class User implements UserInterface, \JsonSerializable
{
    /**
     * Active Status
     */
    const STATUS_ACTIVE = 'active';

    /**
     * Verify Pending Status
     */
    const STATUS_VERIFY_PENDING = 'verify_pending';

    /**
     * Disabled Status
     */
    const STATUS_DISABLED = 'disabled';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $tenantId;

    /**
     * @var ZoneInterface
     */
    protected $zone;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $tagLine;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $status = 'disabled';

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var \DateTime\null
     */
    protected $deletedAt = null;

    /**
     * @var UserIdentityInterface
     */
    protected $identity = null;

    /**
     * @var UseProfileInterface
     */
    protected $profile = null;

    /**
     * {@inheritdoc}
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTenantId(string $tenantId)
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setZone(ZoneInterface $zone)
    {
        $this->zone = $zone;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName(string $displayName = null)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTagLine(string $tagLine = null)
    {
        $this->tagLine = $tagLine;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatar(string $avatar = null)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentity(UserIdentityInterface $identity = null)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProfile(UserProfileInterface $profile = null)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    /**
     * {@inheritdoc}
     */
    public function getZone(): ZoneInterface
    {
        return $this->zone;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function getTagLine(): ?string
    {
        return $this->tagLine;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentity(): ?UserIdentityInterface
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getProfile(): ?UserProfileInterface
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusOptions(string $status = null)
    {
        $reflector = new \ReflectionClass(get_class($this));
        $constants = $reflector->getConstants();
        $result = [];
        foreach ($constants as $constant => $value) {
            if (!empty($status) && $constant == $status) {
                $result = $value;
                break;
            }
            $prefix = "STATUS_";
            if (strpos($constant, $prefix) !==false) {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(array $excludedAttributes = []): array
    {
        return array_diff_key([
            'id' => $this->id,
            'tenantId' => $this->tenantId,
            'zone' => (string) $this->zone,
            'email' => $this->email,
            'userName' => $this->userName,
            'displayName' => $this->displayName,
            'tagLine' => $this->tagLine,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'identity' => $this->identity ? $this->identity->toArray(['tenantId', 'userId']) : [],
            'profile' => $this->identity ? $this->profile->toArray(['tenantId', 'userId']): [],
            'createdAt' => DateTimeHelper::toISO8601($this->createdAt),
            'updatedAt' => DateTimeHelper::toISO8601($this->updatedAt)
        ], array_flip($excludedAttributes));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
