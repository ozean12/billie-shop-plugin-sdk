<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

use RuntimeException;

class BillieBankaccountProvider
{
    /**
     * @var string
     */
    public const PATH = '/../../assets/billie_bankaccount.json';

    public static function all(): array
    {
        $file = __DIR__ . self::PATH;
        if (!is_readable($file)) {
            throw new RuntimeException($file . ' is not readable. Please make sure that the file is readable.');
        }

        $json = file_get_contents($file);
        /** @var array[]|mixed $data */
        $data = json_decode((string) $json, true);

        if (!is_array($data)) {
            return [];
        }

        $result = [];
        foreach ($data as $row) {
            $result[$row['bic']] = [
                'bic' => $row['bic'],
                'label' => $row['institution'],
            ];
        }

        return $result;
    }

    public static function get(string $bic): array
    {
        $billieBankaccounts = self::all();

        if (array_key_exists($bic, $billieBankaccounts)) {
            return $billieBankaccounts[$bic];
        }

        return [];
    }
}
