<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Model\Request\GetBankDataRequestModel;
use Billie\Sdk\Service\Request\GetBankDataRequest;
use PHPUnit\Framework\TestCase;

class GetBankDataRequestTest extends TestCase
{
    public function testExecute(): void
    {
        $requestService = new GetBankDataRequest();
        $responseModel = $requestService->execute(new GetBankDataRequestModel());

        static::assertIsArray($responseModel->getItems());
        static::assertGreaterThan(30, $responseModel->getItems());

        // currently this values come from a static file from the sdk, so we can compare exact names.
        static::assertEquals('Aachener Bausparkasse', $responseModel->getBankName('AABSDE31XXX'));
        static::assertEquals('DB Privat- und Firmenkundenbank (Deutsche Bank PGK)', $responseModel->getBankName('DEUTDEDB803'));
    }
}
