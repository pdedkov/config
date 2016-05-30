<?php
namespace Config;

class Object extends \stdClass {
	/**
	 * Настройки объекта по умолчанию
	 * @var array
	 */
	protected static $_defaults = [];

	/**
	 * Настройки объекта
	 * @var array
	 */
	protected $_config = [];

	public function __construct($namespace = null, $config = []) {
		$this->_config = $this->_config($namespace, $config);
	}

	/**
	 * Получение конфига
	 *
	 * @param string $field либо поле
	 * @return mixed либо значение поля, либо весь конфиг целиком
	 */
	public function config($field = null) {
		$value = $this->_config;
		if (!empty($field)) {
			$fields = explode('.', $field);

			for($i = 0; $i < count($fields); $i++) {
				$value = $value[$fields[$i]];
			}
		}

		return $value;
	}

	/**
	 * Конфигурируем наш объект
	 *
	 * @param string $namespace пространство имён текущего вызова
	 * @param array $config дополнительные опции
	 * @return array конфиг готовый
	 */
	protected function _config($namespace, $config) {
		// если конфига нет, то пытаемся его подгрузить
		if (!empty($namespace) && defined('APP') && class_exists("\Configure")) {
			$field = str_replace('\\', '.', $namespace);
			// подключаем конфиг
			$configured = \Configure::read($field);
			if (!empty($configured)) {
				$config = (empty($config)) ? $configured : Hash::merge($configured, $config);
			}
		}


		return (!empty($config)) ? Hash::merge(static::$_defaults, $config) : static::$_defaults;
	}
}