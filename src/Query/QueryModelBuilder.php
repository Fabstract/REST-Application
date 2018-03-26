<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\Http\Request;
use Fabstract\Component\LINQ\LINQ;
use Fabstract\Component\REST\Assert;
use Symfony\Component\HttpFoundation\ParameterBagInterface;

class QueryModelBuilder
{
    /** @var QueryElementModel[] */
    private $query_element_model_list = [];
    /** @var SortQueryElementModel[] */
    private $sort_query_element_model_list = [];

    /** @var QueryConfig */
    private $query_config = null;

    /**
     * QueryModelBuilder constructor.
     * @param QueryConfig $query_config
     */
    private function __construct($query_config = null)
    {
        if ($query_config === null) {
            $this->query_config = new QueryConfig();
        } else {
            Assert::isType($query_config, QueryConfig::class, 'query_config');

            $this->query_config = $query_config;
        }
    }

    /**
     * @param QueryConfig $query_config
     * @return QueryModelBuilder
     */
    public static function create($query_config = null)
    {
        return new self($query_config);
    }

    /**
     * @param string $query_element
     * @return QueryModelBuilder
     */
    public function addQueryElement($query_element)
    {
        Assert::isNotEmptyString($query_element, 'query_element');

        $this->query_element_model_list[] = QueryElementModel::create($query_element);
        return $this;
    }

    /**
     * @param string[] $query_element_list
     * @return QueryModelBuilder
     */
    public function addQueryElementList(...$query_element_list)
    {
        Assert::isArrayOfString($query_element_list, 'query_element_list');

        foreach ($query_element_list as $query_element) {
            $this->addQueryElement($query_element);
        }

        return $this;
    }

    /**
     * @param QueryElementModel $query_element
     * @return QueryModelBuilder
     */
    public function addQueryElementModel($query_element)
    {
        Assert::isType($query_element, QueryElementModel::class, 'query_element');

        $this->query_element_model_list[] = $query_element;
        return $this;
    }

    /**
     * @param string $sort_query_element
     * @param string $type
     * @param bool $default
     * @return QueryModelBuilder
     */
    public function addSortQueryElement($sort_query_element, $type = 'string', $default = false)
    {
        Assert::isNotEmptyString($sort_query_element, 'sort_query_element');
        Assert::isInStringArray($type, $this->query_config->getQueryAllowedSortKeyTypeList(), 'type');

        $sort_query_element_model = SortQueryElementModel::create($sort_query_element)
            ->setType($type)
            ->setIsDefault($default);
        $this->sort_query_element_model_list[] = $sort_query_element_model;

        return $this;
    }

    /**
     * @param string[] $sort_query_element_list
     * @return QueryModelBuilder
     */
    public function addSortQueryElementList(...$sort_query_element_list)
    {
        Assert::isArrayOfString($sort_query_element_list, 'sort_query_element_list');

        foreach ($sort_query_element_list as $sort_query_element) {
            $this->addSortQueryElement($sort_query_element, false);
        }

        return $this;
    }

    /**
     * @param string[] $sort_query_element_list
     * @return QueryModelBuilder
     */
    public function addDefaultSortQueryElementList(...$sort_query_element_list)
    {
        Assert::isArrayOfString($sort_query_element_list, 'sort_query_element_list');

        foreach ($sort_query_element_list as $sort_query_element) {
            $this->addSortQueryElement($sort_query_element, true);
        }

        return $this;
    }

    /**
     * @param SortQueryElementModel|string $sort_query_element
     * @return QueryModelBuilder
     */
    public function addSortQueryElementModel($sort_query_element)
    {
        Assert::isType($sort_query_element, SortQueryElementModel::class, 'sort_query_element');
        Assert::isInStringArray(
            $sort_query_element->getType(),
            $this->query_config->getQueryAllowedSortKeyTypeList(),
            'type'
        );

        $this->query_element_model_list[] = $sort_query_element;
        return $this;
    }

    /**
     * @param Request $request
     * @return QueryModel
     */
    public function buildFromRequest($request)
    {
        return $this->buildFromQueryParametersBag($request->query);
    }

    /**
     * @param ParameterBagInterface $bag
     * @return QueryModel
     */
    public function buildFromQueryParametersBag($bag)
    {
        $query_element_list = $this->getQueryElementList($bag);
        $sort_query_element_list = $this->getSortQueryElementList($bag);
        $page = $this->getPage($bag);
        $per_page = $this->getPerPage($bag);
        return new QueryModel($query_element_list, $sort_query_element_list, $page, $per_page);
    }

    /**
     * @param ParameterBagInterface $bag
     * @return QueryElementModel[]
     */
    private function getQueryElementList($bag)
    {
        return LINQ::from($this->query_element_model_list)
            ->where(function ($query_element_model) use ($bag) {
                /** @var QueryElementModel $query_element_model */
                $query_value = $bag->get($query_element_model->getQueryKey());
                if ($query_value === null) {
                    return false;
                }

                $filter_callable = $query_element_model->getFilter();
                if ($filter_callable !== null) {
                    $query_value = call_user_func($filter_callable, $query_value);
                }

                $validated = true;
                $validation_list = $query_element_model->getValidationList();
                foreach ($validation_list as $validation) {
                    $validated = $validation->isValid($query_value);
                    if ($validated !== true) {
                        $query_element_model->fireValidationFailed($validation);
                        break;
                    }
                }
                if ($validated !== true) {
                    return false;
                }

                $query_element_model->setValue($query_value);
                return true;
            })
            ->toArray();
    }

    /**
     * @param ParameterBagInterface $bag
     * @return SortQueryElementModel[]
     */
    private function getSortQueryElementList($bag)
    {
        $query_sort_by_key = $this->query_config->getQueryKeySortBy();
        $query_sort_by_value = $bag->get($query_sort_by_key);
        if ($query_sort_by_value === null) {
            $query_sort_by_descending_key = $this->query_config->getQueryKeySortByDescending();
            $query_sort_by_value = $bag->get($query_sort_by_descending_key);
            $sort_descending = true;
        } else {
            $sort_descending = false;
        }

        $query_sort_by_value_list = explode(',', $query_sort_by_value);

        return LINQ::from($this->sort_query_element_model_list)
            ->where(function ($sort_query_element_model) use ($query_sort_by_value_list, $sort_descending) {
                /** @var SortQueryElementModel $sort_query_element_model */
                $sort_type = $sort_query_element_model->getType();
                if (in_array($sort_type, $this->query_config->getQueryAllowedSortKeyTypeList(), true) !== true) {
                    return false;
                }

                $sort_query_key = $sort_query_element_model->getQueryKey();
                if (in_array($sort_query_key, $query_sort_by_value_list, true) === true) {
                    $sort_query_element_model->setDescending($sort_descending);
                    return true;
                }

                if ($sort_query_element_model->isDefault() === true) {
                    return true;
                }

                return false;
            })
            ->toArray();
    }

    /**
     * @param ParameterBagInterface $bag
     * @return int
     */
    private function getPage($bag)
    {
        $query_page_key = $this->query_config->getQueryKeyPage();
        return $bag->getInt($query_page_key, 0);
    }

    /**
     * @param ParameterBagInterface $bag
     * @return int
     */
    private function getPerPage($bag)
    {
        $query_per_page_key = $this->query_config->getQueryKeyPerPage();
        return $bag->getInt($query_per_page_key, 1);
    }
}
