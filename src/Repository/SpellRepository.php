<?php

namespace App\Repository;

use App\Document\Spell;

class SpellRepository extends BaseRepository
{
    protected function setDocument(): string
    {
        return Spell::class;
    }

}
