<?php

namespace Billie\Util;

/**
 * Class BillieBankaccountProvider
 *
 * @package Billie\util
 * @author Marcel Barten <github@m-barten.de>
 */
class BillieBankaccountProvider
{

    const PATH = '/../../assets/billie_bankaccount.json';

    /**
     * @return array
     */
    public static function all()
    {
        $json = file_get_contents(__DIR__ . self::PATH);
        $data = json_decode($json, true);

        $result = [];
        foreach ($data as $row) {

            $result[$row['bic']] = [
                'bic' => $row['bic'],
                'label' => $row['institution']
            ];
        }

        return $result;
    }

    /**
     * @param $bic
     * @return array
     */
    public static function get($bic)
    {
        $billieBankaccounts = self::all();

        if (array_key_exists($bic, $billieBankaccounts)) {
            return $billieBankaccounts[$bic];
        }

        return [];
    }

}