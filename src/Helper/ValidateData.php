<?php

namespace App\Helper;

use Doctrine\ODM\MongoDB\DocumentManager;

class ValidateData
{
    public function __construct(
        private DocumentManager $dm,
    ) {}

    public function checkColumns ($data, $entity): bool {
        $columns = $this->dm->getClassMetadata($entity)->getFieldNames();
        foreach ($data as $key => $value) {
            if (!in_array($key, $columns)) {
                return false;
            }
        }
        return true;
    }

}
