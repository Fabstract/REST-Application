<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\REST\Assert;

class QueryModel
{
    /** @var QueryElementModel[] */
    private $query_element_list = [];
    /** @var SortQueryElementModel[] */
    private $sort_query_element_list = [];
    /** @var int */
    private $page = 0;
    /** @var int */
    private $per_page = 0;

    /**
     * QueryModel constructor.
     * @param QueryElementModel[] $query_element_list
     * @param SortQueryElementModel[] $sort_query_element_list
     * @param int $page
     * @param int $per_page
     */
    public function __construct($query_element_list = [], $sort_query_element_list = [], $page = 0, $per_page = 0)
    {
        Assert::isArrayOfType($query_element_list, QueryElementModel::class, 'query_element_list');
        Assert::isArrayOfType($sort_query_element_list, SortQueryElementModel::class, 'sort_query_element_list');
        Assert::isNotNegative($page, 'page');
        Assert::isNotNegative($per_page, 'per_page');

        $this->query_element_list = $query_element_list;
        $this->sort_query_element_list = $sort_query_element_list;
        $this->page = $page;
        $this->per_page = $per_page;
    }

    /**
     * @return QueryElementModel[]
     */
    public function getQueryElementList()
    {
        return $this->query_element_list;
    }

    /**
     * @return SortQueryElementModel[]
     */
    public function getSortQueryElementList()
    {
        return $this->sort_query_element_list;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->query_element_list) === 0 &&
            count($this->sort_query_element_list) === 0;
    }

    /**
     * @param QueryConfig $query_config
     * @return QueryModelBuilder
     */
    public static function builder($query_config = null)
    {
        return QueryModelBuilder::create($query_config);
    }
}
