<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests;

use Wearesho\Yii\SingleTableInheritance\Tests\Mocks\ActiveRecord;
use Wearesho\Yii\SingleTableInheritance\Tests\Mocks\Factory;

/**
 * Class ActiveRecordTest
 * @package Wearesho\Yii\SingleTableInheritance\Tests
 */
class ActiveRecordTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
        ActiveRecord::$inheritanceFieldValue = 'test';
    }

    public function testDefaultValue(): void
    {
        $record = new ActiveRecord();
        $record->save();
        $this->assertEquals('test', $record->inheritance_field);
    }

    public function testNotFindWithOtherInheritanceValue(): void
    {
        $sql = "INSERT INTO test (inheritance_field) VALUES ('unexpected')";
        $driverName = \Yii::$app->db->getDriverName();

        if ($driverName === 'pgsql') {
            $sql .= " RETURNING ID;";
        }

        $executed = \Yii::$app->db->createCommand($sql)->execute();

        if ($driverName === 'pgsql') {
            $id = $executed;
        } elseif ($driverName === 'mysql') {
            $id = \Yii::$app->db->createCommand("SELECT LAST_INSERT_ID();")->execute();
        }

        $this->assertFalse(ActiveRecord::find()->andWhere(['=', 'id', $id ?? null,])->exists());
    }

    public function testFindWithCorrectInheritanceValue(): void
    {
        $sql = "INSERT INTO test (inheritance_field) VALUES ('test')";
        $driverName = \Yii::$app->db->getDriverName();

        if ($driverName === 'pgsql') {
            $sql .= " RETURNING ID;";
        }

        $executed = \Yii::$app->db->createCommand($sql)->execute();

        if ($driverName === 'pgsql') {
            $id = $executed;
        } elseif ($driverName === 'mysql') {
            $id = \Yii::$app->db->createCommand("SELECT LAST_INSERT_ID();")->execute();
        }

        $this->assertTrue(ActiveRecord::find()->andWhere(['=', 'id', $id,])->exists());
    }

    /**
     * @expectedException \Wearesho\Yii\SingleTableInheritance\Exception
     * @expectedExceptionMessage You must specify $inheritanceFieldValue for inherited class
     * @expectedExceptionCode 3
     */
    public function testNullInheritanceFieldValue(): void
    {
        ActiveRecord::$inheritanceFieldValue = null;
        ActiveRecord::find();
    }

    /**
     * @expectedException \Wearesho\Yii\SingleTableInheritance\Exception
     * @expectedExceptionMessage You must specify $factoryClass for
     * @expectedExceptionCode 4
     */
    public function testMissingFactoryClass(): void
    {
        ActiveRecord::instantiate([]);
    }

    /**
     * @expectedException \Wearesho\Yii\SingleTableInheritance\Exception
     * @expectedExceptionMessage Specified factory class invalidClass does not exist
     * @expectedExceptionCode 5
     */
    public function testNonexistentFactoryClass(): void
    {
        ActiveRecord::$factoryClass = 'invalidClass';
        ActiveRecord::instantiate([]);
    }

    /**
     * @expectedException \Wearesho\Yii\SingleTableInheritance\Exception
     * @expectedExceptionMessage Specified factory class Wearesho\Yii\SingleTableInheritance\Tests\Mocks\ActiveRecord
     * @expectedExceptionCode 6
     */
    public function testInvalidFactoryClass(): void
    {
        ActiveRecord::$factoryClass = ActiveRecord::class;
        ActiveRecord::instantiate([]);
    }

    public function testCorrectInstantiate(): void
    {
        ActiveRecord::$factoryClass = Factory::class;
        $record = ActiveRecord::instantiate([]);
        $this->assertInstanceOf(ActiveRecord::class, $record);
        $this->assertEquals('test', $record->inheritance_field);
    }

    public function testGetInheritanceField(): void
    {
        $this->assertEquals(
            ActiveRecord::$inheritanceField,
            ActiveRecord::getInheritanceField()
        );
    }
}
