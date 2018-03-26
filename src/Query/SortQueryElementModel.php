<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\REST\Assert;

class SortQueryElementModel extends QueryElementModel
{
    /** @var bool */
    private $descending = false;
    /** @var string */
    private $type = null;
    /** @var bool */
    private $is_default = false;

    /**
     * @param bool $descending
     * @return SortQueryElementModel
     */
    public function setDescending($descending = true)
    {
        Assert::isBoolean($descending, 'descending');

        $this->descending = $descending;
        return $this;
    }

    /**
     * @param string $type
     * @return SortQueryElementModel
     */
    public function setType($type)
    {
        Assert::isString($type, 'type');

        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDescending()
    {
        return $this->descending;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * @param bool $is_default
     * @return SortQueryElementModel
     */
    public function setIsDefault($is_default)
    {
        Assert::isBoolean($is_default, 'is_default');

        $this->is_default = $is_default;
        return $this;
    }

    /**
     * Overriding create method because of comments
     *
     * @param string $query_name
     * @return SortQueryElementModel
     */
    public static function create($query_name)
    {
        /** @var SortQueryElementModel $query_element */
        $query_element = parent::create($query_name);
        return $query_element;
    }
}
