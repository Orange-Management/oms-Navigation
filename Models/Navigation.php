<?php
/**
 * Orange Management
 *
 * PHP Version 7.0
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Modules\Navigation\Models;

use phpOMS\DataStorage\Database\Pool;
use phpOMS\Message\RequestAbstract;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Navigation
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Navigation
{

    /**
     * Navigation array.
     *
     * Array of all navigation elements sorted by type->parent->id
     *
     * @var array
     * @since 1.0.0
     */
    private $nav = [];

    /**
     * Singleton instance.
     *
     * @var \Modules\Navigation\Models\Navigation
     * @since 1.0.0
     */
    private static $instance = null;

    /**
     * Database pool.
     *
     * @var Pool
     * @since 1.0.0
     */
    private $dbPool = null;

    /**
     * Constructor.
     *
     * @param RequestAbstract $request Request hashes
     * @param Pool            $dbPool  Database pool
     *
     * @since  1.0.0
     * @author Dennis Eichhorn <d.eichhorn@oms.com>
     */
    private function __construct(RequestAbstract $request, Pool $dbPool = null)
    {
        $this->dbPool = $dbPool;
        $this->load($request->getHash());
    }

    /**
     * Load navigation based on request.
     *
     * @param \string[] $request Request hashes
     *
     * @return void
     *
     * @since  1.0.0
     * @author Dennis Eichhorn <d.eichhorn@oms.com>
     */
    private function load($request)
    {
        if (empty($this->nav)) {
            $this->nav = [];
            $uriPdo    = '';

            $i = 1;
            foreach ($request as $hash) {
                $uriPdo .= ':pid' . $i . ',';
                $i++;
            }

            $uriPdo = rtrim($uriPdo, ',');
            $sth    = $this->dbPool->get('core')->con->prepare('SELECT * FROM `' . $this->dbPool->get('core')->prefix . 'nav` WHERE `nav_pid` IN(' . $uriPdo . ') ORDER BY `nav_order` ASC');

            $i = 1;
            foreach ($request as $hash) {
                $sth->bindValue(':pid' . $i, $hash, \PDO::PARAM_STR);
                $i++;
            }

            $sth->execute();
            $tempNav = $sth->fetchAll();

            foreach ($tempNav as $link) {
                $this->nav[$link['nav_type']][$link['nav_subtype']][$link['nav_id']] = $link;
            }
        }
    }

    /**
     * Get instance.
     *
     * @param RequestAbstract $request Request hashes
     * @param Pool            $dbPool  Database pool
     *
     * @return \Modules\Navigation\Models\Navigation
     *
     * @since  1.0.0
     * @author Dennis Eichhorn <d.eichhorn@oms.com>
     */
    public static function getInstance(RequestAbstract $request = null, Pool $dbPool = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($request, $dbPool);
        }

        return self::$instance;
    }

    /**
     * Overwriting clone in order to maintain singleton pattern.
     *
     * @since  1.0.0
     * @author Dennis Eichhorn <d.eichhorn@oms.com>
     */
    public function __clone()
    {
    }

    public function getNav()
    {
        return $this->nav;
    }
}
