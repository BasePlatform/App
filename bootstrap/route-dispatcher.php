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
  $r->addRoute(['GET'], '/tenants/register', \Base\TenantService\Controller\Tenant\TenantController::class.':'.'register');
  $r->addRoute(['GET'], '/admin/tenants/self/settings[/{group}]', \Base\TenantService\Controller\Tenant\TenantAdminController::class.':'.'getSettings');
});