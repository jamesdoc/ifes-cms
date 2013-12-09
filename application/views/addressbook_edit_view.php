<div class="jumbotron robot_green">
	<div class="container">
		<h1>Address book</h1>
	</div>
</div>

<form class="row" id="edit_addressbook_form" method="post">

    <div class="col-md-8">

      <? if(isset($error)):?>
      <div class="alert alert-danger"><strong>Urgh.</strong> There was some problems with the saving...<br /><br />Here are the details: <?print_r($error)?></div>
      <? endif;?>
      
      <div class="panel panel-primary">

        <div class="panel-heading">
          <h3 class="panel-title">Address book</h3>
        </div>

        <div class="panel-body">

          <div class="form-group">
            <label for="txt_title">Country or Region</label>
            <select name="country_region" id="country_region" class="form-control">
            <? foreach($locale_list as $locale): ?>

              <option value="<?=$locale->locale_code?>"<?=($contact->locale_code==$locale->locale_code ? " selected" : "")?>><?=$locale->locale_name?></option>
            
            <? endforeach; ?>
            </select>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="name_short">Short name</label>
              <input type="text" name="name_short" value="<?=$contact->name_short?>" class="form-control" placeholder="IFES" />
            </div>

            <div class="form-group col-md-6">
              <label for="name_full">Long name</label>
              <input type="text" name="name_full" value="<?=$contact->name_full?>" class="form-control" placeholder="Eye Fees" />
            </div>
          </div>

          <hr />

          <div class="row">
            <div class="form-group col-md-6">
              <label for="contact_person">Main contact</label>
              <input type="text" name="contact_person" value="<?=$contact->contact_person?>" class="form-control" placeholder="Harold" />
            </div>

            <div class="form-group col-md-6">
              <label for="contact_person_role">Contact role</label>
              <select name="contact_person_role" id="contact_person_role" class="form-control">
                <?// Someone should make this look prettier //?>
                <option value="null">No title</option>
                <option value="1"<? if($contact->role == 'General Secretary') {echo ' selected';} ?>>General Secretary</option>
                <option value="2"<? if($contact->role == 'Regional Secretary') {echo ' selected';} ?>>Regional Secretary</option>
                <option value="3"<? if($contact->role == 'Board Chair') {echo ' selected';} ?>>Board Chair</option>
                <option value="4"<? if($contact->role == 'Acting General Secretary') {echo ' selected';} ?>>Acting General Secretary</option>
                <option value="5"<? if($contact->role == 'National Director') {echo ' selected';} ?>>National Director</option>
                <option value="6"<? if($contact->role == 'Office Manager') {echo ' selected';} ?>>Office Manager</option>
                <option value="7"<? if($contact->role == 'Co-General Secretary') {echo ' selected';} ?>>Co-General Secretary</option>
                <option value="8"<? if($contact->role == 'National Coordinator') {echo ' selected';} ?>>National Coordinator</option>
                <option value="9"<? if($contact->role == 'Acting Regional Secretary') {echo ' selected';} ?>>Acting Regional Secretary</option>
                <option value="10"<? if($contact->role == 'Main Contact') {echo ' selected';} ?>>Main Contact</option>
                <option value="11"<? if($contact->role == 'President') {echo ' selected';} ?>>President</option>
                <option value="12"<? if($contact->role == 'Representing IFES North America') {echo ' selected';} ?>>Representing IFES North America</option>
                <option value="13"<? if($contact->role == 'Representing IFES South Pacific') {echo ' selected';} ?>>Representing IFES South Pacific</option>
                <option value="14"<? if($contact->role == 'Acting National Director') {echo ' selected';} ?>>Acting National Director</option>
              </select>
            </div>
          </div>

          <hr />

          <div class="form-group">
            <label for="txt_bio" id="lblBio">Address</label>
            <textarea name="contactDetail[]" id="contactDetail[]" class="form-control" rows="4"><?if(isset($contact->contactDetails['postal'])){echo $contact->contactDetails['postal'];}?></textarea>
            <input type="hidden" name="contactDetailType[]" value="postal" />
            <div class="form-group">
              <select name="office_locale" id="office_locale" class="form-control">
              <? foreach($locale_list as $locale): ?>

                <option value="<?=$locale->locale_code?>"<?=($contact->office_locale_code==$locale->locale_code ? " selected" : "")?>><?=$locale->locale_name?></option>
              
              <? endforeach; ?>
              </select>
            </div>
            <? unset($contact->contactDetails['postal']);?>
            <? unset($contact->contactDetails['latlng']);?>
          </div>

          <hr />


          <div class="row">
            
            <div class="form-group col-md-8">
              <label>Contact detail</label>
            </div>

            <div class="form-group col-md-4">
              <label>Contact type</label>
            </div>
          </div>

          <? $i = 1; if(isset($contact->contactDetails)): foreach($contact->contactDetails as $type=>$detail): ?>
            <div class="row">
              <div class="form-group col-md-8">
                <input type="text" name="contactDetail[]" placeholder="<?=$this->lang->line('addressbook_form_lblEmail');?>" value="<?=$detail?>"  class="form-control contactDetail"/>
              </div>

              <div class="form-group col-md-4">
                <select name="contactDetailType[]" class="form-control">
                  <? foreach($contact_options as $key=>$contact_option): ?>
                  <option value="<?=$key?>" <?if($key==$type){echo 'selected';}?>><?=$contact_option?></option>
                  <? endforeach; ?>
                </select>
              </div>
            </div>
          <? $i++; reset($contact_options); endforeach; endif; ?>

          <? $c=1; while($i <= 8 && $c <= 2): ?>
            <div class="row">
              <div class="form-group col-md-8">
                <input type="text" name="contactDetail[]" placeholder="" value="" class="form-control contactDetail" />
              </div>

              <div class="form-group col-md-4">
                <select name="contactDetailType[]" class="form-control">
                  <? foreach($contact_options as $key=>$contact_option): ?>
                  <option value="<?=$key?>"><?=$contact_option?></option>
                  <? endforeach; ?>
                </select>
              </div>
            </div>
          <? $i++; $c++; reset($contact_options); endwhile; ?>

       
          

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
        <a href="<?=site_url('addressbook')?>" class="btn btn-primary btn-block">View a list of all movements</a>
      </div>
    </div>

  </div>

</form>