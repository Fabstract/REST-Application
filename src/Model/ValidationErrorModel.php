<?php

namespace Fabstract\Component\REST\Model;

use Fabs\Component\Serializer\Normalizer\NormalizableInterface;
use Fabs\Component\Serializer\Normalizer\NormalizationMetadata;
use Fabs\Component\Serializer\Normalizer\Type;
use Fabs\Component\Validator\ValidationError;
use Fabstract\Component\REST\Assert;

class ValidationErrorModel implements NormalizableInterface
{
    /**
     * @var string
     */
    public $class_name = null;
    /**
     * @var string
     */
    public $property_name = null;
    /**
     * @var mixed
     */
    public $property_value = null;
    /**
     * @var string
     */
    public $message = null;
    /**
     * @var string
     */
    public $path = null;

    /**
     * @param NormalizationMetadata $normalization_metadata
     * @return void
     */
    public function configureNormalizationMetadata($normalization_metadata)
    {
        $normalization_metadata->setAsTransient('class_name');
    }

    /**
     * @param ValidationError $validation_error
     * @return ValidationErrorModel
     */
    public static function create($validation_error)
    {
        Assert::isType($validation_error, ValidationError::class, 'validation_error');

        $error_model = new ValidationErrorModel();
        $error_model->class_name = $validation_error->getClassName();
        $error_model->property_name = $validation_error->getPropertyName();
        $error_model->property_value = $validation_error->getPropertyValue();
        $error_model->message = $validation_error->getMessage();
        $error_model->path = $validation_error->getPropertyPathAsString();

        return $error_model;
    }
}
