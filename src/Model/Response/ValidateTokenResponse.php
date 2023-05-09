<?php

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
