<?php

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Model\LegalForm;

class GetLegalFormsResponseModel extends AbstractResponseModel
{
    /**
     * @var LegalForm[]
     */
    protected $items;

    public function fromArray($data)
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
    public function getItems()
    {
        return $this->items;
    }
}
