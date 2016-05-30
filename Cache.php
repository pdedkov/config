<?php
namespace Config;

class Cache extends Singleton {
	protected static $_Instance = null;

	public static function getInstance() {
		if (is_null(self::$_Instance)) {
			$class = get_called_class();
			self::$_Instance = new $class(__NAMESPACE__);
		}

		return self::$_Instance;
	}

	public static function __callStatic($name, $arguments) {
		return call_user_func_array("\Cache::$name", $arguments);
	}
}