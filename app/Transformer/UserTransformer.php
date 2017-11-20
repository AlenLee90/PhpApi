<?php

namespace App\Transformer;

use Illuminate\Database\Eloquent\Model;

class UserTransformer extends Transformer  
{

    public function transform($user)
    {
        return [
            'user_id' => $user['user_id'],
            'password' => $user['password'],
            'email' => $user['email'],
			'created_at' => $user['created_at']
        ];
    }


}
