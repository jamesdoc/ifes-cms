$(document).ready(function() {
	
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

		$('#tags').tagsinput('input').typeahead({
			prefetch: window.location.protocol + '//' + document.location.hostname + '/resource/tags'
		}).bind('typeahead:selected', $.proxy(function (obj, datum) { 
			this.tagsinput('add', datum.value);
			this.tagsinput('input').typeahead('setQuery', '');
		}, $('#tags')));

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

		$(document).on("click", ".modal-close", function() {
			$('.modal').remove();
		});

	} // End 'are we on the edit form?'' check

});