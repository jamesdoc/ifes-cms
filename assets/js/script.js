$(document).ready(function() {
	
	$(document).on("click", ".modal-close", function() {
		$('.modal').remove();
	});

	// Are we on the edit form?
	if ($('#edit_form').length)
	{

		var unsaved_changes = false;
		$('input, select, textarea').change(function () { unsaved_changes = true; });
		$('button').click(function () { unsaved_changes = false; });
		
		$(window).on('beforeunload', function(){
			if(unsaved_changes == true) { return 'There are unsaved changes.'; }
		});
		
		$('.input-append.date').datepicker({weekStart: 1, orientation: "top auto", autoclose: true, calendarWeeks: true});

		// If we have tags on the page...
		if ($('#tags').length)
		{
			$('#tags').tagsinput('input').typeahead({
				prefetch: window.location.protocol + '//' + document.location.hostname + '/resource/tags'
			}).bind('typeahead:selected', $.proxy(function (obj, datum) { 
				this.tagsinput('add', datum.value);
				this.tagsinput('input').typeahead('setQuery', '');
			}, $('#tags')));
		}

		$('.btn_translation_delete').click(function(e){
			e.preventDefault();

			var modal = '<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Are you sure?</h4> </div><div class="modal-body"><p>There really is no going back from this...</p></div> <div class="modal-footer"><button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button><button type="submit" class="btn btn-danger" name="btn_confirm_translation_delete" value="' + $(this).attr('value') + '">Delete translation</button></div></div></div></div>';

			$(modal).insertAfter(this).fadeIn();
		});

		$('.btn_delete_resource').click(function(e){
			e.preventDefault();

			var modal = '<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Are you sure?</h4></div><div class="modal-body"><p>The resource will be no more. There really is no going back from this...</p></div> <div class="modal-footer"><button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button><button type="submit" class="btn btn-danger" name="btn_confirm_resource_delete" value="TRUE">Delete resource</button></div></div></div></div>';

			$(modal).insertAfter(this).fadeIn();
		});

		$('.btn_upload_new_image').click(function(e){
			e.preventDefault();

			var modal = '<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Upload image</h4></div><div class="modal-body"> <div class="form-group"><label>Image</label><input type="file" class="form-control" name="file_image" /><p class="help-block">JPG or GIF only please.</p></div></div> <div class="modal-footer"><button type="submit" class="btn btn-success" name="btn_upload_image" value="TRUE">Upload image</button></div></div></div></div>';

			$(modal).insertAfter(this).fadeIn();
		});

		$('#btn_add_link').click(function(e){
			e.preventDefault();

			var link_input = $(this).parent().prev();

			link_input.clone().prependTo($(this).parent());


		});

	} // End 'are we on the edit form?' check


	if ($('#comment_form').length)
	{

		$('.btn-delete-comment').click(function(e){
			e.preventDefault();

			var modal = '<form method="post" class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Are you sure?</h4></div><div class="modal-body"><p>This action will delete the comment, and it will be no more.</p><p>Please confirm.</p></div> <div class="modal-footer"><button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button><button type="submit" class="btn btn-danger" name="btn_confirm_comment_delete" value="TRUE">Delete comment</button></div></div></div></form>';

			$(modal).insertAfter(this).fadeIn();
		});

	} // End 'are we on the comment form?' check


	if ($('#blogger_new').length)
	{

		$('.btn-add-blogger').click(function(e){

			e.preventDefault();

			var email = $('#txt_email');

			if(isValidEmailAddress(email.val()) == false)
			{
				email.css('color','red');
			}
			else
			{
				email.css('color','');
				$('form').submit();
			}

			
		});
	}


	if ($('#edit_blogger_form').length)
	{
		$('#txt_bio').keydown(function(event){
			if(event.keyCode==13){return false;}

			var textarea = $(this);
			var i = parseInt(textarea.val().length);

			if(i==160)		{ return false;}
			else if(i>=159)	{ textarea.value = textarea.value.slice(0, -1);}
			else if(i>=155)	{ textarea.css('color','#f00');}
			else if(i>=150)	{ textarea.css('color','#ef9b0f');}
			else if(i<150)	{ textarea.css('color','#000');}
			
		});

		$('.btn-remove-blogger').click(function(e){
			e.preventDefault();

			var modal = '<form method="post" class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Are you sure?</h4></div><div class="modal-body"><p>This action will remove the blogger from the CMS, however their blog posts will remain intacted and credited.</p><p>Please confirm this action.</p></div> <div class="modal-footer"><button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button><button type="submit" class="btn btn-danger" name="btn_confirm_blogger_removal" value="TRUE">Confirm removal</button></div></div></div></form>';

			$(modal).insertAfter(this).fadeIn();
		});
	}

});






function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}