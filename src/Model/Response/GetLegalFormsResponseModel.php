<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Model\LegalForm;

class GetLegalFormsResponseModel extends AbstractResponseModel
{
    /**
     * @var LegalForm[]
     */
    protected array $items = [];

    public function fromArray(array $data): self
    {
        $this->items = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->items[] = (new LegalForm())->fromArray($item);
            }
        }

        return $this;
    }

    /**
     * @return LegalForm[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
