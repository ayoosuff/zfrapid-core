<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Filter;

use Zend\Filter\FilterInterface;
use Zend\Filter\Word\DashToCamelCase;
use Zend\Filter\Word\UnderscoreToCamelCase;

/**
 * Class NormalizeParam
 *
 * @package ZFrapidCore\Filter
 */
class NormalizeParam implements FilterInterface
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    public function filter($value)
    {
        $dashToCamelCaseFilter       = new DashToCamelCase();
        $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();

        $value = $dashToCamelCaseFilter->filter($value);
        $value = $underscoreToCamelCaseFilter->filter($value);

        return $value;
    }

}