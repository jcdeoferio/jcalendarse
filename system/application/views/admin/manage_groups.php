<?=($this->uri->rsegment(3))?"<script>confirm('Delete successful')</script>":""?>
<table border='1' cellpadding='4' id='events'>
  <tr>
    <th>groupid</th>
    <th>group name</th>
	<th></th>
	<th></th>
  </tr>
  <?php foreach($groups as $group): ?>
  <tr>
    <td><?= $group['groupid'] ?></td>
    <td><?= $group['groupname'] ?></td>
	<td><?= anchor('/admin/update_group/'.$group['groupid'], 'edit') ?></td>
	<td><?= anchor('/admin/delete_group/' . $group['groupid'], 'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this group?'))")) ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php echo $this->pagination->create_links();?>