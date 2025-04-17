<?php
/*
Plugin name: Autoshay Api
Description: Autoshay Api
Author: Autoshay Api
Version: 1.0
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// ini_set('memory_limit', '1024M'); 
error_reporting(E_ALL);

include_once ('autoload_services.php');
class AutoshayApi extends WP_REST_Controller
{

    const DB_ERR_CON_MSG = 'Error database connection';

    protected $db_name_second;
    protected $is_connected_to_db;

   


    

  
    public function initialize()
    {

        global $g_result;

    //    $g_result = "test123";
           
        $options = $this->get_options();
        $this->db_name_second = $options['db_name'];
        $this->is_connected_to_db = $this->test_db_connection($this->db_name_second);

        $this->init_api();
        $this->init_plugin();

         

     


       session_start();  

    
    }

    protected function test_db_connection($database)
    {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, $database);
        if (!$link)
        {
            return false;
        }

        mysqli_close($link);
        return true;
    }

    protected function init_plugin()
    {
        add_action('admin_menu', array(
            $this,
            'admin_menu'
        ));
    }


    function admin_menu()
    {
        add_menu_page('Autoshay settings', 'Autoshay settings', 'administrator', 'autoshay', array(
            $this,
            'admin_options'
        ));

        $start = true;
        $table_first = "";

        if ($all_tables = $this
            ->tableService
            ->getAllTables())
        {
            $i = 0;
            $num = 0;
            $tables = array();

            foreach ($all_tables as $table) foreach ($table as $table_name) $tables[mb_strtolower($table_name) ] = $table_name;
/*
            ksort($tables);
            foreach ($tables as $table_name)
            {
                if ($i % 13 == 0)
                {
                    $start = true;
                    $num++;
                }

                if ($start)
                {
                    add_menu_page('Autoshay tables ' . $num, 'Autoshay tables ' . $num, 'read', 'autoshay-table-' . $table_name);
                    $start = false;
                    $table_first = $table_name;
                }

                add_submenu_page('autoshay-table-' . $table_first, $table_name, $table_name, 'read', 'autoshay-table-' . $table_name, array(
                    $this,
                    'autoshay_table_options'
                ));
                $i++;
            }
*/

        }
    }

    function autoshay_table_options()
    {
        $page = isset($_GET["page"]) ? $_GET["page"] : "";
        $paged = isset($_GET["paged"]) ? intval($_GET["paged"]) : 1;

        $table_name = str_replace("autoshay-table-", "", $page);
        $url = ($_SERVER["DOCUMENT_URI"]);

        if ($structure = $this
            ->tableService
            ->getStructureTable($table_name))
        {
            $columns = array();

            foreach ($structure as $row) $columns[] = $row->Field;

            $orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : $columns[0];
            $order = isset($_GET["order"]) ? $_GET["order"] : "asc";

            $all = $this
                ->tableService
                ->getRowCountTable($table_name);
            $count_row = $all[0]->count;

            $limit = 50;
            $count_page = ceil($count_row / $limit);

            $first = $paged > 2;
            $prev = $paged > 1;
            $next = $paged < $count_page;
            $last = $paged < $count_page - 1;

            $first_url = $url . "?page=autoshay-table-" . $table_name . "&paged=1&orderby=" . $orderby . "&order=" . $order;
            $prev_url = $url . "?page=autoshay-table-" . $table_name . "&paged=" . ($paged - 1) . "&orderby=" . $orderby . "&order=" . $order;
            $next_url = $url . "?page=autoshay-table-" . $table_name . "&paged=" . ($paged + 1) . "&orderby=" . $orderby . "&order=" . $order;
            $last_url = $url . "?page=autoshay-table-" . $table_name . "&paged=" . $count_page . "&orderby=" . $orderby . "&order=" . $order;

            $rows = $this
                ->tableService
                ->read($table_name, $paged, $limit, $orderby, $order);
            require_once (__DIR__ . '/inc/autoshay_table.php');
        }
        else
        {
            echo '<div class="updated fade"><p>Table ' . $table_name . ' not found!</p></div>';
        }

    }

    function admin_options()
    {

        $action_url = $_SERVER['REQUEST_URI'];
        $options = $this->get_options();
        if (isset($_POST['submitted']))
        {
            check_admin_referer('autoshay_options');

            $options['db_name'] = $_POST['db_name'];
            update_option('autoshay_options', $options);

            if ($this->test_db_connection($options['db_name']))
            {
                echo '<div class="updated fade"><p>Settings saved.</p></div>';
            }
            else
            {
                $options['db_name'] = '';
                echo '<div class="updated fade"><p>Can not make connection to database.</p></div>';
            }

        }
        $nonce = wp_create_nonce('autoshay_options');

        $db_name = $options['db_name'];

        require_once (__DIR__ . '/inc/admin_form.php');
    }

    function get_options()
    {

        //  $options = array(
        //     'db_name' => '',
        //  );
        //  $options['db_name'] = get_option('autoshay_options');
        //  return $options;
        $options = array(
            'db_name' => '',
        );

        $saved = get_option('autoshay_options');

        if (!empty($saved))
        {
            foreach ($saved as $key => $option)
            {
                $options[$key] = $option;
            }
        }

        if ($saved != $options) update_option('autoshay_options', $options);

        return $options;
    }

       private function log844($entry, $mode = 'a', $file = 'debug2') 
        {
          // Get WordPress uploads directory.
          $debug = 'Y';

              if ($debug == 'Y') {
                  $upload_dir = wp_upload_dir();
                  $upload_dir = $upload_dir['basedir'];

                  // Check if $entry is not set or not valid, then set to 'object is not set'
                  if (empty($entry) || !isset($entry)) {
                      $entry = 'object is not set';
                  } else {
                      // If the entry is array or object, json_encode.
                      if (is_array($entry) || is_object($entry)) {
                          $entry = 'Array:' . json_encode($entry);
                      }
                  }

                  // Write the log file.
                  $file = $upload_dir . '/' . $file . '.log';

                  $file = fopen($file, $mode);
                  $bytes = fwrite($file, current_time('mysql') . "::" . $entry . "\n");
                  fclose($file);

                  return $bytes;
              } else {
                  return '';
              }
        }

    protected function init_api()
    {

        $connection = null;

        if ($this->test_db_connection($this->db_name_second))
        {
         //    log844('autoshay_api 233');
            $connection = new wpdb(DB_USER, DB_PASSWORD, $this->db_name_second, DB_HOST);

            $this->orderService = new OrderService($connection);
            $this->carService = new CarService($connection);
            $this->clientService = new ClientService($connection);
            $this->tableService = new TableService($connection);
        }

        add_action('rest_api_init', function ()
        {

            $version = '1';
            $namespace = 'v' . $version;

            register_rest_route($namespace, '/newOrder', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_new_order'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/getOrders', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_get_orders'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/newUser', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_new_user'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/getUsers', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_get_users'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/search', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_search'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/readOnly/(?P<table>[A-Za-z0-9_]+)', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_get_table_data'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/getcitiesbyid', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_getcitiesbyid'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/auth', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'api_auth'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

            register_rest_route($namespace, '/isBooking', array(
                'methods' => 'POST',
                'callback' => ($this->is_connected_to_db ? array(
                    $this,
                    'isBooking'
                ) : array(
                    $this,
                    'error_db_connection'
                )) ,
            ));

           register_rest_route($namespace, '/tester1', array(
            'methods' => 'GET',
            'callback' => ($this->is_connected_to_db ? array(
                $this,
                'api_tester1'
            ) : array(
                $this,
                'error_db_connection'
            )) ,
        ));


        });
    }

    /*API call*/
 
 public function api_tester1($request) 
{
    try {
        // Log access for debugging
        if (function_exists('plugin_log855')) {
            plugin_log855('Tester1 accessed');
        }
        
        // Check if the template file exists
        $template_path = get_template_directory() . '/Rental2/Components/tester1/tester1.php';
        
        if (file_exists($template_path)) {
            // Set headers to ensure proper display
            header('Content-Type: text/html; charset=UTF-8');
            
            // Include the template file
            include_once($template_path);
            exit;
        } else {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Tester file not found at: ' . $template_path
            ), 404);
        }
    } catch (Exception $e) {
        return new WP_REST_Response(array(
            'success' => false,
            'message' => 'Error in tester1: ' . $e->getMessage()
        ), 500);
    }
}


    public function api_new_order($request)
    {

      plugin_log844('autoshay_api.api_new_order579:request');
      plugin_log844($request);


        $client = $this
            ->clientService
            ->getValidatedFields($request);

      plugin_log844('autoshay_api.api_new_order587:client'); 
      plugin_log844($client); 
      


      // Get all request parameters as an associative array
     $allParams = $request->get_params();

    // Convert the parameters array to a JSON string
    $paramsJson = json_encode($allParams);

    // Log the JSON string
    // Assuming `plugin_log6` is your logging function


    plugin_log6('autoshay_api.api_new_order602: request parameters'); 
    plugin_log6($paramsJson);





        if (!is_array($client))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $client
            ) , 200);
        }



        WriteToLog('OrderRequest');
