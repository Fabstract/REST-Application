<?php

namespace Fabstract\Component\REST\Model;

class ErrorResponseModel extends ResponseModel
{
    /** @var string */
    public $error_message = null;
    /** @var null|object */
    public $error_details = null;

    public function configureNormalizationMetadata($normalization_metadata)
    {
        parent::configureNormalizationMetadata($normalization_metadata);

        $normalization_metadata->setRenderIfNotNull('error_details');
    }
}
