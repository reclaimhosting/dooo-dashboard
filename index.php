<?php 
/*
Plugin Name: DoOO Dashboard
Plugin URI:  https://github.com/reclaimhosting/dooo-dashboard
Description: View DoOO reports from the WP Dashboard
Version:     1.0
Author:      Reclaim Hosting
Author URI:  https://reclaimhosting.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//add_action('wp_enqueue_scripts', 'dooo_data_load_scripts');

function dooo_data_load_scripts() { 
   if(get_current_screen()->base === 'dashboard'){

       $deps = array('jquery');
       $version= '1.0'; 
       $in_footer = true;         
       wp_enqueue_style( 'dooo_data-main-css', plugin_dir_url( __FILE__) . 'css/dooo-data-main.css');

        wp_enqueue_script('dataTables', plugins_url('js/jquery.dataTables.min.js', __FILE__), ['jquery'], false, true);
        wp_enqueue_script('dataTablesButtons', plugins_url('js/dataTables.buttons.min.js', __FILE__) , ['dataTables'], false, true);
        wp_enqueue_script('dataTablesJs', plugins_url('js/jszip.min.js', __FILE__), ['dataTables'], false, true);
        wp_enqueue_script('dataTablesFonts', plugins_url('js/vfs_fonts.js', __FILE__), ['dataTables'], false, true);
        wp_enqueue_script('dataTablesHTML5', plugins_url('js/buttons.html5.min.js', __FILE__), ['dataTables'], false, true);
        wp_enqueue_script('dataTablesPrint', plugins_url('js/buttons.print.min.js', __FILE__), ['dataTables'], false, true);
          wp_enqueue_script('dooo_data-main-js', plugin_dir_url( __FILE__) . 'js/dooo-data-main.js', ['dataTables'], '1', true); 
    }
}

add_action('admin_enqueue_scripts', 'dooo_data_load_scripts');




/**
 * Remove the default welcome dashboard message
 *
 */
remove_action( 'welcome_panel', 'wp_welcome_panel' );

add_action('admin_notices', 'dooo_data_logins');



//add_action('wp_dashboard_setup', 'dooo_data_dashboard_widgets');
  
// function dooo_data_dashboard_widgets() {
//    $user = wp_get_current_user();
//    $allowed_roles = array( 'administrator', 'super-admin');
//    if ( array_intersect( $allowed_roles, $user->roles ) ){
//       global $wp_meta_boxes;
//       $domain = $_SERVER['SERVER_NAME'];
//       $name = explode(".", $domain)[0];
//       wp_add_dashboard_widget('custom_dooo_widget', '<h2>DoOO Data</h2>', 'dooo_data_foo', '', '', 'column3', 'high');           
//    }
//   }

function dooo_data_logins(){
   $user = wp_get_current_user();
   $allowed_roles = array( 'administrator', 'super-admin');
   if ( array_intersect( $allowed_roles, $user->roles ) && get_current_screen()->base === 'dashboard'){
      require_once( plugin_dir_path( __FILE__ ) . 'data/last-logins.php' );
      //$data = str_getcsv($bar);
      $data = str_getcsv($bar, "\n");
      $html = "<div id='doo-data'><h1>DoOO Data</h1>";
      //var_dump($data);
      foreach ($data as $key=>$line) {
          $row = explode(",", $line);
          $date = $row[0];
          $user = $row[1];
          $email = $row[2];
          $domain = $row[3];
          $usage = cleanDataUsage($row[4]);
          $start = $row[5];
          if($key === 0){
            $html .="<h2>Last Login</h2>
                  <table id='last-login-table' class='dooo-table'>
                  <thead>
                  <tr>
                     <th scope='col'>{$date}</th>
                     <th scope='col'>{$user}</th>
                     <th scope='col'>{$email}</th>
                     <th scope='col'>{$domain}</th>
                     <th scope='col'>{$usage} (MB)</th>
                      <th scope='col'>{$start}</th>
                  </tr>
                  </thead>
                  <tbody>
                  ";
          } else {
            $html .="<tr>
                     <td>{$date}</td>
                     <td>{$user}</td>
                     <td>{$email}</td>
                     <td><a href='http://{$domain}'>{$domain}</a></td>
                     <td>{$usage}</td>
                     <td>{$start}</td>
                  </tr>";
          }
      }
      echo $html . '</tbody></table></div>';
   }
}


function cleanDataUsage($data){
   if(strpos($data, 'M')>0){
      $number = explode('M', $data);
      return $number[0];
   } else {
      return $data;
   }
   
}
//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");
