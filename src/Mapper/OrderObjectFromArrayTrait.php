<?php

namespace Billie\Mapper;

use Billie\Model\Address;
use Billie\Model\BankAccount;
use Billie\Model\Company;
use Billie\Model\Invoice;
use Billie\Model\Order;

/**
 * Trait OrderObjectFromArrayTrait
 *
 * @package Billie\Mapper
 * @author Marcel Barten <github@m-barten.de>
 */
trait OrderObjectFromArrayTrait
{
    /**
     * @param array $orderResponse
     * @return Order
     */
    public static function orderObjectFromArray($orderResponse)
    {
        $object = new Order();
        $object->referenceId = $orderResponse['uuid'];

        if (array_key_exists('order_id', $orderResponse)) {
            $object->orderId = $orderResponse['order_id'];
        }

        if (array_key_exists('external_code', $orderResponse)) {
            $object->orderId = $orderResponse['external_code'];
        }

        $object->state = $orderResponse['state'];

        $object->amount = $orderResponse['amount'];
        $object->amountTax = $orderResponse['amount_tax'];
        $object->amountNet = $orderResponse['amount_net'];

        $object->bankAccount = new BankAccount($orderResponse['bank_account']['iban'], $orderResponse['bank_account']['bic']);

        $companyAddress = new Address();

        if (array_key_exists('street', $orderResponse['debtor_company'])) {
            // newer version in shipOrder
            $companyAddress->street = $orderResponse['debtor_company']['street'];
            $companyAddress->houseNumber = $orderResponse['debtor_company']['house_number'];
            $companyAddress->city = $orderResponse['debtor_company']['city'];
            $companyAddress->postalCode = $orderResponse['debtor_company']['postal_code'];
            $companyAddress->countryCode = $orderResponse['debtor_company']['country'];
        } else {
            $companyAddress->street = $orderResponse['debtor_company']['address_street'];
            $companyAddress->houseNumber = $orderResponse['debtor_company']['address_house_number'];
            $companyAddress->city = $orderResponse['debtor_company']['address_city'];
            $companyAddress->postalCode = $orderResponse['debtor_company']['address_postal_code'];
            $companyAddress->countryCode = $orderResponse['debtor_company']['address_country'];
        }

        $object->debtorCompany = new Company('', $orderResponse['debtor_company']['name'], $companyAddress);

        if ($orderResponse['invoice']) {
            $invoice = new Invoice();

            if (array_key_exists('number', $orderResponse['invoice'])) {
                $invoice->number = $orderResponse['invoice']['number'];
            } else {
                $invoice->number = $orderResponse['invoice']['invoice_number'];
            }

            $invoice->payoutAmount = $orderResponse['invoice']['payout_amount'];
            $invoice->feeAmount = $orderResponse['invoice']['fee_amount'];
            $invoice->feeRate = $orderResponse['invoice']['fee_rate'];
            $invoice->dueDate = $orderResponse['invoice']['due_date'];

        }
        $object->invoice = isset($invoice) ? $invoice : null;

        return $object;
    }
}