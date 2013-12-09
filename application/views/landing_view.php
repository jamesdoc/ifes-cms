<div class="jumbotron">
	<div class="container">
		<h1>Content management system</h1>
		<p>This will hopefully make everything a bit simpler...</p>
		<!--<p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>-->
	</div>
</div>

<div class="container">

  <div class="row">

  	<? if($this->session->userdata('access') == '5' || in_array('blog', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Blog post</h2>
      <p><a class="btn btn-primary btn-block" href="blog/new">New blog post &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="blog">View / edit / delete &raquo;</a></p>
    </div>
	<? endif ;?>

	<? if($this->session->userdata('access') == '5' || in_array('prayer', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Prayer Diary</h2>
      <p><a class="btn btn-block btn-info" href="prayer/new">New prayer item &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="prayer">View / edit / delete &raquo;</a></p>
      <p>Add weekly prayer points to the IFES prayer diary. Visible at <a href="http://ifesworld.org/pray">ifesworld.org/pray</a>.</p>
    </div>
	<? endif ?>

	<? if($this->session->userdata('access') == '5' || in_array('event', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Event</h2>
      <p><a class="btn btn-block btn-info" href="event/new">New event &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="event">View / edit / delete &raquo;</a></p>
      <p>International, regional or movement events.</p>
    </div>
	<? endif; ?>

  </div>

  <div class="row">

  <? if($this->session->userdata('access') == '5' || in_array('profile', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Profiles</h2>
      <p><a class="btn btn-info btn-block" href="profile/new">New country profile &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="profile">View / edit / delete &raquo;</a></p>
      <p>Create or update the content on main country pages.</p>
    </div>
	<? endif; ?>

	<? if($this->session->userdata('access') == '5' || in_array('video', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Video</h2>
      <p><a class="btn btn-block btn-info" href="video/new">New video &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="video">View / edit / delete &raquo;</a></p>
      <p>Upload or amend a video in the media section</p>
    </div>
	<? endif; ?>

  <? if($this->session->userdata('access') == '5' || in_array('audio', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Audio</h2>
      <p><a class="btn btn-block btn-info" href="audio/new">New Audio Recording &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="audio">View / edit / delete &raquo;</a></p>
      <p>Add or amend audio content in the media section</p>
    </div>
  <? endif; ?>

  </div>

</div>

<hr />

<div class="container">

  <div class="row">

    <? if($this->session->userdata('access') == '5' || in_array('bloggers', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>IFES Bloggers</h2>
      <p><a class="btn btn-info btn-block" href="bloggers/create">Add new blogger &raquo;</a></p>
      <p><a class="btn btn-default btn-block" href="bloggers">View / edit / remove &raquo;</a></p>
      <p>View a list of all the current IFES bloggers</p>
    </div>
  <? endif; ?>

	<? if($this->session->userdata('access') == '5' || in_array('comment', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Comments</h2>
      <p><a class="btn btn-info btn-block" href="comment">Moderate comments &raquo;</a></p>
      <p>Approve, hide or delete offending comments</p>
    </div>
  <? endif; ?>

  <? if($this->session->userdata('access') == '5' || in_array('addressbook', $this->session->userdata('module'))): ?>
    <div class="col-lg-4">
      <h2>Address book</h2>
      <p><a class="btn btn-info btn-block" href="addressbook">Update contact details &raquo;</a></p>
    </div>
  <? endif; ?>

  </div>

</div>