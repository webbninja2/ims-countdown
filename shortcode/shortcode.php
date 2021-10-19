<?php 
		$getTimezone = get_option('imsc_timezone');
    	$timezone = new DateTimeZone($getTimezone);
		$date = new DateTime();
		$date->setTimezone($timezone );

		$atts = shortcode_atts(array('id' => '0'), $atts);

		$args=array('post_type'=>'ims_countdown','p'=>$atts['id']);
		$query = new WP_Query( $args );
		while ($query->have_posts()) : $query->the_post();

			/*CountDown Timer*/
			$TimeCookie      = "TimeCookie-".get_the_ID();
			$multiCountDown  = "countdown".get_the_ID();
			$eAction = "action".get_the_ID();

			$countdown_type   = get_post_meta(get_the_ID(), 'countdown_type', true);
			$countdown_value  = get_post_meta(get_the_ID(), 'countdown_value', true);
			
			$ds  = get_post_meta( get_the_ID(), 'ds', true );
			$hr  = get_post_meta( get_the_ID(), 'hr', true );
			$mn  = get_post_meta( get_the_ID(), 'mn', true );
			$sc  = get_post_meta( get_the_ID(), 'sc', true );


			$sec_ds  = $ds*86400;
			$sec_hr  = $hr*3600;
			$sec_mn  = $mn*60;
			$timeGap = $sec_ds+$sec_hr+$sec_mn+$sc;


			$expire_action    = get_post_meta( get_the_ID(), 'expire_action', true );
			$redirect_url     = get_post_meta( get_the_ID(), 'redirect_url', true );

			/*CountDown Style*/ 
			$theme         = get_post_meta(get_the_ID(), 'theme', true);
			$font_face         = get_post_meta(get_the_ID(), 'font_face', true);
			$title_color        = get_post_meta(get_the_ID(), 'title_color', true);
			$timer_color        = get_post_meta(get_the_ID(), 'timer_color', true);
			$timer_background   = get_post_meta(get_the_ID(), 'timer_background', true);
			$timer_border       = get_post_meta(get_the_ID(), 'timer_border', true);
			$hide_title         = get_post_meta(get_the_ID(), 'hide_title', true);  

			if ($theme == "black") {
				$title_color       = "#2a2a2a"; 
				$timer_color       = "#ffffff"; 
				$timer_background  = "#2a2a2a"; 
				$timer_border      = "#494949"; 

			}elseif ($theme == "white") {
				$title_color       = "#2a2a2a"; 
				$timer_color       = "#333333"; 
				$timer_background  = "#FCFCFC"; 
				$timer_border      = "#d3d3d3";
			}
			elseif ($theme == "gold") {
				$title_color       = "#8c6047"; 
				$timer_color       = "#8c6047"; 
				$timer_background  = "#fcdc88"; 
				$timer_border      = "#9e887c";
			}
			elseif ($theme == "red") {
				$title_color       = "#db4742"; 
				$timer_color       = "#ffffff"; 
				$timer_background  = "#fc544e"; 
				$timer_border      = "#db4742";
			}

			/*CountDown Language*/
			$days      = get_post_meta(get_the_ID(), 'days', true);
			$hours     = get_post_meta(get_the_ID(), 'hours', true);
			$minutes   = get_post_meta(get_the_ID(), 'minutes', true);
			$seconds   = get_post_meta(get_the_ID(), 'seconds', true);

			if ($days == "") {
				$days = "Days";
			}
			if ($hours == "") {
				$hours = "Hours";
			}
			if ($minutes == "") {
				$minutes = "Minutes";
			}
			if ($seconds == "") {
				$seconds = "Seconds";
			}

			$currentDateFormat = $date->format( 'Y/m/d H:i:s' );
			$currentDate = strtotime($currentDateFormat);

			$fixtimekivalue = strtotime($countdown_value); 
			$fixedTime = $fixtimekivalue - $currentDate;

			$cookie_futureTime = $currentDate+$timeGap;


			$fontFace =  str_replace("+"," ",$font_face);

			$font = "https://fonts.googleapis.com/css?family=".$font_face;
			wp_enqueue_style( 'imsc_googleapis', $font );
			wp_enqueue_style( 'imsc_custom', IMSC_PLUGIN_URL.'/css/custom.css' );
			$custom_css = "
					.".$multiCountDown." #note div{
						color : ".$timer_color." !important; 
						background-color: ".$timer_background." !important;
						border-color: ".$timer_border." !important;
					}
					.".$multiCountDown." .countDownTitle ,
					.".$multiCountDown." div span{
						font-family: ".$fontFace." !important;
					}
					.".$multiCountDown." .countDownTitle{
						color : ".$title_color." !important;
					}
					
			";
        	wp_add_inline_style( 'imsc_custom', $custom_css );
        	wp_enqueue_script( 'imsc_custom', IMSC_PLUGIN_URL.'/js/custom.js' );
			
			$current_user = wp_get_current_user();
			if (user_can( $current_user, 'administrator' )) {
			  	unset($_COOKIE[$TimeCookie]);
			}

			$custom_script = "jQuery(document).ready(function(){";
			if ($countdown_type == 0){
					echo "<div class='".$multiCountDown."'>";
						if ($hide_title != 1) {
							echo "<p class='countDownTitle'>".get_the_title()."</p>";
						} ?>
						<div id='note'></div>
						    <div style='display:none;' class='expireContent'><?php the_content()?> </div>	
						</div>
			<?php $custom_script .= "
						
							jQuery(function () {
								austDay = '".$timeGap."';
								jQuery('.".$multiCountDown." #note ').countdown({
									until: austDay,
									onExpiry: ".$eAction.",
									padZeroes: true,
									format: 'DHMS',
									layout: 
									    '{d<}<div><span>{dn} </span>".$days."</div>{d>}{h<}<div><span>{hn} </span>".$hours."</div>{h>}' + 
									    '{m<}<div><span>{mn} </span>".$minutes."</div>{m>}{s<}<div><span>{sn} </span>".$seconds."</div>{s>}' });
							});";

			}elseif ($countdown_type == 2){
				if ($fixedTime <= 0) {
					$custom_script .= $eAction."();";
				}

				echo "<div class='".$multiCountDown."'>";
					if ($hide_title != 1) {
						echo "<p class='countDownTitle'>".get_the_title()."</p>";
					}?>
					<div id='note'></div>
					    <div style='display:none;' class='expireContent'><?php the_content()?> </div>	
					</div>
					<?php $custom_script .= "
							jQuery(function () {
								austDay = '".$fixedTime."';
								jQuery('.".$multiCountDown." #note').countdown({
									until: austDay,
									onExpiry: ".$eAction.",
									padZeroes: true,
									format: 'DHMS',
									layout: 
									    '{d<}<div><span>{dn} </span>".$days."</div>{d>}{h<}<div><span>{hn} </span>".$hours."</div>{h>}' + 
									    '{m<}<div><span>{mn} </span>".$minutes."</div>{m>}{s<}<div><span>{sn} </span>".$seconds."</div>{s>}' });
						});";
			}

			if ($expire_action == 0) {
				$custom_script .= "function ".$eAction."(){}";
			}elseif ($expire_action == 1) {
				$custom_script .= " function ".$eAction."(){
							jQuery('.".$multiCountDown." .expireContent').fadeIn();
							jQuery('.".$multiCountDown." #note').remove();	
						}";
			}elseif ($expire_action == 2) {
				$custom_script .= "function ".$eAction."(){
							jQuery('.".$multiCountDown."').remove();	
						}";
			}elseif ($expire_action == 3) {
				$custom_script .= "function ".$eAction."(){ window.location.replace('".$redirect_url."');}";
			}

			$custom_script .= "});";

		wp_add_inline_script( 'imsc_custom', $custom_script );
        endwhile;