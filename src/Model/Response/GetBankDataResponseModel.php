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
 * @internal Please note, that this model will vary in the future
 */
class GetBankDataResponseModel extends AbstractResponseModel
{
    private array $items = [];

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getBankName(string $bic): ?string
    {
        foreach ($this->items as $item) {
            if ($item['BIC'] === $bic) {
                return $item['Name'];
            }
        }

        return null;
    }

    public function fromArray(array $data): self
    {
        $this->items = ResponseHelper::getArray($data, 'items') ?? [];

        return $this;
    }
}
