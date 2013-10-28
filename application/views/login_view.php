<? if(isset($error)): ?>
<div class="col-md-12">
		<div class="alert alert-block alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4>Uh oh...</h4>
			
			<p>Unauthorised access</p>
		</div>
	</div>
<? endif ?>

<form role="form" method="post" class="col-md-12">

	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="text" class="form-control" id="InputEmail1" placeholder="Enter email" name="txt_user">
	</div>

	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" id="InputPassword1" placeholder="Password" name="txt_pass">
	</div>

	<button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>

</form>