<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    protected $fillable = ['name', 'role_text', 'bio', 'image', 'sort_order'];
}
