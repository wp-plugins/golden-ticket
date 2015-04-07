<?php include('admin_functions.php'); ?>
<style type="text/css">
	.active {font-weight: bold;}
	<?php if ($addon['scheduler'] === TRUE) { echo GOLDEN_TICKET_SCHEDULER_ADMIN_CSS(); } ?>
</style> 
<div class="wrap">
	<?php // screen_icon('plugins'); ?>

	<div style="float: left;height: 64px;margin: 7px 8px 0 0;width: 64px;"><img src="<?php echo plugins_url( '/images/ticket-icon.png', __FILE__ ) ?>" title="Golden Ticket WordPress Plugin" /></div>

	<a href='http://consultingwp.com?so=gard_pro' target="_blank"><span style='background-color:yellow;  padding: 5px 15px;margin-top: 10px;display: inline-block;border: 1px solid yellowgreen;color:black;font-weight:bold'>Need a WordPress coder?</span></a> <a href='http://consultingwp.com?so=gard_pro' target="_blank">Contact <span style="color:#d54e21">Consulting WP</span> about custom wordpress projects or error fixes.</a><br>
	
	<form method="post" action="options.php" id="<?php echo $vars['OPTIONS_ID']; ?>_options_form" name="<?php echo $vars['OPTIONS_ID']; ?>_options_form">
	
	<?php settings_fields($vars['OPTIONS_ID']); ?>
	
	<div id='<?php echo $vars["LOWERCASE_SLUG_UNDERSCORE"]; ?>_window'>

	<h1 style="padding-top: 30px;"><?php echo $vars['PLUGIN_TITLE'] ?> v<?php echo $vars['VERSION']; ?> &raquo; Settings</h1>

		<table class="form-table" style="width:initial;margin-bottom: 20px;">
			<tr style="vertical-align:top;">
				<td style="width: 445px;">
					<table class="widefat">
						<thead>
								<th colspan="2"  style="min-width:265px;">
									<input type="submit" name="submit" value="Save Settings" class="button-primary" />
								</th>
						   </tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2" style="vertical-align:middle;">
									<input type="checkbox" name="<?php echo $vars["UPPERCASE_SLUG"]; ?>-display_mode_delay" value="1" <?php checked( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_delay', 1 ), 1); ?>/> Wait <input class="numeric_entry" type="textbox" name="<?php echo $time_slug; ?>" value="<?php echo $timeout; ?>" maxlength="3" style="width:30px;" /> seconds before showing Golden Ticket.
									<br>
									<input type="checkbox" name="<?php echo $vars["UPPERCASE_SLUG"]; ?>-display_mode_mouse_over" value="1" <?php checked( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_mouse_over', 0 ), 1); ?>/> Show the ticket when the user places their mouse over the invisible trigger.
									<Br>
									<input type="checkbox" name="<?php echo $vars["UPPERCASE_SLUG"]; ?>-display_mode_visible" value="1" <?php checked( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_visible', 0 ), 1); ?>/> Show the ticket when the ticket position is in view.
									<br>
									<br>
									By default, <b>Golden Ticket</b> waits 10 seconds, then displays the ticket. 
									<br>
									You also have the option to wait for the user to move their mouse over our invisible placeholder in your content. 
									<br>
									The third option to display the ticket as soon as it's scrolled into view.
								</td>
							</tr>
							<tr>
								<td colspan="2" style="vertical-align:middle;">									
									Custom Message:
									<br>
									If you would like to add a custom message below your ticket, you may enter it here.<br>
									<textarea  style="width:100%;" id="<?php echo $vars["UPPERCASE_SLUG"]; ?>-message" name="<?php echo $vars["UPPERCASE_SLUG"]; ?>-message"><?php echo get_option( $vars["UPPERCASE_SLUG"].'-message') ?></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="vertical-align:middle;">									
									Choose your ticket:
									<br>
									<input id="<?php echo $ticket_slug["1"]; ?>" type="text" name="<?php echo $ticket_slug["1"]; ?>" value="<?php echo $golden_tickets["1"] ?>" size="50" />
									<input class="goldenticket-upload-button button" type="button" value="Upload Ticket<?php if ($addon['multiple_tickets'] === TRUE) { echo " 1"; } ?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2" style="vertical-align:middle;">									
									<h3 style="margin:0;"><img src="<?php echo plugins_url( '/images/ticket-add-on-icon-16.png', __FILE__ ) ?>" style="width:16px;" /> Add-ons:</h3>
									<?php 
										foreach ($addon as $key => $value) {
											if ( $value !== TRUE )  {
												echo $value,"<br>";
											}
										}
									?>
								</td>
							</tr>
							<?php 
								foreach ($addon as $key => $value) {
									if ( $value === TRUE )  {
										$upper = strtoupper($key);
										$string = "GOLDEN_TICKET_".$upper."_ADMIN";
										echo $string();			
									}
								}
							?>
						</tbody>
						<tfoot>
						  <tr>
							<th colspan="2" ><input type="submit" id="submit" name="submit" value="Save Settings" class="button-primary" /> <a style="font-family:arial;font-size:10px;float:right;" href="admin.php?page=golden-ticket&resetsettings">Reset Settings</a></th>
						  </tr>
						</tfoot>
					</table>
				</td>
				<td style="min-width: 445px;">
					<table class="widefat"><thead>
								<th style="min-width:265px;"></th>
						   </tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<a href="http://thepluginfactory.co/" target="_blank" title="The Plugin Factory"><img src="<?php echo plugins_url( '/images/ThePluginFactoryLogo.png', __FILE__ ) ?>" style="width:100%;max-width:420px;" /></a>
									<?php 


									$show_discount = TRUE;
									foreach ($addon as $key => $value) {
										if ( $value === TRUE )  {
											$show_discount = FALSE;			
										}
									}

									if ($show_discount) {

										date_default_timezone_set('America/Los_Angeles');

										$now = time();
										$threeweeks = '1814400';
										$twoweeks = '1209600';
										$one_day = '86400';

										$blackfriday_date = '1385712000'; 
										$christmas_date = '1387958400';

										$blackfriday_start = $blackfriday_date - $threeweeks;
										$blackfriday_stop = $blackfriday_date + ($one_day * 4);									

										$christmas_start = $christmas_date - $twoweeks;
										$christmas_stop = $christmas_date + 84600;

										if ($now >= $blackfriday_start && $now <= $blackfriday_stop) {
											?>
											<h3 style="color:red;margin:0;">BLACK FRIDAY / CYBER MONDAY SALE</h3>
												Use discount code <b><pre style="font-size:14px;display:initial;color:black;">GTBF2013</pre></b> anytime between Black Friday and<br>
												Cyber Monday to receive 50% off of any Golden Ticket add-on purchases.<br>
												Valid dates: November 29, 2013 through December 2, 2013
												<br>
											<?php 
										} elseif ($now >= $christmas_start && $now <= $christmas_stop) {
											?>
											<h3 style="color:green;margin:0;">CHRISTMAS EVE / CHRISTMAS DAY</h3>
												Use discount code <b><pre style="font-size:14px;display:initial;color:black;">GTCH2013</pre></b> on Christmas Eve or<br>
												Christmas Day to receive 50% off of any Golden Ticket add-on purchases.<br>
												Valid dates: December 24, 2013 and December 25, 2013
												<br>
											<?php 
										}
									}

									?>
									<br>
									Plugin by: <a href="http://thepluginfactory.co/" target="_blank" title="The Plugin Factory">The Plugin Factory</a><br>
									Support Forum: <a href="http://thepluginfactory.co/community/forum/plugin-specific/golden-ticket/" target="_blank" title="Golden Ticket Support">Golden Ticket Support</a><br>
									Official Website: <a href="http://thepluginfactory.co/warehouse/golden-ticket/" target="_blank" title="Golden Ticket Homepage">Golden Ticket Homepage</a><br>
									Additional Credits: jQuery script <a href='https://github.com/protonet/jquery.inview' title='Inview' target='_blank'>inview</a> was created by <a href='https://github.com/tiff' title='Chrisopher Blum' target='_blank'>Christopher Blum</a><br>
								</td>
							</tr>
							<tr>
								<td>
									<?php
										// TICKET PREVIEWS

										if (strlen($ticket_slug["1"]) >= 5) { ?>
										<h2>Ticket Preview</h2>
										<a href="#" class="image_preview" id="thumbnail_image_preview">Thumbnail</a> | 
										<a href="#" class="image_preview active" id="medium_image_preview">Medium</a> | 
										<a href="#" class="image_preview" id="large_image_preview">Large</a> | 
										<a href="#" class="image_preview" id="full_image_preview">Full Width</a>
										<br>
										<?php if ($addon['multiple_tickets'] === TRUE) { echo GOLDEN_TICKET_MULTIPLE_TICKETS_PREVIEW(); } ?>
										<br>
										<img id="preview_image" src="<?php echo get_golden_ticket_src( $golden_tickets['1'], "medium" ); ?>" />
									<?php } ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						  <tr>
							<th ></th>
						  </tr>
						</tfoot>

					</table>
				</td>
			</tr>
		</table>
			<script type="text/javascript">

				jQuery(function ($) {
					$(document).ready(function() {

						// CONTROL-S FOR SAVE

							$(document).keydown(function(event) {
								//19 for Mac Command+S
								if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) return true;
								$("#submit").click();
								event.preventDefault();
								return false;
							});

						// TICKET UPLOAD
	 
							var formfield;
							
							$('.goldenticket-upload-button').click(function() {
								formfield = $(this).prev('input'); //The input field that will hold the uploaded file url
								tb_show('','media-upload.php?TB_iframe=true');
								
								return false;
							});

							window.old_tb_remove = window.tb_remove;
							window.tb_remove = function() {
								window.old_tb_remove(); // calls the tb_remove() of the Thickbox plugin
								formfield=null;
							};
						 
							window.original_send_to_editor = window.send_to_editor;
							window.send_to_editor = function(html){
								if (formfield) {
									fileurl = html.split('"');
									$(formfield).val(fileurl[1]);
									tb_remove();
								} else {
									window.original_send_to_editor(html);
								}
							};
						 

						// TICKET PREVIEW

							ticketnumber = "1";

							$("#thumbnail_image_preview").click(function(event) {
								<?php
									global $vars;
									$ticket_count = get_option( $vars["UPPERCASE_SLUG"].'-ticket_count', "1" );
									$ticket_count++;
									$i = 1;
									global $golden_tickets;
									while ($i <= $ticket_count) { 
										echo "if (ticketnumber == '".$i."') {
											var newsrc = '".get_golden_ticket_src( $golden_tickets["$i"], "thumbnail" )."';
										} else ";
										$i++;
									}
								?>{};
								$("#preview_image").attr("src", newsrc);
								$('.image_preview').removeClass('active');
								$(this).addClass('active');
								return false;
							});

							$("#medium_image_preview").click(function(event) {
								<?php
									global $vars;
									$ticket_count = get_option( $vars["UPPERCASE_SLUG"].'-ticket_count', "1" );
									$ticket_count++;
									$i = 1;
									global $golden_tickets;
									while ($i <= $ticket_count) { 
										echo "if (ticketnumber == '".$i."') {
											var newsrc = '".get_golden_ticket_src( $golden_tickets["$i"], "medium" )."';
										} else ";
										$i++;
									}
								?>{};
								$("#preview_image").attr("src", newsrc);
								$('.image_preview').removeClass('active');
								$(this).addClass('active');
								return false;
							});

							$("#large_image_preview").click(function(event) {
								<?php
									global $vars;
									$ticket_count = get_option( $vars["UPPERCASE_SLUG"].'-ticket_count', "1" );
									$ticket_count++;
									$i = 1;
									global $golden_tickets;
									while ($i <= $ticket_count) { 
										echo "if (ticketnumber == '".$i."') {
											var newsrc = '".get_golden_ticket_src( $golden_tickets["$i"], "large" )."';
										} else ";
										$i++;
									}
								?>{};
								$("#preview_image").attr("src", newsrc);
								$('.image_preview').removeClass('active');
								$(this).addClass('active');
								return false;
							});

							$("#full_image_preview").click(function(event) {
								$("#preview_image").css('width','initial');
								$("#preview_image").css('max-width','100%');
								<?php
									global $vars;
									$ticket_count = get_option( $vars["UPPERCASE_SLUG"].'-ticket_count', "1" );
									$ticket_count++;
									$i = 1;
									global $golden_tickets;
									while ($i <= $ticket_count) { 
										echo "if (ticketnumber == '".$i."') {
											var newsrc = '".get_golden_ticket_src( $golden_tickets["$i"], "full" )."';
										} else ";
										$i++;
									}
								?>{};
								$("#preview_image").attr("src", newsrc);
								$('.image_preview').removeClass('active');
								$(this).addClass('active');
								return false;
							});

							<?php if ($addon['multiple_tickets'] === TRUE) { echo GOLDEN_TICKET_MULTIPLE_TICKETS_JS(); } ?>
						
						// NUMERIC VALIDATION


							$.fn.ForceNumericOnly =
							function()
							{
								return this.each(function()
								{
									$(this).keydown(function(e)
									{
										var key = e.charCode || e.keyCode || 0;
										// allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
										// home, end, period, and numpad decimal
										return (
											key == 8 || 	// backspace
											key == 9 ||		// tab
											key == 13 ||	// enter
											key == 17 ||	// control
											key == 82 ||	// r
											key == 83 ||	// s
											key == 46 ||	// delete
											(key >= 35 && key <= 40) ||
											(key >= 48 && key <= 57) ||
											(key >= 96 && key <= 105));
									});
								});
							};

							$(".numeric_entry").ForceNumericOnly();

						// FORM VALIDATION

							$("form").submit(function() {
								$(".numeric_entry").each(function(){

									var textBox =  $.trim( $(this).val() )
									var isnumeric = $.isNumeric( textBox );
									if (textBox == "" || isnumeric == false) {
										alert("Some numeric fields are either empty or contain text.\n\nPlease be sure all fields only contain numbers and are filled in.");
										event.preventDefault();
									}

								});			
							});

						// SCHEDULER ADD ON

							<?php 
								if (function_exists("GOLDEN_TICKET_SCHEDULER_ADMIN_JS"))
									echo GOLDEN_TICKET_SCHEDULER_ADMIN_JS();
							?>

					});

				});
			</script>
	</div>

