<?php

// VARIABLES
	
	global $vars;
	global $addon;
	global $golden_tickets;

	$time_slug = $vars["UPPERCASE_SLUG"].'-delay_time';
	$timeout = get_option( $time_slug, "10" );

	$ticket_slug["1"] = $vars["UPPERCASE_SLUG"].'-ticket_url_1';
	$golden_tickets["1"] = get_option( $ticket_slug["1"] );
			

// RUN ADMIN SETUP FUNCTIONS FOR ADD-ONS		

	foreach ($addon as $key => $value) {
		if ( $value === TRUE )  {
			$upper = strtoupper($key);
			$function = "GOLDEN_TICKET_".$upper."_ADMIN_SETUP";
			if ($addon["$value"] === TRUE && function_exists($function_exists)) 
				$function();		
		}
	}

// DEFINE FUNCTIONS
	if (!function_exists('get_golden_ticket_src')) {
		function get_golden_ticket_src ($image_src = '', $size = 'full') {
			global $wpdb;
			if (preg_match("/-(\d{2,4})x(\d{2,4})/", $image_src))
				$image_src = preg_replace('/-(\d{2,4})x(\d{2,4})/', '', $image_src);

			$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
			$id = $wpdb->get_var($query);

		    $image = $image_src;

			if ($size == "thumbnail") {
				$image 	= image_downsize( $id, 'thumbnail' );
				$image = $image["0"];
			} elseif ($size == "medium") {
				$image 	= image_downsize( $id, 'medium' );
				$image = $image["0"];
			} elseif ($size == "large") {
				$image 	= image_downsize( $id, 'large' );
				$image = $image["0"];
			}

			return $image;
		}
	}

// CHECK GET VARIABLES

	if (isset($_GET['resetsettings'])) {
		global $GOLDEN_TICKET;
		$GOLDEN_TICKET->reset();
	}