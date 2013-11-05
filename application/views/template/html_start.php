<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="robots" content="noindex">


  <title><?=(isset($title) ? $title : 'IFES CMS') ?></title>

  <link rel="icon" href="<?=site_url('favicon.ico')?>" type="image/x-icon">

  <!-- Bootstrap core CSS -->
  <link href="<?=site_url('assets/css/bootstrap.css')?>" rel="stylesheet">
  <link href="<?=site_url('assets/css/custom.css')?>" rel="stylesheet">
  <? if(isset($css)): foreach($css as $inject): ?>
  <link href="<?=site_url('assets/css/' . $inject . '.css')?>" rel="stylesheet">
  <? endforeach; endif; ?>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../../assets/js/html5shiv.js"></script>
  <script src="../../assets/js/respond.min.js"></script>
  <![endif]-->

</head>

<body>

<div class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=site_url()?>"><img src="<?=site_url('assets/images/logo.png')?>" height="18" /></a>
    </div>
    <div class="collapse navbar-collapse">
      <? if($this->session->userdata('member_id') != null): ?>
      <ul class="nav navbar-nav">
        <li><a href="<?=site_url()?>">Home</a></li>
        
        <? if($this->session->userdata('access') == '5' || in_array('blog', $this->session->userdata('module'))): ?>
        <li><a href="<?=site_url('blog')?>">Blog</a></li>
        <? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('prayer', $this->session->userdata('module'))): ?>
        <li><a href="<?=site_url('prayer')?>">Prayer</a></li>
        <? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('event', $this->session->userdata('module'))): ?>
        <li><a href="<?=site_url('event')?>">Events</a></li>
        <? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('profile', $this->session->userdata('module'))): ?>
        <li><a href="<?=site_url('profile')?>">Profiles</a></li>
        <? endif ?>

		<? if($this->session->userdata('access') == '5' || in_array('video', $this->session->userdata('module'))): ?>
        <li><a href="<?=site_url('video')?>">Video</a></li>
        <? endif ?>
      </ul>
      <?endif;?>

      <? if($this->session->userdata('member_id') != null): ?>
      <form class="navbar-form navbar-right" method="get" action="<?=site_url('search')?>">
        <div class="form-group">
          <input type="text" placeholder="Query" class="form-control" name="for">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
      <? else: ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://ifesworld.org" target="_blank">ifesworld.org »</a></li>
      </ul>
      <?endif;?>
    

    </div><!--/.nav-collapse -->

  </div>


</div>

<div class="container">