<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\Navigation\Views
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Modules\Navigation\Views;

use phpOMS\Views\View;

/**
 * Navigation view.
 *
 * @package    Modules\Navigation\Views
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class NavigationView extends View
{

    /**
     * Navigation Id.
     *
     * This is getting used in order to identify which navigation elements should get rendered.
     * This usually is the parent navigation id
     *
     * @var int
     * @since 1.0.0
     */
    protected $navId = 0;

    /**
     * Navigation.
     *
     * @var mixed[]
     * @since 1.0.0
     */
    protected $nav = [];

    /**
     * Parent element used for navigation.
     *
     * @var int
     * @since 1.0.0
     */
    protected $parent = 0;

    /**
     * Get navigation Id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getNavId() : int
    {
        return $this->navId;
    }

    /**
     * Set navigation Id.
     *
     * @param int $navId Navigation id used for display
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setNavId(int $navId) : void
    {
        $this->navId = $navId;
    }

    /**
     * @return array
     *
     * @since  1.0.0
     */
    public function getNav() : array
    {
        return $this->nav;
    }

    /**
     * @param mixed $nav
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setNav(array $nav) : void
    {
        $this->nav = $nav;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getParent() : int
    {
        return $this->parent;
    }

    /**
     * @param int $parent
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setParent(int $parent) : void
    {
        $this->parent = $parent;
    }
}
