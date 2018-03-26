<?php

namespace Fabstract\Component\REST\Constant;

class QuerySortKeyTypes
{
    const STRING = 'string';
    const DOUBLE = 'double';
    const FLOAT = 'float';
    const LONG = 'long';
    const DATE = 'date';
    const INT = 'int';

    /**
     * @return string[]
     */
    public static function all()
    {
        return
            [
                QuerySortKeyTypes::STRING,
                QuerySortKeyTypes::DOUBLE,
                QuerySortKeyTypes::FLOAT,
                QuerySortKeyTypes::LONG,
                QuerySortKeyTypes::DATE,
                QuerySortKeyTypes::INT
            ];
    }
}
