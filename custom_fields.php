<?php
	add_action( 'add_meta_boxes', 'imsc_countdown_type' );
	function imsc_countdown_type() {
        add_meta_box(
                'wdm_sectionid', 'Countdown Options', 'imsc_meta_box_callback', 'ims_countdown'
        );
	}
	function imsc_sanitize_hex_color( $color ) {
	    if ( '' === $color ) {
	        return '';
	    }
	 
	    // 3 or 6 hex digits, or the empty string.
	    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
	        return $color;
	    }
	}

	function imsc_meta_box_callback( $post ) {
	    wp_nonce_field( 'wdm_meta_box', 'wdm_meta_box_nonce' );

	    /*CountDown Value */
	    $countdown_type   = get_post_meta( $post->ID, 'countdown_type', true );
	    $countdown_value  = get_post_meta( $post->ID, 'countdown_value', true );

	    $ds  = get_post_meta( $post->ID, 'ds', true );
		$hr  = get_post_meta( $post->ID, 'hr', true );
		$mn  = get_post_meta( $post->ID, 'mn', true );
		$sc  = get_post_meta( $post->ID, 'sc', true );


	    /* Countdown Expiry Action */
	    $expire_action  = get_post_meta( $post->ID, 'expire_action', true );
	    $redirect_url = get_post_meta( $post->ID, 'redirect_url', true );

	    /* Sytle */
	    $theme           = get_post_meta($post->ID , 'theme', true);
		$font_face       = get_post_meta($post->ID , 'font_face', true);     
		$title_color      = get_post_meta($post->ID , 'title_color', true);
		$timer_color      = get_post_meta($post->ID , 'timer_color', true);
		$timer_background = get_post_meta($post->ID , 'timer_background', true);
		$timer_border     = get_post_meta($post->ID , 'timer_border', true);
		$hide_title	    	 = get_post_meta($post->ID , 'hide_title', true);

		/*Language*/
		$days     = get_post_meta($post->ID , 'days', true);
		$hours    = get_post_meta($post->ID , 'hours', true);
		$minutes  = get_post_meta($post->ID , 'minutes', true);
		$seconds  = get_post_meta($post->ID , 'seconds', true);

		if ($countdown_type == "" && $countdown_value == "") {
			$checked = "checked='checked'"; 
		}

	    ?>
		<div class="options-group">

			<div class="option">
		    	<div class="option-heading">
	      			<h4 class="option-title">
		       		   	Countdown Type
	      			</h4>
		    	</div>
		    	<div class="option-body">
			    	<div class="dropdown">
		        		<label class="label" for="2" >Fixed Time </label> <input <?= $checked ?> class="labelvalue" type="radio" name="countdown_type" id="2" value="2" <?php checked( $countdown_type, '2' ); ?> >
	        			<div class="clear"></div>

	    				<div class="display-none time-options">
	        				<label class="label" >Select Date </label> <input class="labelvalue " id="event_date" name="countdown_value" value="<?= $countdown_value ?>	" />
		        			<div class="clear"></div>
		        		</div>
	        		</div>
		    		<div class="dropdown">
		        		<label class="label" for="0" >Evergreen </label> <input class="labelvalue" type="radio" name="countdown_type" id="0" value="0" <?php checked( $countdown_type, '0' ); ?> >
		        		<div class="clear"></div>
		    			<div class="display-none time-options">
		    				<label class="label" for="0" > Days </label> <input class="labelvalue" type="number" min="0" value="<?= $ds ?>" placeholder="0" name="ds" >
		    				<div class="clear"></div>
		    				<label class="label" for="0" > Hours </label> <input class="labelvalue" type="number" min="0" value="<?= $hr ?>" placeholder="0" name="hr" >
		    				<div class="clear"></div>
		    				<label class="label" for="0" > Minuts </label> <input class="labelvalue" type="number"	 min="0" value="<?= $mn ?>" placeholder="0" name="mn" >
		    				<div class="clear"></div>
		    				<label class="label" for="0" > Seconds </label> <input class="labelvalue" type="number"	 min="0" value="<?= $sc ?>" placeholder="0" name="sc" >
		    				<div class="clear"></div>
		    			</div>
	    			</div>
	        		<div class="clear"></div>
		    	</div>
		    </div>

		    <div class="option">
		    	<div class="option-heading">
	      			<h4 class="option-title">
		       		   	Countdown Expire Action
	      			</h4>
		    	</div>
		    	<div class="option-body">
	        		<label class="label" for="action-0" >Do Nothing </label> <input <?= $checked ?> class="labelvalue" type="radio" name="expire_action" id="action-0" value="0" <?php checked( $expire_action, '0' ); ?> >
	        		<div class="clear"></div>


	        		<label class="label" for="action-2" >Show Content   </label> <input class="labelvalue" type="radio" name="expire_action" id="action-1" value="1" <?php checked( $expire_action, '1' ); ?> >
	        		<div class="clear"></div>

	        		<label class="label" for="action-2" >Hide Countdown</label> <input class="labelvalue" type="radio" name="expire_action" id="action-2" value="2" <?php checked( $expire_action, '2' ); ?> >
	        		<div class="clear"></div>

	        		<label class="label" for="action-3" >Redirect To URL</label> <input class="labelvalue" type="radio" name="expire_action" id="action-3" value="3" <?php checked( $expire_action, '3' ); ?> > <br><input type='text' class="labelvalue" placeholder="Redirection URL" value="<?= $redirect_url; ?>" name='redirect_url' />
	        		<div class="clear"></div>
		    	</div>
		    </div>

	  		<div class="option">
			    <div class="option-heading">
		      		<h4 class="option-title">
			          	Countdown Style
		      		</h4>
			    </div>
			    <div class="option-body">
			    	<label class="label hide_title" for="hide_title" >Hide Title </label><input class="labelvalue" type="checkbox" name="hide_title" id="hide_title" value="1" <?php checked( $hide_title, '1' ); ?> >
		        	<div class="clear"></div>

	      			<label class="label" >Title Color</label><input type='text' value="<?= $title_color; ?>" name='title_color' class="labelvalue" id='title_color' />
		        	<div class="clear"></div>

	      			<label class="label" >Timer Color</label><input type='text' value="<?= $timer_color; ?>" name='timer_color' class="labelvalue" id='timer_color' />
		        	<div class="clear"></div>

	      			<label class="label" >Timer Background</label><input type='text' value="<?= $timer_background; ?>" name='timer_background' class="labelvalue" id='timer_background' />
		        	<div class="clear"></div>

	      			<label class="label" >Timer Border</label> <input type='text' value="<?= $timer_border; ?>" name='timer_border' class="labelvalue" id='timer_border' />
		        	<div class="clear"></div>
					<label class="label" >Timer Font</label> 
		        	<select name="font_face" id="font_face" class="labelvalue">
		        		<?php 
			        		global $imsc_config_fonts; 

							foreach ($imsc_config_fonts as $key => $value) {
								if ($font_face == $key) {
									$select_font =  " selected";
								}else{
									$select_font =  "";
								}
								echo "<option{$select_font} value='{$key}'>{$value}</option>";
							}

						?>
						</select>
		        	

		        	<div class="clear"></div>
			    	<label class="label" >Timer Themes</label>
	    			 <select name="theme" class="labelvalue">
						<option <?php if ($theme == "custom") { echo "selected='selected'"; }?> value="custom" >Custom Theme</option>
						<option <?php if ($theme == "black") { echo "selected='selected'"; }?> value="black" >Black</option>
						<option <?php if ($theme == "white") { echo "selected='selected'"; }?> value="white" >White</option>
						<option <?php if ($theme == "gold") { echo "selected='selected'"; }?> value="gold" >Gold</option>
						<option <?php if ($theme == "red") { echo "selected='selected'"; }?> value="red" >Red</option>
					</select>
		        	<div class="clear"></div>
	        	</div>
		    </div>

			<div class="option">
			    <div class="option-heading">
		      		<h4 class="option-title">
			          	Countdown Language
		      		</h4>
			    </div>
			    <div class="option-body">
	      			<label class="label" >Days</label><input type='text' class="labelvalue" value="<?= $days; ?>" name='days' id='days' />
		        	<div class="clear"></div>

	      			<label class="label" >Hours</label><input type='text' class="labelvalue" value="<?= $hours; ?>" name='hours' id='hours' />
		        	<div class="clear"></div>

	      			<label class="label" >Minutes</label><input type='text' class="labelvalue" value="<?= $minutes; ?>" name='minutes' id='minutes' />
		        	<div class="clear"></div>

	      			<label class="label" >Seconds </label><input type='text' class="labelvalue" value="<?= $seconds; ?>" name='seconds' id='seconds' />
		        	<div class="clear"></div>
			    </div>
		  	</div>
		  	<div class="option">
			    <div class="option-heading">
		      		<h4 class="option-title">
			          	Shortcode
		      		</h4>
			    </div>
			    <div class="option-body">
		        	<label class="label" >[displayCountdowns id="<?=$post->ID?>"]</label>
		        	<!--<button>Clear Cookie</button>-->
		        	<div class="clear"></div>
	        	</div>
		</div>
	    <?php

	}

	function imsc_save_meta_box_data( $post_id ) {
		$getTimezone = get_option('imsc_timezone'); 
    	$timezone = new DateTimeZone($getTimezone);
		$date = new DateTime();
		$date->setTimezone($timezone );

        if ( !isset( $_POST['wdm_meta_box_nonce'] ) ) {
            return;
        }
        if ( !wp_verify_nonce( $_POST['wdm_meta_box_nonce'], 'wdm_meta_box' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
        }
        if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
        }

        /* CountDown Timer*/
        $new_meta_type =  isset( $_POST['countdown_type'] ) ? trim( $_POST['countdown_type'] ) : '';
        $new_meta_value = isset( $_POST['countdown_value'] ) ? trim( $_POST['countdown_value'] ) : '';
        $ds = isset( $_POST['ds'] ) ? trim( $_POST['ds'] ) : '';
		$hr = isset( $_POST['hr'] ) ? trim( $_POST['hr'] ) : ''; 
		$mn = isset( $_POST['mn'] ) ? trim( $_POST['mn'] ) : '';  
		$sc = isset( $_POST['sc'] ) ? trim( $_POST['sc'] ) : '';   

        $expire_action = isset( $_POST['expire_action'] ) ? trim( $_POST['expire_action'] ) : '';  
        $redirect_url = isset( $_POST['redirect_url'] ) ? trim( $_POST['redirect_url'] ) : '';  
    	
        /* CountDown Style*/
        $theme            = isset( $_POST['theme'] ) ? trim( $_POST['theme'] ) : '';
        $font_face        = isset( $_POST['font_face'] ) ? trim( $_POST['font_face'] ) : '';
		$title_color       = imsc_sanitize_hex_color( $_POST['title_color'] );
		$timer_color       = imsc_sanitize_hex_color( $_POST['timer_color'] );
		$timer_background  = imsc_sanitize_hex_color( $_POST['timer_background'] );
		$timer_border      = imsc_sanitize_hex_color( $_POST['timer_border'] );
		$hide_title        = sanitize_title( $_POST['hide_title'] );

		/*CountDown Language*/
		/*$days = intval( $_POST['days'] );
		if ( ! $days ) {
		  $days = '';
		}
		if ( strlen( $days ) > 5 ) {
		  $days = substr( $days, 0, 5 );
		}
		$hours = intval( $_POST['hours'] );
		if ( ! $hours ) {
		  $hours = '';
		}
		if ( strlen( $hours ) > 5 ) {
		  $hours = substr( $hours, 0, 5 );
		}
		$minutes = intval( $_POST['minutes'] );
		if ( ! $minutes ) {
		  $minutes = '';
		}
		if ( strlen( $minutes ) > 5 ) {
		  $minutes = substr( $minutes, 0, 5 );
		}
		$seconds = intval( $_POST['seconds'] );
		if ( ! $seconds ) {
		  $seconds = '';
		}
		if ( strlen( $seconds ) > 5 ) {
		  $seconds = substr( $seconds, 0, 5 );
		}*/
		$days      = sanitize_title( $_POST['days'] );
		$hours     = sanitize_title( $_POST['hours'] );
		$minutes    = sanitize_title( $_POST['minutes'] );
		$seconds   = sanitize_title( $_POST['seconds'] );

        update_post_meta( $post_id, 'countdown_type', $new_meta_type );
        update_post_meta( $post_id, 'countdown_value', $new_meta_value);

        update_post_meta( $post_id, 'ds', $ds);
		update_post_meta( $post_id, 'hr', $hr);
		update_post_meta( $post_id, 'mn', $mn);
		update_post_meta( $post_id, 'sc', $sc);

        update_post_meta( $post_id, 'expire_action', $expire_action);
        update_post_meta( $post_id, 'redirect_url', $redirect_url);
        
        
		update_post_meta( $post_id, 'theme', $theme);
        update_post_meta( $post_id, 'font_face', $font_face);
        update_post_meta( $post_id, 'title_color', $title_color);
        update_post_meta( $post_id, 'timer_color', $timer_color);
        update_post_meta( $post_id, 'timer_background', $timer_background);
        update_post_meta( $post_id, 'timer_border', $timer_border);
        update_post_meta( $post_id, 'hide_title', $hide_title);

        update_post_meta( $post_id, 'days', $days);
        update_post_meta( $post_id, 'hours', $hours);
        update_post_meta( $post_id, 'minutes', $minutes);
        update_post_meta( $post_id, 'seconds', $seconds);

	}
	add_action( 'save_post', 'imsc_save_meta_box_data',1,2 );