//        WriteToLog(pll_current_language());

        $order = $this
            ->orderService
            ->getValidatedFields($request);
        if (!is_array($order))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $order
            ) , 200);
        }


      plugin_log6('autoshay_api.api_new_order620:order'); 
      plugin_log6($order); 


        $client['Language'] = 'he';

//          plugin_log('626' . $client['Language']);            

        $equipments = $request->get_param('equipments');
        $equipments = is_array($equipments) ? $equipments : array();

        /*

      Order columns  
      id, pickup_moment, pickup_interest_point_id, dropoff_moment, dropoff_interest_point_id, price, Currency, PriceShekels, companyno, GROUPCODE, is_protected, flight_airline, flight_no, created_at, updated_at, client_id, client_first_name, client_last_name, client_email, client_phone, SearchId, OrderStatus, DriverAgeId, OrderSource, ResultID, ResultID_UID, GroupName, Age, equipments, JsonPayment, OrderURL, Version, Simulator, AgentReal




        */

         plugin_log6('autoshay_api.api_new_order633: equipments'); 
        plugin_log6($equipments);

        $equipmentData = getEquipmentData($equipments,$client['Language']);

        plugin_log6($equipmentData);

     
        $client['id'] = $request->get_param('client_id');
        $client['SearchId'] = 0;
        
        /* Changes - Vinod - 11/02/21 - Added price fields to order */ 
        $date1  = date_create($request->get_param('pickup_moment'));
        $date2  = date_create($request->get_param('dropoff_moment'));
        $diff   = date_diff($date1,$date2);
        
        $order['price'] = intval($request->get_param('price_after_discount'));
        $order['OrderSource'] = $request->get_param('OrderSource');
        $order['ResultID'] = intval($request->get_param('ResultID'));
        $order['ResultID_UID'] = intval($request->get_param('ResultID_UID'));
        $order['Age'] = intval($request->get_param('Age'));
        $order['AgentReal'] = intval($request->get_param('agent'));
        $order['Simulator'] = 'Sim2';
        $order['Version'] = $_SESSION['version'] ?? 'Unknown';



     //   $order['AgeRange'] = '30-65';
      

      plugin_log844('autoshay_api.api_new_order 653:order'); 
     plugin_log844($order); 
     


        $priceInsurance = intval($request->get_param('PriceInsurance'));
        $rentDays = $diff->days;
        
        if($order['is_protected'] == 1):
            $insurencePrice = $priceInsurance * $rentDays;      
            $finalPrice = $order['price'] + $insurencePrice;
        else:
            $finalPrice = $order['price'];
        endif;
        
        $order['PriceShekels'] = $finalPrice;
        

        if ($result = $this
            ->orderService
            ->create($client, $order, $equipments))
        {


            /*
            SELECT option_value FROM wp_options WHERE option_name = 'order_email_themes';


            */

            $email_themes = get_field('order_email_themes', 'options') [0];

            
            /*
                start logging 

            */

            // Fetch the field value
            $email_themes1 = get_field('order_email_themes', 'options');

            // Convert the result to a string for logging (assuming it could be an array or object)
            $email_themes_log = is_array($email_themes1) || is_object($email_themes1) ? json_encode($email_themes1) : $email_themes1;


            plugin_log6('autoshay_api.api_new_order 725: $email_themes1/equipmentData'); 
            plugin_log6($email_themes1); 
            plugin_log6($equipmentData); 


            /*

                end logging $email_themes
            */



            $client['Language'] = 'he';

             $conn = openDBconn();

            $email_data = getOrderAndEmailData_v1($conn,$result['id'],'he')[0];




            $email = $client['email'];

            $subject = 'תודה רבה על בקשתך '; 

            /*
            if ($client['Language'] == 'he')
            {
                $subject = 'תודה רבה על הזמנתך'; 
            }
            else
            {
                $subject = $email_themes['english'] ;
            }
            */

            $headers = array(
                'Content-Type: text/html; charset=UTF-8'
            );


            
            /*
            $email_data = $this
                ->orderService
                ->getOrderEmailDataByID($result['id']);
            */

                
            $email_data['price_after_discount'] = intval($request->get_param('price_after_discount'));
            $email_data['PriceInsurance'] = intval($request->get_param('PriceInsurance'));
            $email_data['Currency'] = $request->get_param('Currency');

            


            $email_data['GROUPNAME'] = $request->get_param('GROUPNAME');
            $email_data['CarTypeDesc'] = $request->get_param('CarTypeDesc');

            $email_data['SmallSuitcaseNum'] = $request->get_param('SmallSuitcaseNum');
            $email_data['LargeSuitcaseNum'] = $request->get_param('LargeSuitcaseNum');
            $email_data['PassangersNum'] = $request->get_param('PassangersNum');

            $email_data['DoorsNum'] = $request->get_param('DoorsNum');
            $email_data['email_seats'] = $request->get_param('email_seats');
            $email_data['FuelPolicyDesc'] = $request->get_param('FuelPolicyDesc');
            $email_data['FuelPolicyDescHebrew'] = $request->get_param('FuelPolicyDescHebrew');
            
            $email_data['IsAirconditioning'] = $request->get_param('IsAirconditioning');
            $email_data['IsAutomatic'] = $request->get_param('IsAutomatic');
            $email_data['IsManual'] = $request->get_param('IsManual');
            $email_data['free_options'] = $request->get_param('free_options');
            $email_data['extra_options'] =  $equipmentData;
            $email_data['Age'] = $request->get_param('Age');
            $email_data['lang'] = $request->get_param('lang');

            // added order response data to email data [05/09/2022 start]
            $email_data['flight_airline'] = $request->get_param('flight_airline');
            $email_data['flight_no'] = $request->get_param('flight_no');
            $email_data['phone'] = $request->get_param('phone');

            $subject = $subject . ' ' . $email_data['order_id'];

            
            
            $email_data['lang'] = 'he' ;

            

             /*

                8_40 - add agent Name to email order
            */

            $agent = intval($request->get_param('agent'));
             if (isset($agent) && $agent>0)
             {   

                 $conn = openDBconn();

                 $agentSettings = getPelecardSettingsByAgentID($conn,$agent);
                $email_data['AgentName'] = isset($agentSettings['AgentName']) ? $agentSettings['AgentName'] : "";

            }



             plugin_log6('autoshay_api.api_new_order 725: $email_data'); 
            plugin_log6($email_data); 
            plugin_log6('autoshay_api.api_new_order 725: extra_options'); 
            plugin_log6($email_data['extra_options']);

             plugin_log3('autoshy_api-L728');




            if ($email_data['lang'] == 'en') {
        $currentLanguage = 'en';

//       plugin_log('English');
        
    } else {
        $currentLanguage = 'he';
   //     plugin_log('761' . $email_data['lang']);
   //     plugin_log('Hebrew');
    }



        // plugin_log($email_data)    ; 
         //   $message = $this->get_order_email_text($email_data,  $currentLanguage);

          //   WriteToLog($message);
          //   WriteToLog(print_r($message,'true'));

          //  WriteToLog('Client Email');
          //  WriteToLog($email);


         //   plugin_log('763' . $subject)    ;
         //  plugin_log('764' . $email_data)    ;    

            /*
               8_44 

            */


             SendOrderEmail_V4($email_data,$email,3,'autoshay_api647') ; 


            /*

            wp_mail($email, $subject, $message, $headers);

            $email = trim(get_field('email_receiver', 'options') [0]['address']);
            wp_mail($email, $subject, $message, $headers);

            */

           // WriteToLog('Email_reciever');
          //  WriteToLog($email);

            return new WP_REST_Response(array(
                'success' => true,
                'order_id' => $result['id']
            ) , 200);
        }

    }

    protected function get_order_email_text($email_data, $lang)
    {

      //  plugin_log('782' . $lang);
        ob_start();
        if ($lang=='he')
        {
            require (__DIR__ . '/email/email-rtl.php');
        }
        else
        {
            require (__DIR__ . '/email/email.php');
        }
        return ob_get_clean();
    }

    protected function get_signin_email_text($email_data, $is_rtl = true)
    {

        $is_rtl = true; 
        ob_start();
        if ($is_rtl)
        {
            require (__DIR__ . '/email/signin-rtl.php');
        }
        else
        {
            require (__DIR__ . '/email/signin.php');
        }
        return ob_get_clean();
    }

    public function api_get_orders($request)
    {
        $dates = $this
            ->orderService
            ->getValidatedDatesRange($request);
        if (!is_array($dates))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $dates
            ) , 200);
        }

        $orders = $this
            ->orderService
            ->read($request->get_param('page') , $dates['min'], $dates['max']);

        return new WP_REST_Response($orders, 200);
    }

    public function api_new_user($request)
    {
        $client = $this
            ->clientService
            ->getValidatedFields($request);
        if (!is_array($client))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $client
            ) , 200);
        }

        $isCreated = $this
            ->clientService
            ->create($client);

        return new WP_REST_Response(array(
            'success' => is_numeric($isCreated)
        ) , 200);
    }

    public function api_get_users($request)
    {
        $dates = $this
            ->clientService
            ->getValidatedDatesRange($request);
        if (!is_array($dates))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $dates
            ) , 200);
        }

        $clients = $this
            ->clientService
            ->read($request->get_param('page') , $dates['min'], $dates['max']);

        return new WP_REST_Response($clients, 200);
    }

    public function api_search($request)
    {

        plugin_log855('autoshay_api.php 852 search');
        plugin_log844($request);

        $search = $this
            ->carService
            ->getValidatedFields($request);

        plugin_log844('autoshay_api.php 859 search')    ;
        plugin_log844($search) ;  
            
        if (!is_array($search) || empty($search))
        {
            plugin_log844('autoshay_api.php 808 false');
          //  $search=[];
            
           
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $search
            ) , 200);
            
        }

        plugin_log844('autoshay_api.php 814');
        



        $result = $this
            ->carService
            ->search($search, $request->get_param('initialize') , $request->get_param('filters'));

        return new WP_REST_Response(array(
            'success' => true,
            'result' => $result
        ) , 200);
    }

    public function api_get_table_data($request)
    {

        $table = $request->get_param('table');

        if (!$this
            ->tableService
            ->isAvailable($table))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => "{$table} is not available"
            ) , 200);
        }

        $result = $this
            ->tableService
            ->read($table, $request->get_param('page'));
        return new WP_REST_Response($result, 200);
    }

    public function api_getcitiesbyid($request)
    {
        $id = $request->get_param('id');
        $result = array();
        if (!$id)
        {
            return new WP_REST_Response(array(
                'result' => $result
            ) , 200);
        }

        $result = $this
            ->tableService
            ->getcitiesbyid($id);
        usort($result, array(
            'AutoshayApi',
            'cities_ordering'
        ));

        return new WP_REST_Response(array(
            'result' => $result
        ) , 200);
    }

    public function isBooking($request)
    {

        if (!isset($_POST['searchId']))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => sprintf("Missing searchId params")
            ) , 400);
        }

        $this
            ->clientService
            ->wpdb
            ->query(sprintf("UPDATE Searches SET isBooking=1 WHERE PId = %d", $_POST['searchId']));

        return new WP_REST_Response(array(
            'success' => true,
            'message' => sprintf("search %d was updated", $_POST['searchId'])
        ) , 200);
    }

    public function api_auth($request)
    {
        $client = $this
            ->clientService
            ->getValidatedFields($request, array(
            'last_name'
        ));
        if (!is_array($client))
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => $client
            ) , 200);
        }

        $client['Language'] = $request->get_param('Age');


        $client = $this
            ->clientService
            ->create($client);

        $client['Language'] == 'he';    

        if ($client)
        {

            $email_themes = get_field('signin_email_theme', 'options') [0];

            $email = trim(get_field('signin_email_receiver', 'options') [0]['address']);
            if ($client['Language'] == 'he')
            {
                $subject = $email_themes['herbrew'] ;
            }
            else
            {
                $subject = $email_themes['english'] ;
            }
            $message = $this->get_signin_email_text($client, $client['Language']== 'he');

            $headers = array(
                'Content-Type: text/html; charset=UTF-8'
            );
            wp_mail($email, $subject, $message, $headers);

            return new WP_REST_Response(array(
                'data' => array(
                    'client_id' => $client['id'],
                    'clientData' => json_encode($client)
                ) ,
                'success' => true
            ) , 200);
        }
        else
        {
            return new WP_REST_Response(array(
                'success' => false,
                'message' => 'Unknown error'
            ) , 200);
        }

    }

    /*Direct call*/
    public function cities_ordering($a, $b)
    {
        return strnatcmp($a['Points_of_interest_desc'], $b['Points_of_interest_desc']);
    }

    public function country_ordering($a, $b)
    {
        return strnatcmp($a['stateName'], $b['stateName']);
    }

     public function CarPriceOrdering($a, $b)
    {
        return strnatcmp($a['PriceAfterDiscountShekelsWithVAT'], $b['PriceAfterDiscountShekelsWithVAT']);
    }


    public function getcitiesbyid($id)
    {

        if (!$this->is_connected_to_db)
        {
            trigger_error($this->DB_ERR_CON_MSG);
            return array();
        }

        $result = array();
        if (empty($id))
        {
            return $result;
        }
        $result = $this
            ->tableService
            ->getcitiesbyid($id);
        usort($result, array(
            'AutoshayApi',
            'cities_ordering'
        ));
        return $result;
    }

    public function getcitybyid($id)
    {

        if (!$this->is_connected_to_db)
        {
            trigger_error($this->DB_ERR_CON_MSG);
            return array();
        }

        $result = array();
        if (empty($id))
        {
            return $result;
        }
        $result = $this
            ->tableService
            ->getcitybyid($id);
        return $result;
    }

    public function get_table_data($table)
    {

        if (!$this->is_connected_to_db)
        {
            trigger_error($this->DB_ERR_CON_MSG);
            return array();
        }

        if (!$this->is_connected_to_db)
        {
            return array();
        }

        if (!$this
            ->tableService
            ->isAvailable($table))
        {
            return array();
        }

        return $this
            ->tableService
            ->read($table, 'all');
    }

    public function get_states()
    {
        $result = $this
            ->tableService
            ->read('states', 'all');
        usort($result, array(
            'AutoshayApi',
            'country_ordering'
        ));
        return $result;
    }

    public function get_client()
    {
        if (isset($_COOKIE['client_id']))
        {
            return $this
                ->clientService
                ->getClientByID($_COOKIE['client_id']);
        }
        else
        {
            return false;
        }
    }

