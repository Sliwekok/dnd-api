<?php

namespace App\Repository;

use App\Document\Monster;

class MonsterRepository extends BaseRepository
{
    protected function setDocument(): string
    {
        return Monster::class;
    }

}
