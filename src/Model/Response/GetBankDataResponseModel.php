<?php

namespace Billie\Sdk\Model\Response;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @internal Please note, that this model will vary in the future
 */
class GetBankDataResponseModel extends AbstractResponseModel
{
    /**
     * @var array
     */
    private $items;

    /**
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string $bic
     *
     * @return string|null
     */
    public function getBankName($bic)
    {
        foreach ($this->items as $item) {
            if ($item['BIC'] === $bic) {
                return $item['Name'];
            }
        }

        return null;
    }

    public function fromArray($data)
    {
        $this->items = ResponseHelper::getValue($data, 'items');

        return $this;
    }
}
