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



/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	1.5
 */

    function TZ_PinboardBuildRoute(&$query)
    {


        $segments	= array();
        // get a menu item based on Itemid or currently active
        $app		= JFactory::getApplication();
        $menu		= $app->getMenu();
        $component	= JComponentHelper::getComponent('com_tz_pinboard');
        $items		= $menu->getItems('component_id', $component->id);
        // we need a menu item.  Either the one specified in the query, or the current active one if none specified
        if (empty($query['Itemid'])) {

            $menuItem = $menu->getActive();
            $menuItemGiven = false;
        }
        else {
            $menuItem = $menu->getItem((int)$query['Itemid']);
            $menuItemGiven = true;

        }

        if (isset($query['view'])) {
            $view = $query['view'];
        }
        else {
            // we need to have a view in the query or it is an invalid URL
            return $segments;
        }



        if ( $view == 'addpinboards' || $view == 'manageruser' || $view == 'pinboard' ||$view == 'search' ||$view == 'tags' || $view=='detail')
        {

            if (!$menuItemGiven) {

                $segments[] = $view;
            }
            unset($query['view']);
            if(isset($query['task'])){

                    $task  = JApplication::stringURLSafe($query['task']);
             }
            if($view=='tags'){

                        if(isset($menuItem->query['id_tag']) && isset($query['id_tag']) && $menuItem->query['id_tag'] == $query['id_tag']){
                            unset($query['id_tag']);

                            return $segments;
                        }

                   }
            if(isset($query['id_guest']) || isset($query['id_board']) || isset($query['id_pins']) || isset($query['id_tag'])){
                            if(isset($query['id_guest'])){

                                // Make sure we have the id and the alias
                                if (strpos($query['id_guest'], ':') === false) {
                                    $aquery  = 'SELECT name FROM #__users';
                                    $aquery  .= ' WHERE id='.(int)$query['id_guest'];
                                    $db     = JFactory::getDbo();
                                    $db -> setQuery($aquery);
                                    $name    = $db -> loadResult();
                                    //Convert name of user to alias.
                                    $userAlias  = JApplication::stringURLSafe($name);

                                    $query['id_guest']    = $query['id_guest'].':'.strtolower($userAlias);
                                }
                            }

                        if(isset($query['id_board']) && !empty($query['id_board'])){
                            // Make sure we have the id and the alias
                            if (strpos($query['id_board'], ':') === false) {
                                $aquery  = 'SELECT alias FROM #__tz_pinboard_boards';
                                $aquery  .= ' WHERE id='.$query['id_board'];
                                $db     = JFactory::getDbo();
                                $db -> setQuery($aquery);
                                $alias    = $db -> loadResult();

                                $query['id_board']    = $query['id_board'].':'.$alias;
                            }
                        }

                        if(isset($query['id_pins']) && !empty($query['id_pins']) && $query['id_pins'] !="f"){

                            // Make sure we have the id and the alias
                            if (strpos($query['id_pins'], ':') === false) {

                                $aquery  = 'SELECT alias FROM #__tz_pinboard_pins';
                                $aquery  .= ' WHERE id='.$query['id_pins'];

                                $db     = JFactory::getDbo();
                                $db -> setQuery($aquery);
                                $alias    = $db -> loadResult();

                                $query['id_pins']    = $query['id_pins'].':'.$alias;
                            }
                        }

                    if(isset($query['id_tag']) && !empty($query['id_tag'])){
                                   // Make sure we have the id and the alias
                                   if (strpos($query['id_tag'], ':') === false) {
                                       $aquery  = 'SELECT name FROM #__tz_pinboard_tags';
                                       $aquery  .= ' WHERE id='.$query['id_tag'];
                                       $db     = JFactory::getDbo();
                                       $db -> setQuery($aquery);
                                       $name_t    = $db -> loadResult() ;

                                      $name_ts=JApplication::stringURLSafe($name_t);

                                       $query['id_tag']    = $query['id_tag'].':'.$name_ts;

                                   }
                               }
              }



         if($view == "addpinboards"){

             if(isset($query['task'])){

                  $segments[] = $task;
                  unset($query['task']);
             if(isset($query['id_pins'])){
                 $segments[] = $query['id_pins'];
                 unset($query['id_pins']);
              }
                 return $segments;
          }
         }

         if($view=='detail'){
              $segments[] = $view;
                 if(isset($query['id_pins'])){
                     $segments[] = $query['id_pins'];
                     unset($query['id_pins']);
                }
                  return $segments;
        }




         if($view=="manageruser"){

             if(isset($query['task']) && !empty($query['task'])){
                if($query['task'] =="edit-pin"){

                        $segments[] = 'addpinboards';
                        unset($query['task']);

                     if(isset($query['id_pins'])){
                         $segments[] = $query['id_pins'];
                         unset($query['id_pins']);
                    }
                        return $segments;
                }
             }
                 if(!isset($query['id_guest'])){
                         if(isset($query['task'])){
                             $segments[] = $view;
                             $segments[] = $task;
                             unset($query['task']);
                         }
                         if(isset($query['id_pins'])){
                                   $segments[] = $query['id_pins'];
                                   unset($query['id_pins']);
                         }
                         if(isset($query['id_board'])){
                             $segments[] = $query['id_board'];
                             unset($query['id_board']);
                         }
                        return $segments;

                 }else{

                         $segments[] = $view;
                         if(isset($query['task'])){
                                 $segments[] = $task;
                                 unset($query['task']);
                             }

                         if(isset($query['id_guest'])){
                                  $segments[] = $query['id_guest'];
                                  unset($query['id_guest']);
                              }
                     if(isset($query['id_board'])){
                                $segments[] = $query['id_board'];
                                unset($query['id_board']);
                            }

                         return $segments;
                 }


         }
          $segments[] = $view;







        if(isset($query['id_guest'])){
            $segments[] = $query['id_guest'];
            unset($query['id_guest']);
        }

        if(isset($query['id_board'])){
            $segments[] = $query['id_board'];
            unset($query['id_board']);
        }
        if(isset($query['id_pins'])){
            $segments[] = $query['id_pins'];
            unset($query['id_pins']);
        }
        if(isset($query['id_tag'])){
                   $segments[] = $query['id_tag'];
                   unset($query['id_tag']);
               }

        }


        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param	array	The segments of the URL to parse.
     *
     * @return	array	The URL attributes to be used by the application.
     * @since	1.5
     */
    function TZ_PinboardParseRoute($segments)
    {


    	$vars = array();
        $app	= JFactory::getApplication();
        $menu	= $app->getMenu();
        $item	= $menu->getActive();
        // Count route segments
        $count = count($segments);

        $vars['view']	= $segments[0];

        if($count > 1){
            $vars['task']   = str_replace(array(':','-'),'.', $segments[1]);
        }

        if($vars['view'] =='tags'){
            $vars['id_tag'] = (int)$segments[$count -1];
        }
        if($vars['view'] =='manageruser'){
        if(isset($vars['task']) && !empty($vars['task'])){
            if(!empty($vars['task']) && $vars['task'] == 'tz.edit.pins'){
                $vars['id_pins'] = (int)$segments[$count -1];

            } else  if(!empty($vars['task']) && $vars['task'] == 'tz.more.board'){
                if($count ==4){
                    $vars['id_guest'] = (int) $segments[2];
                    $vars['id_board'] = (int) $segments[$count -1];
                }else{
                    $vars['id_board'] = (int) $segments[$count -1];
                }


            }else if(!empty($vars['task'])  && $vars['task'] == 'tz.edit' || $vars['task'] =='tz.delete'){

                $vars['id_board'] = (int) $segments[$count -1];

            }else if(!empty($vars['task']) && $vars['task'] =='tz.delete.pins'){

                $vars['id_pins'] = (int) $segments[2];
                $vars['id_board'] = (int) $segments[$count -1];

            }
            else{
                 $vars['id_guest'] = (int)$segments[$count -1];
            }
        }
        }

        if($vars['view'] == "addpinboards"){

            if(!empty($vars['task']) && $vars['task'] =='edit.pin'){
                $vars['id_pins'] = (int)$segments[$count -1];
            }
        }
         if($vars['view'] == "detail"){


                $vars['id_pins'] = (int)$segments[$count -1];
            
        }







        return $vars;
    }

