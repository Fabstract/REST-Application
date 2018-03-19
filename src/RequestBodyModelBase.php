<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\Serializer\Normalizer\NormalizableInterface;
use Fabstract\Component\Validator\ValidatableInterface;

abstract class RequestBodyModelBase implements NormalizableInterface, ValidatableInterface
{
}
