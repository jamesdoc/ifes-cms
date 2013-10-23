<div class="jumbotron">
	<div class="container">
		<h1>Filter: <?=ucfirst($type)?></h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <table class="table table-striped">
          <thead>
            <tr>
              <th>Action</th>
              <th>Title</th>
              <th>Author</th>
              <th>Body</th>
              
            </tr>
          </thead>

      <? foreach($records as $record): ?>
        <tr>

          <td><a href="<?=site_url($type . '/edit/' . $record->resource_id)?>" class="btn btn-primary btn-sm">Edit</a></td>
          <td><?=$record->title?></td>
          <td><?=$record->knownas?></td>
          <td><?=word_limiter(strip_tags($record->body), 40)?></td>
          
        </tr>
      <? endforeach; ?>

       </table>

    </div>

  <div class="col-md-4">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Create new...</h3>
      </div>

      <div class="panel-body">
        <p><a href="#">Blog post</a>
        <p><a href="#">Prayer point</a>
        <p><a href="#">Event</a>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Display</h3>
      </div>

      <div class="panel-body">
        <p><a href="#">Blogs</a>
        <p><a href="#">Prayer Diary</a>
        <p><a href="#">Events</a>
      </div>
    </div>

  </div>

</div>