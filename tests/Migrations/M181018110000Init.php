<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests\Migrations;

use yii\db;

/**
 * Class m181018110000init
 * @package Wearesho\Yii\SingleTableInheritance\Tests\Migrations
 */
class M181018110000Init extends db\Migration
{
    public function up()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'inheritance_field' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('test');
    }
}
