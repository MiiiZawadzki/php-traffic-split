<?php

namespace Src\Infrastructure\DependencyInjection;

use Closure;
use Exception;

class Container
{
    private array $bindings = [];
    private static ?self $instance = null;

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param Closure $resolver
     * @return void
     */
    public function bind(string $key, Closure $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function make(string $key)
    {
        if (!isset($this->bindings[$key])) {
            throw new Exception("No binding found for {$key}");
        }

        return $this->bindings[$key]($this);
    }
}
