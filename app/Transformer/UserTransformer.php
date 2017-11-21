<?php

namespace App\Transformer;

use Illuminate\Database\Eloquent\Model;

class UserTransformer extends Transformer  
{

    public function transform($user)
    {
        return [
            'account' => $user['account'],
            'password' => $user['password'],
            'email' => $user['email'],
			'created_at' => $user['created_at']
        ];
    }


}
