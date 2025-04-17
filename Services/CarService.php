<?php

  global $queryArray2;

class CarService extends Service
{
    function  __construct($connection = null){
        parent::__construct($connection);
        
        $this->request_fields = array(
            'country',
            'interest_points',
            'from',
            'to',
            'age',
            'interest_points2',
        );
    }

   
   

    
    public function getValidatedFields(WP_REST_Request $request)
    {
          

            //    plugin_log844('Carservice.php 25');
            //    plugin_log844($request);

            $data = array();
            foreach($this->request_fields as $field){
                $value = $request->get_param($field);
                

          //      plugin_log844('CarService.php 33 value');
           //     plugin_log844($value)   ;         
                
                switch($field){
                    case 'country':
                        if( !is_null($value) ){
                            $value = intval($value);
                            $check = $this->wpdb->get_row("SELECT * FROM states WHERE STATECODE = '{$value}'", ARRAY_A);
                            if($check){
                                $data[$field] = $value;
                            } else {
                                return "{$field} with {$value} does not exist";
                            }
                        } else {
                            return "{$field} required";
                        }
                    break;
                    case 'interest_points':
                    case 'interest_points2':
                        if( !is_null($value) ){
                            $check = $this->wpdb->get_row("SELECT * FROM InterestPoints WHERE Points_of_interest = '{$value}'", ARRAY_A);
                            if($check){
                                $data[$field] = $value;
                            } else {
                                return "{$field} with {$value} does not exist";
                            }
                        } else {
                            return "{$field} required";
                        }
                    break;
                    case 'from':
                        if( !is_null($value) ){
                            $date = strtotime($value);
                            if($date){
                                $data[$field] = date(self::DATE_TIME_FORMAT, $date);
                            } else {
                                return "{$field} have incorrect format";
                            }
                        } else {
                            return "{$field} required";
                        }
                    break;
                    case 'to':
                        if( !is_null($value) ){
                            $date = strtotime($value);
                            if($date){
                                $data[$field] = date(self::DATE_TIME_FORMAT, $date);
                            } else {
                                return "{$field} have incorrect format";
                            }
                        } else {
                            return "{$field} required";
                        }
                    break;
                    case 'age':

               //         write_log('AgeRequest-value');
            //            WriteToLog($value);


                        if( !is_null($value) ){
                            $check = $value; 
                           // $check = $this->wpdb->get_row("SELECT * FROM GroupsDriversAge WHERE CarRangeId // = '{$value}'", ARRAY_A);
                            if($check){
             //                   WriteToLog('YesCheck83');
                                $data[$field] = $value;
                            } else {
               //                 WriteToLog('NoCheck86');
                                "{$field} with {$value} does not exist";
                            }
                        } else {
            //                WriteToLog('log90');
                            return "{$field} required";
                        }
                    break;
                }
            }

        //    plugin_log844('carservice.php 110 data');
         //   plugin_log844('$data');
         //   WriteToLog(print_r($data,'true'))   ;         
            
            return $data;
    }

   
    public function search($params, $initialize = 1, $filters_data = array())
    {
            $dateFormat = 'Ymd';
            $timeFormat = 'His';
            
            $dateTo = strtotime($params['to']);
            $dateFrom = strtotime($params['from']);


                  //  plugin_log844('CarService.php 122 ');
                 //   plugin_log5($_SESSION['cacheData'] ?? '');

            if($initialize)
            {

                 $ageCode = $this->wpdb->get_results("SELECT * FROM AutoShay.DriversRange WHERE  minVal>= " . $params['age'] . " and MaxVal>=" . $params['age']." limit 1", ARRAY_A);
                 //         WriteToLog(print_r($ageCode,true));

                 if (isset($ageCode[0]['PId']) && !empty($ageCode[0]['PId']) )
                 {
                    $ageCode1 = $ageCode[0]['PId'];
                 }
                 else
                 {
                    $ageCode1=$params['age'];
                 }
                
                /* Changes - Vinod - 09/02/21 - fetched db source from db */
                $options = get_option('autoshay_options');
        
                $pos= strpos($_SERVER['REQUEST_URI'],'/',1);
                $version = substr($_SERVER['REQUEST_URI'],1,$pos-1);

                $_SESSION['version'] = $version;

                plugin_log6('Carservice.php 148 - version');
                plugin_log6($version);



             


                $langpos = strpos($_SERVER['HTTP_REFERER'],'/en/',1);
                //    plugin_log('requestURI');

                  //   plugin_log($langpos);

                 if ($langpos>0) 
                 {
                    $lang ='en';
                 }
                 else
                 {
                    $lang='he';
                 }
               

                $dt = new DateTime("now", new DateTimeZone('Israel'));

                    // $dt->format('m/d/Y, H:i:s');



                 //            plugin_log($dt);

                $result = $dt->format('Y-m-d H:i:s');

      









                $queryParams = [
                                    'country_code' => $params['country'],
                                    'origin_interest_point' => $params['interest_points'],
                                    'origin_interest_point2' => $params['interest_points2'],
                                    'from_date' => date($dateFormat, $dateFrom),
                                    'from_hour'=>date($timeFormat, $dateFrom),
                                    'to_hour'=>date($timeFormat, $dateTo),
                                    'to_date' => date($dateFormat, $dateTo),
                                    'age_code' => $ageCode1,
                                    'switch' => $version,
                                    'db_source' => $options['db_name']
                                    
                ];

                 $queryParams2 = [
                                    'country_code' => $params['country'],
                                    'origin_interest_point' => $params['interest_points'],
                                    'origin_interest_point2' => $params['interest_points2'],
                                    'from_date' => date($dateFormat, $dateFrom),
                                    'from_hour'=>date($timeFormat, $dateFrom),
                                    'to_hour'=>date($timeFormat, $dateTo),
                                    'to_date' => date($dateFormat, $dateTo),
                                    'age_code' => $params['age']
                  
                ];


             
               
                  //      plugin_log($params)    ;
                    //    plugin_log('serverRef:');
                    //    plugin_log($_SERVER['HTTP_REFERER']);

                $queryArray = parseQueryString($_SERVER['HTTP_REFERER']);

                if (isset($queryArray['date_take_lm'])) 
                {

                    $queryArray['date_take_lm'] = transformDateFormat_V2($queryArray['date_take_lm']);
                    $queryArray['date_return_lm'] = transformDateFormat_V2($queryArray['date_return_lm']);
                }


                // plugin_log844('CarService.php 234 QueryParams:');
               // plugin_log844($queryArray);

                if (isset($_SESSION['cacheData'])) 
                {
                    $queryArray['cityFrom'] = $_SESSION['cacheData']['cityFrom'];
                    $queryArray['cityTo'] = $_SESSION['cacheData']['cityTo'];
                    $queryArray['date_take_lm_year'] = $_SESSION['cacheData']['date_take_lm_year'];
                    $queryArray['date_take_lm_month'] = $_SESSION['cacheData']['date_take_lm_month'];
                    $queryArray['date_take_lm_day'] = $_SESSION['cacheData']['date_take_lm_day'];
                    $queryArray['TimeFromHour'] = $_SESSION['cacheData']['TimeFromHour'];
                    $queryArray['TimeFromMinut'] = $_SESSION['cacheData']['TimeFromMinut'];
                    $queryArray['date_return_lm_year'] = $_SESSION['cacheData']['date_return_lm_year'];
                    $queryArray['date_return_lm_month'] = $_SESSION['cacheData']['date_return_lm_month'];
                    $queryArray['date_return_lm_day'] = $_SESSION['cacheData']['date_return_lm_day'];
                    $queryArray['TimeToHour'] = $_SESSION['cacheData']['TimeToHour'];
                    $queryArray['TimeToMinut'] = $_SESSION['cacheData']['TimeToMinut'];
                    $queryArray['age'] = $_SESSION['cacheData']['age'];
                    $queryArray['agent'] = $_SESSION['cacheData']['agent'];

                    $queryArray['agent'] = $_SESSION['cacheData']['agent'];

                    $queryArray['date_take_lm'] = $_SESSION['cacheData']['From1'];
                    $queryArray['date_return_lm'] = $_SESSION['cacheData']['To1'];
                } // isset cachedata



             

                plugin_log5('CarService.php 252 QueryParams:');
                plugin_log5($queryArray);

                $queryArray2 = parseQueryString_V2($queryArray);
                plugin_log844('QueryParams2: carservice.php 275');

                /*
                
                 $queryArray2["URL"]="https://search.auto-shay.com/integration/8_51/v3_2/CallerV8_50.php";
                */

                 $queryArray2["URL"] = 'https://' . $_SERVER['HTTP_HOST'] . '/integration/8_51/v4_0/CallerV8_50.php';

                //$queryArray2["URL"]="https://search.auto-shay.com/integration/8_51/v3_2/CallerV8_50.php";


                  
                $queryArray2["version"]= $version;


                 plugin_log844('CarService.php 289_new');
                plugin_log844($queryArray2);
                $_SESSION['QueryStringParameters']= $queryArray2;

               
          

                $QstringSim = $queryArray2["sim"];
                $_SESSION['sim'] = $QstringSim  ;



                $Qcache = $queryArray2["cache"];
                $agent = $queryArray2["agent"];


          
                if ($QstringSim==2) 

                // Simulator 2        

                {


                    plugin_log844('CarService 314 Before Sim2');
                    
                    if  (!$Qcache>0)  
                    {
                    $sim2Result = trim(makeSimulator2Request($queryArray2));        
                    $autoShayResultID = extractNumber($sim2Result);
                    }
                    else
                    {
                        $autoShayResultID= $Qcache;
                    }

                    plugin_log844($autoShayResultID);


                    plugin_log855('CarService.php Run Car Query 332 ');

                     $query = $this->wpdb->prepare( 
                            "call Integration.GetSimulator2ResultsV8_50test(%s,%s)",
                           $autoShayResultID ,
                            $lang 
                            
                           );
                    $result = $this->wpdb->get_results( $query, ARRAY_A);       

                     plugin_log855('DataFetch from Integration.GetSimulator2ResultsV8_50 CarService.php 342');

                }; // Simulator2


            


              $_SESSION['ResponseResultCache' . $autoShayResultID] =$result;
              $_SESSION['result_id'] = $autoShayResultID;

                    plugin_log('QResult:')    ;
                  //  plugin_log($result)  ;      



                $result = $this->findCheapest($result);
                
                $data = array(
                    'cars' => $result,
                );            
            }  ;  // end initiliaze


            plugin_log('369');

            $autoShayResultID = $_SESSION['result_id'];
            $result = $_SESSION['ResponseResultCache' . $autoShayResultID] ;

             $filteredResults = $result;

            // CarType
            if (isset($filters_data[0])) 
            {


                 $result = array_filter($result,array(new DynamicFilter("CarTypeID",implode(',',array_values($filters_data[0]))), "isInFilter"));
                 $result= array_values($result);
            };

            if (isset($filters_data[1])) 
            {

                    //       plugin_log844B('SupplierFilter');

                          $result = array_filter($result,array(new DynamicFilter("CompanyNumber",implode(',',array_values($filters_data[1]))), "isInFilter"));
                          $result= array_values($result);


                           plugin_log('Afterlog');
            };


            if (isset($filters_data[2])) 
            {

              //  WriteToLog('FueloptionsFilter');
              //   WriteToLog(print_r(array_values($filters_data[2]),true));
              //   WriteToLog(print_r(implode(',',array_values($filters_data[2])),true));

                 $result = array_filter($result,array(new DynamicFilter("FuelPolicy",implode(',',array_values($filters_data[2]))), "isInFuel"));
                 $result= array_values($result);
            };


          if (isset($filters_data[3])) 
          {

                //    WriteToLog('FuelOptions1');
                 //    WriteToLog(print_r(array_values($filters_data[3]),true));
                 //    WriteToLog(print_r(implode(',',array_values($filters_data[3])),true));

                    $result = array_filter($result,array(new DynamicFilter("FuelPolicy",implode(',',array_values($filters_data[3]))), "isInFuel"));
                    $result= array_values($result);
          };


          if (isset($filters_data[4])) 
          {

                 //   plugin_log844B('CarSpecs');
                 //   plugin_log844B(array_values($filters_data[4]));
                     $result = array_filter($result,array(new DynamicFilter("CarSpecs",implode(',',array_values($filters_data[4]))), "isInSpecs"));
                     $result= array_values($result);
                 //    plugin_log844B($result);
          };    

           if (isset($filters_data[5])) 
           { 

                     $result = array_filter($result,array(new DynamicFilter("PartySize",implode(',',array_values($filters_data[5]))), "isInParty"));
                      $result= array_values($result);
           };       


              plugin_log('443')  ;

              $_SESSION['res' . $autoShayResultID] = $result;
              $result = $this->findCheapest($result);
                $data = array(
                    'cars' => $result,
                );
              


            if($initialize)
            {
    
                $data['filters'] = $this->getFilters($autoShayResultID);
            } 
              else 
            {
                 $data['filters'] = array();
            }

            plugin_log('THE DATA - real');
            plugin_log(print_r($data,true));

            

        

    
            $CleanCars =[];
    
            foreach($data['cars'] as &$car)
            {
                /* Changes - Vinod - 09/02/21 - Added keys that are different */
                $car['GroupName'] = $car['GROUPNAME'];
                $car['GroupCode'] = $car['GROUPCODE'];
                $car['NumofDays'] = $car['NumOfDays'];
                $car['GroupDescCode'] = $car['GROUPDESCCODE'];
                $car['COMPANYNAME'] = $car['CompanyName']; 

                $clean_car = array(
                'UID' => $car['UID'],
                'Source' => $car['Source'],
                'PartySize' => $car['PartySize'],
                'PassangersNum' =>$car['PassangersNum'],
                'GroupName' => $car['GROUPNAME'],
                'GroupCode' => $car['GROUPCODE'],
                'NumofDays' => $car['NumOfDays'],
                'GroupDescCode' => $car['GROUPDESCCODE'],
                'COMPANYNAME' => $car['CompanyName'],
                'PriceAfterDiscountShekelsWithVAT' => $car['PriceAfterDiscountShekelsWithVAT'],
                'agent' => $car['agent']
                );
                $CleanCars[] = $clean_car;
                
                if($car['CarTypeID2'])
                {

                    $query1 = "SELECT CarTypeDesc, CarTypeDescHebrew FROM CarTypes3 WHERE PId = " . $car['CarTypeID2'];
                   // plugin_log2($query1);

                    $type_descr = $this->wpdb->get_row( "SELECT CarTypeDesc, CarTypeDescHebrew FROM CarTypes3 WHERE PId = {$car['CarTypeID2']}", ARRAY_A);
                
                 //   $car['CarTypeDesc'] = (pll_current_language() == 'he' ? $type_descr['CarTypeDescHebrew'] : $type_descr['CarTypeDesc']);
                    $car['CarTypeDesc'] = (pll_current_language() == 'he' ? ($type_descr['CarTypeDescHebrew'] ?? '') : ($type_descr['CarTypeDesc'] ?? ''));
                }
                
                $isRare = $this->wpdb->get_var( "SELECT IsRare FROM CarTypes WHERE PId = '{$car['CarTypeID']}'");
                $car['IsRare'] = $isRare;

               
                
                $ExtraDesc = (pll_current_language() == 'he' ? 'ExtraDescHebrew' : 'ExtraDesc');
            
                $freeOptions = explode(',', trim($car['Freeoptions'],','));
                $car['free_options'] = $freeOptions;
                
                $extraOptions = explode(',', trim($car['Extraoptions'],','));
                $car['extra_options'] = $extraOptions;
                
              
            } //for each
           




        return $data;
    } // function
        
  
    


   

    

