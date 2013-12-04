<div class="jumbotron robot_red">
	<div class="container">
		<h1>IFES bloggers</h1>
	</div>
</div>

<form class="row" id="edit_blogger_form" method="post">

    <div class="col-md-8">
      
      <div class="panel panel-primary">

        <div class="panel-heading">
          <h3 class="panel-title">Comment</h3>
        </div>

        <div class="panel-body">

          <div class="form-group">
            <label for="txt_title">Name</label>
            <input type="text" name="txt_knownas" value="<?=$blogger->knownas?>" class="form-control" placeholder="Harold" />
          </div>

          <div class="form-group">
            <label for="txt_title">Country</label>
            <select name="cbo_locale" id="cbo_locale" class="form-control">
            <? foreach($locale_list as $locale): ?>

              <option value="<?=$locale->locale_code?>"<?=($blogger->locale_code==$locale->locale_code ? " selected" : "")?>><?=$locale->locale_name?></option>
            
            <? endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="txt_bio" id="lblBio">Biography</label>
            <textarea name="txt_bio" id="txt_bio" class="form-control"><?=$blogger->bio?></textarea>
          </div>

          <div class="form-group">
            <label for="txt_title">Email address</label>
            <input type="text" value="<?=$blogger->email_primary?>" class="form-control" placeholder="Harold" disabled />
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
        <button type="submit" class="btn btn-success btn-block">Save changes</button>
        <a href="#" class="btn btn-danger btn-block btn-remove-blogger">Remove blogger</a>
        <hr />
        <a href="http://ifesworld.org/blog/author/<?=$blogger->username?>" class="btn btn-info btn-block" target="_blank">View all posts by <?=$blogger->knownas?></a>
      </div>
    </div>

    <div class="panel panel-primary">

      <div class="panel-heading">

        <h3 class="panel-title">Back...</h3>

      </div>

      <div class="panel-body">

        <p><a href="<?=site_url('bloggers')?>" class="btn btn-primary btn-block">View a list of all bloggers</a>

      </div>
      
    </div>

  </div>

</form>