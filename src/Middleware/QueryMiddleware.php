<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\REST\Constant\HttpHeaders;
use Fabstract\Component\REST\Query\QueryResponseModel;

class QueryMiddleware extends MiddlewareBase
{
    public function after()
    {
        $returned_value = $this->response->getReturnedValue();
        if ($returned_value instanceof QueryResponseModel) {
            $this->response->headers->set(HttpHeaders::X_TOTAL_COUNT, $returned_value->getTotalCount());
            $this->response->setReturnedValue($returned_value->getModelList());
        }
    }
}
