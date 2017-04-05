<?php 

defined('_JEXEC') or die;

class PlgSystemTagMerging extends JPlugin {

	function onAfterInitialise() {
		$isTagsView = $this->isTagsView();
		if (!$isTagsView ) {
			return;
		}
		
		$app = JFactory::getApplication();
		$input = $app->input;
		$task = $input->get('task');
		if ($task === 'tag.merging') {
			$original = $input->get('original_tags');
			if(empty($original)) {
				$app->enqueueMessage('Please pick a tag to merge', 'error');
				return;
			}
			$target = $input->get('target_tag');
			if(empty($target)) {
				$app->enqueueMessage('Please select target tag to merge', 'error');
				return;
			}
			if($merge = $this->mergeTag($original, $target)) {
				$app->enqueueMessage('Merge tags successfully');
			}
		}
	}
	
	function onBeforeRender() {
		$isTagsView = $this->isTagsView();
		if (!$isTagsView ) {
			return;
		}
		$path = __DIR__ . '/toolbars/merging.php';
		ob_start();
		include $path;
		$output = ob_get_clean();
		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Custom', $output, 'batch');
	}

	function OnAfterRender() {
		$isTagsView = $this->isTagsView();
		if (!$isTagsView) {
			return;
		}
		$app = JFactory::getApplication();
		$path = JPluginHelper::getLayoutPath('system', 'tagmerging');
		$this->form = $this->getForm();
		ob_start();
		include $path;
		$output = ob_get_clean();

		$content = $app->getBody();
		$pattern = '/method="post" name="adminForm" id="adminForm">/';
		$replace = '$0' . $output ;
		$content = preg_replace($pattern, $replace, $content);
		$app->setBody($content);
	}
	
	function isTagsView() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$option = $input->get('option');
		$view = $input->get('view');
		if ($app->isAdmin() && $option === 'com_tags' && (empty($view) || $view === 'tags')) {
			return true;
		} else {
			return false;
		}
	}
	
	function getForm() {
		$path = __DIR__. '/forms/tag.xml';
		$form = JForm::getInstance('myform', $path);
		return $form;
	}

	function mergeTag($original, $target) {
		$db = JFactory::getDbo();
		$q = "update #__contentitem_tag_map";
		$q .= ' set tag_id='.$target;
		$q .= ' where tag_id in ('. implode(',', $original).')';
		$q .= ' and type_alias="com_content.article"';
		$db->setQuery($q);
		return $db->execute();
	}
}
