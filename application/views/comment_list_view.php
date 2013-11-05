<div class="jumbotron robot_red">
	<div class="container">
		<h1>Comment moderation</h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <div class="table-responsive">
      <table class="table table-striped">
         
        <thead>
          <tr>
            <th>Action</th>
            <th colspan="2">Name</th>
            <th width="40%">Comment</th>
            <th colspan="2" width="30%">Resource</th>
          </tr>
        </thead>

      <? if(count($comments) > 0): foreach($comments as $comment): ?>
        <tr>

          <td>
            <a href="<?=site_url('comment/view/' . $comment->comment_id)?>" class="btn btn-primary btn-sm">view</a>
          </td>

          <td>
            <img src="http://www.gravatar.com/avatar/<?=$comment->gravatar?>?s=30&amp;d=mm" class="img-rounded" />
          </td>

          <td>
            <?=$comment->comment_name?>
          </td>

          <td>
            <?=word_limiter(strip_tags($comment->comment_content), 40)?>
          </td>
          
          <td>
            <?=$comment->resource_title?>
          </td>

          <td>
            <a href="http://ifesworld.org/resource/<?=$comment->resource_id?>" target="_blank" class="btn btn-xs btn-primary">go &raquo;</a>
          </td>

        </tr>
      <? endforeach; endif; ?>

       </table>
       </div>

       <?=$this->pagination->create_links();?>

    </div>

  <div class="col-md-4">

    <? $this->load->view('template/goto_sidebar') ?>

  </div>

</div>