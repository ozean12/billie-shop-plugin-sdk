<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

use BadMethodCallException;
use Psr\Log\LoggerInterface;
use Stringable;

/**
 * @method static void debug(string|Stringable $message, array $context = [])
 * @method static void error(string|Stringable $message, array $context = [])
 * @method static void alert(string|Stringable $message, array $context = [])
 * @method static void info(string|Stringable $message, array $context = [])
 * @method static void critical(string|Stringable $message, array $context = [])
 * @method static void emergency(string|Stringable $message, array $context = [])
 * @method static void notice(string|Stringable $message, array $context = [])
 * @method static void warning(string|Stringable $message, array $context = [])
 */
class Logging
{
    private static LoggerInterface $logger;

    private static bool $logHeaders = false;

    public static function __callStatic(string $name, array $params): void
    {
        $logLevel = strtolower($name);

        if (isset(self::$logger)) {
            if (method_exists(self::$logger, $logLevel)) {
                self::$logger->{$logLevel}($params[0], $params[1]);
            }

            throw new BadMethodCallException(sprintf('Log-Level or method `%s` does not exist', $logLevel));
        }
    }

    public static function setPsr3Logger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    public static function isLogHeaders(): bool
    {
        return self::$logHeaders;
    }

    public static function setLogHeaders(bool $logHeaders): void
    {
        self::$logHeaders = $logHeaders;
    }
}
