<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Traits;

trait BuildTrait
{
    public function build(): string
    {
        $nodeCollection = $this->nodeCollection;
        $fieldsNode = $nodeCollection->getFieldsNode();
        $whereNode = $nodeCollection->getWhereNode();
        $limitNode = $nodeCollection->getLimitNode();
        $offsetNode = $nodeCollection->getOffsetNode();
        $searchNode = $nodeCollection->getSearchNode();
        $sortNode = $nodeCollection->getSortNode();
        $excludeNode = $nodeCollection->getExcludeNode();
        $query = [];
        if (false === $fieldsNode->isEmpty()) {
            $query[] = 'fields ' . $fieldsNode->build() . ';';
        }

        if (false === $excludeNode->isEmpty()) {
            $query[] = 'exclude ' . $excludeNode->build() . ';';
        }

        if (false === $searchNode->isEmpty()) {
            $query[] = 'search "' . $searchNode->build() . '";';
        }

        if (false === $whereNode->isEmpty()) {
            $query[] = 'where ' . $whereNode->build() . ';';
        }

        if (false === $sortNode->isEmpty()) {
            $query[] = 'sort ' . $sortNode->build() . ';';
        }

        if (false === $offsetNode->isEmpty()) {
            $query[] = 'offset ' . $offsetNode->build() . ';';
        }

        if (false === $limitNode->isEmpty()) {
            $query[] = 'limit ' . $limitNode->build() . ';';
        }

        return implode(' ', $query);
    }
}
