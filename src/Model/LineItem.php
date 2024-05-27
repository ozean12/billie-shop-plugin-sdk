<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

/**
 * @method $this   setExternalId(string $externalId)
 * @method string getExternalId()
 * @method $this   setTitle(string $title)
 * @method string getTitle()
 * @method $this   setQuantity(int $quantity)
 * @method int    getQuantity()
 * @method $this   setDescription(string|null $description)
 * @method string|null getDescription()
 * @method $this   setCategory(string|null $category)
 * @method string|null getCategory()
 * @method $this   setBrand(string|null $brand)
 * @method string|null getBrand()
 * @method $this   setGtin(string|null $gtin)
 * @method string getGtin()
 * @method $this   setMpn(string|null $mpn)
 * @method string|null getMpn()
 * @method $this   setProductUrl(string|null $productUrl)
 * @method string|null getProductUrl()
 * @method $this   setImageUrl(string|null $imageUrl)
 * @method string|null getImageUrl()
 * @method $this   setType(string|null $type)
 * @method string|null getType()
 * @method $this   setQuantityUnit(string|null $quantityUnit)
 * @method string|null getQuantityUnit()
 * @method $this   setTaxRate(float|null $taxRate)
 * @method float|null  getTaxRate()
 * @method $this   setTotalDiscountAmount(float|null $totalDiscountAmount)
 * @method float|null  getTotalDiscountAmount()
 * @method $this   setUnitPrice(float|null $unitPrice)
 * @method float|null  getUnitPrice()
 * @method $this   setAmount(Amount $amount)
 * @method Amount getAmount()
 */
class LineItem extends AbstractModel
{
    protected ?string $externalId = null;

    protected ?string $title = null;

    protected ?string $description = null;

    protected ?int $quantity = null;

    protected ?string $category = null;

    protected ?string $brand = null;

    protected ?string $gtin = null;

    protected ?string $mpn = null;

    protected ?string $productUrl = null;

    protected ?string $imageUrl = null;

    protected ?string $type = null;

    protected ?string $quantityUnit = null;

    protected ?float $taxRate = null;

    protected ?float $totalDiscountAmount = null;

    protected ?float $unitPrice = null;

    protected ?Amount $amount = null;

    protected function getFieldValidations(): array
    {
        return [
            'amount' => Amount::class,
        ];
    }
}
