<?php
/*
Plugin Name: iweather
Description: simple plugin shows weather forecast on the top of the admin panel
Plugin URI: http://ian-lab.com
Author: Yuan Liu
Author URI: http://ian-lab.com 
Version: 1.0
License: GPL2
*/
/*

    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
    function yl_iw_get_the_json_object(){
    	$url = 'http://api.openweathermap.org/data/2.5/weather?q=Brisbane,AU';
    	$args = array(
    		'hearder'=> array('Content-type' => 'application/json')
    		);
    	$response = wp_remote_get( $url, $args );
    	if (is_wp_error($response )) {
    		echo 'Something is going nasty:'.$response->get_error_message();
    		return false;		
    	}
    	else
    	{	
    		$body = wp_remote_retrieve_body( $response );
    		return $body;
    	}
    }

    function yl_iw_decode_json_object($json_object){
    	return json_decode( $json_object, true);
    }

    function yl_iw_convertToCen($fTemp){
    	return $cTemp = round($fTemp-273.15);
    }

    function yl_iw_weather_show(){
    	if (!yl_iw_get_the_json_object()) {
    		echo "Cannot retrieve weather information";
    	}
    	else
    	{
    		$weather = yl_iw_decode_json_object(yl_iw_get_the_json_object());
		//var_dump(get_the_json_object());
		//var_dump($weather);
    		if($weather['cod']== 200){
    			echo '<div class="weather_bar">';
    			echo "<span>".$weather['name'].": ".$weather['weather'][0]['description']."</span>";
    			echo "<span>Current Temperature: ".yl_iw_convertToCen($weather['main']['temp'])."&#176"."C</span>";
    			echo "Humidity: ".$weather['main']['humidity']."% ";
    			echo "<span>High: ".yl_iw_convertToCen($weather['main']['temp_min'])."&#176"."C</span>";
    			echo "<span>Low: ".yl_iw_convertToCen($weather['main']['temp_max'])."&#176"."C</span>";
    			echo '</div>';
    		}else{
    			echo $weather['message'];
    		}
    	}
    }

    add_action( 'admin_notices', 'yl_iw_weather_show' );

    function yl_iw_weather_bar_css() {
    	echo "
    	<style type='text/css'>
    		.weather_bar {
    			display: inline-block;
    			line-height: 19px;
    			padding: 11px 15px;
    			font-size: 14px;
    			text-align: left;
    			margin: 25px 20px 0 2px;
    			background-color: #fff;
    			border-left: 4px solid #ffba00;
    			-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    			box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

    		}
    		.weather_bar span{
    			padding:0 2em
    		}
    	</style>
    	";
    }
    add_action( 'admin_head', 'yl_iw_weather_bar_css' );



