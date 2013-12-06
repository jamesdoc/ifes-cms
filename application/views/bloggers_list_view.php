<div class="jumbotron robot_yellow">
	<div class="container">
		<h1>IFES bloggers</h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <div class="table-responsive">
      <table class="table table-striped">
         
        <thead>
          <tr>
            <th>Action</th>
            <th colspan="2" width="30%">Name</th>
            <th colspan="2" width="50%">Biog</th>
          </tr>
        </thead>

      <? if(count($bloggers) > 0): foreach($bloggers as $blogger): ?>
        <tr>

          <td>
            <a href="<?=site_url('bloggers/view/' . $blogger->member_id)?>" class="btn btn-primary btn-sm">Edit</a>
          </td>

          <td>
            <img src="http://www.gravatar.com/avatar/<?=$blogger->gravatar?>?s=30&amp;d=mm" class="img-rounded" />
          </td>

          <td>
            <?=$blogger->knownas?>
          </td>

          <td>
            <p><?=$blogger->bio?></p>
          </td>

          <td>
            <a href="http://ifesworld.org/blog/author/<?=$blogger->username?>" target="_blank" class="btn btn-xs btn-primary">view blog posts &raquo;</a>
          </td>

        </tr>
      <? endforeach; endif; ?>

       </table>
       </div>

    </div>

  <div class="col-md-4">

    <div class="panel panel-primary">

      <div class="panel-heading">

        <h3 class="panel-title">Create new</h3>

      </div>

      <div class="panel-body">

        <p><a href="<?=site_url('bloggers/create')?>" class="btn btn-primary btn-block">Create new blogger</a>

      </div>
      
    </div>

    <? $this->load->view('template/goto_sidebar') ?>    

  </div>

</div>