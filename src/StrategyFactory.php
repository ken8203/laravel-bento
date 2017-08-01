<?php namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Custom;
use Illuminate\Support\Str;

class StrategyFactory
{
    /**
     * @var array
     */
    protected $customStrategies = [];

    /**
     * @param string $name
     * @param array ...$options
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    public function make($name, ...$options)
    {
        if (isset($this->customStrategies[$name])) {
            $customStrategy = $this->customStrategies[$name];

            return new Custom($customStrategy, $options);
        }

        $className = '\\Exolnet\\Bento\\Strategy\\'. Str::studly($name);

        return new $className(...$options);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function register($name, callable $callback)
    {
        $this->customStrategies[$name] = $callback;

        return $this;
    }
}