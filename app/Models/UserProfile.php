<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['age', 'height', 'weight', 'gender', 'bio', 'avatar', 'label'])]
class UserProfile extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
