<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
