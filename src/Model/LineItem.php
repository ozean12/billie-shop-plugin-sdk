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

    protected ?string $mpn = null;

    protected Amount $amount;
}
