<?php
/**
 * Plugin Name: NextGEN Image Cropping
 * Plugin URI: http://www.omegafi.com
 * Description: Extension of NextGen Gallery to allow image cropping
 * Version: 1.2
 *
 * Author: Mitch McCoy
 * Author URI: http://www.omegafi.com
 */ 
/*
Copyright 2011  Mitch McCoy (email : mmccoy@omegafi.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

http://www.gnu.org/licenses/gpl.txt
*/

class NGGImageCropper {

	function __construct() {
			
		$this->plugin_path = trailingslashit( WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) );

		add_action( 'admin_init', array(&$this, 'register_init') );
		add_action( 'admin_menu', array (&$this, 'add_menu') );
		add_action('admin_print_scripts', array(&$this,'add_gallery_script'));
		add_action('admin_print_styles', array(&$this,'add_gallery_style'));
	
		$this->options		=	get_option ('ngg_crop');
		
        // if no options aviabale, we setup the default values
        if( !is_array($this->options) )
            $this->default_options();
	}
	
	function add_gallery_script() {
		// Calculate aspect ratio
		if(empty($this->options['crop_height'])) {
			$aspect = 1;
		}
		else {
			$aspect = ($this->options['crop_width'] / $this->options['crop_height']);
		}
	
		$params = array(
					'plugin_path'	=>	$this->plugin_path,
					'crop_width'	=>	$this->options['crop_width'],
					'crop_height'	=>	$this->options['crop_height'],
					'imagesize'	=>	$this->options['imagesize'],
					'aspect'		=>	$aspect);
		wp_enqueue_script('ngg_crop', $this->plugin_path . 'js/gallery.js', 'jquery', false, false);	
		wp_enqueue_script('Jcrop', $this->plugin_path . 'jcrop/js/jquery.Jcrop.js', 'jquery', false, false);	
		wp_enqueue_script('Jcrop-Color', $this->plugin_path . 'jcrop/js/jquery.color.js', 'jquery', false, false);	
		wp_localize_script('ngg_crop', 'ngg_crop', $params);
	}
	
	function add_gallery_style() {
		wp_enqueue_style('omegafi_nextgen', $this->plugin_path . 'jcrop/css/jquery.Jcrop.css');	
	}

	function add_menu()  {
		add_submenu_page( NGGFOLDER , 'Image Cropping', 'Image Cropping', 'manage_options', 'ngg_crop', array (&$this, 'show_page'));
	}
	
    function register_init(){
		register_setting('ngg_crop', 'ngg_crop');
    }
	
    function default_options() {
		
		// Add logic for default crop width/height here

		$this->options = array();
		$this->options['imagesize']	=	500;
        $this->options['crop_width']	=	150;
   	    $this->options['crop_height']	=	150;
        
        update_option('ngg_crop', $this->options);
    }
	
	function show_page() {
		
		echo '<div class="wrap ngg-wrap">';
			echo '<h2>NextGEN Gallery Image Cropping</h2>';
			if (function_exists('wp_nonce_field')): wp_nonce_field('update-options'); endif;
			echo '<form method="post" action="options.php">';
			settings_fields('ngg_crop');
			echo '<table>';
				echo '<tr>';
					echo '<th colspan="2" align="left">';
						echo 'These settings will be applied to the cropping page.';
						echo '<br><br>';
					echo '</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="2">';
						echo 'Scale original image size to <input type="text" name="ngg_crop[imagesize]" value="' . $this->options['imagesize'] . '" size="4">px.&nbsp;&nbsp;This is helpful when cropping large images that don\'t fit on the screen.';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Pre-selected Width';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" name="ngg_crop[crop_width]" value="' . $this->options['crop_width'] . '" size="4">px';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo 'Pre-selected Height';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" name="ngg_crop[crop_height]" value="' . $this->options['crop_height'] . '" size="4">px';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="2" align="right">';
						echo '<div class="submit">';
							echo '<input type="submit" name="submitbutton" value="Submit" class="button-primary>';
						echo '</div>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';
		echo '</div>';
	}
}

$nggcropobj = new NGGImageCropper();
?>