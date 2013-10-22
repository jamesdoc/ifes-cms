<form role="form" method="post">

	<div class="row">

		<div class="col-md-8">
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Language specific content</h3>
				</div>

				<div class="panel-body">
					
					<div class="form-group">
						
						<div class="form-group">
							<label for="txt_title">Title</label>
							<input type="text" class="form-control" id="txt_title" name="txt_title" placeholder="">
						</div>
						
						<div class="form-group">
							<label for="txt_body">Content</label>
							<textarea class="form-control" id="txt_body" name="txt_body"></textarea>
						</div>
						
						<hr />
						
						<div class="form-group">
							<label for="txt_link">Related link</label>
							<input type="text" class="form-control" id="txt_link" name="txt_link" placeholder="http://...">
						</div>
						
						<div class="form-group">
							<label for="txt_link">Short description <small>(< 140 character)</small></label>
							<textarea class="form-control" id="txt_shortdesc" name="txt_shortdesc"></textarea>
						</div>
					</div>
					
				</div>
			</div>

		</div>

		<div class="col-md-4">
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Publish</h3>
				</div>
				
				<div class="panel-body">
					<button type="submit" class="btn btn-lg btn-success btn-block">Publish</button>
					<button type="submit" class="btn btn-lg btn-warning btn-block">Save draft</button>
					<hr />
					<button type="submit" class="btn btn-sm btn-danger btn-block">Delete</button>
				</div>
			</div>
			
			<div class="panel-group" id="accordion">
				
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
							<div class="form-group">
								<label>Start date</label>
								<div id="startdate" class="input-group input-append date">
									<input type="text" class="form-control"></input>
									<span class="input-group-addon">
										{ }
									</span>
								</div>
							</div>
							
							<div class="form-group">
								<label>End date</label>
								<div id="datetimepicker" class="input-group input-append date">
									<input type="text" class="form-control"></input>
									<span class="input-group-addon">
										{ }
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
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
							
							<ul>
								<li>English</li>
								<li>Spanish</li>
							</ul>
							
							<label>Add new translation</label>
							<div class="form-group">
								<select class="form-control" name="cbo_post_as">
									<option>English</option>
									<option>Spanish</option>
									<option>French</option>
								</select>
							</div>
							
						</div>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
								Post as
							</a>
						</h4>
					</div>
					
					<div id="collapseFour" class="panel-collapse collapse">
						<div class="panel-body">
							
							<div class="form-group">
								<select class="form-control" name="cbo_post_as">
									<option>James Doc</option>
									<option>Andy Moore</option>
									<option>Penny Vinden</option>
								</select>
							</div>
							
						</div>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
								Tags
							</a>
						</h4>
					</div>
					
					<div id="collapseFive" class="panel-collapse collapse">
						<div class="panel-body">
							
							<ul>
								<li></li>
								<li></li>
							</ul>
							
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</form>