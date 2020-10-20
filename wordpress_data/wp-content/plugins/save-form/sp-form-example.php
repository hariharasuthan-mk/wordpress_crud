<?php
/*
Plugin Name: Save Form Plugin
Plugin URI: https://github.com/hariharasuthan-mk/wordpress_crud
Description: Simple WordPress CRUD Form
Version: 1.0
Author: Hariharasuthan
*/

global $savesample_db_version;
$savesample_db_version = '1.0';


add_action('admin_menu', 'my_menu_pages');
function my_menu_pages(){
    add_menu_page('Save form Plugins Configuration Page title', 'Save Form Plugin', 'manage_options', 'contact-form', 'my_savefrm_config' );
    add_submenu_page('contact-form', 'Save form Plugin - Table Configuration', 'Plugin | Table Config', 'manage_options', 'contact-form','' );

    add_submenu_page('contact-form', 'Save form Plugin - List Contacts', 'Plugin | List Contacts', 'manage_options', 'list-contacts','my_list_data' );
}

function my_list_data() {
  global $wpdb;
  $tbl = get_option('myfrm_tbl');
  $results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$wpdb->prefix}{$tbl}",OBJECT);
  //var_dump($results);echo $wpdb->last_query;
  if(count((array)$results)>0){
    for ($i = 0; $i < count((array)$results); $i++){
      $data_row.= '<tr>
                    <td>'.$results[$i]->first_name.'</td>
                    <td>'.$results[$i]->last_name.'</td>
                    <td>'.$results[$i]->email.'</td>
                    <td>'.$results[$i]->phone.'</td>
                    <td>'.$results[$i]->country.'</td>
                    <td>'.$results[$i]->dob.'</td>
                  </tr>';
    }

  }
  else{
    $data_row = '<tr>
                  <td colspan="6">No data found</td>
                 </tr>';
  }
  //echo 'hello'.$wpdb->prefix.get_option('myfrm_tbl');

  echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

  echo '<div class="card">
        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Contact Lists Table </strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">';

  echo '<div class="form-row">
    <div class="form-group col-md-12"><table style="">
    <tbody>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Country</th>
        <th>DOB</th>
      </tr>
      '.$data_row.'
    </tbody>
  </table></div></div></div></div>';

echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';


}


function my_savefrm_config() {

  if(isset($_POST['cf-submitted']))
  {

    $table_name = $_POST['cf-tblname'];

    if(null !== get_option('myfrm_tbl')){

      savesample_uninstall();
      update_option('myfrm_tbl', $table_name);
      $msg = "Table value ".$table_name." configuration updated";

    }
    else{
      add_option('myfrm_tbl',$table_name);
      $msg = "Table value ".$table_name." configuration created";
    }

    savesample_install(); //  register_activation_hook( __FILE__, 'savesample_install' );
    echo $msg;
  }


  echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

  echo '<div class="card">
        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Contact Form Table Configuration</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">';

  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
   <div class="form-row">
    <div class="form-group col-md-4">
      <label class="form-check-label" for="gridCheck">
        Specify Table Name
      </label>
    </div>
    <div class="form-group col-md-8">
      <input type="text" class="form-control" required="required" placeholder=" " name="cf-tblname" pattern="[a-zA-Z0-9_ ]+" value="' . ( esc_attr( get_option('myfrm_tbl') )  ) . '" size="40" />
    </div>
  </div>


  <div class="form-row">
    <div class="form-group col-md-12">
      <input type="submit" name="cf-submitted" value="Configure Table Name">
    </div>
  </div>

</form></div></div>';

echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';

}

function addAdminPageContent1() {
  add_menu_page('List Contacts Details', 'Save Form', 'manage_options', __FILE__, 'ListSaveformTablePage', 'dashicons-wordpress');

}

function addAdminPageContent2() {
  add_menu_page('Configure Saveform ', 'Add Table name for saveform', 'manage_options', __FILE__, 'crudAdminPage', 'dashicons-admin-generic');
}


