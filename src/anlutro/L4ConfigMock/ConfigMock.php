<?php
/**
 * Laravel 4 Config Mock
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   Laravel 4 Config Mock
 */

namespace anlutro\L4ConfigMock;

/**
 * The config mock class.
 */
class ConfigMock
{
	/**
	 * The config items.
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Construct the mock class.
	 *
	 * @param array $items Associative array of items to load into the config.
	 */
	public function __construct(array $items = array())
	{
		$this->items = $items;
	}

	/**
	 * Load a set of config items into the class.
	 *
	 * @param  mixed  $load    If an array, will load the items into the class.
	 * If a string, will assume it's a path to a config file, require that path
	 * and add it to the items.
	 * @param  string $package (optional) If set to vendor/package, it will
	 * prefix all item keys with vendor/package::
	 */
	public function load($load, $package = null)
	{
		if ($package) {
			$prefix = $package . '::';
		} else {
			$prefix = '';
		}

		if (is_array($load)) {
			$items = $load;
		} else {
			$items = require $load;

			if (strpos($load, 'config.php') === false) {
				$prefix .= basename($load, '.php') . '.';
			}
		}

		foreach ($items as $key => $item) {
			$this->items[$prefix.$key] = $item;
		}
	}

	/**
	 * Get a config item.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	public function get($key)
	{
		if (isset($this->items[$key]))
			return $this->items[$key];
		else
			return null;
	}

	/**
	 * Set a config item.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		$this->items[$key] = $value;
	}

	/**
	 * Check if an item exists in config.
	 *
	 * @param  string  $key
	 *
	 * @return boolean
	 */
	public function has($key)
	{
		return isset($this->items[$key]);
	}
}
