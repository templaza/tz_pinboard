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

// No direct access
defined('_JEXEC') or die;

// Import JTableCategory

class TableTz_Pinboard_category extends JTableNested
{
	/**
	 * Method to delete a node and, optionally, its child nodes from the table.
	 *
	 * @param   integer  $pk        The primary key of the node to delete.
	 * @param   boolean  $children  True to delete child nodes, false to move them up a level.
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     http://docs.joomla.org/JTableNested/delete
	 * @since   2.5
	 */
        var $id = null;
       var $asset_id= null;
       var $parent_id= null;
       var $lft= null;
       var $rgt = null;
       var $level = null;
       var $path = null;
       var $extension = null;
       var $title = null;
       var $alias = null;
       var $note = null;
       var $description = null;
       var $published = null;
       var $checked_out = null;
       var $checked_out_time = null;
       var $access = null;
       var $params = null;
       var $metadesc = null;
       var $metakey = null;
       var $metadata = null;
       var $created_user_id = null;
       var $created_time = null;
       var $modified_user_id = null;
       var $modified_time = null;
       var $hits = null;
       var $language = null;
       var $version =null;
       function __construct(&$db) {
             parent::__construct('#__tz_pinboard_category','id',$db);

       }

        /**
    	 * Override check function
    	 *
    	 * @return  boolean
    	 *
    	 * @see     JTable::check
    	 * @since   11.1
    	 */
    	public function check()
    	{
    		// Check for a title.
    		if (trim($this->title) == '')
    		{
    			$this->setError(JText::_('JLIB_DATABASE_ERROR_MUSTCONTAIN_A_TITLE_CATEGORY'));
    			return false;
    		}
    		$this->alias = trim($this->alias);
    		if (empty($this->alias))
    		{
    			$this->alias = $this->title;
    		}

    		$this->alias = JApplication::stringURLSafe($this->alias);
    		if (trim(str_replace('-', '', $this->alias)) == '')
    		{
    			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
    		}

    		return true;
    	}

    /**
    	 * Overridden JTable::store to set created/modified and user id.
    	 *
    	 * @param   boolean  $updateNulls  True to update fields even if they are null.
    	 *
    	 * @return  boolean  True on success.
    	 *
    	 * @since   11.1
    	 */
    	public function store($updateNulls = false)
    	{
    		$date = JFactory::getDate();
    		$user = JFactory::getUser();

    		if ($this->id)
    		{
    			// Existing category
    			$this->modified_time = $date->toSql();
    			$this->modified_user_id = $user->get('id');
    		}
    		else
    		{
    			// New category
    			$this->created_time = $date->toSql();
    			$this->created_user_id = $user->get('id');
    		}
    		// Verify that the alias is unique
    		$table = JTable::getInstance('Tz_Pinboard_category', 'Table', array('dbo' => $this->getDbo()));
    		if ($table->load(array('alias' => $this->alias, 'parent_id' => $this->parent_id, 'extension' => $this->extension))
    			&& ($table->id != $this->id || $this->id == 0))
    		{

    			$this->setError(JText::_('JLIB_DATABASE_ERROR_CATEGORY_UNIQUE_ALIAS'));
    			return false;
    		}


    		return parent::store($updateNulls);
    	}


}
