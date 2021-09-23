<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Types;

use KrisKuiper\IGDBV4\QueryBuilder\Nodes\WhereNode;

class LogicGate
{
    private string $logicGate;
    private WhereNode $whereNode;

    public function __construct(string $logicGate, WhereNode $whereNode)
    {
        $this->logicGate = $logicGate;
        $this->whereNode = $whereNode;
    }

    public function getLogicGate(): string
    {
        return $this->logicGate;
    }

    public function getWhereNode(): WhereNode
    {
        return $this->whereNode;
    }
}
