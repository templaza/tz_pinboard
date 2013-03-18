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
    defined('_JEXEC') or die;
    class modTz_Pinboard_add{

        public static function getBoard(){   // show board
                      $user = JFactory::getUser();
                      $id = $user->id;
                      $db = JFactory::getDbo();
                      $sqk = " select id, title from #__tz_pinboard_boards where created_user_id=$id";
                      $db->setQuery($sqk);
                      $row = $db->loadObjectList();
                      return $row;
                }
        public static function getCheckuser(){
                     $user = JFactory::getUser();
                     $id = $user->id;
                     return $id;
                }
    }



?>