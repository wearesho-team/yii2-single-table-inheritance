<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests\Mocks;

use Wearesho\Yii\SingleTableInheritance;

/**
 * Class Factory
 * @package Wearesho\Yii\SingleTableInheritance\Tests\Mocks
 */
class Factory implements SingleTableInheritance\FactoryInterface
{
    /**
     * @inheritdoc
     */
    public static function getInstance(array $params, array $config = [])
    {
        return new ActiveRecord();
    }
}
