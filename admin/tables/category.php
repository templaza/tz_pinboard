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

class CategoriesTableCategory extends JTable
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
	public function delete($pk = null, $children = false)
	{
        if($pk){
            $query  = 'DELETE FROM #__tz_pinboard_categories'
                .' WHERE catid = '.$pk;
            $db     = JFactory::getDbo();
            $db -> setQuery($query);
            if(!$db -> query()){
                var_dump($db -> getErrorMsg());
                return false;
            }
        }

		return parent::delete($pk, $children);
	}
}
