<?php

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ResponseHelper;

/**
 * @method self   setExternalId(string $externalId)
 * @method string getExternalId()
 * @method self   setTitle(string $title)
 * @method string getTitle()
 * @method self   setQuantity(int $quantity)
 * @method int    getQuantity()
 * @method self   setDescription(string $description)
 * @method string getDescription()
 * @method self   setCategory(string $category)
 * @method string getCategory()
 * @method self   setBrand(string $brand)
 * @method string getBrand()
 * @method self   setGtin(string $gtin)
 * @method string getGtin()
 * @method self   setMpn(string $mpn)
 * @method string getMpn()
 * @method self   setAmount(Amount $amount)
 * @method Amount getAmount()
 */
class LineItem extends AbstractModel
{
    protected ?string $externalId = null;

    protected ?string $title = null;

    protected ?int $quantity = null;

    protected ?string $description = null;

    protected ?string $category = null;

    protected ?string $brand = null;

    protected ?string $gtin = null;

    protected ?string  $mpn = null;

    protected ?Amount $amount = null;

    public function getFieldValidations(): array
    {
        return [
            'externalId' => 'string',
            'title' => 'string',
            'quantity' => 'integer',
            'description' => '?string',
            'category' => '?string',
            'brand' => '?string',
            'gtin' => '?string',
            'mpn' => '?string',
            'amount' => '?' . Amount::class,
        ];
    }

    public function fromArray(array $data): self
    {
        $this->externalId = ResponseHelper::getString($data, 'external_id');
        $this->title = ResponseHelper::getString($data, 'title');
        $this->quantity = ResponseHelper::getInt($data, 'quantity');
        $this->description = ResponseHelper::getString($data, 'description');
        $this->category = ResponseHelper::getString($data, 'category');
        $this->brand = ResponseHelper::getString($data, 'brand');
        $this->gtin = ResponseHelper::getString($data, 'gtin');
        $this->mpn = ResponseHelper::getString($data, 'mpn');
        $this->amount = ResponseHelper::getObject($data, 'external_id', Amount::class, $this->readOnly);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'title' => $this->title,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'category' => $this->category,
            'brand' => $this->brand,
            'gtin' => $this->gtin,
            'mpn' => $this->mpn,
            'amount' => $this->amount instanceof Amount ? $this->amount->toArray() : null,
        ];
    }
}
