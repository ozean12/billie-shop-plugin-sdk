<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Mock\Model;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string|null getObjectKey1()
 * @method string|null getObjectKey2()
 * @method ResponseHelperModelMock|null getSubObject()
 */
class ResponseHelperModelMock extends AbstractModel
{
    protected ?string $objectKey1 = null;

    protected ?string $objectKey2 = null;

    protected ?ResponseHelperModelMock $subObject = null;

    public function fromArray(array $data): AbstractModel
    {
        $this->objectKey1 = ResponseHelper::getString($data, 'key1');
        $this->objectKey2 = ResponseHelper::getString($data, 'key2');
        $this->subObject = ResponseHelper::getObject($data, 'sub', self::class);

        return $this;
    }
}
