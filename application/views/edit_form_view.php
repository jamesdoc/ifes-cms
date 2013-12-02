<form role="form" method="post" id="edit_form" enctype="multipart/form-data">

	<div class="row">

		<? if(isset($error)):?>
		<div class="col-md-12">
			<div class="alert alert-block alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>Uh oh...</h4>
				
				<? foreach($error as $err): ?>
				<p><?=$err?></p>
				<? endforeach;?>
			</div>
		</div>
		<?endif;?>

		<div class="col-md-8">
			
			<? if(array_key_exists('content', $modules)): ?>
			<div class="panel panel-primary">

				<div class="panel-heading">
					<h3 class="panel-title">Language specific content</h3>
				</div>

				<div class="panel-body">
					
					<div class="form-group">
						
						<? if(in_array('title', $modules['content'])): ?>
						<div class="form-group">
							<label for="txt_title">Title</label>
							<input type="text" class="form-control" id="txt_title" name="txt_title" placeholder="" value="<?=$resource->title?>" />
						</div>
						<? endif; ?>



						<? if(in_array('media_link', $modules['content'])): ?>
						<label for="txt_link">Links to files</label>
						<? $link = json_decode($resource->link); ?>


						<? if(is_array($link)): foreach($link as $lnk): ?>

						<div class="input-group">
							<input type="text" class="form-control" id="txt_link" name="txt_link[]" placeholder="http://..." value="<?=$lnk->resource_path?>">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-globe"></span>
							</span>
						</div>
						<? endforeach; elseif (is_object($link)): ?>
						<div class="input-group">
							<input type="text" class="form-control" id="txt_link" name="txt_link[]" placeholder="http://..." value="<?=$link->resource_path?>">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-globe"></span>
							</span>
						</div>
						<? endif; ?>

						<div class="input-group">
							<input type="text" class="form-control" id="txt_link" name="txt_link[]" placeholder="http://...">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-globe"></span>
							</span>
						</div>
						<p class="help-block"><button type="submit" class="btn btn-default btn-xs btn-warning" name="btn_add_audio" value="en">Add another row</button></p>
						<p class="help_block">For video please use Vimeo or YouTube links only, audio should have both Mp3 and OGG files provided.</p>
						<? endif; ?>


						
						<? if(in_array('content', $modules['content'])): ?>
						<div class="form-group">
							<label for="txt_body">Content</label>
							<textarea class="form-control" id="txt_body" name="txt_body"><?=$resource->body?></textarea>
							<?=display_ckeditor($ckeditor);?>
						</div>
						<? endif; ?>



						<? if(in_array('image', $modules['content'])): ?>
						<div class="form-group">
							<label>Insert image</label>
							<div>

								<? if(count($images) > 0): foreach($images as $image): $url = $this->config->item('media_server') . $image; ?><button type="submit" class="image_btn" style="background-image: url('<?=$url?>');" name="btn_insert_image" value="<?=$url?>"></button><? endforeach; endif; ?>

								<div class="input-group">
									<a href="#" class="btn btn-default btn_upload_new_image">Upload new...</a>
								</div>

							</div>
						</div>
						<? endif;?>
						
						<hr />
						
						<? if(in_array('link', $modules['content'])): ?>
						<label for="txt_link">Related link</label>
						<div class="input-group">
							<input type="text" class="form-control" id="txt_link" name="txt_link" placeholder="http://..." value="<?=$resource->link?>">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-globe"></span>
							</span>
						</div>
						<? endif; ?>
						
						<? if(in_array('short_description', $modules['content'])): ?>
						<div class="form-group">
							<label for="txt_link">Short description <small>(< 140 character)</small></label>
							<textarea class="form-control" id="txt_short_description" name="txt_short_description"><?=$resource->desc_short?></textarea>
						</div>
						<? endif ?>

						<input type="hidden" name="txt_lang_code" value="<?=$resource->lang_code?>" />

					</div>
					
				</div>
			</div>
			<? endif;?>

		</div>

		<div class="col-md-4">
			
			<? if(array_key_exists('publish', $modules)): ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Publish</h3>
				</div>
				
				<div class="panel-body">

					<? if($resource->status == 0): ?>
						<button type="submit" class="btn btn-lg btn-success btn-block" name="btn_publish" value="Publish">Publish</button>
						<button type="submit" class="btn btn-lg btn-warning btn-block" name="btn_save_draft" value="Save Draft">Save draft</button>
					<? else: ?>
						<button type="submit" class="btn btn-lg btn-success btn-block" name="btn_save" value="Update">Save</button>
					<? endif; ?>

					<hr />
					<button type="submit" class="btn btn-sm btn-danger btn-block btn_delete_resource" name="btn_delete" value="Delete">Delete</button>
				</div>
			</div>
			<? endif; ?>
			
			
				
			<? if(array_key_exists('datetime', $modules)): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							Dates and times
						</a>
					</h4>
				</div>
				
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						
						<? if(in_array('published_dt', $modules['datetime'])): ?>
						<div class="form-group">
							<? $date = ($resource->published_dt != "" ? date('Y-m-d',strtotime($resource->published_dt)) : ''); ?>
							<label>Publish date</label>
							<div id="datetimepicker_published_dt" class="input-group input-append date" data-date="<?=$date?>" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" name="publish_date" value="<?=$date?>" />
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
							</div>
						</div>

						<div class="form-group">
							<? $time = ($resource->published_dt != "" ? date('H:i',strtotime($resource->published_dt)) : ''); ?>
							<label>Publish time</label>
							<div class="input-group input-append time" data-date="<?=$time?>" data-date-format="hh:ii">
								<input type="text" class="form-control" name="publish_time" value="<?=$time?>" />
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-time"></i>
								</span>
							</div>
						</div>
						<? endif; ?>

						
						<? if(in_array('start_dt', $modules['datetime'])): ?>
						<div class="form-group">
							<? $date = ($resource->published_dt != "" ? date('Y-m-d',strtotime($resource->published_dt)) : ''); ?>
							<label>Start date</label>
							<div id="datetimepicker_start_dt" class="input-group input-append date" data-date="<?=$date?>" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" name="start_date" value="<?=$date?>" />
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
							</div>
						</div>
						<? endif; ?>
						
						<? if(in_array('end_dt', $modules['datetime'])): ?>
						<div class="form-group">
							<? $date = ($resource->end_dt != "" ? date('Y-m-d',strtotime($resource->end_dt)) : ''); ?>
							<label>End date</label>
							<div id="datetimepicker_end_dt" class="input-group input-append date" data-date="<?=$date?>" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" name="end_date" value="<?=$date?>" />
								<span class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								</span>
							</div>
						</div>
						<? endif; ?>

						<? if(in_array('week_number', $modules['datetime'])): ?>
						<div class="form-group">
							<? $date = ($resource->published_dt != "" ? date('Y-m-d',strtotime($resource->published_dt)) : ''); ?>
							<label>Week number</label>
							<div id="startdate" class="input-group input-append date week-number" data-date="<?=$date?>" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" value="<?=$date?>" name="week_begin" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<p class="help-block">This is a helpful message.</p>
						</div>
						<? endif; ?>

					</div>
				</div>
			</div>
			<? endif; ?>
			
			<? if(array_key_exists('translation', $modules)): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
							Translations
						</a>
					</h4>
				</div>
				
				<div id="collapseThree" class="panel-collapse collapse in">
					<div class="panel-body">
						
						<? 
							$translations = explode(',', $resource->translations);

							foreach($translations as $translation):
						?>

							<div class="form-group">
								<?=strtoupper($translation)?>
								<button type="submit" class="btn btn-default btn-xs btn-warning" name="btn_translation_edit" value="<?=$translation?>">Edit</button>
								<button type="submit" class="btn btn-default btn-xs btn-danger btn_translation_delete" name="btn_translation_delete" value="<?=$translation?>">Delete</button></li>
							</div>

						<? endforeach; ?>
						
						<label>Add new translation</label>
						<div class="form-inline">
							<div class="form-group">

								<select class="form-control" name="cbo_add_translation">
									<? foreach($languages as $language): ?>
									<option value="<?=$language->lang_code?>"><?=$language->name?></option>
									<? endforeach; ?>
								</select>

							</div>

							<button type="submit" class="btn btn-default" name="btn_add_translation" value="Add">Add</button>
						</div>
						
					</div>
				</div>
			</div>
			<? endif ?>
			
			<? /* Looky looky: http://timschlechter.github.io/bootstrap-tagsinput/examples/ */?>
			<? if (array_key_exists('tag', $modules)): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
							Tags
						</a>
					</h4>
				</div>
				
				<div id="collapseFive" class="panel-collapse collapse in">
					<div class="panel-body">
						
						
						<?
						$tags = '';
						if($resource_tags != null)
						{
							foreach($resource_tags as $tag)
							{
								if($tag->tag_name != '')
								{
									$tags .= ucfirst(trim($tag->tag_name)) . ',';
								}
							}
						}
						?>

						
							<input type="text" class="form-control" value="<?=$tags?>" data-role="tagsinput" id="tags" name="txt_tags" />
						
						
					</div>
				</div>
			</div>
			<?endif?>


			<? if(array_key_exists('additionals', $modules) && $post_as != null): ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
							Additional options
						</a>
					</h4>
				</div>
				
				<div id="collapseFour" class="panel-collapse collapse">
					<div class="panel-body">
						
						<? if(in_array('post_as', $modules['additionals'])): ?>
						<div class="form-group">
							<label>Post as</label>
							<select class="form-control" name="cbo_post_as">
								<optgroup label="You">
								<option value="<?=$this->session->userdata('member_id')?>"><?=$this->session->userdata('knownas')?></option>
								</optgroup>

								<optgroup label="Others">
								<? foreach($post_as as $member): ?>
								<option value="<?=$member->member_id?>"<? if($member->member_id == $resource->member_id){ echo ' selected';} ?>><?=$member->knownas?></option>
								<? endforeach; ?>
								</optgroup>
							</select>
						</div>
						<? endif; ?>

						
						<? if(in_array('comments', $modules['additionals'])): ?>
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="chk_discussion" value="1"<? if($resource->discussion == 1){echo ' checked';} ?>> Allow comments
								</label>
							</div>
						</div>
						<? endif;?>

						<? if(in_array('featured', $modules['additionals'])): ?>
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="chk_featured" value="1"<? if($resource->featured == 1){echo ' checked';} ?>> Feature on front page
								</label>
							</div>
						</div>
						<? endif;?>
						
					</div>
				</div>
			</div>
			<? endif; ?>

		</div>

	</div>

</form>
<? /*
<hr />

<pre>
<?print_r($resource);?>
</pre>
*/ ?>