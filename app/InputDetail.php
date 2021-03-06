<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\InputDetail;

class InputDetail extends Model
{
    public static function getViewTableDatas($date,$userId){
		$results;
		try{
			$results = DB::table('input_details')
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['user_id', '=', $userId],
				])
				->get();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getViewTableDetail($id,$userId){
		$results;
		try{
			$results = DB::table('input_details')
				->where([
					['delete_flag', '=', '0'],
					['id', '=', $id],
					['user_id', '=', $userId],
				])
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function deleteViewTableData($id){
		$status = false;
		try{
			DB::table('input_details')->where('id', '=', $id)->delete();
			$status = true;
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		
		return $status;
	}
	
	public static function getSumPayments($date,$userId){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '0'],
					['user_id', '=', $userId],
				])
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getSumPaymentsGroupByCategory($date){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount,category_id'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '0'],
				])
				->groupBy('category_id')
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getSumIncomes($date,$userId){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '1'],
					['user_id', '=', $userId],
				])
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getSumIncomesGroupByCategory($date){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount,category_id'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '1'],
				])
				->groupBy('category_id')
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getRec14DaysDatas($date,$userId){
		$results = [];
		$date = date("Y-m-d", strtotime($date." - 13 days"));
		for ($x = 0; $x <= 13; $x++) {
		try{
			$payments = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date."%"],
					['consumption_flag', '=', '0'],
					['user_id', '=', $userId],
				])
				->get();
			$incomes = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '0'],
					['user_id', '=', $userId],
				])
				->get();
			$currentDayResult = ($payments->first()->amount) - ($incomes->first()->amount);
			$results[$date] = $currentDayResult;			
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		$date = date("Y-m-d", strtotime($date." + 1 days"));
		}
		return $results;
	}
	
	public static function getRec3MonsDatas($date,$userId){
		$results = [];
		$date = date("Y-m", strtotime($date." - 2 months"));
		for ($x = 0; $x <= 2; $x++) {
		try{
			$payments = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date."%"],
					['consumption_flag', '=', '0'],
					['user_id', '=', $userId],
				])
				->get();
			$incomes = DB::table('input_details')
				->select(DB::raw('ifnull(SUM(amount),0) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['consumption_flag', '=', '0'],
					['user_id', '=', $userId],
				])
				->get();
			$monthlyResult = ($payments->first()->amount) - ($incomes->first()->amount);
			$results[$date] = $monthlyResult;			
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		$date = date("Y-m", strtotime($date."-01 + 1 month"));
		}
		return $results;
	}
	
	public static function updateData($request){
		$status = false;
		try{
			$inputDetail;
			if(isset($request->id)){
				$inputDetail = InputDetail::find($request->id);
			}else{
				$inputDetail = new InputDetail;	
			}
			$inputDetail->user_id = $request->user_id;
			$inputDetail->amount = $request->amount;
			$inputDetail->category_id = $request->category_id;
			$inputDetail->currency_id = $request->currency_id;
			$inputDetail->consumption_flag = $request->consumption_flag;
			$inputDetail->location = $request->location;
			$inputDetail->save();
			$status = true;
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $status;
	}
}
