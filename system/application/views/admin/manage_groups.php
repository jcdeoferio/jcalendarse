<?php echo ($this->uri->rsegment(3))?"<script>confirm('Delete successful')</script>":"";
$tmpl = array ( 'table_open'  => '<table id="events" border="1" cellpadding="4">' );
$this->table->set_template($tmpl);
$this->table->set_heading('groupid','group name','','');
foreach($groups as $group){
	$this->table->add_row($group['groupid'],$group['groupname'],anchor('/admin/update_group/'.$group['groupid'], 'edit'),anchor('/admin/delete_group/'.$group['groupid'], 		'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this group?'))")));
}
echo $this->table->generate().$this->pagination->create_links();
?>