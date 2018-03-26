<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\REST\Assert;
use Fabstract\Component\REST\Constant\QuerySortKeyTypes;

class QueryConfig
{
    const DEFAULT_QUERY_KEY_SORT_BY = 'sort_by';
    const DEFAULT_QUERY_KEY_SORT_BY_DESCENDING = 'sort_by_descending';
    const DEFAULT_QUERY_KEY_PAGE = 'page';
    const DEFAULT_QUERY_KEY_PER_PAGE = 'per_page';
    const DEFAULT_QUERY_ALLOWED_SORT_KEY_TYPE_LIST =
        [
            QuerySortKeyTypes::STRING,
            QuerySortKeyTypes::DOUBLE,
            QuerySortKeyTypes::FLOAT,
            QuerySortKeyTypes::LONG,
            QuerySortKeyTypes::DATE,
            QuerySortKeyTypes::INT
        ];

    /** @var string */
    private $query_key_sort_by = QueryConfig::DEFAULT_QUERY_KEY_SORT_BY;
    /** @var string */
    private $query_key_sort_by_descending = QueryConfig::DEFAULT_QUERY_KEY_SORT_BY_DESCENDING;
    /** @var string */
    private $query_key_page = QueryConfig::DEFAULT_QUERY_KEY_PAGE;
    /** @var string */
    private $query_key_per_page = QueryConfig::DEFAULT_QUERY_KEY_PER_PAGE;
    /** @var string[] */
    private $query_allowed_sort_key_type_list = QueryConfig::DEFAULT_QUERY_ALLOWED_SORT_KEY_TYPE_LIST;

    /**
     * @param string $sort_by_key
     * @return QueryConfig
     */
    public final function setQueryKeySortBy($sort_by_key)
    {
        Assert::isNotEmptyString($sort_by_key, 'sort_by_key');

        $this->query_key_sort_by = $sort_by_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKeySortBy()
    {
        return $this->query_key_sort_by;
    }

    /**
     * @param string $sort_by_descending_key
     * @return QueryConfig
     */
    public final function setQueryKeySortByDescending($sort_by_descending_key)
    {
        Assert::isNotEmptyString($sort_by_descending_key, 'sort_by_descending_key');

        $this->query_key_sort_by_descending = $sort_by_descending_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKeySortByDescending()
    {
        return $this->query_key_sort_by_descending;
    }

    /**
     * @param string $page_key
     * @return QueryConfig
     */
    public final function setQueryKeyPage($page_key)
    {
        Assert::isNotEmptyString($page_key, 'page_key');

        $this->query_key_page = $page_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKeyPage()
    {
        return $this->query_key_page;
    }

    /**
     * @param string $per_page_key
     * @return QueryConfig
     */
    public final function setQueryKeyPerPage($per_page_key)
    {
        Assert::isNotEmptyString($per_page_key, 'per_page_key');

        $this->query_key_per_page = $per_page_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKeyPerPage()
    {
        return $this->query_key_per_page;
    }

    /**
     * @param string[] $query_allowed_sort_key_type_list
     * @return QueryConfig
     */
    public function setQueryAllowedSortKeyTypeList($query_allowed_sort_key_type_list)
    {
        Assert::isArrayOfString($query_allowed_sort_key_type_list, 'query_allowed_sort_key_type_list');

        $this->query_allowed_sort_key_type_list = $query_allowed_sort_key_type_list;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getQueryAllowedSortKeyTypeList()
    {
        return $this->query_allowed_sort_key_type_list;
    }
}
