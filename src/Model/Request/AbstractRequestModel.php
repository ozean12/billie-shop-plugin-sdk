<?php

namespace Billie\Sdk\Model\Request;

use BadMethodCallException;
use Billie\Sdk\Model\AbstractModel;

abstract class AbstractRequestModel extends AbstractModel
{
    public function __construct()
    {
        parent::__construct(null, false);
    }

    public function fromArray($data)
    {
        throw new BadMethodCallException('the method `fromArray` is not allowed on the model ' . get_class($this));
    }
}
