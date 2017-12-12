<?php 
	defined( 'ABSPATH' ) or die( __('No script kiddies please!', 'wp-datepicker') );
/*
Plugin Name: WP Datepicker
Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/wp-datepicker
Description: WP Datepicker is a great plugin to implement custom styled jQuery UI datepicker site-wide. You can set background images and manage CSS from your theme.
Version: 1.3.7
Author: Fahad Mahmood
Author URI: http://www.androidbubbles.com
Text Domain: wp-datepicker
Domain Path: /languages/
License: GPL2

This WordPress Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This free software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this software. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/ 


        
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        

	global $wpdp_premium_link, $wpdp_dir, $wpdp_pro, $wpdp_data, $wpdp_options, $wpdp_styles;
	$wpdp_dir = plugin_dir_path( __FILE__ );	
	$rendered = FALSE;
	$wpdp_pro = file_exists($wpdp_dir.'pro/wp-datepicker-pro.php');
	$wpdp_data = get_plugin_data(__FILE__);
	$wpdp_premium_link = 'http://shop.androidbubbles.com/product/wp-datepicker-pro';
	
	$wpdp_options = array(
		'dateFormat'=>'text',
	);
		
	$wpdp_data = get_plugin_data(__FILE__);
	
	$wpdp_styles = array('ll-skin-melon', 'll-skin-latoja', 'll-skin-santiago', 'll-skin-lugo', 'll-skin-cangas', 'll-skin-vigo', 'll-skin-nigran', 'll-skin-siena', 'custom-colors');
	
	
	if($wpdp_pro){
		include($wpdp_dir.'pro/wp-datepicker-pro.php');
	}
	
	include('inc/functions.php');
        
	
		
	function wpdp_backup_pro($src='pro', $dst='') { 

		$plugin_dir = plugin_dir_path( __FILE__ );
		$uploads = wp_upload_dir();
		$dst = ($dst!=''?$dst:$uploads['basedir']);
		$src = ($src=='pro'?$plugin_dir.$src:$src);
		
		$pro_check = basename($plugin_dir);

		$pro_check = $dst.'/'.$pro_check.'.dat';

		if(file_exists($pro_check)){
			if(!is_dir($plugin_dir.'pro')){
				mkdir($plugin_dir.'pro');
			}
			$files = file_get_contents($pro_check);
			$files = explode('\n', $files);
			if(!empty($files)){
				foreach($files as $file){
					
					if($file!=''){
						
						$file_src = $uploads['basedir'].'/'.$file;
						//echo $file_src.' > '.$plugin_dir.'pro/'.$file.'<br />';
						//copy($file_src, $plugin_dir.'pro/'.$file);

						$trg = $plugin_dir.'pro/'.$file;
						if(!file_exists($trg) && file_exists($file_src))
						@copy($file_src, $trg);
						
					}
				}//exit;
			}
		}
		
		if(is_dir($src)){
			if(!file_exists($pro_check)){
				$f = fopen($pro_check, 'w');
				fwrite($f, '');
				fclose($f);
			}	
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						wpdp_backup_pro($src . '/' . $file, $dst . '/' . $file); 
					} 
					else { 
						$dst_file = $dst . '/' . $file;
						
						if(!file_exists($dst_file)){
							
							copy($src . '/' . $file,$dst_file); 
							$f = fopen($pro_check, 'a+');
							fwrite($f, $file.'\n');
							fclose($f);
						}
					} 
				} 
			} 
			closedir($dir); 
			
		}	
	}		

	add_action( 'admin_enqueue_scripts', 'register_wpdp_scripts' );
	add_action( 'wp_enqueue_scripts', 'register_wpdp_scripts' );
	

	
	if(is_admin()){
				
		if($wpdp_pro)
		wpdp_backup_pro();
		
		add_action( 'admin_menu', 'wpdp_menu' );		
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'wpdp_plugin_links' );	
		
		add_action('admin_footer', 'wpdp_footer_scripts');
		
	}else{
		
	
		add_action('wp_footer', 'wpdp_footer_scripts');
		
	}