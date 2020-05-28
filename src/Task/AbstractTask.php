<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Task;

use Zend\Filter\StaticFilter;
use Zend\Stdlib\Parameters;
use ZF\Console\Route;
use ZFrapidCore\Console\ConsoleInterface;

/**
 * Class AbstractTask
 *
 * @package ZFrapidCore\Task
 */
abstract class AbstractTask implements TaskInterface
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
     * Start command task processing
     *
     * @param Route            $route
     * @param ConsoleInterface $console
     * @param Parameters       $params
     *
     * @return int
     */
    public function __invoke(
        Route $route, ConsoleInterface $console, Parameters $params
    ) {
        $this->route   = $route;
        $this->console = $console;
        $this->params  = $params;

        return $this->processCommandTask();
    }

    /**
     * Process the command task
     *
     * @return integer
     */
    abstract public function processCommandTask();

    /**
     * Filter camel case to dash
     *
     * @param string $text
     *
     * @return string
     */
    public function filterCamelCaseToDash($text)
    {
        $text = StaticFilter::execute($text, 'Word\CamelCaseToDash');
        $text = StaticFilter::execute($text, 'StringToLower');

        return $text;
    }

    /**
     * Filter camel case to underscore
     *
     * @param string $text
     *
     * @return string
     */
    public function filterCamelCaseToUnderscore($text)
    {
        $text = StaticFilter::execute($text, 'Word\CamelCaseToUnderscore');
        $text = StaticFilter::execute($text, 'StringToLower');

        return $text;
    }

    /**
     * Filter camel case to dash
     *
     * @param string $text
     *
     * @return string
     */
    public function filterCamelCaseToUpper($text)
    {
        $text = StaticFilter::execute($text, 'Word\CamelCaseToUnderScore');
        $text = StaticFilter::execute($text, 'StringToUpper');

        return $text;
    }

    /**
     * Filter dash to camel case
     *
     * @param string $text
     *
     * @return string
     */
    public function filterDashToCamelCase($text)
    {
        $text = StaticFilter::execute($text, 'Word\DashToCamelCase');

        return $text;
    }

    /**
     * Filter underscore to camel case
     *
     * @param string $text
     *
     * @return string
     */
    public function filterUnderscoreToCamelCase($text)
    {
        $text = StaticFilter::execute($text, 'Word\UnderscoreToCamelCase');

        return $text;
    }
}
