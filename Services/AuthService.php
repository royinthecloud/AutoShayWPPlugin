<?php

    class AuthService extends Service{
        function  __construct($connection = null){
            parent::__construct($connection);
            
            $this->request_fields = array(
                'name',
                'email',
                'phone',
            );
        }
        
        public function getValidatedFields(WP_REST_Request $request){
            $data = array();
            foreach($this->request_fields as $field){
                $value = $request->get_param($field);
                
                switch($field){
                    case 'name':
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
        
        public function processContact($contact){
            return $this->wpdb->insert('contactbooking', $contact);
        }
    }