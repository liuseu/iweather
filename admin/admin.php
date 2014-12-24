<?php
add_action('admin_menu','yl_iw_create_menu' );

function yl_iw_create_menu(){
	//create custom top-level menu
	add_menu_page('iWeather Plugin settings page','iWeather Settings','manage_options','yl_iw_menu_settings','yl_iw_menu_setting_page',plugins_url( '/images/wp-icon.png',__FILE__ )); 	
	add_submenu_page('yl_iw_menu_settings','About this plugin','About','manage_options','about-iweather','yl_iw_menu_about_page' );
	add_options_page( 'iWeather Options','iWeather Options','manage_options','iWeather-options','yl_iw_options_page' );
}

function yl_iw_menu_setting_page(){
	echo 'I am the menu setting page';
}

function yl_iw_menu_about_page(){
	echo 'I am iWeather, a wordpress plugin';
}

function yl_iw_options_page(){
	//add option API here
	echo 'I have a lot of options';?>
	<div class=”wrap” >
		<h2> My plugin </h2>
		<form action=”options.php” method=”post”>
		<?php settings_fields('yl_iw_options');?>
		<?php do_settings_sections('iWeather-options');?>
		<input name="Submit" type="submit" value="Save Changes"/>
		</form>
	</div>
	<?php
}
add_action( 'admin_init', 'yl_iw_admin_init');
function yl_iw_admin_init(){
	yl_iw_register_setting();
	yl_iw_add_settings_section();
	yl_iw_add_settings_field();
}
function yl_iw_register_setting(){	
	register_setting( 'yl_iw_options', 
		'yl_iw_options', 
		'yl_iw_validate_options' 
		);
}

function yl_iw_add_settings_section(){
	add_settings_section( 'yl_iw_main', 'iWeather Plugin Settings', 'yl_iw_section_text', 'iWeather-options' );
}

function yl_iw_add_settings_field(){
	add_settings_field( 'yl_iw_text_string', 'Enter something here', 'yl_iw_setting_input', 'iWeather-options', 'yl_iw_main');
}

function yl_iw_section_text(){
	echo '<p>Enter your settings here.</p>';
}

function yl_iw_setting_input(){
	$options = get_option( 'yl_iw_options' );
	$text_string = $options['text_string'];
	echo "<input id='text_string' name='yl_iw_options[text_string]' type='text' value='$text_string' />";

}
function yl_iw_validate_options($input){
	$vaild = array();
	$valid['text_string'] = preg_replace('/[^a-zA-Z]/','',$input['text_string']);
	if ($vaild['text_string'] != $input['text_string']) {
		add_settings_error('yl_iw_text_string', 
						   'yl_iw_texterror',
						   'Incorrect value entered!',
						   'error');
	}
	return $valid;
}








