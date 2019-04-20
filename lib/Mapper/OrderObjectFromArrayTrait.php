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
        $object->orderId = $orderResponse['order_id'];
        $object->state = $orderResponse['state'];

        $object->bankAccount = new BankAccount($orderResponse['bank_account']['iban'], $orderResponse['bank_account']['bic']);

        $companyAddress = new Address();
        $companyAddress->street = $orderResponse['debtor_company']['address_street'];
        $companyAddress->houseNumber = $orderResponse['debtor_company']['address_house_number'];
        $companyAddress->city = $orderResponse['debtor_company']['address_city'];
        $companyAddress->postalCode = $orderResponse['debtor_company']['address_postal_code'];
        $companyAddress->countryCode = $orderResponse['debtor_company']['address_country'];
        $object->debtorCompany = new Company('', $orderResponse['debtor_company']['name'], $companyAddress);

        if ($orderResponse['invoice']) {
            $invoice = new Invoice();
            $invoice->number = $orderResponse['invoice']['invoice_number'];
            $invoice->payoutAmount = $orderResponse['invoice']['payout_amount'];
            $invoice->feeAmount = $orderResponse['invoice']['fee_amount'];
            $invoice->feeRate = $orderResponse['invoice']['fee_rate'];
            $invoice->dueDate = $orderResponse['invoice']['due_date'];

        }
        $object->invoice = isset($invoice) ? $invoice : null;

        return $object;
    }
}