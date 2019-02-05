<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
/**
*Theattributesthataremassassignable.
*@vararray
*/
protected $fillable=[
    'role','name', 'surname', 'nick','email','password',
];
/**
*Theattributesthatshouldbehiddenforarrays.
*@vararray
*/
protected $hidden=[
'password','remember_token',
];
//DefinimoslarelaciónOneToManyconlatabla'images'
public function images(){
//Estemétododevuelveelarraydeobjetosconlasimágenesasociadosaunusuario
return $this->hasMany('App\Image');
}
}
