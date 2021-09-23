<?php

declare(strict_types=1);

namespace KrisKuiper\IGDBV4\QueryBuilder\Nodes;

class NodeCollection
{
    private WhereNode $whereNode;
    private FieldsNode $fieldsNode;
    private LimitNode $limitNode;
    private OffsetNode $offsetNode;
    private SearchNode $searchNode;
    private SortNode $sortNode;
    private ExcludeNode $excludeNode;

    public function __construct()
    {
        $this->whereNode = new WhereNode();
        $this->fieldsNode = new FieldsNode();
        $this->limitNode = new LimitNode();
        $this->offsetNode = new OffsetNode();
        $this->searchNode = new SearchNode();
        $this->sortNode = new SortNode();
        $this->excludeNode = new ExcludeNode();
    }

    public function getFieldsNode(): FieldsNode
    {
        return $this->fieldsNode;
    }

    public function getWhereNode(): WhereNode
    {
        return $this->whereNode;
    }

    public function getLimitNode(): LimitNode
    {
        return $this->limitNode;
    }

    public function getOffsetNode(): OffsetNode
    {
        return $this->offsetNode;
    }

    public function getSearchNode(): SearchNode
    {
        return $this->searchNode;
    }

    public function getSortNode(): SortNode
    {
        return $this->sortNode;
    }

    public function getExcludeNode(): ExcludeNode
    {
        return $this->excludeNode;
    }
}
