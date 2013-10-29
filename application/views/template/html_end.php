
</div>

<footer class="footer">
	<div class="container">

		<p>© <?=date('Y')?> IFES, une organisation déclarée à Lausanne, Suisse. IFES is a registered charity in England and Wales (247919), and a limited company (876229).</p>
		
		<ul class="footer-links">
			<li>Built on <a href="http://getbootstrap.com" target="_blank">Bootstrap</a></li>
			<li>by <a href="http://jamesdoc.com" target="_blank">James Doc</a></li>
			<li>with some WebBot help</li>
			<? if($this->session->userdata('member_id') != null): ?>
			<li class="muted">·</li>
			<li><a href="<?=site_url('logout')?>">Logout</a>?</li>
			<? endif; ?>
		</ul>
	</div>
</footer>



<script src="<?=base_url('assets/js/jquery.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>

<? if(isset($javascript)): foreach($javascript as $inject): ?>
<script src="<?=base_url('assets/js/' . $inject . '.js')?>"></script>
<? endforeach; endif; ?>

<script src="<?=base_url('assets/js/script.js')?>"></script>

</body>

</html>