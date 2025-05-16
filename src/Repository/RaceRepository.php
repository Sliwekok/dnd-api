<?php

namespace App\Repository;

use App\Document\Race;

class RaceRepository extends BaseRepository
{
    protected function setDocument(): string
    {
        return Race::class;
    }

}
