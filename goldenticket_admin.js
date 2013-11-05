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
					fileurl = $('img',html).attr('src');
					$(formfield).val(fileurl);
					alert(fileurl);
					tb_remove();
				} else {
					window.original_send_to_editor(html);
				}
			};
	});

});
