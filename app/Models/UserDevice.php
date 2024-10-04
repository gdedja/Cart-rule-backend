<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [
        'user_id', 'device_name', 'device_ip',
    ];

    // Define any relationships here if needed
    // For example, if a device belongs to a user:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
