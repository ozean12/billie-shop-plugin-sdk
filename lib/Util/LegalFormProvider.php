<?php

namespace Billie\Util;

/**
 * Class LegalFormProvider
 *
 * @package Billie\util
 * @author Marcel Barten <github@m-barten.de>
 */
class LegalFormProvider
{

    const PATH = '/../../assets/legal-forms.json';

    /**
     * @return array
     */
    public static function all()
    {
        $json = file_get_contents(__DIR__ . self::PATH);
        $data = json_decode($json, true);

        $result = [];
        foreach ($data as $row) {
            if (array_key_exists('requred', $row)) {
                $required = $row['requred'];
            } else {
                $required = $row['required'];
            }

            $result[$row['code']] = [
                'code' => $row['code'],
                'label' => $row['name'],
                'vat_id_required' => $row['required_input'] === 'Ust-ID' && $required === 1,
                'registration_id_required' => $row['required_input'] === 'HR-NR' && $required === 1,
            ];
        }

        return $result;
    }

    /**
     * @param $code
     * @return array
     */
    public static function get($code)
    {
        $allLegalForms = self::all();

        if (array_key_exists($code, $allLegalForms)) {
            return $allLegalForms[$code];
        }

        return [];
    }

    /**
     * @param string $legalFormCode
     * @return boolean
     */
    public static function isVatIdRequired($legalFormCode)
    {
        if ($result = self::get($legalFormCode)) {
            return $result['vat_id_required'];
        }

        return false;
    }

    /**
     * @param string $legalFormCode
     * @return boolean
     */
    public static function isRegistrationIdRequired($legalFormCode)
    {
        if ($result = self::get($legalFormCode)) {
            return $result['registration_id_required'];
        }

        return false;
    }

    /**
     * @param string $legalForm
     * @return array
     */
    public static function getInformationFor($legalForm)
    {
        $allRows = self::all();
        if (array_key_exists($legalForm, $allRows)) {
            return $allRows[$legalForm];
        }

        return [];
    }
}