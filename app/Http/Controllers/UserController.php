<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformer\UserTransformer;

class UserController extends ApiController
{
	protected $userTransformer;
	
	public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }
	
        public function index()
    {

        $users = User::all();
        return $this->response(
            [
                'status' => 'success',
                'status_code' => $this->getStatusCode(),
                'data' => $this->userTransformer->transformCollection($users->toArray())
            ]
        );
    }

    public function show($id)
    {
        $user = User::find($id);

        if (! $user)
        {
            return $this->setStatusCode(404)->responseNotFound();
        }

        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $this->userTransformer->transform($user)
            ]
        );
    }
}
