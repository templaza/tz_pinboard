<?php
/*------------------------------------------------------------------------

# TZ Pinboard Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

class ContentTableFeatured extends JTable
{
	/**
	 * @param	JDatabase	A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__content_frontpage', 'content_id', $db);
	}
}
