<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Transformer\UserTransformer;
use Illuminate\Support\Facades\DB;

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
        if(Auth::attempt(['name' => request('name'),'password' => request('password'),'email' => request('email')])){
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
			return $this->setStatusCode(401)->tokenUnauthorised();
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            //return response()->json(['error'=>$validator->errors()], 401);
			return $this->setStatusCode(402)->validatorFails();            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //$success['token'] =  $user->createToken('MyApp')->accessToken
        $success['name'] =  $user->name;

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
    /*
	public function getDetails()
    {
        $user = Auth::user();
		$date = date("Y-m-d")."%";
		$results = DB::table('input_details')
						->where([
							['delete_flag', '=', '0'],
							['created_at', 'like', $date],
						])
						->get();
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	*/
}
