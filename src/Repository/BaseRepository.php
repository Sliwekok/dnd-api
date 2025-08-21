<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectRepository;


abstract class BaseRepository extends ServiceEntityRepository
{
    protected DocumentManager $dm;
    protected string $class;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $this->class = $this->setDocument();
    }

    abstract protected function setDocument(): string;

    function getDocument (): mixed
    {
        return $this->class;
    }

    protected static array $unsetFields = [
        'id',
        'allowedFields',
        'source',
        'accepted',
    ];

    protected function getRepository(): ObjectRepository
    {
        return $this->dm->getRepository($this->class);
    }

    public function getSingle(string $name) : ?array
    {
        $item = $this->getRepository()->findOneBy(['nameGeneric' => $name]);
        return $this->toArray($item);
    }

    public function getList($cond = false) : array
    {
        if ($cond) {

            $items = $this->getRepository()->findBy($cond);
        } else {
            $items = $this->getRepository()->findAll();
        }
	    return $this->toArray($items);
    }

    public function toArray(mixed $items): array
    {
        $strip = function(array $doc): array {
            foreach (static::$unsetFields as $field) {
                if (array_key_exists($field, $doc)) {
                    unset($doc[$field]);
                }
            }
            return $doc;
        };

        if (is_iterable($items)) {
            $out = [];
            foreach ($items as $item) {
                if (is_object($item) && method_exists($item, 'toArray')) {
                    $doc = $item->toArray();
                } elseif (is_array($item)) {
                    $doc = $item;
                } else {
                    $doc = json_decode(json_encode($item), true);
                }

                $out[] = $strip($doc);
            }
            return $out;
        }

        if (is_object($items)) {
            $doc = method_exists($items, 'toArray')
                ? $items->toArray()
                : json_decode(json_encode($items), true);

            return $strip($doc);
        }

        return [];
    }

    public function getListFiltered($data): array {
		$builder = $this->dm->createQueryBuilder($this->class);
		$entity = $this->getDocument();

		foreach ($data as $field => $value) {
			$key = $entity::$allowedFields[$field]['key'];
			$type = $entity::$allowedFields[$field]['type'];

			// operator handling
			$operator = null;
			if (preg_match('/^(>=|<=|>|<)(.*)$/', trim($value), $matches)) {
				$operator = $matches[1];
				$value = trim($matches[2]);
			}

			// data type for DB
			switch ($type) {
				case 'integer':
					$value = (int) $value;
					break;
				case 'float':
					$value = (float) $value;
					break;
				case 'boolean':
					$value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
					break;
                case 'string':
                    $value = trim($value);
                case 'array':
                    $value = is_array($value) ? $value : explode(',', $value);
			}

			$fieldBuilder = $builder->field($key);
			if ($operator) {
				match ($operator) {
					'>'  => $fieldBuilder->gt($value),
					'>=' => $fieldBuilder->gte($value),
					'<'  => $fieldBuilder->lt($value),
					'<=' => $fieldBuilder->lte($value),
					default => $fieldBuilder->equals($value),
				};
			} else {
                if ($type === 'array') {
                    $fieldBuilder->in($value);
                } else {
                    $fieldBuilder->equals($value);
                }
			}
		}

		$data = $builder->getQuery()->execute();
        return $this->toArray($data);
	}
}
