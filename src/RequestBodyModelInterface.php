<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\Serializer\Normalizer\NormalizableInterface;
use Fabstract\Component\Validator\ValidatableInterface;

interface RequestBodyModelInterface extends NormalizableInterface, ValidatableInterface
{
}
