<?php

namespace Wearesho\Yii\SingleTableInheritance;

/**
 * Interface FactoryInterface
 * @package Wearesho\Yii\SingleTableInheritance
 */
interface FactoryInterface
{
    /**
     * @param array $params
     * @param array $config
     * @return mixed
     */
    public static function getInstance(array $params, array $config = []);
}
