<?php

namespace App\Helper;

use Doctrine\ODM\MongoDB\DocumentManager;

class ValidateData
{
    public function __construct(
        private DocumentManager $dm,
    ) {}

    public function checkColumns ($data, $entity): bool {
        $entity = new $entity();
        if (!empty($entity->getAllowedFields())) {
            foreach ($data as $key => $value) {
                if (!$entity->isFieldAllowed($key)) {
                    return false;
                }
            }
        }
        return true;
    }

	public function checkColumnsValueTypes(array $data, string $entity): bool {
        $entity = new $entity();

		foreach ($data as $key => $value) {
			$mapping = $entity->getAllowedFields();
            foreach ($mapping as $field) {
                switch ($field['type']) {
                    case 'string':
                        if (!is_string($value)) return false;
                        break;
                    case 'int':
                    case 'integer':
                        if (!is_numeric($value)) return false;
                        break;
                    case 'float':
                    case 'double':
                        if (!is_float($value) && !is_int($value) && !is_numeric($value)) return false;
                        break;
                    case 'bool':
                    case 'boolean':
                        if (!is_bool($value)) return false;
                        break;
                    default:
                        break;
                }
            }
		}

		return true;
	}


}
