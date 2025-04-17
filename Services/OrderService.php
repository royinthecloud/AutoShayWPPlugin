<?php

class OrderService extends Service
{
    function __construct($connection = null){
        parent::__construct($connection);
        
        $this->request_fields = array(
            'is_protected',
            'flight_airline',
            'flight_no',
            'pickup_moment',
            'dropoff_moment',
            'pickup_interest_point_id',
            'dropoff_interest_point_id',
            'companyno',
            'GROUPCODE',
            
        );
    }
    
    public function getValidatedFields(WP_REST_Request $request){
        $data = array();
        foreach($this->request_fields as $field){
            $value = $request->get_param($field);
            
            switch($field){
                case 'is_protected':
                    if( is_null($value) ){
                       $data[$field] = 0;
                    } else{
                       $data[$field] = intval($value);
                    }
                break;
                case 'flight_airline':
                case 'flight_no':
                    if( is_null($value) ){
                       $data[$field] = '';
                    } else{
                       $data[$field] = substr($value, 0, 255);
                    }
                break;
                case 'pickup_moment':
                case 'dropoff_moment':
                    if( is_null($value) ){
                       return "{$field} required";
                    } else{
                        $date = strtotime($value);
                        if($date){
                            $data[$field] = date(self::DATE_TIME_FORMAT, $date);
                        } else {
                            return "{$field} have incorrect format";
                        }
                    }
                break;
                case 'pickup_interest_point_id':
                case 'dropoff_interest_point_id':
                case 'companyno':
                case 'GROUPCODE':
                    if( is_null($value) ){
                       return "{$field} required";
                    } else{
                        $data[$field] = intval($value);
                    }
            }
        }
  //      plugin_log('OrderService.getValidatedFields67');
   //     plugin_log($data);

      //  WriteToLog('Order Data');
      //  WriteToLog(print_r($data,'true'));

        return $data;
    }
    
    public function create(array $client, array $order, array $equipments)
    {


  //      plugin_log('FindOrCreate Client call');
  //      plugin_log($client);

        $client = $this->findOrCreateClient($client);

    
 //   WriteToLog('Get/Client/Order/equipment');

 //   WriteToLog(print_r($client,'true'));
 //   WriteToLog(print_r($order,'true'));
 //   WriteToLog(print_r($equipments,'true'));

// plugin_log('OrderServices.Orders');

// plugin_log('Order-M004');
// plugin_log($order);

// plugin_log('equipment-M004');
// plugin_log($equipments);

// plugin_log('Client-M004');
// plugin_log($client);


        $dt = new DateTime("now", new DateTimeZone('Israel'));


        plugin_log4('Hovo OrderService 107');
        plugin_log4($order);



        $order['client_id'] =   (!empty($client['id'])) ? $client['id'] : 0 ;
        $order['updated_at'] =   date(self::DATE_TIME_FORMAT,time());
        $order['created_at'] =   $dt->format(self::DATE_TIME_FORMAT);
        
        $order['client_first_name'] = (!empty($client['first_name'])) ? $client['first_name'] : '' ;
        $order['client_last_name'] = (!empty($client['last_name'])) ? $client['last_name'] : '' ;
        $order['client_email'] = (!empty($client['email'])) ? $client['email'] : '' ;
        $order['client_phone'] = (!empty($client['phone'])) ? $client['phone'] : '' ;
        $order['SearchId'] = (!empty($client['SearchId'])) ? $client['SearchId'] : 0 ;

     //   plugin_log($_SERVER['REQUEST_URI'] . '/complete/?order=' . $order); 


// https://search.auto-shay.com/7_78B/en/complete/?order=25001438

       // $order['DriverAgeId'] = $client['id'];

        

     //   plugin_log('OrderService110-M004');
     //   plugin_log($order);
     //   plugin_log($this->order_table);


        $this->wpdb->insert($this->order_table, $order);
         $lastid = $this->wpdb->insert_id;


        if (!empty($client['SearchId']))    
        {

           
            $driverId = $this->wpdb->get_var("SELECT `Searches`.`DriversAgeId` FROM `Searches` WHERE PId={$client['SearchId']}");
            $this->wpdb->update($this->order_table, array('DriverAgeId'=>$driverId), array('id'=>$lastid));
        } ;

  



        
        $order = $this->getOrderByID($this->wpdb->insert_id);
    //   plugin_log('OrderService110-M004');
     //   plugin_log($order);



        if(!$order || !$this->assassinateWithEquipment($order, $equipments)){
            

       //     plugin_log('troubles during creating')    ;
        //    plugin_log($order);

            throw new Exception('troubles during creating');
        }
        

        return $order;
    }
    
    public function getOrderByID($id){
    //     plugin_log('OrderService110-M005');    
    //    plugin_log($id);
        return $this->wpdb->get_row("SELECT * FROM {$this->order_table} WHERE id = '{$id}'", ARRAY_A);
    }
    
