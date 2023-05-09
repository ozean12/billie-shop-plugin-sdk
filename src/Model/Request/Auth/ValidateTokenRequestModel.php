<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\Auth;

use Billie\Sdk\Model\Request\AbstractRequestModel;

class ValidateTokenRequestModel extends AbstractRequestModel
{
    protected function _toArray(): array
    {
        return [];
    }
}
