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
defined("_JEXEC") or die;


class TZ_PinboardModelDetail extends JModelList
{

    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        $this->setState('params', $params);
        $show_date_comment = $params->get('show_date_comment');
        $page_commnet = $params->get('page_commnet_detail');
        $detail_image_size = $params->get('pinboard_image_size');
        $delete_text_cm = $params->get('remove_comment');
        $change_comment = $params->get('changecomment');
        $state_comment = $params->get('state_comment');
        $limit_commnet = $params->get('Limits_comment');
        $show_tags_detail = $params->get('show_tags_detail');
        $show_tags_title = $params->get('show_tags_title');
        $type_detail = $params->get('type_detail');
        $text_web = $params->get('text_web');
        $comment_detail = $params->get('comment_detail');
        $button_D = $params->get('button_detail');
        $ds_detial = $params->get('ds_detail');
        $name_board = $params->get('name_board_d');
        $date_d = $params->get('date_d');
        $web_d = $params->get('web_d');
        $img_user = $params->get('imgUser_d');
        $show_social = $params->get('tz_show_social');
        $this->setState('social', $show_social);
        $this->setState('img_user', $img_user);
        $this->setState('web_d', $web_d);
        $this->setState('date_d', $date_d);
        $this->setState('name_b', $name_board);
        $this->setState('ds_detail', $ds_detial);
        $this->setState('button_d', $button_D);
        $this->setState('s_detail', $comment_detail);
        $this->setState('text_webs', $text_web);
        $this->setState('type_details', $type_detail);
        $this->setState('show_date', $show_date_comment);
        $this->setState('pinboard_image_size', $detail_image_size);
        $this->setState('show_tags_title', $show_tags_title);
        $this->setState('show_tags_detail', $show_tags_detail);
        $this->setState('remove_comment', $delete_text_cm);
        $this->setState('change_comment', $change_comment);
        $this->setState('state_comment', $state_comment);
        $this->setState('Limits_comment', $limit_commnet);
        $this->setState('page_cm', $page_commnet);
        $this->setState('star_page_cm', 0);
    }

    /*
    * method check user rights
    */
    function getAuthorize()
    {
        $mainframe = JFactory::getApplication();
        $option = 'com_tz_pinboard';
        $params = $mainframe->getParams($option);
        $modticket = $params->get('modticket', array());
        $user = JFactory::getUser();
        $groups = JAccess::getGroupsByUser($user->id);
        if (!count($modticket) || !count($groups)) {
            return false;
        }

        foreach ($modticket as $mod) {
            foreach ($groups as $group) {
                if (intval($mod) == intval($group)) {
                    return true;
                }
            }
        }

    }

    /*
     * function display detail pin
    */
    function  getDetailPins()
    {
        $id_content = JRequest::getInt('id_pins');
        $this->updateHist();
        if ($id_content == 'f') return false;
        if (isset($id_content) && !empty($id_content)) {
            $db = JFactory::getDbo();
            $sql = "SELECT u.id as id_user, u.name as name_user, tz_u.images as img_user,
                                        ca.id as category_id,  ca.title as boar_title,
                                        c.title as conten_title, c.introtext as content_introtext,  c.state as c_state,
                                        c.id as content_id, c.created as c_created, c.attribs as c_attribs, pz.video as pz_video,
                                       pz.images as poro_img, w.url as website
                                  FROM #__users AS u  LEFT join  #__tz_pinboard_users as tz_u  on tz_u.usersid  = u.id
                                          LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                          LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                          LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                          LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                  WHERE  c.id=$id_content";
            $db->setQuery($sql);
            $row = $db->loadObject();

            $follows = $this->checkFollow($row->id_user);
            $row->follow = $follows;
            $tangs = $this->DetailTag($row->content_id);
            $row->tags = $tangs;
            $check_like = $this->chekcLikeUser($row->content_id);
            $row->check_like = $check_like;

            return $row;
        }

    }

    /*
     * Method check users like or not
     */
    function  chekcLikeUser($id_content)
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "select like_p as p from #__tz_pinboard_like where id_content=$id_content AND id_user_p =$id_user";
        $db->setQuery($sql);
        $row = $db->loadAssoc();
        return $row;
    }


    /*
     * method check user follow?
    */
    function checkFollow($id_guest)
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "select folowing as f from #__tz_pinboard_follow where id_user=$id_user AND id_guest=$id_guest ";
        $db->setQuery($sql);
        $row = $db->loadAssoc();
        return $row;
    }

    function DetailTag($id)
    {
        $db = JFactory::getDbo();
        $sql = "select t.id as tagid, t.name as tagname
                        from  #__tz_pinboard_tags AS t
                          LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                        WHERE tx.contentid =$id";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    function updateHist()
    {
        $id_content = JRequest::getInt('id_pins');
        $db = JFactory::getDbo();
        $sql = "update #__tz_pinboard_pins set hits = hits+1 where  id=$id_content";
        $db->setQuery($sql);
        $db->query();
    }

    function getSosanhuser()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        return $id_user;
    }

    /*
     * method insert active comment
    */
    function InsertActiveComment()
    {
        $id_content = strip_tags(htmlspecialchars($_POST['id_pins']));
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "INSERT INTO #__tz_pinboard_active  VALUES(NULL,'c','" . $id_content . "','" . $id_user . "','content') ";
        $db->setQuery($sql);
        $db->query();
    }

    /*
     * function count the number of comment
    */
    function getDemcommnet()
    {
        $id_conten = JRequest::getInt('id_pins');
        $db = JFactory::getDbo();
        $sql = "select count(id) as number_id from #__tz_pinboard_comment where content_id =$id_conten";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    // display comment
    function getShowCommnet()
    {
        $id_conten = JRequest::getInt('id_pins');
        $limit_star = $this->getState('star_page_cm');
        $limit = $this->getState('page_cm');
        $db = JFactory::getDbo();
        $sql = "SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
                              c.created_by as create_by
                        FROM #__users AS u
                            LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                            LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
                            LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
                        WHERE cm.content_id =$id_conten AND cm.state=1 AND cm.checkIP=1  order by cm.id desc limit $limit_star,$limit";

        $db->setQuery($sql);
        if ($row = $db->loadObjectList()) {
            return $row;
        }
        return false;

    }

    function  checkInsertComment()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $IP = $_SERVER['REMOTE_ADDR'];
        $db = JFactory::getDbo();
        $sql = "select checkIP FROM #__tz_pinboard_comment WHERE id_user=$id_user and IP ='" . $IP . "' limit 0,1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    function Insert_comment_Content()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if (isset($url_arr['port']) &&  $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        $id_content = strip_tags(htmlspecialchars(JRequest::getInt('id_pins')));
        $content_cm = strip_tags(htmlspecialchars(JRequest::getString('content')));
        $content_cm = str_replace("'", "\'", $content_cm);
        $delete_text = $this->getState('remove_comment');
        $change_comment = $this->getState('change_comment');
        $arr_commnet = explode(",", $delete_text);
        $arr_commnet = array_map("trim", $arr_commnet);
        $commnet_replace = str_replace($arr_commnet, $change_comment, $content_cm);
        $state = $this->getState('state_comment');
        $IP = $_SERVER['REMOTE_ADDR'];
        $user = JFactory::getUser();
        $id_user = $user->id;
        $dt = JFactory::getDate();
        $dtime = $dt->toSql();
        $db = JFactory::getDbo();
        $checkIP = $this->checkInsertComment();
        if ($checkIP == "") {
            $sql = "INSERT INTO #__tz_pinboard_comment VALUES('NULL','" . $commnet_replace . "', '$id_content', '$id_user','" . $state . "','" . $dtime . "','" . $IP . "','1')";
        } else {
            $checkIP = $this->checkInsertComment()->checkIP;
            $sql = "INSERT INTO #__tz_pinboard_comment VALUES('NULL','" . $commnet_replace . "', '$id_content', '$id_user','" . $state . "','" . $dtime . "','" . $IP . "','.$checkIP.')";
        }
        $db->setQuery($sql);
        $db->query();
    }

    function getShowcommnetInsert()
    {

        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $content_id = JRequest::getInt('id_pins');
        $sql = "SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
                                   c.created_by as create_by
                            FROM #__users AS u
                                    LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                                    LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
                                    LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
                            WHERE cm.content_id =$content_id  AND cm.id_user =$id_user AND cm.state=1 AND cm.checkIP=1 order by cm.id desc limit 0,1";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    function DeleteCommnet()
    {
        $id_cm = $_POST['id'];
        $db = JFactory::getDbo();
        $sql = "delete from #__tz_pinboard_comment where id=$id_cm";
        $db->setQuery($sql);
        $db->query();
    }

    function ajaxcomment()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if ( isset($url_arr['port']) &&  $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        $this->Insert_comment_Content();
        $this->InsertActiveComment();
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'detail' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewDetail();
        $showdate = $this->getState('show_date');
        $view->assign('show_date', $showdate);
        $view->assign('sosanhuser', $this->getSosanhuser());
        $view->assign('ShowCommnet', $this->getShowcommnetInsert());
        $arr = array();
        $arr['contents'] = $view->loadTemplate('comment');
        $arr['count_number'] = $this->getDemcommnet()->number_id;
        return $arr;
    }

    function ajaxdeletecomment()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if (isset($url_arr['port']) &&  $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        $this->DeleteCommnet();
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'detail' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewDetail();
        $showdate = $this->getState('show_date');
        $view->assign('show_date', $showdate);
        $view->assign('sosanhuser', $this->getSosanhuser());
        $view->assign('ShowCommnet', $this->getShowCommnet());
        $arr = array();
        $arr['contents'] = $view->loadTemplate('comment');
        $arr['count_number'] = $this->getDemcommnet()->number_id;
        return $arr;
    }

    function ajaxphantrangcomment()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if ( isset($url_arr['port']) &&  $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'detail' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewDetail();
        $page = $_POST['page'];
        if (isset($_POST['counts'])) {
            $counts = $_POST['counts'];
        }
        $limit = $this->getState('page_cm');
        $limitstart1 = $limit * ($page - 1);
        $offset = (int)$limitstart1;
        if (!empty($counts)) {
            $offset = $offset + $counts;
        }
        $show_date = $this->getState('show_date');
        $this->setState('star_page_cm', $offset);
        $view->assign('show_date', $show_date);
        $view->assign('sosanhuser', $this->getSosanhuser());
        $view->assign('ShowCommnet', $this->getShowCommnet());
        return $view->loadTemplate('comment');
    }


    /*
     * method return light box detail
    */
    function ajaxDetail()
    {
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'detail' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewDetail();
        $Limits_comment = $this->getState('Limits_comment');
        $show_tags_title = $this->getState('show_tags_title');
        $show_tags_detail = $this->getState('show_tags_detail');
        $page_cm = $this->getState('page_cm');
        $type_Detail = $this->getState('type_details');
        $showdate = $this->getState('show_date');
        $img_size = $this->getState('pinboard_image_size');
        $text_webs = $this->getState('text_webs');
        $c_detail = $this->getState('s_detail');
        $button_d = $this->getState('button_d');
        $ds_detial = $this->getState('ds_detail');
        $name_board = $this->getState('name_b');
        $date_d = $this->getState('date_d');
        $web_dt = $this->getState('web_d');
        $img_user = $this->getState('img_user');
        $social = $this->getState('social');
        $view->assign('social', $social);
        $view->assign('imgUser', $img_user);
        $view->assign('web_d', $web_dt);
        $view->assign('date_d', $date_d);
        $view->assign('name_b', $name_board);
        $view->assign('ds_detail', $ds_detial);
        $view->assign('button_d', $button_d);
        $view->assign('s_detail', $c_detail);
        $view->assign('text_website', $text_webs);
        $view->assign('type_details', $type_Detail);
        $view->assign('show_date', $showdate);
        $view->assign('page_comment', $page_cm);
        $view->assign('show_title', $show_tags_title);
        $view->assign('show_tags', $show_tags_detail);
        $view->assign('limit_comment', $Limits_comment);
        $view->assign('show_detail', $this->getDetailPins());
        $view->assign('sosanhuser', $this->getSosanhuser());
        $view->assign('Demcommnet', $this->getDemcommnet());
        $view->assign('ShowCommnet', $this->getShowCommnet());
        $view->assign('img_size', $img_size);
        $view->assign('checkApp', 'false');
        return $view->loadTemplate('ajaxpins');
    }

    /*
     * Method check follow insert
    */
    function checkFoolow()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_user_guest = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        $SQL = "SELECT folowing from #__tz_pinboard_follow where id_user =$id_user AND id_guest =$id_user_guest";
        $db->setQuery($SQL);
        $row = $db->query();
        $num_row = $db->getNumRows($row);
        return $num_row;
    }

    /*
  * method check user Follow Active or not Follow and get id user Follow
  */
    function checkFollowActive()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_follow = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        $SQL = "SELECT id_user from #__tz_pinboard_active where id_user=$id_user AND target=$id_follow";
        $db->setQuery($SQL);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * Method insert into table Follow Active
    */
    function InsertFollowActive()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_follow = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        if (isset($this->checkFollowActive()->id_user)) {
            $check = $this->checkFollowActive()->id_user;
        }
        if (isset($id_user) && !empty($id_user)) {
            if (isset($check) AND !empty($check)) {
                $sql = "UPDATE alls_tz_pinboard_active SET `active` = 'f' WHERE target =$id_follow AND id_user = $id_user";
            } else if (empty($check)) {
                $sql = "INSERT INTO #__tz_pinboard_active  VALUES(NULL,'f','" . $id_follow . "','" . $id_user . "','follow') ";
            }

            $db->setQuery($sql);
            $db->query();
        }
    }

    /*
    * Method insert into table UnFollow Active
   */
    function InsertUnFollowActive()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_follow = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        if (isset($this->checkFollowActive()->id_user)) {
            $check = $this->checkFollowActive()->id_user;
        }
        if (isset($id_user) && !empty($id_user)) {
            if (isset($check) AND !empty($check)) {
                $sql = "UPDATE alls_tz_pinboard_active SET `active` = 'uf' WHERE target =$id_follow AND id_user = $id_user";
            } else if (empty($check)) {
                $sql = "INSERT INTO #__tz_pinboard_active  VALUES(NULL,'uf','" . $id_follow . "','" . $id_user . "','follow') ";
            }
            $db->setQuery($sql);
            $db->query();
        }
    }

    /*
     * method insert follo
    */
    function inserFollow()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if ( isset($url_arr['port']) && $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_user_guest = $_POST['id_user_guest'];
        $db = JFactory::getDbo();

        if (isset($id_user) && !empty($id_user)) {
            $checklik = $this->checkFoolow();
            if (isset($checklik) AND !empty($checklik)) {
                $sql = "update #__tz_pinboard_follow set folowing ='1' where id_user =$id_user AND id_guest =$id_user_guest";
            } else if ($checklik == "") {
                $sql = "INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'1','" . $id_user . "','" . $id_user_guest . "') ";
            }
            $this->InsertFollowActive();
            $db->setQuery($sql);
            $db->query();
        } else {
            return 'f';
        }
    }


    /*
     * method insert unfollow
    */
    function insertUnfollow()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if ( isset($url_arr['port']) &&  $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_user_guest = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        if (isset($id_user) && !empty($id_user)) {
            $checklik = $this->checkFoolow();
            if (isset($checklik) AND !empty($checklik)) {
                $sql = "update #__tz_pinboard_follow set folowing ='0' where id_user =$id_user AND id_guest =$id_user_guest";
            } else if (empty($checklik)) {
                $sql = "INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'0','" . $id_user_guest . "','" . $id_user . "') ";
            }
            $this->InsertUnFollowActive();
            $db->setQuery($sql);
            $db->query();
        } else {
            return 'f';
        }
    }
}

?>