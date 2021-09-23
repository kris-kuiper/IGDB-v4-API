<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Types;

class WhereType
{
    private string $logicGate;
    private string $field;
    private null|array|string|int|float $value;
    private string $operator;

    public function __construct(string $logicGate, string $field, null|array|string|int|float $value, string $operator = '=')
    {
        $this->logicGate = $logicGate;
        $this->field = $field;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function getLogicGate(): string
    {
        return $this->logicGate;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): null|array|string|int|float
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
