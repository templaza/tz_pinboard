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

    abstract class TZ_PinboardHelperRoute{
        protected static $lookup;

        public static function getPinboardManageruserRoute($id_guest=null,$id_pins=null){
            $needles = array(
                    'manageruser'  => 1
                );
            $user = JFactory::getUser();
                       $id = $user->id;
            if(isset($id_guest) && !empty($id_guest)){
                if($id != $id_guest ){
                        $link="index.php?option=com_tz_pinboard&amp;view=manageruser&amp;id_guest=".$id_guest;
                }else{
                    $link="index.php?option=com_tz_pinboard&amp;view=manageruser";
                }
            }else if(isset($id_pins) && !empty($id_pins)){
                $link="index.php?option=com_tz_pinboard&amp;view=manageruser&amp;task=tz.edit.pins&amp;id_pins=".$id_pins;
            }else{

                $link="index.php?option=com_tz_pinboard&amp;view=manageruser";
            }

            if ($item = self::_findItem($needles)) {
           			$link .= '&Itemid='.$item;
           		}
           		elseif ($item = self::_findItem()) {
           			$link .= '&Itemid='.$item;
           		}

            return $link;
        }
        public static function getPinboardManagetuset2($id_pins=null,$id_guest,$id_board){
            $needles = array(
                       'manageruser'  => 1
                   );
            $user = JFactory::getUser();
              $id = $user->id;
               if(isset($id_pins) && !empty($id_pins)){
                   $link="index.php?option=com_tz_pinboard&amp;task=tz.edit.pins&amp;view=manageruser&amp;id_pins=".$id_pins;
               }else if(isset($id_guest) && !empty($id_guest) && isset($id_board) && !empty($id_board)){
                if($id != $id_guest){
                   $link="index.php?option=com_tz_pinboard&amp;view=manageruser&amp;task=tz.more.board&amp;id_guest=".$id_guest."&amp;id_board=".$id_board;
                }else{
                    $link="index.php?option=com_tz_pinboard&amp;view=manageruser&amp;task=tz.more.board&amp;id_board=".$id_board;
                }
               }

               if ($item = self::_findItem($needles)) {
                        $link .= '&amp;Itemid='.$item;
                    }
                    elseif ($item = self::_findItem()) {
                        $link .= '&amp;Itemid='.$item;
                    }

               return $link;
        }
        public static function getPinboardTagsRoute($id){
                    $needles = array(
                            'tags'  =>array((int) $id)
                        );

                        $link="index.php?option=com_tz_pinboard&amp;view=tags&amp;id_tag=".$id;


                    if ($item = self::_findItem($needles)) {
                   			$link .= '&amp;Itemid='.$item;
                   		}
                   		elseif ($item = self::_findItem()) {
                   			$link .= '&amp;Itemid='.$item;
                   		}

                    return $link;
                }
          public static function getPinboardDetailRoute($id){
                    $needles = array(
                            'detail'  =>array((int) $id)
                        );
                     $link ="index.php?option=com_tz_pinboard&amp;view=detail&amp;id_pins=".$id;

                    if ($item = self::_findItem($needles)) {

                   			$link .= '&amp;Itemid='.$item;
                   		}
                   		elseif ($item = self::_findItem()) {

                   			$link .= '&amp;Itemid='.$item;
                   		}

                    return $link;
                }
        public  static  function getAddpinboard($id){
            $needles = array(
                  'addpinboards'  =>array((int) $id)
              );
                $link="index.php?option=com_tz_pinboard&amp;view=addpinboards&amp;task=edit.pin&id_pins=".$id;
               if ($item = self::_findItem($needles)) {
                        $link .= '&amp;Itemid='.$item;
                    }
                    elseif ($item = self::_findItem()) {
                        $link .= '&amp;Itemid='.$item;
                    }

               return $link;
        }

        protected static function _findItem($needles = null)
        	{
        		$app		= JFactory::getApplication();

        		$menus		= $app->getMenu('site');
                $active     = $menus->getActive();
                $component	= JComponentHelper::getComponent('com_tz_pinboard');


                 $items		= $menus->getItems('component_id', $component->id);
        		// Prepare the reverse lookup array.
        		if (self::$lookup === null)
        		{
        			self::$lookup = array();



        			foreach ($items as $item)
        			{

        				if (isset($item->query) && isset($item->query['view']))
        				{
        					$view = $item->query['view'];

        					if (!isset(self::$lookup[$view])) {
        						self::$lookup[$view] = array();
        					}
                            if ($active && $active->component == 'com_tz_pinboard') {
                                if (isset($active->query) && isset($active->query['view'])){

                                    if (isset($active->query['id'])) {
                                        self::$lookup[$active->query['view']][$active->query['id']] = $active->id;
                                    }
                                }
                            }
        				}
        			}
        		}
                if ($needles)
               		{

               			foreach ($needles as $view => $ids)
               			{

               				if (isset(self::$lookup[$view]))
               				{

                               if($view == 'manageruser'){
                                   foreach ($items as $item)
                                  {

                                      if($view == $item -> query['view']){
                                          $Itemid   = $item -> id;
                                          return $Itemid;
                                      }
                                  }

                               } else if($view =='tags'){

                                   foreach ($items as $item)
                                         {

                                             if(isset($item -> query['id_tag']) && !empty($item -> query['id_tag'])){
                                               foreach($ids as  $id){
                                                 if($id == (int)$item -> query['id_tag']){
                                                     $Itemid   = $item -> id;
                                                     return $Itemid;
                                                 }

                                                 }

                                             }

                                         }
                                   return $component->params->get('mymenuitem');
                               }else if($view == 'addpinboards'){
                                   foreach ($items as $item)
                                    {

                                        if($view == $item -> query['view']){
                                            $Itemid   = $item -> id;
                                            return $Itemid;
                                        }
                                    }
                               }else if($view=="detail"){
                                    foreach ($items as $item)
                                    {

                                        if($view == $item -> query['view']){
                                            $Itemid   = $item -> id;
                                            return $Itemid;
                                        }
                                    }


                               }
               					foreach($ids as  $id)
               					{
               						if (isset(self::$lookup[$view][(int)$id])) {
               							return self::$lookup[$view][(int)$id];
               						}
               					}
               				}
               			}
               		}
               		else
               		{
               			if ($active && $active->component == 'com_tz_pinboard') {
               				return $active->id;
               			}
               		}


        		return null;
        	}



    }

?>