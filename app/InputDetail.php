<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InputDetail extends Model
{
    public static function getViewTableDatas($date){
		$results;
		try{
			$results = DB::table('input_details')
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
				])
				->get();
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getViewTableDetail($id){
		$results;
		try{
			$results = DB::table('input_details')
				->where([
					['delete_flag', '=', '0'],
					['id', '=', $id],
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
	
	public static function getSumPayments($date){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('SUM(amount) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['comsuption_flag', '=', '0'],
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
				->select(DB::raw('SUM(amount) as amount,category_id'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['comsuption_flag', '=', '0'],
				])
				->groupBy('category_id')
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
	
	public static function getSumIncomes($date){
		$results;
		try{
			$results = DB::table('input_details')
				->select(DB::raw('SUM(amount) as amount'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['comsuption_flag', '=', '1'],
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
				->select(DB::raw('SUM(amount) as amount,category_id'))
				->where([
					['delete_flag', '=', '0'],
					['created_at', 'like', $date],
					['comsuption_flag', '=', '1'],
				])
				->groupBy('category_id')
				->get();	
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		return $results;
	}
}
