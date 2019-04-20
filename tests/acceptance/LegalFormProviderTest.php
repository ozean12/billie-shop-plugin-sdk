<?php

namespace Billie\Tests\acceptance;

use Billie\Util\LegalFormProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class LegalFormProviderTest
 *
 * @package Billie\Tests\acceptance
 * @author Marcel Barten <github@m-barten.de>
 */
class LegalFormProviderTest extends TestCase
{
    public function testGetAllSupportedLegalForms()
    {
        $allSupportedLegalForms = LegalFormProvider::all();

        $this->assertArrayHasKey('UG (haftungsbeschränkt) & Co. KGaA', $allSupportedLegalForms);
    }

    public function testCheckRegistrationNumberRequirement()
    {
        $gmbhRegistrationNumberRequired = LegalFormProvider::isRegistrationIdRequired('Gesellschaft mit beschränkter Haftung');

        $this->assertTrue($gmbhRegistrationNumberRequired);
    }

    public function testCheckVatIdRequirement()
    {
        $gbrVatRequired = LegalFormProvider::isVatIdRequired('Einzelunternehmer');

        $this->assertTrue($gbrVatRequired);
    }
}