<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function permissions () {
        return $this->belongsToMany(Permission::class, 'rank_permissions', 'rankId', 'permissionId');
    }

    public function checkPerm ($perm): bool {
        return $this->permissions->where('permId', $perm)->count();
    }
}
