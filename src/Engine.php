<?php
/**
 * Aura\View Laravel Engine
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
 * @category  View
 * @package   Jnjxl\View
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2015 Jake Johns
 * @license   http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link      http://jakejohns.net
 */


namespace Jnjxl\View;

use Illuminate\View\Engines\EngineInterface;
use Aura\View\View;

/**
 * Engine
 *
 * @category View
 * @package  Jnjxl\View
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/agpl-3.0.txt AGPL V3
 * @link     http://jakejohns.net
 *
 * @see EngineInterface
 */
class Engine implements EngineInterface
{
    /**
     * _view
     *
     * @var    Aura\View
     * @access private
     */
    private $_view;

    /**
     * __construct
     *
     * @param View $view Aura\View instance
     *
     * @access public
     */
    public function __construct(View $view)
    {
        $this->_view = $view;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param string $path full path to view
     * @param array  $data data for view
     *
     * @return string
     */
    public function get($path, array $data = array())
    {
        $registry = $this->_view->getViewRegistry();
        $registry->set('current-view', $path);

        $this->_view->addData($data);
        $this->_view->setView('current-view');
        return $this->_view->__invoke();
    }
}
