
</div>

<script src="<?=base_url('assets/js/jquery.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>

<? if(isset($javascript)): foreach($javascript as $inject): ?>
<script src="<?=base_url('assets/js/' . $inject . '.js')?>"></script>
<? endforeach; endif; ?>

<script src="<?=base_url('assets/js/script.js')?>"></script>

<script>
$('#datetimepicker_published_dt').datepicker();
</script>

</body>

</html>