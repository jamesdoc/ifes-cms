<div class="jumbotron robot_blue">
	<div class="container">
		<h1>Search: <?=ucfirst($this->input->post('txt_search'))?></h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <div class="table-responsive">
      <table class="table table-striped">
          <thead>
            <tr>
              <th>Action</th>
              <th>Type</th>
              <th>Title</th>
              <th>Published Date</th>
              
            </tr>
          </thead>

      <? if(count($results) > 0): foreach($results as $record): ?>
        <tr>

          <td>
            <a href="<?=site_url('resource/edit/' . $record->resource_id)?>" class="btn btn-primary btn-sm">Edit</a>
          </td>

          <td>
            <?=ucfirst($record->type)?>
          </td>

          <td>
            <?=ucfirst($record->title)?>
          </td>

          <td>
            <?=date('Y-m-d', strtotime($record->published_dt))?>
          </td>
          
        </tr>
      <? endforeach; endif; ?>

       </table>
       </div>


    </div>

  <div class="col-md-4">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Go to...</h3>
      </div>

      <div class="panel-body">
        <p><a href="<?=site_url('blog')?>">Blogs</a>
        <p><a href="<?=site_url('prayer')?>">Prayer Diary</a>
        <p><a href="<?=site_url('event')?>">Events</a>
        <p><a href="<?=site_url('profile')?>">Profiles</a>
        <p><a href="<?=site_url('video')?>">Video</a>
        <hr />
        <p><a href="<?=site_url('comment')?>">Comment moderation</a>
      </div>
    </div>

  </div>

</div>