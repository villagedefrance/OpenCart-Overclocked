<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_CachedObjectStorage
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    v1.8.1, released: 01-05-2015
 * @edition     Overclocked Edition
 */

/**
 * PHPExcel_CachedObjectStorageFactory
 *
 * @category    PHPExcel
 * @package     PHPExcel_CachedObjectStorage
 * @copyright    Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_CachedObjectStorageFactory {
    const CACHEINMEMORY = 'Memory';
    const CACHEINMEMORYGZIP = 'MemoryGZip';
    const CACHEINMEMORYSERIALIZED = 'MemorySerialized';
    const CACHEIGBINARY = 'Igbinary';
    const CACHETODISCISAM = 'DiscISAM';
    const CACHETOAPC = 'APC';
    const CACHETOMEMCACHE = 'Memcache';
    const CACHETOPHPTEMP = 'PHPTemp';
    const CACHETOWINCACHE = 'Wincache';
    const CACHETOSQLITE = 'SQLite';
    const CACHETOSQLITE3 = 'SQLite3';

    /**
     * Name of the method used for cell cacheing
     *
     * @var string
     */
    private static $_cacheStorageMethod = null;

    /**
     * Name of the class used for cell cacheing
     *
     * @var string
     */
    private static $_cacheStorageClass = null;

    /**
     * List of all possible cache storage methods
     *
     * @var string[]
     */
    private static $_storageMethods = array(
        self::CACHEINMEMORY,
        self::CACHEINMEMORYGZIP,
        self::CACHEINMEMORYSERIALIZED,
        self::CACHEIGBINARY,
        self::CACHETOPHPTEMP,
        self::CACHETODISCISAM,
        self::CACHETOAPC,
        self::CACHETOMEMCACHE,
        self::CACHETOWINCACHE,
        self::CACHETOSQLITE,
        self::CACHETOSQLITE3
    );

    /**
     * Default arguments for each cache storage method
     *
     * @var array of mixed array
     */
    private static $_storageMethodDefaultParameters = array(
        self::CACHEINMEMORY => array(),
        self::CACHEINMEMORYGZIP => array(),
        self::CACHEINMEMORYSERIALIZED => array(),
        self::CACHEIGBINARY => array(),
        self::CACHETOPHPTEMP => array('memoryCacheSize' => '1MB'),
        self::CACHETODISCISAM => array('dir' => null),
        self::CACHETOAPC => array('cacheTime' => 600),
        self::CACHETOMEMCACHE => array('memcacheServer' => 'localhost', 'memcachePort' => 11211, 'cacheTime' => 600),
        self::CACHETOWINCACHE => array('cacheTime' => 600),
        self::CACHETOSQLITE => array(),
        self::CACHETOSQLITE3 => array()
    );

    /**
     * Arguments for the active cache storage method
     *
     * @var array of mixed array
     */
    private static $_storageMethodParameters = array();

    /**
     * Return the current cache storage method
     *
     * @return string|NULL
     **/
    public static function getCacheStorageMethod() {
        return self::$_cacheStorageMethod;
    }

    /**
     * Return the current cache storage class
     *
     * @return PHPExcel_CachedObjectStorage_ICache|NULL
     **/
    public static function getCacheStorageClass() {
        return self::$_cacheStorageClass;
    }

    /**
     * Return the list of all possible cache storage methods
     *
     * @return string[]
     **/
    public static function getAllCacheStorageMethods() {
        return self::$_storageMethods;
    }

    /**
     * Return the list of all available cache storage methods
     *
     * @return string[]
     **/
    public static function getCacheStorageMethods() {
        $activeMethods = array();

        foreach(self::$_storageMethods as $storageMethod) {
            $cacheStorageClass = 'PHPExcel_CachedObjectStorage_' . $storageMethod;

            if (call_user_func(array($cacheStorageClass, 'cacheMethodIsAvailable'))) {
                $activeMethods[] = $storageMethod;
            }
        }

        return $activeMethods;
    }

    /**
     * Identify the cache storage method to use
     *
     * @param    string            $method        Name of the method to use for cell cacheing
     * @param    array of mixed    $arguments    Additional arguments to pass to the cell caching class
     *                                        when instantiating
     * @return boolean
     **/
    public static function initialize($method = self::CACHEINMEMORY, $arguments = array()) {
        if (!in_array($method, self::$_storageMethods)) {
            return false;
        }

        $cacheStorageClass = 'PHPExcel_CachedObjectStorage_' . $method;

        if (!call_user_func(array($cacheStorageClass, 'cacheMethodIsAvailable'))) {
            return false;
        }

        self::$_storageMethodParameters[$method] = self::$_storageMethodDefaultParameters[$method];

        foreach($arguments as $k => $v) {
            if (array_key_exists($k, self::$_storageMethodParameters[$method])) {
                self::$_storageMethodParameters[$method][$k] = $v;
            }
        }

        if (self::$_cacheStorageMethod === null) {
            self::$_cacheStorageClass = 'PHPExcel_CachedObjectStorage_' . $method;
            self::$_cacheStorageMethod = $method;
        }

        return true;
    }

    /**
     * Initialise the cache storage
     *
     * @param    PHPExcel_Worksheet     $parent        Enable cell caching for this worksheet
     * @return    PHPExcel_CachedObjectStorage_ICache
     **/
    public static function getInstance(PHPExcel_Worksheet $parent) {
        $cacheMethodIsAvailable = true;

        if (self::$_cacheStorageMethod === null) {
            $cacheMethodIsAvailable = self::initialize();
        }

        if ($cacheMethodIsAvailable) {
            $instance = new self::$_cacheStorageClass($parent, self::$_storageMethodParameters[self::$_cacheStorageMethod]);

            if ($instance !== null) {
                return $instance;
            }
        }

        return false;
    }

    /**
     * Clear the cache storage
     *
     **/
	public static function finalize() {
		self::$_cacheStorageMethod = null;
		self::$_cacheStorageClass = null;
		self::$_storageMethodParameters = array();
	}
}
