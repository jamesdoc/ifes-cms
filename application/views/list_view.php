<div class="jumbotron">
	<div class="container">
		<h1>Filter: <?=ucfirst($type)?></h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <div class="table-responsive">
      <table class="table table-striped">
          <thead>
            <tr>
              <th>Action</th>
              <th>Title</th>
              <th>Author</th>
              <th>Body</th>
              
            </tr>
          </thead>

      <? if(count($records) > 0): foreach($records as $record): ?>
        <tr>

          <td>
            <a href="<?=site_url($type . '/edit/' . $record->resource_id)?>" class="btn btn-primary btn-sm">Edit</a>
          </td>

          <td>
            <? if($record->status == 0): ?>
              <span class="label label-warning">Draft</span>
            <? elseif (date('ymdHis', strtotime($record->published_dt)) > date('ymdHis') ): ?>
              <span class="label label-info">Scheduled</span><br/ >
            <? endif ?>
            <?=$record->title?>
          </td>

          <td>
            <?=$record->knownas?>
          </td>

          <td>
            <?=word_limiter(strip_tags($record->body), 40)?>
          </td>
          
        </tr>
      <? endforeach; endif; ?>

       </table>
       </div>

       <?=$this->pagination->create_links();?>

    </div>

  <div class="col-md-4">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Create new...</h3>
      </div>

      <div class="panel-body">
        <a href="<?=site_url($type . '/new')?>" class="btn btn-primary btn-block">New <?=ucfirst($type)?></a>
      </div>
    </div>

    <? $this->load->view('template/goto_sidebar') ?>

  </div>

</div>