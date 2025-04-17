<?php

class Service
{
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
    protected $request_fields;
    protected $client_table;
    protected $order_table;
    protected $car_table;
    
    function  __construct($connection = null){
        
        if(!$connection){
            global $wpdb;
            $this->wpdb = $wpdb;
        } else{
            $this->wpdb = $connection;
        }
        
        $this->client_table = 'clients';
        $this->order_table = 'orders';
        
    }
    
    public function getValidatedDatesRange(WP_REST_Request $request){
        $dates = array(
            'min' => null,
            'max' => null
        );
        
        if($min = $request->get_param('min')){
            $date = strtotime($request->get_param('min'));
            if(!$date){
                return 'min date have incorrect format';
            }
            $dates['min'] = date(self::DATE_TIME_FORMAT, $date );
        }

        if($max = $request->get_param('max')){
            $date = strtotime($request->get_param('max'));
            if(!$date){
                return 'max date have incorrect format';
            }
            $dates['max'] = date(self::DATE_TIME_FORMAT, $date );
        }
        
        return $dates;
    }
}