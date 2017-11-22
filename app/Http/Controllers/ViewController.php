<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\InputDetail;
use Illuminate\Support\Facades\Auth;

class ViewController extends ApiController
{
    public function getViewDatas(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'))."%";
		$results = InputDetail::getViewTableDatas($date);
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
	public function getViewDetail(Request $request)
    {	
        $user = Auth::user();
		$results = InputDetail::getViewTableDetail($request->input('id'));
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
	public function deleteViewData(Request $request)
    {	
        $user = Auth::user();
		if(InputDetail::deleteViewTableData($request->input('id')) == true){
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
					'status_code' => $this->setStatusCode(101)->queryFails()
				]
			);
		}
    }
	
	/*
	public function getChartTodaySum(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'))."%";
		$paymentResults = InputDetail::getSumPayments($date);
		$incomeResults = InputDetail::getSumIncomes($date);
		$results['sumResult'] = $paymentResults
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
