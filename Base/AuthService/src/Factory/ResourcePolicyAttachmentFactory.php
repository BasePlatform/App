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

namespace Base\AuthService\Factory;

use Base\Factory\FactoryInterface;
use Base\AuthService\Entity\ResourcePolicyAttachmentInterface;

/**
 * Resource Policy Attachment Factory
 *
 * @package Base\AuthService\Factory
 */
class ResourcePolicyAttachmentFactory implements ResourcePolicyAttachmentFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     * @param FactoryInterface $variantFactory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return ResourcePolicyAttachmentInterface
     */
    public function createNew(): ResourcePolicyAttachmentInterface
    {
        return $this->factory->createNew();
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return $this->factory->getClassName();
    }
}