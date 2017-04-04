<?php 
/**
 * @package     Content Tag Merging for Joomla
 * @subpackage  plg_tagmerging
 * @copyright   Copyright (C) MrMeo - D4J Team http://designforjoomla.com
 * @license     GPLv2 or later
 */

defined('_JEXEC') or die;

class plgSystemTagMergingInstallerScript {
	function postflight($type, $parent) {
		$element = $parent->getElement();
		$q = 'UPDATE `#__extensions` SET enabled=1 WHERE type="plugin" AND element="'.$element.'"';
		$db = JFactory::getDbo();
		$db->setQuery($q);
		$db->execute();
	}
}