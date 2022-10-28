<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'employee_id',
        'phone',
        'point'
    ];
}
