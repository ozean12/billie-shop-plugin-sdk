<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Exception;

/**
 * Class OrderNotCancelledException
 *
 * @author Marcel Barten <github@m-barten.de>
 */
class OrderNotCancelledException extends BillieException
{
    /**
     * @var string
     */
    protected $message = 'The order %s has not been cancelled.';

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @param string $referenceId
     */
    public function __construct($referenceId)
    {
        parent::__construct();
        $this->referenceId = $referenceId;
    }

    public function getBillieCode(): string
    {
        return 'ORDER_NOT_CANCELLED';
    }

    public function getBillieMessage(): string
    {
        return sprintf($this->message, $this->referenceId);
    }
}
