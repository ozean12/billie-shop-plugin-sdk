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

class BillieException extends Exception
{
    /**
     * @var string
     */
    protected $billieCode;

    /**
     * @param string     $message
     * @param string     $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = '000', $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->billieCode = $code;
    }

    /**
     * @return string
     */
    public function getBillieCode()
    {
        return $this->billieCode;
    }
}
