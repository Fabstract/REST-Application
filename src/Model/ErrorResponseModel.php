<?php

namespace Fabstract\Component\REST\Model;

use Fabstract\Component\Serializer\Normalizer\NormalizationMetadata;

class ErrorResponseModel extends ResponseModel
{
    /** @var string */
    public $error_message = null;
    /** @var null|object */
    public $error_details = null;

    /**
     * @param NormalizationMetadata $normalization_metadata
     * @return void
     */
    public function configureNormalizationMetadata($normalization_metadata)
    {
        parent::configureNormalizationMetadata($normalization_metadata);

        $normalization_metadata->setRenderIfNotNull('error_details');
    }
}
