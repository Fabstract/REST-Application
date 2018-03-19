<?php

namespace Fabstract\Component\REST\Model;

use Fabs\Component\Serializer\Normalizer\NormalizableInterface;
use Fabs\Component\Serializer\Normalizer\NormalizationMetadata;
use Fabs\Component\Validator\ValidatableInterface;
use Fabs\Component\Validator\Validation\StringValidation;
use Fabs\Component\Validator\ValidationMetadata;

class ResponseModel implements NormalizableInterface, ValidatableInterface
{
    /** @var string */
    public $status = null;
    /** @var array|object */
    public $data = null;

    /**
     * @param NormalizationMetadata $normalization_metadata
     * @return void
     */
    public function configureNormalizationMetadata($normalization_metadata)
    {
        $normalization_metadata->setRenderIfNotNull('data');
    }

    /**
     * @param ValidationMetadata $validation_metadata
     * @return void
     */
    public function configureValidationMetadata($validation_metadata)
    {
        $validation_metadata->addValidation('status', new StringValidation());
    }
}
