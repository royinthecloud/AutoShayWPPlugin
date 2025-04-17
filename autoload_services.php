<?php 
    spl_autoload_register ( function ($class) {
        $file = __DIR__ . '/Services/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    });


if ( ! function_exists( 'plugin_log' ) ) {
    function plugin_log( $entry, $mode = 'a', $file = 'debug2' ) { 
      // Get WordPress uploads directory.

      $debug ='N';
        
      if ($debug=='Y')
      {
        
          $upload_dir = wp_upload_dir();
          $upload_dir = $upload_dir['basedir'];
      
          // If the entry is array, json_encode.
          if ( is_array( $entry ) || is_object( $entry )) { 
            $entry = json_encode( $entry ); 
          } 
      
          // Write the log file.
          $file  = $upload_dir . '/' . $file . '.log';

          
          $file  = fopen( $file, $mode );
          $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" ); 
          fclose( $file ); 
      
          return $bytes;
      }
      else
      {
        return '';
      }
    }
}


if ( ! function_exists( 'plugin_log2' ) ) {
    function plugin_log2( $entry, $mode = 'a', $file = 'debug2' ) { 
      // Get WordPress uploads directory.

      $debug ='N';
        
      if ($debug=='Y')
      {
        
          $upload_dir = wp_upload_dir();
          $upload_dir = $upload_dir['basedir'];
      
          // If the entry is array, json_encode.
          if ( is_array( $entry ) || is_object( $entry )) { 
            $entry = json_encode( $entry ); 
          } 
      
          // Write the log file.
          $file  = $upload_dir . '/' . $file . '.log';

          
          $file  = fopen( $file, $mode );
          $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" ); 
          fclose( $file ); 
      
          return $bytes;
      }
      else
      {
        return '';
      }
    }
}

if ( ! function_exists( 'plugin_log3' ) ) 
{
    function plugin_log3( $entry, $mode = 'a', $file = 'debug3' ) 
    { 
      // Get WordPress uploads directory.

      $debug ='Y';
        
      if ($debug=='Y')
      {
        
          $upload_dir = wp_upload_dir();
          $upload_dir = $upload_dir['basedir'];
      
          // If the entry is array, json_encode.
          if ( is_array( $entry ) || is_object( $entry )) { 
            $entry = json_encode( $entry ); 
          } 
      
          // Write the log file.
          $file  = $upload_dir . '/' . $file . '.log';

          
          $file  = fopen( $file, $mode );
          $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" ); 
          fclose( $file ); 
      
          return $bytes;
      }
      else
      {
        return '';
      }
    }
}


if ( ! function_exists( 'plugin_log4' ) ) 
{
    function plugin_log4( $entry, $mode = 'a', $file = 'debug2' ) 
    { 
      // Get WordPress uploads directory.

      $debug ='Y';
        
      if ($debug=='Y')
      {
        
          $upload_dir = wp_upload_dir();
          $upload_dir = $upload_dir['basedir'];
      
          // If the entry is array, json_encode.
          if ( is_array( $entry ) || is_object( $entry )) { 
            $entry = json_encode( $entry ); 
          } 
      
          // Write the log file.
          $file  = $upload_dir . '/' . $file . '.log';

          
          $file  = fopen( $file, $mode );
          $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" ); 
          fclose( $file ); 
      
          return $bytes;
      }
      else
      {
        return '';
      }
    }
}

if ( ! function_exists( 'plugin_log5' ) ) 
{
    function plugin_log5( $entry, $mode = 'a', $file = 'debug2' ) 
    { 
      // Get WordPress uploads directory.

      $debug ='N';
        
      if ($debug=='Y')
      {
        
          $upload_dir = wp_upload_dir();
          $upload_dir = $upload_dir['basedir'];
      
          // If the entry is array, json_encode.
          if ( is_array( $entry ) || is_object( $entry )) { 
            $entry = json_encode( $entry ); 
          } 
      
          // Write the log file.
          $file  = $upload_dir . '/' . $file . '.log';

          
          $file  = fopen( $file, $mode );
          $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" ); 
          fclose( $file ); 
      
          return $bytes;
      }
      else
      {
        return '';
      }
    }
}

/*

V8_36 

*/

if ( ! function_exists( 'plugin_log6B' ) ) 
{
    function plugin_log6B($entry, $mode = 'a', $file = 'debug2') 
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
                  $entry = json_encode($entry);
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

}



// plugin_log('autoload_services.New1- S001');