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

    <? $this->load->view('template/goto_sidebar') ?>

  </div>

</div>