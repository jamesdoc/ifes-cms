$(document).ready(function() {// Adding custom typeahead support using http://twitter.github.io/typeahead.js
	
	console.log($("#tags").val());
	console.log($("#tags").tagsinput('items'));
	
	$('#tags').tagsinput('input').typeahead({
		prefetch: 'http://cms.ifesworld.dev/resource/tags'
	}).bind('typeahead:selected', $.proxy(function (obj, datum) { 
		console.log(obj);
		this.tagsinput('add', datum.value);
		this.tagsinput('input').typeahead('setQuery', '');
	}, $('#tags')));
	

	

	$('.btn_translation_delete').click(function(e){
		e.preventDefault();

		var modal = '<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Are you sure?</h4> </div><div class="modal-body"><p>There really is no going back from this...</p></div> <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="submit" class="btn btn-danger" name="btn_confirm_translation_delete" value="' + $(this).attr('value') + '">Delete translation</button></div></div></div></div>';

		$(modal).insertAfter(this).fadeIn();
	});

});