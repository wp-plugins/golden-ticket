<?php
/*
    Plugin Name: Golden Ticket
    Plugin URI: http://thepluginfactory.co/warehouse/golden-ticket
	Description: Display fun tickets and reward your visitors for reading your content.
	Version: 1.0.3
	Author: The Plugin Factory
	Author URI: http://thepluginfactory.co
*/

if (!class_exists('GOLDEN_TICKET')) {
	class GOLDEN_TICKET {

		function strtotitle($title){
			$smallwordsarray = array('of','a','the','and','an','or','nor','but','is','if','then','else','when','at','from','by','on','off','for','in','out','over','to','into','with');
			$title = strtolower($title);
			$words = explode(' ', $title);
			foreach ($words as $key => $word){
				if ($key == 0 or !in_array($word, $smallwordsarray)) {
					$words[$key] = ucwords($word);
				}
			}
			$newtitle = implode(' ', $words);
			return $newtitle;
		}
			
		function get_vars() {

			# EDIT THIS
				$vars["UPPERCASE_SLUG"] =  'GOLDEN_TICKET'; // PLUGIN NAME
				$vars["VERSION"] = '1.0.3';

			# THESE NEVER CHANGE
				$vars["AUTHOR"] = 'The Plugin Factory';
				$vars["WEBSITE"] =  '<a href="http://thepluginfactory.co/" target="_blank">The Plugin Factory</a>';

			# THESE ARE DYNAMIC
				$vars["PLUGIN_TITLE"] = $this->strtotitle( str_replace("_", " ", $vars["UPPERCASE_SLUG"]) ); // Plugin Name // OPTIONS_NICK
				$vars["LOWERCASE_SLUG_UNDERSCORE"] = strtolower( str_replace(" ", "_", $vars["UPPERCASE_SLUG"]) ); // plugin_name //OPTIONS_URL_CODE
				$vars["LOWERCASE_SLUG_DASH"] = strtolower( str_replace("_", "-", $vars["UPPERCASE_SLUG"]) ); // plugin-name //OPTIONS_URL_CODE
				$vars["OPTIONS_ID"] = $vars["UPPERCASE_SLUG"].'-options';
				$vars["SUPPORT"] = '<a href="http://thepluginfactory.co/community/forum/plugin-specific/'.$vars["LOWERCASE_SLUG_DASH"].'/" target="_blank">'.$vars["PLUGIN_TITLE"].' Support Forum</a>';
				$vars["WEBSITE_PAGE"] =  '<a href="http://thepluginfactory.co/'.$vars["LOWERCASE_SLUG_DASH"].'/" target="_blank">'.$vars["PLUGIN_TITLE"].' Official Website</a>';
			
			return $vars;
		}
		
		function register()  { 
			if (!current_user_can('manage_options')) return;
			global $vars;
			global $addon;
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-display_mode_delay');
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-display_mode_visible');
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-display_mode_mouse_over');
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-delay_time');
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-message');
			register_setting( $vars["OPTIONS_ID"], $vars["UPPERCASE_SLUG"].'-ticket_url_1');

			// REGISTER ADD-ONS
				foreach ($addon as $key => $value) {
					if ( $value === TRUE )  {
						$upper = strtoupper($key);
						$string = "GOLDEN_TICKET_".$upper."_REGISTER";						
						if (function_exists($string)) {
							$string();			
						}	
					}
				}

			$this->enqueue_backend();
		}

		function reset()  { 
			if (!current_user_can('manage_options')) return;
			global $vars;
			global $addon;
			delete_option( $vars["UPPERCASE_SLUG"].'-display_mode_delay');
			delete_option( $vars["UPPERCASE_SLUG"].'-display_mode_visible');
			delete_option( $vars["UPPERCASE_SLUG"].'-display_mode_mouse_over');
			delete_option( $vars["UPPERCASE_SLUG"].'-delay_time');
			delete_option( $vars["UPPERCASE_SLUG"].'-message');
			delete_option( $vars["UPPERCASE_SLUG"].'-ticket_url_1');

			// REGISTER ADD-ONS
				foreach ($addon as $key => $value) {
					if ( $value === TRUE )  {
						$upper = strtoupper($key);
						$string = "GOLDEN_TICKET_".$upper."_RESET";						
						if (function_exists($string)) {
							$string();			
						}	
					}
				}
		}

		function content_filter($html) {
			// AUTO INSERT ADD ON
				
				return GOLDEN_TICKET_AUTO_INSERT_FRONTEND($html);

		}

		# SHORTCODE FUNCTION

			function shortcode($atts = '') {

				extract( shortcode_atts( array(
					'ticket' => '1',
					'odds' => '0'
				), $atts ) );


				global $vars;
				$slug = $vars["UPPERCASE_SLUG"].'-ticket_url_1';
				$ticket_src = get_option( $slug );
				
				// ODDS ADD ON
					
					if (function_exists('GOLDEN_TICKET_ODDS_FRONTEND')) {
						$theodds = GOLDEN_TICKET_ODDS_FRONTEND($odds,$ticket);
						if( $theodds != "1" ) return $theodds;
					}

				// MULTIPLE TICKETS ADD ON
					
					if (function_exists('GOLDEN_TICKET_MULTIPLE_TICKETS_FRONTEND'))
						$ticket_src = GOLDEN_TICKET_MULTIPLE_TICKETS_FRONTEND($ticket);

				// TOOLTIPS ADD ON
					
					$tooltip = '';
					if (function_exists('GOLDEN_TICKET_TOOLTIPS_FRONTEND'))
						$tooltip = GOLDEN_TICKET_TOOLTIPS_FRONTEND($ticket);

				$display_mode_visible = get_option( $vars["UPPERCASE_SLUG"].'-display_mode_visible', 0 );
				$display_mode_delay = get_option( $vars["UPPERCASE_SLUG"].'-display_mode_delay', 0 );
				$display_mode_mouse_over = get_option( $vars["UPPERCASE_SLUG"].'-display_mode_mouse_over', 0 );


				if ($display_mode_mouse_over == 0) {
					$opendiv = "<div id='goldenticket_trigger' style='display:block;float:right;width:1px;height:1px;'></div>";
				} else {
					$opendiv = "<div id='goldenticket_trigger' style='display:block;width:100%;height:20px;margin-top: -20px;'></div>";
				}

				$message = "<span style='width:100%;text-align:right;display:block;font-size:10px;color:#666666;'>
								Powered by: <a style='color: #d54e21;font-weight: bold;' href='http://thepluginfactory.co/warehouse/golden-ticket/' title='Golden Ticket WordPress Plugin' target='_blank'>Golden Ticket</a>
							</span>";

				if ( strlen(get_option($vars["UPPERCASE_SLUG"].'-message')) >= 1 )
					$message = get_option( $vars["UPPERCASE_SLUG"].'-message' );

				if ( $message == "blank" )
					$message = '';

				
				if (function_exists('GOLDEN_TICKET_LINKS_OUTPUT')) {
					$ticket_output = GOLDEN_TICKET_LINKS_OUTPUT($ticket,$ticket_src);
				} else {
					$ticket_output = "<img src='{$ticket_src}' style='width:100%' />";
				}
				

				$goldenticket = $opendiv."<div id='goldenticket' style='display:none'>
											<span title='{$tooltip}'>
												{$ticket_output}
												<br>
												$message
											</span>
										</div>";
				return $goldenticket;

			}

			function this_plugin_function() {

				add_shortcode( 'goldenticket' , $this->shortcode() );

			}

		# END SHORTCODE FUNCTION

		function enqueue_frontend(){

			global $vars;
			global $addon;

			wp_enqueue_script( 'jquery' );

			if ( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_visible' ) == "1" ) {
				wp_enqueue_script( 'inview', plugins_url( '/jquery.inview.js', __FILE__ ), array(), '1.0', true );
			}
			
			if ( file_exists( dirname(__FILE__) . "/goldenticket_js.js" ) ) {
				wp_enqueue_script( 'jquery-effects-core' );
				wp_enqueue_script( 'jquery-effects-slide' );
				wp_enqueue_script( 'goldenticket', plugins_url( '/goldenticket_js.js', __FILE__ ), array(), '1.0.'.rand(9999,99999), true );

			}			

			// REGISTER ADD-ONS
				foreach ($addon as $key => $value) {
					if ( $value === TRUE )  {
						$upper = strtoupper($key);
						$string = "GOLDEN_TICKET_".$upper."_ENQUEUE_FRONTEND";
						if (function_exists($string)) {
							$string();			
						}
					}
				}


		}

		function enqueue_backend(){

			global $addon;
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style(  'thickbox' );

			// REGISTER ADD-ONS
				foreach ($addon as $key => $value) {
					if ( $value === TRUE )  {
						$upper = strtoupper($key);
						$string = "GOLDEN_TICKET_".$upper."_ENQUEUE_ADMIN";
						if (function_exists($string)) {
							$string();			
						}
					}
				}
		}

		function setup_menu() {

			function menu() {
				include(dirname(__FILE__) . '/options.php');
			}

			global $vars;
			$page_title = $vars["PLUGIN_TITLE"];
			$menu_title = $vars["PLUGIN_TITLE"];
			$capability = 'manage_options';
			$menu_slug  = $vars["LOWERCASE_SLUG_DASH"];
			$function   = 'menu';
			$icon_url   = plugins_url( '/images/ticket-icon-16.png' , __FILE__ );
			$position   = 999;

			add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url/*, $position */ ); 
		}

		function addoncheck() {

			$addonlink = '<a href="http://thepluginfactory.co/warehouse/golden-ticket/" title="Golden Ticket Add-ons" target="_blank">More info</a>';

			$addon = array(	
						"multiple_tickets" => "Upload multiple tickets $addonlink",
						"auto_insert" => "Auto insert tickets $addonlink",
						"links" => "Make tickets clickable $addonlink",
						"tooltips" => "Show a <a href='http://jqueryui.com/tooltip' target='_blank'>tooltip</a> on ticket hover $addonlink",
						// "split_testing" => "Test which tickets convert better $addonlink",
						// "scheduler" => "Schedule start and end dates $addonlink",
						// "click_tracking" => "Track clicks on tickets $addonlink",
						"odds" => "Set the odds of a ticket appearing $addonlink"
					);

			foreach ($addon as $key => $value) {
				if ( function_exists( 'GOLDEN_TICKET_'.strtoupper($key).'_REGISTER' ) ) {
					$addon["$key"] = TRUE;
				}
			}
			return $addon;
		}
	}
}

$GOLDEN_TICKET = new GOLDEN_TICKET;
$vars = $GOLDEN_TICKET->get_vars();
$addon = $GOLDEN_TICKET->addoncheck();

// ADD ONS

	add_action( 'plugins_loaded', array($GOLDEN_TICKET,'addoncheck' ) );

if ( is_admin() ) {

	// WP HOOKS

		add_action( 'admin_menu',  array($GOLDEN_TICKET,'setup_menu') );
		add_action( 'admin_init',  array($GOLDEN_TICKET,'register') );

} else {

	// MAIN SETUP

		$GOLDEN_TICKET->this_plugin_function();


	// WP HOOKS
		
		add_action( 'wp_enqueue_scripts', array($GOLDEN_TICKET,'enqueue_frontend') );
		add_shortcode( 'goldenticket' , array($GOLDEN_TICKET,'shortcode' ) );
		if (function_exists('GOLDEN_TICKET_AUTO_INSERT_FRONTEND'))
			add_filter('the_content', array($GOLDEN_TICKET,'content_filter' ) );


}

