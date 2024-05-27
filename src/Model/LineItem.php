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
 * @method self   setExternalId(string $externalId)
 * @method string getExternalId()
 * @method self   setTitle(string $title)
 * @method string getTitle()
 * @method self   setQuantity(int $quantity)
 * @method int    getQuantity()
 * @method self   setDescription(string|null $description)
 * @method string|null getDescription()
 * @method self   setCategory(string|null $category)
 * @method string|null getCategory()
 * @method self   setBrand(string|null $brand)
 * @method string|null getBrand()
 * @method self   setGtin(string|null $gtin)
 * @method string getGtin()
 * @method self   setMpn(string|null $mpn)
 * @method string|null getMpn()
 * @method self   setProductUrl(string|null $productUrl)
 * @method string|null getProductUrl()
 * @method self   setImageUrl(string|null $imageUrl)
 * @method string|null getImageUrl()
 * @method self   setType(string|null $type)
 * @method string|null getType()
 * @method self   setQuantityUnit(string|null $quantityUnit)
 * @method string|null getQuantityUnit()
 * @method self   setTaxRate(float|null $taxRate)
 * @method float|null  getTaxRate()
 * @method self   setTotalDiscountAmount(float|null $totalDiscountAmount)
 * @method float|null  getTotalDiscountAmount()
 * @method self   setUnitPrice(float|null $unitPrice)
 * @method float|null  getUnitPrice()
 * @method self   setAmount(Amount $amount)
 *
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

    protected Amount $amount;
}
