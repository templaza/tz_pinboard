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

    class modTZ_Pinboard_active{


        /*
        * method get data user follow and return data Active
       */
        public static     function getDataActive(){
                $user       =     JFactory::getUser();
                $id_user    =     $user->id;
                $db         =     JFactory::getDbo();
                $sql        =     "SELECT id_guest as id from #__tz_pinboard_follow where id_user=$id_user AND folowing=1 ";
                $db  -> setQuery($sql);
                $row =  $db->loadObjectList();
                $arr = array();
                foreach($row as $item){
                    $arr[] = $item->id;
                }
                return $arr;
            }

        /*
         * Method get data Active
        */
        public static     function getActive($id,$limit){
            $user       =     JFactory::getUser();
            $id_user    =     $user->id;
            if(isset($id_user)){
                if(isset($id) && !empty($id)){
                 $id         =     implode(',',$id);
                 $id_activi  =  "where  id_user in ($id,$id_user)  order by a.id desc limit 0,$limit";
                }else{
                    $id_activi  = "where  id_user = $id_user  order by a.id desc limit 0,$limit";
                }

                    $db         =     JFactory::getDbo();
                    $sql        =     "SELECT a.active as a_active, a.id as aid, a.type as a_type, a.target as a_target,
                                              u.name as u_user, us.images as us_img, p.title as p_title
                                         From   #__tz_pinboard_active as a
                                                LEFT JOIN #__tz_pinboard_pins as p on a.target 	= p.id
                                                LEFT JOIN #__users as u on a.id_user = u.id
                                                LEFT JOIN #__tz_pinboard_users as us on u.id = us.usersid $id_activi ";

                    $db         ->      setQuery($sql);
                    $row        =       $db -> loadObjectList();
                    foreach($row as $item){
                        if($item->a_type=='follow'){
                                $sql = "select u.name as u_name
                                        from #__tz_pinboard_pins as p left join #__users as u on p.created_by = u.id
                                        where p.created_by = $item->a_target";
                                $db         ->      setQuery($sql);
                                $rows        =       $db -> loadObject();
                                $item->follow = $rows->u_name;
                        }
                    }
                    return $row;
            }
        }

    }


?>