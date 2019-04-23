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

        $this->assertArrayHasKey('10001', $allSupportedLegalForms);
    }

    public function testCheckRegistrationNumberRequirement()
    {
        $gmbhRegistrationNumberRequired = LegalFormProvider::isRegistrationIdRequired('10001');

        $this->assertTrue($gmbhRegistrationNumberRequired);
    }

    public function testCheckVatIdRequirement()
    {
        $gbrVatRequired = LegalFormProvider::isVatIdRequired('6022');

        $this->assertTrue($gbrVatRequired);
    }
}