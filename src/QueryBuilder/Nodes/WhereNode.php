<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

use KrisKuiper\IGDBV4\QueryBuilder\Types\LogicGate;

class WhereNode extends AbstractNode
{
    public function build(): string
    {
        $query = [];

        foreach ($this->items as $index => $item) {
            if ($item instanceof LogicGate) {
                if ($index > 0) {
                    $query[] = sprintf('%s (%s)', $item->getLogicGate(), $item->getWhereNode()->build());
                } else {
                    $query[] = sprintf('(%s)', $item->getWhereNode()->build());
                }

                continue;
            }

            $value = $item->getValue();
            $field = $item->getField();
            $operator = $item->getOperator();
            $logicGate = $item->getLogicGate();

            if (true === is_array($value)) {
                $value = sprintf('(%s)', implode(', ', $value));
            }

            if ($index > 0) {
                $query[] = sprintf('%s %s %s %s', $logicGate, $field, $operator, $value);
            } else {
                $query[] = sprintf('%s %s %s', $field, $operator, $value);
            }
        }

        return implode(' ', $query);
    }
}
