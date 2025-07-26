<?php

namespace App\Document;

use ReflectionClass;

class BaseModel
{
    public function toArray(): array {
        $data = [];
        $class = new ReflectionClass($this);

        do {
            foreach ($class->getProperties() as $property) {
                if ($property->getName() == 'id') {
                    continue;
                }
                if ($property->getName() == 'url') {
                    continue;
                }
                $property->setAccessible(true);
                $data[$property->getName()] = $property->getValue($this);
            }
            $class = $class->getParentClass();
        } while ($class);

        return $data;
    }

}
