<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\REST\Assert;
use Fabstract\Component\Serializer\Normalizer\NormalizableInterface;

class QueryResponseModel
{
    /** @var NormalizableInterface[] */
    private $model_list = [];
    /** @var int */
    private $total_count = 0;

    /**
     * QueryResponseModel constructor.
     * @param array $model_list
     * @param int $total_count
     */
    public function __construct($model_list, $total_count)
    {
        Assert::isArrayOfType($model_list, NormalizableInterface::class, 'model_list');
        Assert::isNotNegative($total_count);

        $this->model_list = $model_list;
        $this->total_count = $total_count;
    }

    /**
     * @return NormalizableInterface[]
     */
    public function getModelList()
    {
        return $this->model_list;
    }

    /**
     * @param NormalizableInterface[] $model_list
     * @return QueryResponseModel
     */
    public function setModelList($model_list)
    {
        $this->model_list = $model_list;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * @param int $total_count
     * @return QueryResponseModel
     */
    public function setTotalCount($total_count)
    {
        $this->total_count = $total_count;
        return $this;
    }
}
