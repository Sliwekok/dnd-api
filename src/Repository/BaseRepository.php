<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectRepository;


abstract class BaseRepository
{
    protected DocumentManager $dm;
    protected string $class;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $this->class = $this->setDocument();
    }

    abstract protected function setDocument(): string;

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
            return $array;
        }
        return $array;
    }
}
