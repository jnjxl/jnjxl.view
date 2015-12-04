<?php
/**
 * Aura View for Laravel
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Service
 * @package   Jnjxl\View
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2015 Jake Johns
 * @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link      http://jakejohns.net
 */


namespace Jnjxl\View;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * ServiceProvider
 *
 * @category Service
 * @package  Jnjxl\View
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see ServiceProvider
 */
class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // Aura\Html helpers
        $app->singleton(
            'Aura\Html\HelperLocator',
            function () use ($app) {
                $factory = $app->make('Aura\Html\HelperLocatorFactory');
                return $factory->newInstance();
            }
        );

        // Aura\View instance
        $app->singleton(
            'Aura\View\View',
            function () use ($app) {
                $factory = $app->make('Aura\View\ViewFactory');
                $helpers = $app->make('Aura\Html\HelperLocator');
                $view = $factory->newInstance($helpers);

                $viewReg = $view->getViewRegistry();
                $layoutReg = $view->getLayoutRegistry();

                $viewReg->setPaths($app['config']['view.paths']);
                $layoutReg->setPaths($app['config']['view.paths']);

                return $view;
            }
        );

        // Resolver
        $app->resolving(
            'view',
            function ($view) use ($app) {
                $view->addExtension(
                    'php', 'aura',
                    function () use ($app) {
                        return new Engine($app->make('Aura\View\View'));
                    }
                );
            }
        );
    }
}
