<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

/**
 * @method string|null getAddition()
 * @method $this setAddition(string|null $addition)
 *
 * @deprecated may be merged with the parent model
 */
class AddressWithAddition extends Address
{
    protected ?string $addition = null;
}
