<?php

declare(strict_types=1);

namespace Inspira\Config;

use Dotenv\Dotenv;
use Throwable;

class Env
{
	private static Env $instance;

	/**
	 * @var null[]|string[] $data
	 */
	private array $data = [];

	public function __construct(protected string $path)
	{
		// Silently catch exception from missing .env file
		self::$instance = $this;
		try {
			self::$instance->data = Dotenv::createImmutable($path)->safeLoad();
		} catch (Throwable) { }
	}

	public static function getInstance(): Env
	{
		return self::$instance;
	}

	public static function get(string $key, mixed $default = null): mixed
	{
		return static::$instance?->data[$key] ?? $default;
	}

	public static function all(): array
	{
		return static::$instance?->data ?? [];
	}

	public static function set(string $key, mixed $value): void
	{
		static::$instance->data[$key] = $value;
	}
}
