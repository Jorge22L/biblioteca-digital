<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';
    public $timestamps = true;

    protected $fillable = [
        'password',
    ];

    public function setPasswordAttribute($value){
        if($value && strlen($value) < 60){
            $this->attributes['password'] = bcrypt($value);
        }
        else{
            $this->attributes['password'] = $value;
        }
    }
}