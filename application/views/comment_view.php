<div class="jumbotron robot_red">
	<div class="container">
		<h1>Comment moderation</h1>
	</div>
</div>

<div class="row" id="comment_form">

    <div class="col-md-8">
      
      <div class="panel panel-primary">

        <div class="panel-heading">
          <h3 class="panel-title">Comment</h3>
        </div>

        <div class="panel-body">

          <div class="form-group">
            <label for="txt_title">Name</label>
            <p class="form-control-static"><?=$comment[0]->comment_name?></p>
          </div>

          <div class="form-group">
            <label for="txt_title">Comment</label>
            <p class="form-control-static"><?=nl2br($comment[0]->comment_content)?></p>
          </div>

          <div class="form-group">
            <label for="txt_title">Email</label>
            <p class="form-control-static"><?=$comment[0]->comment_email?></p>
          </div>

        </div>

      </div>

      
    </div>

  <div class="col-md-4">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Actions</h3>
      </div>

      <div class="panel-body">
        <a href="http://ifesworld.org/resource/<?=$comment[0]->resource_id?>" target="_blank" class="btn btn-success btn-block">View comment on resource</a>
        <a href="mailto:<?=$comment[0]->comment_email?>" class="btn btn-warning btn-block">Email <?=$comment[0]->comment_name?></a>
        <a href="#" class="btn btn-danger btn-block btn-delete-comment">Delete comment</a>
      </div>
    </div>

  </div>

</div>