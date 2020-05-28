<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Command;

use Zend\Stdlib\Parameters;
use ZF\Console\Route;
use ZFrapidCore\Task\TaskInterface;
use ZFrapidCore\Console\ConsoleInterface;

/**
 * Class AbstractCommand
 *
 * @package ZFrapidCore\Command
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var ConsoleInterface
     */
    protected $console;

    /**
     * @var Route
     */
    protected $route;

    /**
     * @var Parameters
     */
    protected $params;

    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * Start command processing
     *
     * @param Route            $route
     * @param ConsoleInterface $console
     *
     * @return integer
     */
    public function __invoke(Route $route, ConsoleInterface $console)
    {
        $this->route   = $route;
        $this->console = $console;
        $this->params  = new Parameters();

        $this->startCommand();

        if (!$this->processTasks()) {
            return 1;
        }

        $this->stopCommand();

        return 0;
    }

    /**
     * Process command tasks
     */
    public function processTasks()
    {
        /** @var TaskInterface $task */
        foreach ($this->tasks as $task) {
            $callable = new $task();

            $result = call_user_func(
                $callable, $this->route, $this->console, $this->params
            );

            if (1 === $result) {
                return false;
            }
        }

        return true;
    }
}
