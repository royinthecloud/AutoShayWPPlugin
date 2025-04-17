<?php

class TableService extends Service
{
    function  __construct($connection = null){
        parent::__construct($connection);
        
        $this->available_tables = array(
            "states",
            "InterestPoints",
            "RentalBranches",
            "LocationTypes",
            "BranchesOpeningHours",
            "ExceptionDate",
            "CarTypes",
            "CarTypes3",
            "FuelPolicies",
            "DriversRange",
            "GroupsDriversAge",
            "Vehicles",
            "TariffHeader",
            "TariffExtras",
            "TariffLines",
            "TariffAreas",
            "Companies",
            "Filters",
            "GroupFilters",
        );
    }
    
    public function isAvailable($table){
        return in_array($table, $this->available_tables);
    }
    
    public function getRowCountTable($table){
		return $this->wpdb->get_results("SELECT count(*) as count FROM ".$table);
	}
	
    public function getStructureTable($table){
		return $this->wpdb->get_results("DESCRIBE ".$table);
	}
	
    public function getAllTables(){
		return $this->wpdb->get_results("SHOW TABLES");
	}
	
    public function read($table, $page = 1, $limit = 10, $orderby = false, $order = "asc")
    {
        $pager = '';
        $sort = '';
		
		if($orderby)
			$sort = "ORDER BY ".$orderby." ".$order; 
		
        if($page != 'all'){
            if(!$page){
                $page = 1;
            }
            
            $page = intval($page);
            $offset = ($page - 1) * $limit;
            $pager = "LIMIT {$limit} OFFSET {$offset}";
        }
        
        return $this->wpdb->get_results("SELECT * FROM {$table} {$sort} {$pager}", ARRAY_A);
    }

    function getcitiesbyid($id){
        return $this->wpdb->get_results("SELECT * FROM  InterestPoints WHERE country = '{$id}'", ARRAY_A);
    }
    
    function getcitybyid($id){
        return $this->wpdb->get_row("SELECT * FROM  InterestPoints WHERE Points_of_interest = '{$id}'", ARRAY_A);
    }
	
	function getCurrencyByCurrencyCode($currencyCode){
        return $this->wpdb->get_results("SELECT * FROM  CurrencyRates_DCA_502 WHERE currency = '{$currencyCode}'", ARRAY_A);
    }
} 