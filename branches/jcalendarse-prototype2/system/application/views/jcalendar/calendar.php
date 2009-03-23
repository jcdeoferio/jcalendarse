<?php echo js_calendar_script('my_form');  ?>

<?php echo js_calendar_write('entry_date', time(), true);?>
<!--
<form name="my_form">
<input type="text" name="entry_date" value="" onblur="update_calendar(this.name, this.value);" />
-->

<p><a href="javascript:void(0);" onClick="set_to_time('entry_date', '<?php echo time();?>')" >Today</a></p>

<!--
</form>
-->