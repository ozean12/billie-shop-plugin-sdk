<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response\Auth;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getClientId()
 * @method array  getScopes()
 */
class ValidateTokenResponse extends AbstractResponseModel
{
    protected string $clientId;

    /**
     * @var string[]
     */
    protected array $scopes = [];

    public function fromArray(array $data): self
    {
        $this->clientId = ResponseHelper::getStringNN($data, 'client_id');
        $this->scopes = ResponseHelper::getArray($data, 'scopes') ?? [];

        return $this;
    }
}