    protected function filteredSearch($filters_data, $autoShayResultID)
    {
        $filtered_results = array();


        $QstringSim=$_SESSION['sim'];

      //  plugin_log('FilteredSearch');
      //  plugin_log($filters_data);

        
        foreach($filters_data as $group_id => $filters){
            if(!count($filters)){
                continue;
            }
            
            if($group_id == 0){
                $where = implode(', ', $filters);
                /* Changes - Vinod - 11/02/21 - Replaced TempResults table */ 

            if ($QstringSim==2)  
            {
                 $query_template = "
                        SELECT *
                        FROM  Integration.WSResult_1002_Sim2_V2  AS TempResults
                        WHERE AutoShayResultID={$autoShayResultID} and CarTypeID IN ({$where})
                    ";       
            }        

            else
            {

                 $query_template = "
                        SELECT *
                        FROM  Integration.WSResult_1002  AS TempResults
                        WHERE AutoShayResultID={$autoShayResultID} and CarTypeID IN ({$where})
                    ";   
            }    

                
                
                $results = $this->wpdb->get_results( $query_template, ARRAY_A);
                if(count($results)){
                    $filtered_results[$group_id] = $results;
                }
            } else {
                $query = "SELECT * FROM Integration.Filters WHERE PID = '{$group_id}'";
                $group = $this->wpdb->get_row( $query, ARRAY_A);
                
                if(!$group){
                    continue;
                }
                
                switch($group['FilterType']) {
                    case 'Group':
                        $filter_ids = implode(', ', $filters);
                     //    print_r('Group!');
                     //    print_r($filters);

                        $query = "SELECT * FROM Integration.GroupFilters_V75 WHERE filterId = '{$group['PID']}' AND PID in ({$filter_ids})";
                        $group_filters = $this->wpdb->get_results( $query, ARRAY_A);
                        /*
                        if(!count($group_filters)){
                            continue;
                        }
                        */

               //         WriteToLog('635:' . $query);

                        $where_array = array();
                        foreach($group_filters as $group_filter){
                            $where_array[] = $group_filter['Criteria'];
                        }
                        
                        $where = implode(' OR ', $where_array);
                        $where = "WHERE {$where}";

                    //     WriteToLog($where);
                        
                        $join = '';
                        
                        if($group['JoinObject']){
                            $join = "inner join {$group['JoinObject']} on TempResults.{$group['FilterValue']} = {$group['JoinObject']}.{$group['ObjectId']}";
                        }

                         if ($QstringSim==2)  
                         {
                                 $query_template = "
                                select *
                                from
                                 (select * from Integration.WSResult_1002_Sim2_V2 where AutoShayResultID={$autoShayResultID}) AS TempResults 
                                  {$join}
                                {$where}
                            ";
                         } 
                         else
                         {
                             $query_template = "
                            select *
                            from
                             (select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID}) AS TempResults 
                              {$join}
                            {$where}
                        ";

                         }

                       
                        $results = $this->wpdb->get_results( $query_template, ARRAY_A);
                        if(count($results)){
                            $filtered_results[$group_id] = $results;
                        }

                    //    WriteToLog($query_template);
                        
                    break;


                    case 'Value':
                        
                        $where = '';
                        $join = '';
                        
                        if($group['DecodingValue']){
                            $where_in = implode(',', $filters);
                            // $where_in = '"'.$where_in.'"';
                         //    print_r('Value!');
                           //  print_r($filters);
                            // print_r($where_in);
                          //   print_r('separotor');
                            $where = "{$group['DecodingValue']} IN ({$where_in})";

                      //      WriteToLog($where);

                        }
                        
                       
                        if ($QstringSim==2)  
                         {
                            $query_template = "                            
                            select * from Integration.WSResult_1002_Sim2 where AutoShayResultID={$autoShayResultID} and {$where}";
      
                         }
                         else
                         {
                            $query_template = "                            
                            select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID} and {$where}";
  
                         }


                        
                     //    WriteToLog($query_template);
                        


                        $results = $this->wpdb->get_results( $query_template, ARRAY_A);
                        if(count($results)){
                            $filtered_results[$group_id] = $results;
                        }
                        
                    break;
                }
            }
        }

        if(count($filtered_results) > 1){
            $initial = array_shift($filtered_results);
            
            $filtered_results = array_reduce($filtered_results, function($result, $current){
                if(!$result){
                    return array();
                }
                $intersect = array();
                foreach($result as $item){
                    if(in_array($item, $current)){
                       $intersect[] = $item;
                    }
                }
                return $intersect;
                
            }, $initial);
            
        } elseif(count($filtered_results) == 1){
            $filtered_results = array_shift($filtered_results) ;
        }
     //   print_r('filterresults:');
     //   print_r($filtered_results);
                        
        return $filtered_results;
    }
  






    protected function findCheapest($cars){
        $groups = array();
        
     //   usort($cars, array('CarService', 'sortByPrice'));
        
        foreach($cars as $car){
            /* Changes - Vinod - 09/02/21 - Added key that was different in webservice*/
            if(!isset($car['GroupCode'])){
                $car['GroupCode'] = $car['GROUPCODE'];
            }
            
            if(!isset($groups[ $car['GroupCode'] ])){
                $groups[ $car['GroupCode'] ] = array();
            }
            $groups[ $car['GroupCode'] ][] = $car;
        }
        
        foreach($groups as $key => $group){
            usort($group, array('CarService', 'sortByPrice'));
            $groups[$key] = $group[0];
            
        }
        
        $groups = array_values($groups);
        $cheapest_keys = array();
        foreach($groups as $group){
            $key = array_search($group, $cars);
            if($key !== false){
                $cheapest_keys[] = $key;
            }
        }
        foreach($cars as $key => $car){
            if(in_array($key, $cheapest_keys)){
                $cars[$key]['TopSeller'] = 1;
            } else {
                $cars[$key]['TopSeller'] = 0;
            }
        }
        
   //     WriteToLog('Cars501');

      //  $cars_filtered = array_filter($cars,"test_CarType");
    //    WriteToLog(print_r($cars,'true'));
        // $cars_filtered = array_filter($cars,"test_CarType");
        $cars_filtered = array_filter($cars,array(new DynamicFilter("CarTypeID","3"), "isInFilter"));


     //   WriteToLog(print_r($cars_filtered,'true'));
        return $cars;
    }
    
    public function sortByPrice($a, $b){
        $a_price = intval($a['PriceAfterDiscount']);
        $b_price = intval($b['PriceAfterDiscount']);
        if ($a_price == $b_price) {
            return 0;
        }
        return ($a_price < $b_price) ? -1 : 1;
    }
    


    public function getGroupedFilters(){

         if  (!isset($_SESSION['getGroupedFilters']))
         { 


        $GroupName = (pll_current_language() != 'he' ? 'GRoupName' : 'GroupNameHebrew');
        $FilterName = (pll_current_language() != 'he' ? 'FilterName' : 'FilterNameHebrew');
        
        $query = "
            SELECT f.PID as GroupId, gf.PID as FilterId, f.{$FilterName} as FilterName, gf.{$GroupName} as GroupName
            FROM Integration.Filters as f
            LEFT JOIN Integration.GroupFilters_V75 as gf ON gf.filterId = f.PID
            ORDER BY gf.PID
        ";
    //    WriteToLog('818: '. $query);
        $filters = $this->wpdb->get_results( $query, ARRAY_A);
        $grouped_filters = array();
        foreach($filters as $filter){
            if( !isset($grouped_filters[ $filter['GroupId'] ])){
                $grouped_filters[ $filter['GroupId'] ] = array(
                    'GroupName' => $filter['FilterName'],
                    'filters' => array()
                );
            }
            
            if( $filter['FilterId'] && $filter['GroupName']) {
                $grouped_filters[ $filter['GroupId'] ]['filters'][] = array(
                    'FilterId' => $filter['FilterId'],
                    'FilterName' => $filter['GroupName']
                );
            }
        }
        
         $_SESSION['getGroupedFilters']=  $grouped_filters;

       // WriteToLog('getGroupedFilters1');
      //  WriteToLog(print_r($grouped_filters,true));

    }
        else  {

           $grouped_filters = $_SESSION['getGroupedFilters'];

    }

        return $grouped_filters;
    }
    

    protected function getFilters($autoShayResultID){
        


         $QstringSim = $_SESSION['sim']   ;

    //   WriteToLog('GetFilters1');
        $grouped_filters = array();
        
        $query = "SELECT * FROM Integration.Filters";
        $groups = $this->wpdb->get_results( $query, ARRAY_A);
        
        foreach($groups as $group){
            if(!isset($grouped_filters[ $group['PID'] ])){
                $grouped_filters[ $group['PID'] ] = array();
            }
            
            switch($group['FilterType']) {
                case 'Group':
                    $query = "SELECT * FROM Integration.GroupFilters_V75 WHERE filterId = '{$group['PID']}' ";
                    $filters = $this->wpdb->get_results( $query, ARRAY_A);
                    

                  //  WriteToLog('873:' . $query);
                    foreach($filters as $filter){
                        $grouped_filters[ $group['PID'] ][ $filter['PID'] ] = array();
                        $where = '';
                        $join = '';
 
                        if( $filter['Criteria'] ){
                            $where = "where {$filter['Criteria']}";
                        }
                        if($group['JoinObject']){
                            $join = "inner join {$group['JoinObject']} on TempResults.{$group['FilterValue']} = {$group['JoinObject']}.{$group['ObjectId']}";
                        }
                        /* Changes - Vinod - 11/02/21 - Replaced TempResults table */ 

                        if ($QstringSim==2) 
                        {
                           $query_template = "
                            select distinct min(PriceAfterDiscountShekels) as price, Currency,CompanyNumber
                            from (select * from Integration.WSResult_1002_Sim2_V2 where AutoShayResultID={$autoShayResultID}) as TempResults
                          {$join}
                            {$where}";     

                        }
                        else
                        {

                            $query_template = "
                            select distinct min(PriceAfterDiscountShekels) as price, Currency,CompanyNumber
                            from (select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID}) as TempResults
                          {$join}
                            {$where}";
                        }
                        
                        plugin_log7('CarService.php 969')   ;                     
                         plugin_log7($query_template); 
                        $result = $this->wpdb->get_row( $query_template, ARRAY_A);
                        $grouped_filters[ $group['PID'] ][ $filter['PID'] ] = $result;
                    }
                    
                break;
                case 'Value':
                    $filters = array();
                    
                    $join = '';
                    if($group['JoinObject']){
                        $join = "inner join {$group['JoinObject']} on TempResults.{$group['FilterValue']} = {$group['JoinObject']}.{$group['ObjectId']}";
                    }
                    /*
                    $query_template = "
                        select TempResults.{$group['DecodingValue']}, TempResults.{$group['FilterValue']}, min(PriceAfterDiscountShekels) as price, Currency
                        from ( select * from Integration.WSResult_1001_cacheV2) as TempResults 
                        {$join}
                        group by {$group['DecodingValue']}
                    ";
                    */
                    if ($QstringSim==2) 
                    {
                              $query_template = "
                        select TempResults.{$group['FilterValue']},TempResults.{$group['DecodingValue']}, min(PriceAfterDiscountShekelsWithVAT) as price, Currency
                        from 
                        (select * from Integration.WSResult_1002_Sim2_V2 where AutoShayResultID={$autoShayResultID}) as TempResults 
                        group by {$group['FilterValue']},TempResults.{$group['DecodingValue']}
                    ";

                    }

                    else
                    {

                        $query_template = "
                        select TempResults.{$group['FilterValue']},TempResults.{$group['DecodingValue']}, min(PriceAfterDiscountShekelsWithVAT) as price, Currency
                        from 
                        (select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID}) as TempResults 
                        group by {$group['FilterValue']},TempResults.{$group['DecodingValue']}
                    ";
                    }

                       

                    plugin_log7('CarService.php 1015')   ;                     
                     plugin_log7($query_template); 
                       
                    $results = $this->wpdb->get_results( $query_template, ARRAY_A);
                    
                    foreach($results as $filter){
                     //   $filters[ $filter[ $group['FilterValue'] ] ] = $filter;
                        $filters[ $filter[ $group['DecodingValue'] ] ] = $filter;
                    //    print_r('getfilters');

                    }
                    
                    $grouped_filters[ $group['PID'] ] = $filters;
                    
                break;
            }
            
        }
        
       if ($QstringSim==2) 
       {
            $query = "
            SELECT CarTypeID, min(PriceAfterDiscountShekelsWithVAT) as price
            FROM (select * from Integration.WSResult_1002_Sim2_V2 where AutoShayResultID={$autoShayResultID}) as TempResults
            GROUP BY CarTypeID";
       }
       else
       {
            $query = "
            SELECT CarTypeID, min(PriceAfterDiscountShekelsWithVAT) as price
            FROM (select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID}) as TempResults
            GROUP BY CarTypeID";
       }

            

        $minprice = $this->wpdb->get_results( $query, ARRAY_A);
        
        $results = array();
        foreach($minprice as $car){
            /*
            $query = "
                SELECT CarTypeId, SmallSuitcaseNum, LargeSuitcaseNum, PassangersNum, PriceAfterDiscountShekels as price, Currency
                FROM Integration.WSResult_1001_cacheV2 as temp1
                WHERE AutoShayResultID = '". $autoShayResultID ."' and CarTypeId = '{$car['CarTypeId']}' AND PriceAfterDiscountShekels = '{$car['price']}'
            ";
            */

           if ($QstringSim==2)
           {
                $query = "SELECT CarTypeId, SmallSuitcaseNum, LargeSuitcaseNum, PassangersNum, PriceAfterDiscountShekelsWithVAT as price, Currency
                FROM (select * from Integration.WSResult_1002_Sim2_V2 where AutoShayResultID={$autoShayResultID}) as temp1
                WHERE  CarTypeId = '{$car['CarTypeID']}' AND PriceAfterDiscountShekelsWithVAT = '{$car['price']}'
            ";
           }
           else
           {
             $query = "SELECT CarTypeId, SmallSuitcaseNum, LargeSuitcaseNum, PassangersNum, PriceAfterDiscountShekelsWithVAT as price, Currency
                FROM (select * from Integration.WSResult_1002 where AutoShayResultID={$autoShayResultID}) as temp1
                WHERE  CarTypeId = '{$car['CarTypeID']}' AND PriceAfterDiscountShekelsWithVAT = '{$car['price']}'
            ";

           }
            
            plugin_log7('CarService.php 1079')   ;                     
            plugin_log7($query_template); 
                    
            $results[] = $this->wpdb->get_row( $query, ARRAY_A);
        }
        
        $types = array();
        foreach($results as $car){
            if(!isset($types[ $car['CarTypeID'] ])){
                $types[ $car['CarTypeID'] ] = array();
            }
            $types[ $car['CarTypeID'] ] = $car;
        }
        $grouped_filters[0] = $types;
        
        foreach ($grouped_filters as $key_group => $group){
            foreach($group as $key_filter => $filter){
        if(!is_array($filter)) continue;
                foreach($filter as $key_field => $field){
                    if($key_field == 'price' && !is_null($field)){
                        $field = floatval($field);
                        $grouped_filters[$key_group][$key_filter][$key_field] = round($field, 1);
                    }
                }
            }
        }
      //  WriteToLog('GroupedFilters693');
      //  WriteToLog(print_r($grouped_filters,'true'));


        

        return $grouped_filters;
    }
    
}
