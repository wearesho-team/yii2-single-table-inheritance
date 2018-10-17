<?php

namespace Wearesho\Yii\SingleTableInheritance\Tests;

use yii\helpers\ArrayHelper;
use yii\phpunit\MigrateFixture;
use yii\phpunit\TestCase;

/**
 * Class AbstractTestCase
 * @package Wearesho\Bobra\Cpa\Tests
 *
 * @internal
 */
abstract class AbstractTestCase extends TestCase
{
    public function globalFixtures()
    {
        $fixtures = [
            [
                'class' => MigrateFixture::class,
                'migrationNamespaces' => [
                    'Wearesho\\Yii\\SingleTableInheritance\\Tests\\Migrations',
                ],
            ],
        ];

        return ArrayHelper::merge(parent::globalFixtures(), $fixtures);
    }
}
