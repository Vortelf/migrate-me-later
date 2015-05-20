

<?php $attributes = array('id' => 'json');?>
<?php echo form_open($redirect_uri,$attributes); ?>


	<?php echo form_hidden('json',$json)?>

<?php echo form_close();?>
<script type="text/javascript">
	document.getElementById('json').submit();
</script>