<?php

namespace Fabstract\Component\REST\Query;

use Fabstract\Component\REST\Assert;
use Fabstract\Component\Validator\ValidationInterface;

class QueryElementModel
{
    /** @var string */
    private $query_key = null;
    /** @var string */
    private $field_name = null;
    /** @var bool */
    private $is_exact = false;
    /** @var bool */
    private $is_required = true;
    /** @var mixed */
    private $value = null;
    /** @var string[] */
    private $allowed_special_characters = [];
    /** @var callable */
    private $filter = null;
    /** @var ValidationInterface[] */
    private $validation_list = [];
    /** @var callable|null */
    private $validation_failed_callback = null;

    /**
     * QueryElementModel constructor.
     * @param string $query_key
     */
    protected function __construct($query_key)
    {
        Assert::isNotEmptyString($query_key, 'query_key');

        $this->query_key = $query_key;
    }

    /**
     * @param string $field_name
     * @return QueryElementModel
     */
    public function setFieldName($field_name)
    {
        Assert::isNotEmptyString($field_name, 'field_name');

        $this->field_name = $field_name;
        return $this;
    }

    /**
     * @param bool $is_exact
     * @return QueryElementModel
     */
    public function setIsExact($is_exact = true)
    {
        Assert::isBoolean($is_exact, 'is_exact');

        $this->is_exact = $is_exact;
        return $this;
    }

    /**
     * @param bool $is_required
     * @return QueryElementModel
     */
    public function setIsRequired($is_required = true)
    {
        Assert::isBoolean($is_required, 'is_required');

        $this->is_required = $is_required;
        return $this;
    }

    /**
     * @param ValidationInterface $validation
     * @return QueryElementModel
     */
    public function addValidation($validation)
    {
        Assert::isType($validation, ValidationInterface::class, 'validation');

        $this->validation_list[] = $validation;
        return $this;
    }

    /**
     * @param callable $validation_failed_callback
     * @return QueryElementModel
     */
    public function setValidationFailedCallback($validation_failed_callback)
    {
        Assert::isCallable($validation_failed_callback, 'validation_failed_callback');

        $this->validation_failed_callback = $validation_failed_callback;
        return $this;
    }

    /**
     * @param $value mixed
     * @return QueryElementModel
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKey()
    {
        return $this->query_key;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        if ($this->field_name !== null) {
            return $this->field_name;
        }

        return $this->getQueryKey();
    }

    /**
     * @return bool
     */
    public function getIsExact()
    {
        return $this->is_exact;
    }

    /**
     * @return bool
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return ValidationInterface[]
     */
    public function getValidationList()
    {
        return $this->validation_list;
    }

    /**
     * @param ValidationInterface $validation
     * @return boolean
     */
    public function fireValidationFailed($validation)
    {
        if (is_callable($this->validation_failed_callback)) {
            return call_user_func($this->validation_failed_callback, [$this, $validation]);
        }

        return true;
    }

    /**
     * @param string $query_key
     * @return QueryElementModel
     */
    public static function create($query_key)
    {
        $query_element = new static($query_key);
        return $query_element;
    }

    /**
     * @return string[]
     */
    public function getAllowedSpecialCharacters()
    {
        return $this->allowed_special_characters;
    }

    /**
     * @param string[] $allowed_special_characters
     * @return QueryElementModel
     */
    public function setAllowedSpecialCharacters($allowed_special_characters)
    {
        Assert::isArrayOfString($allowed_special_characters, 'allowed_special_characters');

        $this->allowed_special_characters = $allowed_special_characters;
        return $this;
    }

    /**
     * @return callable
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param callable $filter
     * @return QueryElementModel
     */
    public function setFilter($filter)
    {
        Assert::isCallable($filter, 'filter');

        $this->filter = $filter;
        return $this;
    }
}
