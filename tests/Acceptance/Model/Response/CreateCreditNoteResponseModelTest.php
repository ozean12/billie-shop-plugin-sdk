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
    public function testToArray(): void
    {
        static::assertEquals([], $this->getValidModel()->toArray());
    }

    public function testFromArray(): void
    {
        $responseModel = $this->getValidModel();

        static::assertEquals('12345678', $responseModel->getUuid());
    }

    protected function getValidModel(): CreateCreditNoteResponseModel
    {
        return new CreateCreditNoteResponseModel([
            'uuid' => '12345678',
        ]);
    }
}
