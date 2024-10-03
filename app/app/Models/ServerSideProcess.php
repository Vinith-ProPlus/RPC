<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class ServerSideProcess extends Model{
    use HasFactory;
	private static $dataTableFormats=[];
	
	private static function NumberFormat($Value,$Decimal){

		if($Decimal!="auto"){
			$Value=floatval($Value);
			$Decimal=intval($Decimal);

			return number_format($Value,$Decimal,".","");
		}else{
			return $Value;
		}
	}
    private static function formatData($index,$d,$req){
		if(is_array(self::$dataTableFormats)){
        if(array_key_exists($index,self::$dataTableFormats)){
            $t=self::$dataTableFormats[$index];
            if($t['type']=="date"){
				
                return date($t['format'],strtotime($d));
            }else if($t['type']=="decimals"){
                return self::NumberFormat($d,$t['format']);
            }
        }
		}
		
        return $d;
    }
	private static function data_output ( $columns, $data,$request ){
		$out = array();
		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();
			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];
				//dd($data[$i][ $columns[$j]['db'] ]);
				$data[$i][ $columns[$j]['db'] ] =self::formatData($j,$data[$i][ $column['db'] ],$request);
				
				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
					$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
				}else {
					$row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
				}
			}
			$out[] = $row;
		}
		return $out;
	}
	private static function limit ( $request, $columns ){
		$limit = '';
		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}
		return $limit;
	}
	private static function order ( $request, $columns ){
		$order = '';
		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );
			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?'ASC' :'DESC';
					$orderBy[] = ''.$column['db'].' '.$dir;
				}
			}
			if ( count( $orderBy ) ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}
		return $order;
	}
	private static function filter($request, $columns, &$bindings){
		$globalSearch = array();
		$columnSearch = array();
		$searchBuilderFilters = array(); // New array to hold SearchBuilder filters
		$dtColumns = self::pluck($columns, 'dt');
		$dbColumns = self::pluck($columns, 'db');
		// Global search logic
		if (isset($request['search']) && $request['search']['value'] != '') {
			$str = $request['search']['value'];
			for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];

				if ($requestColumn['searchable'] == 'true') {
					$globalSearch[] = "" . $column['db'] . " LIKE '%" . $str . "%'";
				}
			}
		}

		// Column-specific search logic
		if (isset($request['columns'])) {
			for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];
				$str = $requestColumn['search']['value'];

				if ($requestColumn['searchable'] == 'true' && $str != '') {
					$columnSearch[] = "" . $column['db'] . " LIKE '%" . $str . "%'";
				}
			}
		}

		// SearchBuilder logic: loop through the SearchBuilder filters
		$columnIndexMap=[];
		if (isset($request['columnIndexMap'])){
			$columnIndexMap=json_decode($request['columnIndexMap'],true);
		}
		if (isset($request['searchBuilder']) && isset($request['searchBuilder']['criteria'])) { 
			foreach ($request['searchBuilder']['criteria'] as $criteria) {
				if(array_key_exists('data',$criteria)){
					if(array_key_exists($criteria['data'],$columnIndexMap)){
						$columnIdx = array_search($columnIndexMap[$criteria['data']], $dtColumns);
						$condition = array_key_exists('condition',$criteria)? $criteria['condition']:"contains";
						$value = array_key_exists('value',$criteria)? $criteria['value']:["0"=>""];
						$type = array_key_exists('type',$criteria)? $criteria['type']:null;
						$columnName = $columns[$columnIdx]['db'];
						if($columnName!="" ){
							if(($condition=="equals" || $condition=="=") && ( $value[0]!="")){
								$searchBuilderFilters[] = "$columnName = '" . $value[0] . "'";
							}else if(($condition=="not" || $condition=="!=") && ( $value[0]!="")){
								$searchBuilderFilters[] = "$columnName != '" . $value[0] . "'";
							}else if($condition=="starts" && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName LIKE '" . $value[0] . "%'";
							}else if($condition=="!starts" && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName NOT LIKE '" . $value[0] . "%'";
							}else if($condition=="contains"  && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName LIKE '%" . $value[0] . "%'";
							}else if($condition=="!contains" && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName NOT LIKE '%" . $value[0] . "%'";
							}else if($condition=="ends"  && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName LIKE '%" . $value[0] . "'";
							}else if($condition=="!ends"  && $value[0]!=""){
								$searchBuilderFilters[] = "$columnName NOT LIKE '%" . $value[0] . "'";
							}else if($condition=="null"  && $value[0]!=""){
								$searchBuilderFilters[] = "($columnName IS NULL || $columnName='')";
							}else if($condition=="!null" && $value[0]!=""){
								$searchBuilderFilters[] = "($columnName IS NOT NULL AND $columnName<>'')";
							}else if($condition=="lessThan" || $condition=="<"){
								$searchBuilderFilters[] = "$columnName < '" . $value[0] . "'";
							}else if($condition=="lessThanEqual" || $condition=="<="){
								$searchBuilderFilters[] = "$columnName <= '" . $value[0] . "'";
							}else if($condition=="greaterThan" || $condition==">"){
								$searchBuilderFilters[] = "$columnName > '" . $value[0] . "'";
							}else if(($condition=="greaterThanEqual" || $condition==">=") && ( $value[0]!="")){
								$searchBuilderFilters[] = "$columnName >= '" . $value[0] . "'";
							}else if($condition=="between" && count($value) == 2 ){
								$searchBuilderFilters[] = "$columnName BETWEEN '" . $value[0] . "' AND '" . $value[1] . "'";
							}else if($condition=="!between" && count($value) == 2){
								$searchBuilderFilters[] = "$columnName NOT BETWEEN '" . $value[0] . "' AND '" . $value[1] . "'";
							}
						}
					}
				}
			}
		}

		// Combine the global, column, and SearchBuilder filters into a single WHERE clause
		$where = '';
		if (count($globalSearch)) {
			$where = '(' . implode(' OR ', $globalSearch) . ')';
		}
		if (count($columnSearch)) {
			$where = $where === '' ? implode(' AND ', $columnSearch) : $where . ' AND ' . implode(' AND ', $columnSearch);
		}
		
		if (count($searchBuilderFilters)) {
			$logic=" AND ";
			if(isset($request['searchBuilder'])){
				$logic=array_key_exists("logic",$request['searchBuilder'])?" ".trim($request['searchBuilder']['logic'])." ":" AND ";
			}
			$where = $where === '' ? implode($logic, $searchBuilderFilters) : $where . ' AND ' . implode($logic, $searchBuilderFilters);
		}
		if ($where !== '') {
			$where = 'WHERE ' . $where;
		}
		return $where;
	}

	/*
	private static function filter ( $request, $columns, &$bindings ){
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = self::pluck( $columns, 'dt' );
		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				if ( $requestColumn['searchable'] == 'true' ) {
					$globalSearch[] = "".$column['db']." LIKE '%".$str."%'";
				}
			}
		}
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				$str = $requestColumn['search']['value'];
				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					$columnSearch[] = "".$column['db']." LIKE '%".$str."%'";
				}
			}
		}
		$where = '';
		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}
		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}
		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}
		return $where;
	}
	*/
	public static function SSP ( $data ){ 
		if(property_exists($data['POSTDATA'],'formats')){
			self::$dataTableFormats=json_decode($data['POSTDATA']->formats,true);
		}
		
		$bindings = array();
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';
		$limit = self::limit( $data['POSTDATA'], $data['COLUMNS'] );
		$order = self::order( $data['POSTDATA'], $data['COLUMNS'] );
		$where = self::filter( $data['POSTDATA'], $data['COLUMNS'], $bindings );
		if ( $data['WHERERESULT'] ) {
			if(($data['WHERERESULT']!=NULL)&&($data['WHERERESULT']!="")){
				$where = $where ? $where .' AND '.$data['WHERERESULT'] :'WHERE '.$data['WHERERESULT'];
			}
		}
		if ( $data['WHEREALL'] ) {
			if(($data['WHEREALL']!=NULL)&&($data['WHEREALL']!="")){
				$where = $where ? $where .' AND '.$data['WHEREALL'] :'WHERE '.$data['WHEREALL'];
				$whereAllSql = 'WHERE '.$data['WHEREALL'];
			}
		}
		// Main query to actually get the data
		$sql="SELECT ".implode(",", self::pluck($data['COLUMNS'], 'db'))." FROM ".$data['TABLE'];
		if(($where!="")&&($where!=NULL)){$sql.=" ".$where;}
		if(array_key_exists("GROUPBY",$data)){if(($data['GROUPBY']!="")&&($data['GROUPBY']!=NULL)){$sql.=" Group By ".$data['GROUPBY'];}}
		if(($order!="")&&($order!=NULL)){$sql.=" ".$order;}
		if(($limit!="")&&($limit!=NULL)){$sql.=" ".$limit;}
		$sdata = self::sql_exec($sql);
		//echo $sql;
		$sql="SELECT COUNT(".$data['PRIMARYKEY'].") AS RCOUNT FROM ".$data['TABLE'];
		if(($where!="")&&($where!=NULL)){$sql.=" ".$where;}
		if(array_key_exists("GROUPBY",$data)){if(($data['GROUPBY']!="")&&($data['GROUPBY']!=NULL)){$sql.=" Group By ".$data['GROUPBY'];}}
		// Data set length after filtering
		$resFilterLength = self::sql_exec($sql);
		$recordsFiltered = $resFilterLength[0]['RCOUNT'];



		// Total data set length
		$resTotalLength = self::sql_exec( "SELECT COUNT(".$data['PRIMARYKEY'].") AS RCOUNT FROM   ".$data['TABLE']." ".$whereAllSql);
		$recordsTotal = $resTotalLength[0]['RCOUNT'];
		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $data['POSTDATA']['draw'] ) ?
				intval( $data['POSTDATA']['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $data['COLUMNS1'], $sdata,$data['POSTDATA'] )
		);
		return array();
	}
	private static function sql_exec ( $sql){
		$result=DB::select($sql);
		$return=array();
		if(count($result)>0){
			for($i=0;$i<count($result);$i++){
				$return[]=(array)$result[$i];
			}
		}
		return $return;
	}
	private static function fatal ( $msg ){
		echo json_encode( array( "error" => $msg) );
		exit(0);
	}
	private static function bind ( &$a, $val, $type ){
		$key = ':binding_'.count( $a );
		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);
		return $key;
	}
	private static function pluck ( $a, $prop ){
		$out = array();
		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}
		return $out;
	}
	private static function _flatten ( $a, $join = ' AND ' ){
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}
