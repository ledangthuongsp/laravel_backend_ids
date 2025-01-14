<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    //
    use HasFactory;

    protected $fillable = ['role_type'];

    /**
     * Mối quan hệ: Một Role có nhiều User.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
