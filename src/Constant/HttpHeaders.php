<?php

namespace Fabstract\Component\REST\Constant;

class HttpHeaders extends \Fabstract\Component\Http\Constant\HttpHeaders
{
    const X_HTTP_METHOD_OVERRIDE = 'X-HTTP-METHOD-OVERRIDE';
    const X_RATELIMIT_REMAINING = 'X-RateLimit-Remaining';
    const X_RATELIMIT_LIMIT = 'X-RateLimit-Limit';
    const X_RATELIMIT_RESET = 'X-RateLimit-Reset';
    const REQUEST_METHOD = 'REQUEST_METHOD';
    const X_TOTAL_COUNT = 'X-Total-Count';
    const IF_NONE_MATCH = 'If-None-Match';
    const CONTENT_TYPE = 'Content-Type';
    const ETAG = 'ETag';
}
