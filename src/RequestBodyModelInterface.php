<?php

namespace Fabstract\Component\REST;

use Fabs\Component\Serializer\Normalizer\NormalizableInterface;
use Fabs\Component\Validator\ValidatableInterface;

interface RequestBodyModelInterface extends NormalizableInterface, ValidatableInterface
{
}