    public function getOrderEmailDataByID($id){
        $query = "
            SELECT 
                o.id as order_id,
                o.dropoff_moment,
                o.pickup_moment,
                o.price,
                o.is_protected,
                p_point.Points_of_interest_desc as pickup_location, 
                d_point.Points_of_interest_desc as dropoff_location,
                DATEDIFF(o.dropoff_moment, o.pickup_moment) AS rent_days,
                o.client_first_name as first_name,
                o.client_last_name as last_name,
                o.client_email as email,
                o.GROUPCODE,
                o.companyno,
                o.DriverAgeId,
                v.GROUPNAME,
                v.PassangersNum,
                v.LargeSuitcaseNum,
                v.SmallSuitcaseNum,
                v.IsAirconditioning,
                v.IsAutomatic,
                v.IsManual,
                v.DoorsNum,
                ct3.CarTypeDesc,
                ct3.CarTypeDescHebrew,
                fp.FuelPolicyDesc,
                fp.FuelPolicyDescHebrew
            FROM {$this->order_table} as o
            LEFT JOIN InterestPoints as p_point ON p_point.Points_of_interest = o.pickup_interest_point_id
            LEFT JOIN InterestPoints as d_point ON d_point.Points_of_interest = o.dropoff_interest_point_id
            LEFT JOIN clients as c ON c.id = o.client_id
            LEFT JOIN Vehicles as v ON v.companyno = o.companyno AND v.GROUPCODE = o.GROUPCODE
            LEFT JOIN CarTypes3 as ct3 ON ct3.PId = v.CarTypeId2
            LEFT JOIN FuelPolicies as fp ON fp.PId = v.CarTypeId2
            WHERE o.id = '{$id}'
        ";
        

     //   plugin_log('getOrderEmailDataByID170');

      //  plugin_log($query);



        $order = $this->wpdb->get_row($query, ARRAY_A);

        
        if($order){
            $order['equipment'] = $this->getOrderEquipment($id);
        }


         plugin_log3($order)  ; 


        if( date('H' , strtotime($order['dropoff_moment']) ) >  date('H' , strtotime($order['pickup_moment']) ) ||
            date('H' , strtotime($order['dropoff_moment']) ) ==  date('H' , strtotime($order['pickup_moment']) ) && date('i' , strtotime($order['dropoff_moment']) ) >  date('i' , strtotime($order['pickup_moment']) )
            ){
            $order['rent_days']++;
        }
        return $order;
    }
    

    public function getOrderEquipment($id){
        
        $ExtraDesc = (pll_current_language() == 'he' ? 'ExtraDescHebrew' : 'ExtraDesc');
        $query = "
            SELECT ec.{$ExtraDesc} as ExtraDesc
            FROM order_equipment oe
            LEFT JOIN ExtraClasses as ec ON ec.ExtraClass = oe.equipment_id
            WHERE order_id = '{$id}'
        ";
        
        return $this->wpdb->get_col($query);
    }
    
    public function getFreeOptionsByTariff($id){
        $ExtraDesc = (pll_current_language() == 'he' ? 'ExtraDescHebrew' : 'ExtraDesc');
        $query = "
            SELECT ec.{$ExtraDesc} as ExtraDesc FROM ExtraClasses ec WHERE ec.ExtraClass IN 
                (SELECT te.TARIFFCLASS FROM TariffExtras te WHERE te.FatherTariffCode = '{$id}' AND te.INCLUDEDINTHEPRICE = 'כ' )
        ";
        return $this->wpdb->get_col( $query );
    }
    
    public function findOrCreateClient($client){
        
        
    //    plugin_log('findOrCreateClient- L254')    ;
    //    plugin_log($client)    ;


        if( !is_null($client['id']) ){
            $user = $this->wpdb->get_row("SELECT * FROM {$this->client_table}  WHERE id = '{$client['id']}'", ARRAY_A);
            if($user){
                return $client;
            }
        }
            
        $user = $this->wpdb->get_row("SELECT * FROM {$this->client_table} WHERE email = '{$client['email']}'", ARRAY_A);
        if(!$user){
            $client['created_at'] = date(self::DATE_TIME_FORMAT);
            $client['updated_at'] = date(self::DATE_TIME_FORMAT);
            $this->wpdb->insert($this->client_table , $client);
            
            $user = $this->wpdb->get_row("SELECT * FROM {$this->client_table}  WHERE id = '{$this->wpdb->insert_id}'", ARRAY_A);
            return $user;
        } else {
            $client['id'] = $user['id'];
            return $client;
        }
    }
    
    public function assassinateWithEquipment($order, array $eqKeys)
    {
        $result = true;

        foreach($eqKeys as $eq){
            if(!$eq){
                continue;
            }
            $result = $result && $this->wpdb->insert('order_equipment',[
                'equipment_id' => $eq,
                'order_id' => $order['id']
            ]);
        }


 //       plugin_log('assassinateWithEquipment') ;
   //     plugin_log($result) ;

        return $result;
    }


    public function read($page = 1, $minDate = null, $maxDate = null)
    {
        if(!$page){
            $page = 1;
        }
        
        $and_where = array();
        if($minDate){
            $and_where[] = "created_at >= '{$minDate}'";
        }

        if($maxDate){
            $and_where[] = "created_at <= '{$maxDate}'";
        }
        
        $and_where = implode(' AND ', $and_where);
        if(strlen($and_where)){
            $and_where = 'WHERE ' . $and_where;
        }
        
        $limit = 10;
        $page = intval($page);
        $offset = ($page - 1) * $limit;
        
        return $this->wpdb->get_results("SELECT * FROM {$this->order_table} {$and_where} LIMIT {$limit} OFFSET {$offset}", ARRAY_A);
    }

    public function getOrderA($id){
        $query = "
            SELECT 
                o.*,
                p_point.*, 
                v.*,
                ct3.*,
                fp.*
            FROM {$this->order_table} as o
            LEFT JOIN InterestPoints as p_point ON p_point.Points_of_interest = o.pickup_interest_point_id
            LEFT JOIN InterestPoints as d_point ON d_point.Points_of_interest = o.dropoff_interest_point_id
            LEFT JOIN clients as c ON c.id = o.client_id
            LEFT JOIN Vehicles as v ON v.companyno = o.companyno AND v.GROUPCODE = o.GROUPCODE
            LEFT JOIN CarTypes3 as ct3 ON ct3.PId = v.CarTypeId2
            LEFT JOIN FuelPolicies as fp ON fp.PId = v.CarTypeId2
            WHERE o.id = '{$id}'
        ";
        return $this->wpdb->get_results($query, ARRAY_A);
    }
}