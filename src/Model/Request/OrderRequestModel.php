<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method string getId()
 * @method self   setId(string $id)
 */
class OrderRequestModel extends AbstractRequestModel implements EntityRequestModelInterface
{
    /**
     * Uuid or the order-id
     */
    protected string $id;

    public function __construct(string $uuid)
    {
        parent::__construct();
        $this->setId($uuid);
    }

    public function getBillieEntityId(): string
    {
        return $this->getId();
    }

    protected function _toArray(): array
    {
        // this request does not have any body-parameters
        return [];
    }
}
