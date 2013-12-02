<div class="panel panel-primary">

	<div class="panel-heading">

		<h3 class="panel-title">Go to...</h3>

	</div>

	<div class="panel-body">
		
		<? if($this->session->userdata('access') == '5' || in_array('blog', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('blog')?>">Blog</a>
		<? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('prayer', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('prayer')?>">Prayer Diary</a>
		<? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('event', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('event')?>">Events</a>
		<? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('profile', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('profile')?>">Profiles</a>
		<? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('video', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('video')?>">Video</a>
		<? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('audio', $this->session->userdata('module'))): ?>
		<p><a href="<?=site_url('audio')?>">Audio</a>
		<? endif ?>


		<? if($this->session->userdata('access') == '5' || in_array('comment', $this->session->userdata('module'))): ?>
		<hr />
		<p><a href="<?=site_url('comment')?>">Comment moderation</a>
		<? endif ?>

	</div>
	
</div>