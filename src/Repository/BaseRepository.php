<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\Query\Parameter;
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
        $array = [];

		if (empty($items)) return $array;

        if (is_object($items)) {
            if (method_exists($items, 'toArray')) {
                $array[] = $items->toArray();
            } else {
                $array[] = json_decode(json_encode($items), true);
            }
        } else {
            foreach ($items as $item) {
                if (method_exists($item, 'toArray')) {
                    $array[] = $item->toArray();
                } else {
                    $array[] = json_decode(json_encode($item), true);
                }
            }
        }
        if (!empty(static::$unsetFields)) {
            foreach ($array as $key => $item) {
                foreach (static::$unsetFields as $field) {
                    if (isset($item[$field])) {
                        unset($array[$key][$field]);
                    }
                }
            }
        }

        return $array;
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
				$fieldBuilder->equals($value);
			}
		}




		return $builder->getQuery()->execute()->toArray();
	}
}
