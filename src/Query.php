<?php

namespace Wearesho\Yii\SingleTableInheritance;

use yii\db\ActiveQuery;

/**
 * Class Query
 * @package Wearesho\Yii\SingleTableInheritance
 */
class Query extends ActiveQuery
{
    /**
     * @var string
     */
    public $inheritanceField;
    /**
     * @var mixed
     */
    public $inheritanceFieldValue;
    /**
     * @var string
     */
    public $tableName;

    public function prepare($builder)
    {
        if (!empty($this->inheritanceFieldValue)) {
            $this->andWhere([
                (\is_array($this->inheritanceFieldValue) ? 'in' : '='),
                "{$this->tableName}.{$this->inheritanceField}",
                $this->inheritanceFieldValue
            ]);
        }
        return parent::prepare($builder);
    }

    /**
     * @param \yii\db\Query $from
     * @return static
     */
    public static function create($from)
    {
        $query = new static([
            'where' => $from->where,
            'limit' => $from->limit,
            'offset' => $from->offset,
            'orderBy' => $from->orderBy,
            'indexBy' => $from->indexBy,
            'select' => $from->select,
            'selectOption' => $from->selectOption,
            'distinct' => $from->distinct,
            'from' => $from->from,
            'groupBy' => $from->groupBy,
            'join' => $from->join,
            'having' => $from->having,
            'union' => $from->union,
            'params' => $from->params,
        ]);
        if ($from instanceof static) {
            $query->tableName = $from->tableName;
            $query->inheritanceFieldValue = $from->inheritanceFieldValue;
            $query->inheritanceField = $from->inheritanceField;
        }
        return $query;
    }
}
