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

return \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
    $r->addRoute(['POST'], '/tenants/register', \Base\TenantService\Controller\Site\RegisterTenantAction::class.':'.'process');
    $r->addRoute(['POST'], '/system/apps/activate', \Base\AppService\Controller\System\ActivateAppAction::class.':'.'process');
});
