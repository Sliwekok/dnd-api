<?php
declare(strict_types=1);

namespace App\Service;

use App\Helper\ValidateData;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\UniqueNameInterface\HttpCodesInterface;

class ValidationService
{
    private ValidateData $validateData;

    public function __construct(DocumentManager $dm)
    {
        $this->validateData = new ValidateData($dm);
    }

    public function validateRequestData(array $data, string $documentClass): ?JsonResponse
    {
        if (!empty($data)) {
            $columnValidator = $this->validateData->checkColumns($data, $documentClass);
            if (!$columnValidator) {
                return new JsonResponse(['msg' => 'Invalid data column names'], HttpCodesInterface::BAD_REQUEST);
            }

            $valueValidator = $this->validateData->checkColumnsValueTypes($data, $documentClass);
            if (!$valueValidator) {
                return new JsonResponse(['msg' => 'Invalid data column value types'], HttpCodesInterface::BAD_REQUEST);
            }
        }

        return null;
    }
}
