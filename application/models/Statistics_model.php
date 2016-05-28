<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics_model extends CI_Model {

    private $table = 'stockinfo_table';
  
    function __construct(){
        parent::__construct();
    }

    public function Month(){
    	$query = $this->db->get($this->table);
    	$Array_return = array();
		for($j=1;$j<=12;$j++){
			
			$Month = "0".$j;
			$Month;
			$i = 0;
	    	$Unreturned = 0;
	    	
	    	$Array_return[$j]['Month'] = $j;
	    	foreach ($query->result() as $row){  
			    $DataMonth = explode("/", $row->input_date);
			    if($Month == @$DataMonth[1] ){
			    	$i++;
			    	$Array_return[$j]['Lend'] = $i;
			    	//統計這個月的借出數量
			    	if($row->output_date == NULL){
			    		$Array_return[$j]['Unreturned'] = ++$Unreturned;
			    		//計算尚未歸還的
			    	}
			    	if(@$Array_return[$j]['Unreturned'] == NULL){
			    		//因為空值所以會跳警告
			    		$Array_return[$j]['Unreturned'] = 0;
			    	}
			    }
			}
		}
        return $Array_return;
    }
	public function ArticleLoan(){
		
		$i=1;							//統計物品名稱數量用
		$name = "";
		$Array_return = array();

		//設備總數
		//
		//
		
		//取不重複資料
		$DISTINCTQuery = $this->db->query("
			SELECT DISTINCT name FROM instock_table;
		");
		foreach ($DISTINCTQuery->result() as $DISTINCTQueryRow){ 

			//建立設備名稱
			if($DISTINCTQueryRow->name != $name){
				$Array_return[$i]['name'] = $name = $DISTINCTQueryRow->name;
				$i++;
			}

			//統計設備總數
			$SUMQuery = $this->db->query("
				SELECT SUM( total ) AS Sum FROM instock_table WHERE name = '{$DISTINCTQueryRow->name}'; 
			");
			foreach ($SUMQuery->result() as $SUMQueryRow) {
				for($x=1;$x<=$i-1;$x++){
					if($DISTINCTQueryRow->name == @$Array_return[$x]['name']){
						$Array_return[$x]['Total'] = @$Array_return[$x]['Total'] + $SUMQueryRow->Sum;
						
					}	
				}		
			}
		}

		//借出總數
		$query = $this->db->query("
			SELECT 
				instock_table.name, 
				instock_table.type,
				stockinfo_table.total
			FROM 
				instock_table, 
				stockinfo_table 
			WHERE 
				rfidcode = instock_onlyid and 
				output_date = '' 
		");
		
		foreach ($query->result() as $row){ 
			for($x=1;$x<=$i-1;$x++){
				
				if($row->name == $Array_return[$x]['name']){
					$Array_return[$x]['LendTotal'] = @$Array_return[$x]['LendTotal'] + $row->total;
				}
				if(@$Array_return[$x]['LendTotal'] == NULL){
					//因為空值所以會跳警告
					$Array_return[$x]['LendTotal'] = '0';
				}
			}
		}
		return $Array_return;	
	}
	public function TypeLoan(){
			
		$i=1;							//統計物品名稱數量用
		$type = "";
		$Array_return = array();

		//設備總數
		//
		//
		
		//取不重複資料
		$DISTINCTQuery = $this->db->query("
			SELECT DISTINCT type FROM instock_table;
		");
		foreach ($DISTINCTQuery->result() as $DISTINCTQueryRow){ 
			//建立設備名稱
			if($DISTINCTQueryRow->type != $type){
				$Array_return[$i]['type'] = $type = $DISTINCTQueryRow->type;
				$i++;
			}
			//統計設備總數
			$SUMQuery = $this->db->query("
				SELECT SUM( total ) AS Sum FROM instock_table WHERE type = '{$DISTINCTQueryRow->type}'; 
			");
			foreach ($SUMQuery->result() as $SUMQueryRow) {
				for($x=1;$x<=$i-1;$x++){
					if($DISTINCTQueryRow->type == @$Array_return[$x]['type']){
						$Array_return[$x]['Total'] = @$Array_return[$x]['Total'] + $SUMQueryRow->Sum;
						
					}		
				}		
			}
		}

		//借出總數
		$query = $this->db->query("
			SELECT 
				instock_table.type, 
				stockinfo_table.total
			FROM 
				instock_table, 
				stockinfo_table 
			WHERE 
				rfidcode = instock_onlyid and 
				output_date = '' 
		");
		
		foreach ($query->result() as $row){ 
			
			for($x=1;$x<=$i-1;$x++){
				if($row->type == $Array_return[$x]['type']){

					$Array_return[$x]['LendTotal'] = @$Array_return[$x]['LendTotal'] + $row->total;
				}
				if(@$Array_return[$x]['LendTotal'] == NULL){
					//因為空值所以會跳警告
					$Array_return[$x]['LendTotal'] = '0';
				}
			}
		}
		return $Array_return;
	}
}