<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string getClientId()
 * @method array  getScopes()
 */
class ValidateTokenResponse extends AbstractResponseModel
{
    protected ?string $clientId = null;

    /**
     * @var string[]
     */
    protected array $scopes = [];

    public function fromArray(array $data): self
    {
        $this->clientId = ResponseHelper::getString($data, 'client_id');
        $this->scopes = ResponseHelper::getArray($data, 'scopes') ?? [];

        return $this;
    }
}
