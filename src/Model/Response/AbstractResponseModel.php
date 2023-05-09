<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Model\AbstractModel;

abstract class AbstractResponseModel extends AbstractModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data, true);
    }
}
