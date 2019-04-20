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

    const PATH = '/../../assets/legal-forms.csv'; // must be UTF-8 encoded

    /**
     * @return array
     */
    public static function all()
    {
        $file = file(__DIR__ . self::PATH);
        $data = array_map('str_getcsv', array_slice($file, 1));


        $result = [];
        foreach ($data as $row) {
            $rowArray = explode(';', $row[0]);
            $result[$rowArray[1]] = [
                'code' => $rowArray[0],
                'label' => $rowArray[1],
                'vat_id_required' => $rowArray[2] === 'Ust-ID' && $rowArray[3] === 'mandatory',
                'registration_id_required' => $rowArray[2] === 'HR-NR' && $rowArray[3] === 'mandatory',
            ];
        }

        return $result;
    }

    /**
     * @param string $legalForm
     * @return boolean
     */
    public static function isVatIdRequired($legalForm)
    {
        if ($result = self::getInformationFor($legalForm)) {
            return $result['vat_id_required'];
        }

        return false;
    }

    /**
     * @param string $legalForm
     * @return boolean
     */
    public static function isRegistrationIdRequired($legalForm)
    {
        if ($result = self::getInformationFor($legalForm)) {
            return $result['registration_id_required'];
        }

        return false;
    }

    /**
     * @param string $legalForm
     * @return array
     */
    private static function getInformationFor($legalForm)
    {
        $allRows = self::all();
        if (array_key_exists($legalForm, $allRows)) {
            return $allRows[$legalForm];
        }

        return [];
    }
}