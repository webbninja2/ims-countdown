<?php

add_action('admin_menu', 'imsc_menu');
	function imsc_menu(){
	    add_submenu_page('edit.php?post_type=ims_countdown', __('Settings','imsc_countdown_settings'), __('Settings','imsc_countdown_settings'), 'manage_options', 'imsc_countdown_settings', 'imsc_countdown_settings');

	    	add_action( 'admin_init', 'imsc_register_mysettings' );
	}

	function imsc_register_mysettings() {
		//register our settings
		register_setting( 'imsc_settings', 'imsc_timezone' );
	}

	function imsc_countdown_settings() {?>
		<div class="wrap">
		<h2>IMS Countdown Settings</h2>

		<form method="post" action="options.php">
		    <?php settings_fields( 'imsc_settings' ); ?>
		    <?php do_settings_sections( 'imsc_settings' ); ?>
		    <table class="form-table">
		        <tr valign="top">
		        <th scope="row">Select Time Zone</th>
		        <td><td>
		        		<select name="imsc_timezone">
		        			<?php
		        			global $imsc_config_timezone;
		        				foreach ($imsc_config_timezone as $key => $value) {
		        					$sVal = get_option('imsc_timezone');
		        					if ($sVal == $value) {
		        						$selected = 'selected';
		        					}else{
		        						$selected = "";
		        					}
		        					echo "<option {$selected} value='{$value}'>{$key}</option>";
		        				}
		        			?>
		        		</select>
		        	</td>
		        </tr>
		    </table>
		    
		    <?php submit_button(); ?>

		</form>
		</div>
		<?php }

	if( !function_exists("update_ims_countdown_info") ) {
		function update_ims_countdown_info() {
		  register_setting( 'ims_countdown-info-settings', 'ims_countdown_info' );
		}
	}