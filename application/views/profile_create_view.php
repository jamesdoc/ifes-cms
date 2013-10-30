<form role="form" method="post" class="col-md-offset-4 col-md-4">

	<? if(count($locale_list > 0)): ?>
	<div class="form-group">
		<label for="cbo_locale">Select a country:</label>
		<select name="cbo_locale" id="cbo_locale" class="form-control">
			
			<? 
			$region = '0';

			foreach($locale_list as $locale): ?>
			
				<? if($region != $locale->region_name): ?>
					<optgroup label="<?=$locale->region_name?>" />
					<? $region = $locale->region_name?>
				<? endif; ?>

				<option value="<?=$locale->locale_code?>"><?=$locale->locale_name?></option>
			
			<? endforeach; ?>

		</select>
	</div>

	<button type="submit" class="btn btn-lg btn-primary btn-block">Create</button>

	<hr />

	<? endif; ?>

	<p>Profile not in the list?<br /><a href="<?=site_url('profile')?>">Perhaps it already exists...</a></p>

</form>