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

	public function checkColumnsValueTypes(array $data, string $entity): bool {
		$classMetadata = $this->dm->getClassMetadata($entity);

		foreach ($data as $key => $value) {
			if (!$classMetadata->hasField($key)) {
				return false;
			}

			$mapping = $classMetadata->getFieldMapping($key);
			$type = $mapping['type'] ?? null;

			switch ($type) {
				case 'string':
					if (!is_string($value)) return false;
					break;
				case 'int':
				case 'integer':
					if (!is_int($value)) return false;
					break;
				case 'float':
				case 'double':
					if (!is_float($value) && !is_int($value)) return false;
					break;
				case 'bool':
				case 'boolean':
					if (!is_bool($value)) return false;
					break;
				default:
					break;
			}
		}

		return true;
	}


}
