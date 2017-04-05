<?php 

defined('_JEXEC') or die;
?>

<div id="mergingModal" class="modal hide fade">
	<div class="modal-header">
			<button type="button" class="close novalidate" data-dismiss="modal">×</button>
				<h3>Select tags to merger</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span6">
				<?php echo $this->form->renderField('original_tags') ?>
			</div>
			<div class="span6">
				<?php echo $this->form->renderField('target_tag') ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a class="btn" type="button" data-dismiss="modal"><?php echo JText::_('JCANCEL'); ?></a>
		<button class="btn btn-success" type="submit" onclick="Joomla.submitbutton('tag.merging');">
		<?php echo JText::_('Merge tags'); ?>
		</button>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	$('#merging-btn').on('click', function() {
		$('#mergingModal').modal('show');
	});
});	
</script>