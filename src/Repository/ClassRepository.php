<?php

namespace App\Repository;

use App\Document\CharacterClass;

class ClassRepository extends BaseRepository
{
    protected function setDocument(): string
    {
        return CharacterClass::class;
    }

}