<?php
	global $vars;

	if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == true ) {

		$custom_js = "
			jQuery(function ($) {
				$(document).ready(function() {
					// START FUNCTIONS HERE
		";

		if ( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_mouse_over', 0 ) == "1" ) {

			$custom_js .= "
						$('#goldenticket_trigger').mouseenter(function(event) {
							$('#goldenticket').show( 'slide', { direction: 'up' }, 1500);
						});
			";

		} 

		if ( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_delay', 0 ) == "1" ) {
			$time = get_option( $vars["UPPERCASE_SLUG"]."-delay_time", 5 );
			$time = $time * 10;
			$custom_js .= "
						setTimeout(function() {
							$('#goldenticket').show( 'slide', { direction: 'up' }, 1500);
						}, ".$time."00);
			";		
		} 

		if ( get_option( $vars["UPPERCASE_SLUG"].'-display_mode_visible', 0 ) == "1" ) {
			$custom_js .= "
					    $('#goldenticket_trigger').bind('inview', function(event, visible) {
					      if (visible) {
							setTimeout(function() {
								$('#goldenticket').show( 'slide', { direction: 'up' }, 1500);
							}, 1000);
					      }
					    });


			";		
		}


		// TOOLTIPS ADD ON

			if (function_exists("GOLDEN_TICKET_TOOLTIPS_ADMIN_JS"))
				$custom_js .= GOLDEN_TICKET_TOOLTIPS_ADMIN_JS();


		
		$custom_js .= "
				// END FUNCTIONS HERE
			});

		});
		";

		$file = dirname(__FILE__) . "/goldenticket_js.js"; 
		$fh = fopen($file, 'w');
		fwrite($fh, $custom_js);
		fclose($fh);

	}