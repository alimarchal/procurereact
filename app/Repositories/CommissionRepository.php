<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository
{
    public function create(array $data): Commission
    {
        return Commission::create($data);
    }
}
