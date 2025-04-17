<?php

class ClientService extends Service
{
    function  __construct($connection = null){
        parent::__construct($connection);
        
        $this->request_fields = array(
            'first_name',
            'last_name',
            'email',
            'phone',
        );
    }
    
    public function getValidatedFields(WP_REST_Request $request, $exclude_fields = array()){
        
        $data = array();
        
        $this->request_fields = array_diff($this->request_fields, $exclude_fields);
        foreach($this->request_fields as $field){
            $value = $request->get_param($field);
            
            switch($field){
                case 'first_name':
                case 'last_name':
                case 'phone':
                    if( !is_null($value) ){
                        $data[$field] = substr($value, 0, 255);
                    } else {
                        return "{$field} required";
                    }
                break;

              
                case 'email':
                
                    if( !is_null($value) ){
                       
                        if(is_email($value)){
                            $data[$field] = $value;
                        } else {
                            return "{$field} should be email";
                        }  

                    } else {
                        return "{$field} required";
                    }
              
                break;
            }
        }
        
        return $data;
    }
    
    public function create(array $attributes)
    {
        return $this->updateOrCreateClient($attributes);
    }
    
    public function updateOrCreateClient($client){
        

      //  plugin_log('updateOrCreateClient')    ;

      //  plugin_log($client);

        $user = $this->wpdb->get_row("SELECT * FROM {$this->client_table} WHERE email = '{$client['email']}'", ARRAY_A);

        if(!$user){
            $client['created_at'] = date(self::DATE_TIME_FORMAT);
            $client['updated_at'] = date(self::DATE_TIME_FORMAT);
            $this->wpdb->insert($this->client_table , $client);
            return $this->getClientByID($this->wpdb->insert_id);
        } else {
            $client['updated_at'] = date(self::DATE_TIME_FORMAT);
            $this->wpdb->update($this->client_table , $client, array('email' => $client['email']));
            return $this->getClientByID($user['id']);
        }

    }
    
    public function getClientByID($id){
        $client =  $this->wpdb->get_row("SELECT * FROM {$this->client_table} WHERE id = '{$id}'", ARRAY_A);

        plugin_log('getClientByID:');
        plugin_log(print_r($client));
        return $client ;
        
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
        
        return $this->wpdb->get_results("SELECT * FROM {$this->client_table} {$and_where} LIMIT {$limit} OFFSET {$offset}", ARRAY_A);
    }

}