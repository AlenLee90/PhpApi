<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\InputDetail;
use Illuminate\Support\Facades\Auth;

class InputDataController extends ApiController
{
    public function updateInputDetail(Request $request)
    {	
        $user = Auth::user();
		$results = InputDetail::updateData($request);
		
		if($results == true){
			return $this->response(
				[
					'status' => 'success',
					'status_code' => $this->getStatusCode()
				]
			);
		}else{
			return $this->response(
				[
					'status' => 'fail',
					'status_code' => $this->setStatusCode(301)->queryFails()
				]
			);
		}
    }
}
