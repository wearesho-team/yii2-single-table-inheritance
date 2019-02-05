<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests\Mocks;

use Wearesho\Yii\SingleTableInheritance;

/**
 * Class ActiveRecord
 * @package Wearesho\Yii\SingleTableInheritance\Tests\Mocks
 *
 * @property string $inheritance_field
 */
class ActiveRecord extends SingleTableInheritance\ActiveRecord
{
    public static $factoryClass;

    public static $inheritanceField = 'inheritance_field';

    public static $inheritanceFieldValue = 'test';

    public static function tableName(): string
    {
        return 'test';
    }
}
