<?php

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
    /** @var string */
    protected $externalId;

    /** @var string */
    protected $title;

    /** @var int */
    protected $quantity;

    /** @var string */
    protected $description;

    /** @var string */
    protected $category;

    /** @var string */
    protected $brand;

    /** @var string */
    protected $gtin;

    /** @var string */
    protected $mpn;

    /** @var Amount */
    protected $amount;

    /**
     * {@inheritDoc}
     */
    public function getFieldValidations()
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

    /**
     * {@inheritDoc}
     */
    public function fromArray($data)
    {
        $this->externalId = ResponseHelper::getValue($data, 'external_id');
        $this->title = ResponseHelper::getValue($data, 'title');
        $this->quantity = ResponseHelper::getValue($data, 'quantity');
        $this->description = ResponseHelper::getValue($data, 'description');
        $this->category = ResponseHelper::getValue($data, 'category');
        $this->brand = ResponseHelper::getValue($data, 'brand');
        $this->gtin = ResponseHelper::getValue($data, 'gtin');
        $this->mpn = ResponseHelper::getValue($data, 'mpn');
        $this->amount = ResponseHelper::getObject($data, 'external_id', Amount::class, $this->readOnly);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
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
            'amount' => $this->amount->toArray(),
        ];
    }
}