/*
V8_36

Cach data overwrites querystring data


*/


public function getCacheData()
{
    global $cacheData;

    if (!isset($cacheData))
    {
        $cache = $_GET['cache'] ?? 0;
        $sim = $_GET['sim'] ?? 2;

        if ($cache > 0)
        {
            $conn = openDBconn();
            if ($sim == 1)
            {
                $cacheData = getResultFromSimulator1($conn, $cache);

                /*
                
                $_GET['cityFrom'] = $cacheData['cityFrom'];
                $_GET['cityTo'] = $cacheData['cityTo'];
                $_GET['date_take_lm_year'] = $cacheData['date_take_lm_year'];
                $_GET['date_take_lm_month'] = $cacheData['date_take_lm_month'];
                $_GET['date_take_lm_day'] = $cacheData['date_take_lm_day'];
                $_GET['TimeFromHour'] = $cacheData['TimeFromHour'];
                $_GET['TimeFromMinut'] = $cacheData['TimeFromMinut'];
                $_GET['date_return_lm_year'] = $cacheData['date_return_lm_year'];
                $_GET['date_return_lm_month'] = $cacheData['date_return_lm_month'];
                $_GET['date_return_lm_day'] = $cacheData['date_return_lm_day'];
                $_GET['TimeToHour'] = $cacheData['TimeToHour'];
                $_GET['TimeToMinut'] = $cacheData['TimeToMinut'];
                $_GET['age'] = $cacheData['age'] ?? 30;
                $_GET['agent'] = $cacheData['agent'] ?? 0;
                $_GET['version'] = $cacheData['version'] ?? 'undefined';
                $_GET['from'] = $cacheData['From1'] ;
                $_GET['to'] = $cacheData['To1'] ;

                */

            }
            elseif ($sim == 2)
            {
                $cacheData = getResultFromSimulator2($conn, $cache);
            }
            else
            {
                $cacheData = [];
            }
        }
        else
        {
            $cacheData = [];
        }
    }

    $_SESSION['cacheData'] = $cacheData;
    return $cacheData; 
}


    public function get_grouped_filters()
    {

        global $grouped_filters;

        if (!isset($grouped_filters))
        {
                $grouped_filters = $this
                ->carService
                ->getGroupedFilters(); 
            //      WriteToLog('Number Y');
        }
//            $grouped_filters = new carService();
        
//            $grouped_filters->getGroupedFilters();
        
         $_SESSION['grouped_filters'] =  $grouped_filters;
        
       return  $grouped_filters;
      
      /* 
        return $this
            ->carService
            ->getGroupedFilters();
        */    
    }
}

function get_autoshay_api()
{
    global $autoshay_api;



    if (!$autoshay_api)
    {
      //  session_start();  
        $_SESSION['init_id']  =1 ;
        $autoshay_api = new AutoshayApi();
        $autoshay_api->initialize();

        // plugin_log844('autoshay_api.php 1139');

     //     WriteToLog('CountryFromLead');
     //     WriteToLog($_GET['countryFrom']);
    }

 //  WriteToLog('CountryFromLead');
    return $autoshay_api;
}

get_autoshay_api();