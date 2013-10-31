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
        <li><a href="<?=site_url('blog')?>">Blog</a></li>
        <li><a href="<?=site_url('prayer')?>">Prayer</a></li>
        <li><a href="<?=site_url('event')?>">Events</a></li>
        <li><a href="<?=site_url('profile')?>">Profiles</a></li>
        <li><a href="<?=site_url('video')?>">Video</a></li>
      </ul>
      <?endif;?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://ifesworld.org" target="_blank">ifesworld.org &raquo;</a></li>
      </ul>

    </div><!--/.nav-collapse -->

  </div>


</div>

<div class="container">