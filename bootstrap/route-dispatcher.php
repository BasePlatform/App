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
    $r->addRoute(['GET', 'POST'], '/tenants/register', \Base\TenantService\Controller\TenantController::class.':'.'register');
    $r->addRoute(['GET', 'POST'], '/system/apps/activate', \Base\TenantService\Controller\TenantController::class.':'.'activate');
    $r->addRoute(['GET'], '/admin/tenants/self/settings[/{group}]', \Base\TenantService\Controller\TenantAdminController::class.':'.'getSettings');
});
