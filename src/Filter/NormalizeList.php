<?php
/**
 * ZFrapid - Core classes for ZFrapid tools
 *
 * @link      https://github.com/ZFrapid/zfrapid-core
 * @copyright Copyright (c) 2014 - 2016 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */
namespace ZFrapidCore\Filter;

use Zend\Filter\Word\DashToCamelCase;
use Zend\Filter\Word\UnderscoreToCamelCase;
use ZF\Console\Filter\Explode;

/**
 * Class NormalizeList
 *
 * @package ZFrapidCore\Filter
 */
class NormalizeList extends Explode
{
    /**
     * @param mixed $value
     *
     * @return array|mixed
     */
    public function filter($value)
    {
        $list = parent::filter($value);

        $dashToCamelCaseFilter       = new DashToCamelCase();
        $underscoreToCamelCaseFilter = new UnderscoreToCamelCase();

        foreach ($list as $listKey => $listOption) {
            $listOption = $dashToCamelCaseFilter->filter($listOption);
            $listOption = $underscoreToCamelCaseFilter->filter($listOption);

            $list[$listKey] = $listOption;
        }

        return $list;
    }

}