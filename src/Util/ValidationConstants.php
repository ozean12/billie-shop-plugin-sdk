<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

class ValidationConstants
{
    /**
     * @var string
     */
    public const TYPE_STRING_REQUIRED = 'string';

    /**
     * @var string
     */
    public const TYPE_STRING_OPTIONAL = '?' . self::TYPE_STRING_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_INT_REQUIRED = 'integer';

    /**
     * @var string
     */
    public const TYPE_INT_OPTIONAL = '?' . self::TYPE_INT_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_FLOAT_REQUIRED = 'float';

    /**
     * @var string
     */
    public const TYPE_FLOAT_OPTIONAL = '?' . self::TYPE_FLOAT_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_BOOLEAN_REQUIRED = 'boolean';

    /**
     * @var string
     */
    public const TYPE_BOOLEAN_OPTIONAL = '?' . self::TYPE_BOOLEAN_REQUIRED;

    /**
     * @var string
     */
    public const TYPE_ARRAY_REQUIRED = 'array';

    /**
     * @var string
     */
    public const TYPE_ARRAY_OPTIONAL = '?' . self::TYPE_ARRAY_REQUIRED;
}
