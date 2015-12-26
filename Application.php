<?php

require_once('Context.php');

class Application {

	/**
	 * Application middlewares
	 *
	 * @var array
	 */
	protected $middlewares = array();

	/**
	 *
	 */
	public function __construct()
	{
		$this->context = $this->createContext();
	}

	/**
	 * Add a middleware
	 *
	 * @param Closure $callback Callback to be ran
	 * @return void
	 */
	public function middleware(Closure $callback)
	{
		$this->middlewares[] = $callback;

		return $this;
	}

	/**
	 * Runs all the middleware
	 *
	 * @return Application
	 */
	public function run()
	{
		$next = function() { };
		$middlewares = $this->middlewares;
		$i = count($middlewares);

		while ( $i-- ) {
			$binded = Closure::bind($middlewares[$i], $this->context);
			$next = function() use ($binded, $next) {
				$binded($next);
			};
		}

		return $next();
	}

	/**
	 * Creates a new context. Put to its own method for overridability
	 *
	 * @return Context
	 */
	protected function createContext()
	{
		return new Context();
	}

}