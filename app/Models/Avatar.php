<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Avatar
 * @package App\Models
 * @property string $avatar
 * @property integer $user_id
 */
class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'user_id'
    ];
}
