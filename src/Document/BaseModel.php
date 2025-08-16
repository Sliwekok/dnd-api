<?php

namespace App\Document;

use ReflectionClass;

abstract class BaseModel
{


    /**
     * Fields allowed for search.
     * Child classes can override.
     */
    public static array $allowedFields = [];

    /**
     * Get allowed fields for search.
     */
    public static function getAllowedFields(): array
    {
        return static::$allowedFields;
    }

    /**
     * Check if field is allowed for search.
     */
    public static function isFieldAllowed(string $field): bool
    {
        return array_key_exists($field, static::$allowedFields);
    }

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
