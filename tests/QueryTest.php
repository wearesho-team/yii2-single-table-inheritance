<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests;

use Wearesho\Yii\SingleTableInheritance\Query;
use Wearesho\Yii\SingleTableInheritance\Tests\Mocks\ActiveRecord;

/**
 * Class QueryTest
 * @package Wearesho\Yii\SingleTableInheritance\Tests
 */
class QueryTest extends AbstractTestCase
{
    public function testCreateFromQueryInstance(): void
    {
        $sourceQuery = ActiveRecord::find();

        $query = Query::create($sourceQuery);
        $this->assertInstanceOf(Query::class, $query);
        $this->assertEquals(ActiveRecord::tableName(), $query->tableName);
        $this->assertEquals('inheritance_field', $query->inheritanceField);
        $this->assertEquals('test', $query->inheritanceFieldValue);
    }

    public function testCreateFromOtherQuery(): void
    {
        $query = Query::create(new \yii\db\Query());
        $this->assertNull($query->tableName);
        $this->assertNull($query->inheritanceField);
        $this->assertNull($query->inheritanceFieldValue);
    }
}
