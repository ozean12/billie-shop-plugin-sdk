<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Response;

use Billie\Sdk\Model\Response\CreateCreditNoteResponseModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateCreditNoteResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $responseModel = new CreateCreditNoteResponseModel([
            'uuid' => '12345678',
        ]);

        static::assertEquals('12345678', $responseModel->getUuid());
    }
}
