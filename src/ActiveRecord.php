<?php

namespace Wearesho\Yii\SingleTableInheritance;

use yii\db;

/**
 * Class ActiveRecord
 * @package Wearesho\Yii\SingleTableInheritance
 */
abstract class ActiveRecord extends db\ActiveRecord
{
    /** @var string Path to class */
    protected static $factoryClass;

    /** @var string */
    protected static $inheritanceField = 'type';

    /** @var mixed  Must be null in basic class */
    protected static $inheritanceFieldValue = null;

    public static function getInheritanceField(): string
    {
        return static::$inheritanceField;
    }

    public static function getInheritanceFieldValue(): string
    {
        return static::$inheritanceFieldValue;
    }

    public static function find(): db\ActiveQuery
    {
        $currentClass = \get_called_class();
        $currentReflection = new \ReflectionClass($currentClass);
        $isInstantiable = $currentReflection->isInstantiable();

        if ($isInstantiable && \is_null(static::$inheritanceFieldValue)) {
            throw new Exception(
                "You must specify \$inheritanceFieldValue for inherited class " . $currentClass,
                3
            );
        }

        $params = [
            'tableName' => static::tableName(),
            'inheritanceField' => static::$inheritanceField,
        ];

        if ($isInstantiable) {
            $params['inheritanceFieldValue'] = static::$inheritanceFieldValue;
        }

        $queryClassName = static::queryClass();
        $inheritanceQueryInstance = new $queryClassName(\get_called_class(), $params);

        return $inheritanceQueryInstance;
    }

    public static function instantiate($row)
    {
        if (!static::$factoryClass) {
            throw new Exception(
                "You must specify \$factoryClass for " . \get_called_class(),
                4
            );
        }

        if (!\class_exists(static::$factoryClass)) {
            throw new Exception(
                "Specified factory class " . static::$factoryClass . ' does not exist',
                5
            );
        }

        $factoryClassReflection = new \ReflectionClass(static::$factoryClass);
        if (!$factoryClassReflection->implementsInterface(FactoryInterface::class)) {
            throw new Exception(
                "Specified factory class " . static::$factoryClass . ' must implement ' . FactoryInterface::class,
                6
            );
        }

        /** @see FactoryInterface::getInstance() */
        $instance = \call_user_func([static::$factoryClass, 'getInstance'], $row);
        return $instance;
    }

    /**
     * @return string
     */
    public static function queryClass(): string
    {
        return Query::class;
    }

    public function init()
    {
        $this->{static::$inheritanceField} = static::$inheritanceFieldValue;
        parent::init();
    }

    public function beforeSave($insert)
    {
        $this->{static::$inheritanceField} = static::$inheritanceFieldValue;
        return parent::beforeSave($insert);
    }
}
