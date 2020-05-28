<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Task;

use Zend\Stdlib\Parameters;
use ZF\Console\Route;
use ZFrapidCore\Console\ConsoleInterface;

/**
 * Class TaskInterface
 *
 * @package ZFrapidCore\Task
 */
interface TaskInterface
{
    /**
     * Start command task processing
     *
     * @param Route            $route
     * @param ConsoleInterface $console
     * @param Parameters       $params
     *
     * @return int
     */
    public function __invoke(Route $route, ConsoleInterface $console, Parameters $params);

    /**
     * Process the command task
     *
     * @return integer
     */
    public function processCommandTask();
}