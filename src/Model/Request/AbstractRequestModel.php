<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

use BadMethodCallException;
use Billie\Sdk\Model\AbstractModel;

abstract class AbstractRequestModel extends AbstractModel
{
    public function __construct()
    {
        parent::__construct([], false);
    }

    public function fromArray(array $data): self
    {
        throw new BadMethodCallException('the method `fromArray` is not allowed on the model ' . static::class);
    }
}
