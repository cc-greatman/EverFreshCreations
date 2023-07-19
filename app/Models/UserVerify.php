<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;

    public $table = "user_verify";

    /**
     * Write code on method
     *
     * @return response()
     */
    protected $fillable = [
        'user_id',
        'token'
    ];

    /**
     * Write Code on Method
     *
     * @return response()
     */
    public function user () {

        return $this->belongsTo(User::class, 'user_id');
    }
}
