<?php

namespace App\Repository;

use App\Document\Traits;

class TraitsRepository extends BaseRepository
{
    protected function setDocument(): string
    {
        return Traits::class;
    }

}
