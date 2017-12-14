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
		$userId = $request->input('user_id');
		$results = InputDetail::getViewTableDatas($date,$userId);
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
		$results = InputDetail::getViewTableDetail($request->input('id'),$request->input('user_id'));
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
	public function updateViewDetail(Request $request)
    {	
        $user = Auth::user();
		/*
		if(isset($request->id)){
			$results = InputDetail::updateData($request);
			
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
		*/
		if(isset($request->id)){
			InputDetail::updateData($request);
			return $this->response(
				[
					'status' => 'success',
					'status_code' => $this->getStatusCode()
				]
			);
		}else{
			return $this->setStatusCode(402)->validatorFails();
		}

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
					'status_code' => $this->setStatusCode(401)->queryFails()
				]
			);
		}
    }
	
	
	public function getChartTodaySum(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'))."%";
		$userId = $request->input('user_id');
		$paymentResults = InputDetail::getSumPayments($date,$userId);
		$incomeResults = InputDetail::getSumIncomes($date,$userId);
		$todaySum = ($paymentResults->first()->amount) - ($incomeResults->first()->amount);
		$todaySum = sprintf('%0.2f', $todaySum);
		$results = array('paymentSum' => $paymentResults->first()->amount, 'incomeSum' => $incomeResults->first()->amount, 'resultSum' => (double)$todaySum);
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
	public function getChartRec14DaysDatas(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'));
		$userId = $request->input('user_id');
		$results = InputDetail::getRec14DaysDatas($date,$userId);
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
	public function getChartRec3MonsDatas(Request $request)
    {	
        $user = Auth::user();
		$date = ($request->input('date'));
		$userId = $request->input('user_id');
		$results = InputDetail::getRec3MonsDatas($date,$userId);
        return $this->response(
            [
                'status' => 'success',
				'status_code' => $this->getStatusCode(),
                'data' => $results
            ]
        );
    }
	
}
