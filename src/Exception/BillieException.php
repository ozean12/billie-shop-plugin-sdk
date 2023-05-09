<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

use Exception;
use Throwable;

class BillieException extends Exception
{
    protected string $billieCode;

    public function __construct(string $message = '', string $code = '000', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->billieCode = $code;
    }

    public function getBillieCode(): string
    {
        return $this->billieCode;
    }
}
