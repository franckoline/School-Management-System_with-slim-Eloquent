<?php

namespace Main\Transformers;

use Main\Models\Users;
use League\Fractal\TransformerAbstract;

class UsersTransformer extends TransformerAbstract
{

    public function transform(Users $user)
    {
        return [
            'id'            => (int)$user->id,
            'email'         => $user->email,           
            'username'      => $user->username,
            'firstname'     =>$user->username,
            'token'         => $user->token,
            'createdAt'     => optional($user->created_at)->toIso8601String(),
            'updatedAt'     => optional($user->update_at)->toIso8601String(),

        ];
    }
}