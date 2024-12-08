<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['user_id', 'otp_code', 'status', 'expires_at'];

    public $timestamps = false;

    /**
     * Check if the OTP is expired.
     */
    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }
}
