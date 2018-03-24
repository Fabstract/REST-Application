<?php

namespace Fabstract\Component\REST\Query;

class QueryResponseModel
{
    public $model_list = [];
    public $total_count = 0;

    /**
     * QueryResponseModel constructor.
     * @param array $model_list
     * @param int $total_count
     */
    public function __construct($model_list, $total_count)
    {
        $this->model_list = $model_list;
        $this->total_count = $total_count;
    }
}
