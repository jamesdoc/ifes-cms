<div class="jumbotron robot_green">
	<div class="container">
		<h1>Address book</h1>
	</div>
</div>

<div class="row">

    <div class="col-md-8">
      
      <div class="table-responsive">
      <table class="table table-striped">
         
        <thead>
          <tr>
            <th>Action</th>
            <th colspan="2">Name & Locale</th>
            <th width="40%">Main contact</th>
          </tr>
        </thead>

      <? foreach($addresses as $address): ?>
        <tr>

          <td>
            <a href="<?=site_url('addressbook/edit/' . $address->movement_id)?>" class="btn btn-primary btn-sm">Edit</a>
          </td>

          <td>
            <?=$address->name_short?>
          </td>

          <td>
            <?=$address->locale?>  <? if($address->locale_root != ''):?>[<?=strtoupper($address->locale_root)?>]<?endif;?>
          </td>

          <td>
            <?=$address->contact_person?> <? if($address->role != '') {echo ' (' . $address->role . ')';} ?>
          </td>

        </tr>
      <? endforeach; ?>

       </table>
       </div>


    </div>

  <div class="col-md-4">

    <? $this->load->view('template/goto_sidebar') ?>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">James Doc's top tip:</h3>
      </div>

      <div class="panel-body">
        <p>Press Ctrl/&#8984;+F to search</p>
      </div>
    </div>

  </div>

</div>