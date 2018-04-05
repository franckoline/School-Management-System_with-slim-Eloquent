<?php

namespace Main\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $fillable = ['username', 'email','firstname', 'token', 'image', 'bio', 'moto',
                            'address', 'mission', 'vision', 'about', 'phone', 'search_term',
                          ];

    protected $hidden = [
        'password',
    ];

    public function getImageAttribute($value){
        if (is_null($value)) {
            return 'https://aiivon.com/wp-content/uploads/2017/08/aiivon-web-logo.png';
        }

        return $value;
    }

    /********************
     *  Relationships
     ********************/

    

}
