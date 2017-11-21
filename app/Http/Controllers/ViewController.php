<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewController extends ApiController
{
    public function getViewDatas(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'))."%";
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
}
