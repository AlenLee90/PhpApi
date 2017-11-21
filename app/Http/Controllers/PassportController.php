<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Transformer\UserTransformer;

class PassportController extends ApiController
{

    //public $successStatus = 200;
	
	protected $userTransformer;
	
	public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['account' => request('account'),'password' => request('password'),'email' => request('email')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            //return response()->json(['success' => $success], $this->successStatus);
			return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $success
            ]
        );
        }
        else{
            //return response()->json(['error'=>'Unauthorised'], 401);
			return $this->setStatusCode(402)->tokenUnauthorised();
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            //return response()->json(['error'=>$validator->errors()], 401);
			return $this->setStatusCode(401)->validatorFails();            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //$success['token'] =  $user->createToken('MyApp')->accessToken
        $success['account'] =  $user->account;

        //return response()->json(['success'=>$success], $this->successStatus);
		return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $this->userTransformer->transform($user)
            ]
        );
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        //return response()->json(['success' => $user], $this->successStatus);
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $this->userTransformer->transform($user)
            ]
        );
    }
}
