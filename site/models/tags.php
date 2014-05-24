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


class TZ_PinboardModelTags extends JModelList
{


    /**
     * Method to auto-populate the model state.

     */
    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        $this->setState('params', $params);
        $limit_pin = $params->get('tz_article_limit');
        $limitstart = JRequest::getCmd('limitstart', 0);
        $width_columns = $params->get('width_columns');
        $tz_layout = $params->get('tz_pinboard_layout');
        $limit_commnet = $params->get('Limits_comment');
        $state_comment = $params->get('state_comment');
        $change_comment = $params->get('changecomment');
        $delete_text_cm = $params->get('remove_comment');
        $type_show_pin = $params->get('type_show_pin');
        $arrangements_pins = $params->get('arrangements_pins');
        $tz_pin_approve = $params->get('tz_pin_approve');
        $type_detail = $params->get('type_detail');
        $page_commnet = $params->get('page_commnet');
        $image_thum = $params->get('portfolio_image_size');
        $show_date_comment = $params->get('show_date_comment');
        $tag_id = JRequest::getInt('id_tag');
        $comment_thum = $params->get('comment_thumbnails'); // show comment thumbnails
        $show_button = $params->get('show_button'); // show button repin, like, unlike
        $show_title_thum = $params->get('show_title_thum'); // show or hide title thumbnails
        $show_tags_thum = $params->get('show_tags_thum'); // show or hide tags
        $count_button = $params->get('show_count_button'); // show or hide count comment, like, hist
        $s_user = $params->get('show_user'); // show or hide info user
        $this->setState('s_user', $s_user);
        $this->setState('count_button', $count_button);
        $this->setState('tag_thum', $show_tags_thum);
        $this->setState('title_thum', $show_title_thum);
        $this->setState('s_button', $show_button);
        $this->setState('s_thumb', $comment_thum);
        $this->setState('show_date', $show_date_comment);
        $this->setState('image_thum', $image_thum);
        $this->setState('page_cm', $page_commnet);
        $this->setState('arrangements_pins', $arrangements_pins);
        $this->setState('type_detail', $type_detail);
        $this->setState('check_status', $tz_pin_approve);
        $this->setState('tag_id', $tag_id);
        $this->setState('type_show_pin', $type_show_pin);
        $this->setState('tz_layout', $tz_layout);
        $this->setState('page_cm', $page_commnet);
        $this->setState('star_page_cm', 0);
        $this->setState('limit_commnet', $limit_commnet);
        $this->setState('remove_comment', $delete_text_cm);
        $this->setState('change_comment', $change_comment);
        $this->setState('state_comment', $state_comment);
        $this->setState('width_columns', $width_columns);
        $this->setState('limit_pin', $limit_pin);
        $this->setState('limitstar', $limitstart);
    }


    /*
     * Method Display the category name when selected in the menu
    */
    function getNameTag()
    {
        $tag_id = $this->getState('tag_id');
        if (isset($tag_id) && !empty($tag_id)) {
            $tag = $tag_id;
        }
        $db = JFactory::getDbo();
        $sql = "select name from #__tz_pinboard_tags where id=$tag";
        $db->setQuery($sql);
        return $db->loadObject();
    }


    /*
     *  method display Pins
     */
    function getPins()
    {
        $limit = $this->getState('limit_pin');
        $limitStart = $this->getState('limitstar');
        $type_show_pin = $this->getState('type_show_pin');
        $arrangements = $this->getState('arrangements_pins');
        $tag = $this->getState('tag_id');
        $tz_layout = $this->getState('tz_layout');
        if (isset($tag) && !empty($tag)) {
            $tag_id = $tag;
        }
        if (isset($tag_id) && !empty($tag_id)) {
            $tags = "where tx.tagsid = $tag_id  and c.state=1 order by c.$type_show_pin $arrangements";
        } else {
            $tags = "";
        }
        $db = JFactory::getDbo();
        $sql = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.hits as content_hit, c.state as c_state, c.attribs as c_attribs, pz.images as poro_img, pz.video as pz_video,
                                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                    c.catid as catidc, u.name as user_name,  us.images as user_img , us.url as usurl, us.gender as usgender,
                                    us.twitter as ustwitter, us.facebook as usfacebook, us.google_one as usgoogle_one, us.description as usdescription
                            FROM #__users AS u
                                INNER JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                INNER JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                INNER JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                LEFT JOIN #__tz_pinboard_users as us ON u.id = us.usersid
                                LEFT JOIN #__tz_pinboard_tags_xref AS tx on c.id = tx.contentid
                                LEFT JOIN #__tz_pinboard_tags AS tg on tx.tagsid = tg.id
                                $tags";

        $sql2 = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id,  c.hits as content_hit,  c.state as c_state, c.attribs as c_attribs, pz.images as poro_img, pz.video as pz_video,
                                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                    c.catid as catidc, u.name as user_name,  us.images as user_img , us.url as usurl, us.gender as usgender,
                                    us.twitter as ustwitter, us.facebook as usfacebook, us.google_one as usgoogle_one, us.description as usdescription
                            FROM #__users AS u
                                INNER JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                INNER JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                INNER JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                LEFT JOIN #__tz_pinboard_users as us ON u.id = us.usersid
                                LEFT JOIN #__tz_pinboard_tags_xref AS tx on c.id = tx.contentid
                                LEFT JOIN #__tz_pinboard_tags AS tg on tx.tagsid = tg.id $tags  ";

        $db->setQuery($sql);
        $count_r = $db->query();
        $total = $db->getNumRows($count_r);
        $this->pagNavPins = new JPagination($total, $limitStart, $limit);

        // Select the type of paging
        if ($tz_layout == "default") {
            $db->setQuery($sql2, $this->pagNavPins->limitstart, $this->pagNavPins->limit);
        } else {
            $db->setQuery($sql2, $limitStart, $limit);
        }

        $row = $db->loadObjectList();
        foreach ($row as $item) {
            $check_l = $this->chekcLikeUser($item->content_id);
            $item->checl_l = $check_l;
            $countL = $this->countLike($item->content_id);
            $item->countL = $countL;
            $countComment = $this->countComment($item->content_id);
            $item->countComment = $countComment;
            $show_comment = $this->getShowComment($item->content_id);
            $item->showcomment = $show_comment;
            $tangs = $this->DetailTag($item->content_id);
            $item->tags = $tangs;
        }
        return $row;
    }

    /*
     *  method show tag
    */
    function detailTag($id)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT t.id as tagid, t.name as tagname
                     FROM  #__tz_pinboard_tags AS t
                           LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                     WHERE tx.contentid =$id";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * Method  paging in joomla
    */
    function getPaginationPins()
    {
        if (!$this->pagNavPins)
            return '';
        return $this->pagNavPins;
    }


    /*
     * Method check user like or not like
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
     * Method count like
     */
    function countLike($id_content)
    {
        $db = JFactory::getDbo();
        $sql = "select count(id) as count_l from #__tz_pinboard_like where id_content=$id_content AND like_p =1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    /*
     * Method Count comment
     */
    function countComment($id_content)
    {
        $db = JFactory::getDbo();
        $sql = "select count(id) as count_l from #__tz_pinboard_comment where content_id=$id_content";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * Method  returns the user's logo
     */
    function getUserImgLogin()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "select images from #__tz_pinboard_users where usersid=$id_user";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * Method  returns  id of user
    */
    function getSosanhuser()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        return $id_user;
    }


    /*
     * method ajax paging
     */
    function PinAjax()
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
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'tags' . DIRECTORY_SEPARATOR . 'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewTags();
        $page = JRequest::getInt('page');
        $limit = $this->getState('limit_pin');
        $limitstart1 = $limit * ($page - 1);
        $offset = (int)$limitstart1;
        $this->setState('limitstar', $offset);
        $text_commnet = $this->getState('limit_commnet');
        $img_size = $this->getState('image_thum');
        $width_columns = $this->getState('width_columns');
        $tz_layout = $this->getState('tz_layout');
        $type_detail = $this->getState('type_detail');
        $page_cm = $this->getState('page_cm');
        $show_date = $this->getState('show_date');
        $s_user = $this->getState('s_user'); // show user
        $s_thumb = $this->getState('s_thumb'); // show comment
        $button = $this->getState('s_button'); // show button
        $tag_thum = $this->getState('tag_thum'); // show tag
        $title_thum = $this->getState('title_thum'); // show title
        $count_button = $this->getState('count_button'); // show count like, comment, hist
        $view->assign('s_user', $s_user);
        $view->assign('count_button', $count_button);
        $view->assign('title_thum', $title_thum);
        $view->assign('tag_thum', $tag_thum);
        $view->assign('s_button', $button);
        $view->assign('s_thumb', $s_thumb);
        $view->assign('show_date', $show_date);
        $view->assign('page_com', $page_cm);
        $view->assign('type_detail', $type_detail);
        $view->assign('Limit_comment', $text_commnet);
        $view->assign('UserImgLogin', $this->getUserImgLogin());
        $view->assign('sosanhuser', $this->getSosanhuser());
        $view->assign('tz_layout', $tz_layout);
        $view->assign('width_columns', $width_columns);
        $view->assign('img_size', $img_size);
        $view->assign('Pins', $this->getPins());
        return ($view->loadTemplate('pinboard'));
    }

    /*
     * method  display comment
    */
    function getShowComment($id_content)
    {
        $limit_star = $this->getState('star_page_cm');
        $limit = $this->getState('page_cm');
        $db = JFactory::getDbo();
        $sql = "SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
                             c.created_by as create_by
                       FROM #__users AS u
                            LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                            LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
                            LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
                       WHERE cm.content_id =$id_content AND cm.state=1 AND cm.checkIP=1  order by cm.id desc limit $limit_star,$limit";
        $db->setQuery($sql);
        if ($row = $db->loadObjectList()) {
            return $row;
        }
        return false;
    }

    /*
     * method count the number of comment
    */
    function getDemcommnet()
    {
        $id_conten = $_POST['id_content'];
        $db = JFactory::getDbo();
        $sql = "select count(id) as number_id from #__tz_pinboard_comment where content_id =$id_conten";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }
}

?>