function ListSaveformTablePage() {

  echo "Table comes here";
}

function crudAdminPage() {

  echo "Form comes here";
}


function savesample_install() {
	global $wpdb;
	global $savesample_db_version;

	$table_name = $wpdb->prefix . get_option('myfrm_tbl');//'contact';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		first_name tinytext NOT NULL,
		last_name tinytext NOT NULL,
		email varchar(55) DEFAULT '' NOT NULL,
		phone varchar(12) NOT NULL,
		country tinytext NOT NULL,
		dob datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		createdtime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";



	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'savesample_db_version', $savesample_db_version );
}


function savesample_uninstall()
{
    global $wpdb;

    $table_name = $wpdb->prefix . get_option('myfrm_tbl');//'contact';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option('savesample_db_version');
    delete_option('myfrm_tbl');

}
register_deactivation_hook(__FILE__, 'savesample_uninstall');



function html_form_code() {
  if(isset($_POST['cf-submitted']))
  {
    global $wpdb;//echo 'Insert comes here';
    $tbl = get_option('myfrm_tbl');
    $results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$wpdb->prefix}{$tbl}",OBJECT);

    $fname = $_REQUEST["cf-fname"];
    $lname = $_REQUEST["cf-lname"];
    $email = $_REQUEST["cf-email"];
    $phone = $_REQUEST["cf-phone"];
    $country = $_REQUEST["cf-country"];
    $dob     = $_REQUEST["cf-dob"];


    //$results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$wpdb->prefix}{$tbl}",OBJECT);
    //var_dump($results);echo $wpdb->last_query;

    if(null !== get_option('myfrm_tbl')){

      $msg = "Table value configuration updated";

      $wpdb->query(
               $GLOBALS['wpdb']->prepare(
               "
               INSERT INTO {$wpdb->prefix}{$tbl}
               ( first_name , last_name , email , phone , country, dob)
               VALUES ( %s, %s, %s, %s, %s, %s )
               ",
               array(
                     $fname,
                     $lname,
                     $email,
                     $phone,
                     $country,
                     $dob,
                  )
               )
            );
        //echo $wpdb->last_query;

    }

    echo $msg;

  }


  echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <input type="text" class="form-control" required="required" placeholder="FirstName" name="cf-fname" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-fname"] ) ? esc_attr( $_POST["cf-fname"] ) : '' ) . '" size="40" />
    </div>
    <div class="form-group col-md-6">
      <input type="text" placeholder="LastName" required="required" class="form-control" name="cf-lname" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-lname"] ) ? esc_attr( $_POST["cf-lname"] ) : '' ) . '" size="40" />
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <input type="email" class="form-control" required="required" placeholder="Email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" />
    </div>
    <div class="form-group col-md-6">
      <input type="text"  class="form-control" placeholder="Phone Number" name="cf-phone" pattern="[a-zA-Z_+0-9 ]+" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
    <select class="selectpicker form-control" data-live-search="true" data-default="United States" data-flag="true" name="cf-country">
            <option value="">Choose Country</option>
            <option value="India">India</option>
            <option value="USA">USA</option>
            <option value="Australia">Australia</option>
            <option value="South Africa">South Africa</option>
    </select>
    </div>
    <div class="form-group col-md-6">
      <input class="form-control" type="date" value="2000-08-19" name="cf-dob" id="cf-dob" placeholder="Date of birth">
    </div>
  </div>



  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        I have read <a href="./agree">Agree Terms & Coditions</a> and <a href="./privacy">privacy</a> and policy
      </label>
    </div>
  </div>
  <input type="submit" name="cf-submitted" value="SUBMIT">
</form>';

  echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';


}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$subject = sanitize_text_field( $_POST["cf-subject"] );
		$message = esc_textarea( $_POST["cf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

function cf_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}

add_shortcode( 'crud_save_form', 'cf_shortcode' );

?>
