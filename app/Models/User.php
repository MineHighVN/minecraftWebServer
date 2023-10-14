<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable
{
    use HasFactory;

    protected $rememberTokenName = '';

    public function getRank () {
        return $this->hasOne(Rank::class, 'id', 'rank');
    }

    public function checkPerm ($perm): bool {
        return $this->getRank?->checkPerm($perm) ? true : false;
    }
}
