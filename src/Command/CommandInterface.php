<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Command;

use ZFrapidCore\Console\ConsoleInterface;
use ZF\Console\Route;

/**
 * Class CommandInterface
 *
 * @package ZFrapidCore\Command
 */
interface CommandInterface
{
    /**
     * Start command processing
     *
     * @param Route            $route
     * @param ConsoleInterface $console
     *
     * @return integer
     */
    public function __invoke(Route $route, ConsoleInterface $console);

    /**
     * Start the command
     */
    public function startCommand();

    /**
     * Stop the command
     */
    public function stopCommand();
}