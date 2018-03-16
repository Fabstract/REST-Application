<?php

namespace Fabstract\Component\REST\Exception;

use Exception;
use Fabstract\Component\REST\Assert;
use Fabstract\Component\REST\Model\ValidationErrorModel;

class ResponseValidationException extends Exception
{
    /** @var ValidationErrorModel[] */
    private $validation_error_model_list = [];

    /**
     * ResponseValidationException constructor.
     * @param ValidationErrorModel[] $validation_error_model_list
     */
    public function __construct($validation_error_model_list = [])
    {
        Assert::isArrayOfType($validation_error_model_list, ValidationErrorModel::class, 'validation error model list');

        parent::__construct("Response object could not be validated. See validation log for more info.", 0, null);

        $this->validation_error_model_list = $validation_error_model_list;
    }

    /**
     * @return ValidationErrorModel[]
     */
    public function getValidationErrorModelList()
    {
        return $this->validation_error_model_list;
    }

    /**
     * @param ValidationErrorModel[] $validation_error_model_list
     */
    public function setValidationErrorModelList($validation_error_model_list)
    {
        $this->validation_error_model_list = $validation_error_model_list;
    }
}
