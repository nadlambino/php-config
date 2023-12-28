<?php

namespace Inspira\Config;

if (!function_exists('config')) {
	/**
	 * @template T
	 * @param string|null $key
	 * @param T|null $default
	 * @return T
	 */
	function config(?string $key = null, mixed $default = null): mixed
	{
		if (is_null($key)) {
			return Config::getInstance();
		}

		return Config::get($key, $default);
	}
}

if (!function_exists('env')) {
	/**
	 * @template T
	 * @param string|null $key
	 * @param T|null $default
	 * @return T
	 */
	function env(?string $key = null, mixed $default = null): mixed
	{
		if (is_null($key)) {
			return Env::getInstance();
		}

		return Env::get($key, $default);
	}
}
