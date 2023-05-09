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
 * @method string getUuid()
 * @method self   setUuid(string $uuid)
 */
class OrderRequestModel extends AbstractRequestModel implements EntityRequestModelInterface
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        parent::__construct();
        $this->setUuid($uuid);
    }

    public function getBillieEntityId(): string
    {
        return $this->getUuid();
    }

    protected function _toArray(): array
    {
        // this request does not have any body-parameters
        return [];
    }
}
