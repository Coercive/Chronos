<?php
namespace Coercive\Utility\Chronos;

/**
 * Chronos
 *
 * @package 	Coercive\Utility\Chronos
 * @link		https://github.com/Coercive/Chronos
 *
 * @author  	Anthony Moral <contact@coercive.fr>
 * @copyright   2018 Anthony Moral
 * @license 	MIT
 */
class Chronos
{
	# Full monitoring datas
	static private $datas = [];

	/**
	 * The current Apache env request time
	 *
	 * @return float
	 */
	static public function getServerRequestTime(): float
	{
		return floatval($_SERVER['REQUEST_TIME_FLOAT'] ?? 0);
	}

	/**
	 * The current request time
	 *
	 * @return float
	 */
	static public function getCurrentRequestTime(): float
	{
		return microtime(true) - self::getServerRequestTime();
	}

	/**
	 * Monitor start
	 *
	 * @param string $name
	 * @return array
	 */
	static public function start(string $name): array
	{
		return self::$datas[$name] = [
			'name' => $name,
			'time_start' => self::getCurrentRequestTime(),
			'memory_start' => memory_get_usage(true),
			'laps' => []
		];
	}

	/**
	 * Monitor stop
	 *
	 * @param string $name
	 * @return array
	 */
	static public function stop(string $name): array
	{
		self::$datas[$name]['time_stop'] = self::getCurrentRequestTime();
		self::$datas[$name]['memory_stop'] = memory_get_usage(true);
		return self::$datas[$name];
	}

	/**
	 * Monitor add lap
	 *
	 * @param string $name
	 * @param string $message [optional]
	 * @return array
	 */
	static public function lap(string $name, string $message = ''): array
	{
		self::$datas[$name]['laps'][] = [
			'time' => self::getCurrentRequestTime(),
			'memory' => memory_get_usage(true),
			'message' => $message
		];
		return self::$datas[$name];
	}

	/**
	 * Diff one item or all process
	 *
	 * @param string $name
	 * @return array
	 */
	static public function diff(string $name = ''): array
	{
		# No elements
		if(!count(self::$datas)) {
			return [
				'time' => 0,
				'memory' => 0
			];
		}

		# Diff all the process
		if(!$name) {
			foreach (self::$datas as $first) { break; }
			foreach (self::$datas as $last) {}

			$start_time = $first['time_start'] ?? 0;
			$start_memory = $first['memory_start'] ?? 0;
			$stop_time = $last['time_stop'] ?? 0;
			$stop_memory = $last['memory_stop'] ?? 0;
		}
		else {
			$start_time = self::$datas[$name]['time_start'] ?? 0;
			$start_memory = self::$datas[$name]['memory_start'] ?? 0;
			$stop_time = self::$datas[$name]['time_stop'] ?? 0;
			$stop_memory = self::$datas[$name]['memory_stop'] ?? 0;
		}

		$time = $stop_time - $start_time;
		$memory = $stop_memory - $start_memory;

		return [
			'time' => $time > 0 ? $time : 0,
			'memory' => $memory > 0 ? $memory : 0
		];
	}

	/**
	 * Get one or all items
	 *
	 * @param string $name
	 * @return array
	 */
	static public function get(string $name = ''): array
	{
		return $name ? (self::$datas[$name] ?? []) : self::$datas;
	}
}