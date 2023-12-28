<?php

declare(strict_types=1);

namespace Inspira\Config;

class Config
{
	private static Config $instance;

	/**
	 * @var null[]|string[] $data
	 */
	protected array $data = [];

	public function __construct(protected string $path)
	{
		self::$instance = $this;
		self::$instance->load();
	}

	public static function getInstance(): Config
	{
		return self::$instance;
	}

	public static function get(string $key, mixed $default = null): mixed
	{
		return static::$instance?->read(static::$instance->data, $key, $default);
	}

	public static function all(): array
	{
		return static::$instance?->data ?? [];
	}

	public static function set(string $key, mixed $value): void
	{
		static::$instance->data[$key] = $value;
	}

	private function read(array $data, string $key, mixed $default = null)
	{
		$keys = explode('.', $key);

		foreach ($keys as $key) {
			if (isset($data[$key])) {
				$data = $data[$key];
			} else {
				return $default;
			}
		}

		return $data;
	}

	private function load(): void
	{
		$files = glob($this->path . '/*.php');

		foreach ($files as $file) {
			$filename = pathinfo($file, PATHINFO_FILENAME);
			$configs[$filename] = require $file;
		}

		self::$instance->data = $configs ?? [];
	}
}
