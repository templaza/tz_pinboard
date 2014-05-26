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
jimport('joomla.filesystem.folder');
class Tz_pinboardModelManageruser extends JModelList
{


    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        $this->setState('params', $params);
        $check_status = $params->get('tz_pin_approve');
        $max_title = $params->get('text_title');
        $max_introtex = $params->get('text_descript_pin');
        $limit = $params->get('limits');
        $type_detail = $params->get('type_detail');
        $limit_pin = $params->get('limits_pins');
        $limitstart = JRequest::getCmd('limitstart', 0);
        $limit_like = $params->get('limits_like');
        $limits_Board_Pin = $params->get('limits_Board_Pin');
        $limits_Follow = $params->get('limits_Follow');
        $limit_commnet = $params->get('Limits_comment');
        $page_commnet = $params->get('page_commnet');
        $delete_text_cm = $params->get('remove_comment');
        $change_comment = $params->get('changecomment');
        $state_comment = $params->get('state_comment');
        $max_text_board = $params->get('text_boar');
        $max_text_board_ds = $params->get('text_boar_description');
        $state_boar = $params->get('state_boar');
        $limit_img_b = $params->get('limit_img_board');
        $this->setState('limit_img_b', $limit_img_b);
        $this->setState('type_detail', $type_detail);
        $this->setState('state_boar', $state_boar);
        $this->setState('max_text_board', $max_text_board);
        $this->setState('max_text_board_ds', $max_text_board_ds);
        $this->setState('remove_comment', $delete_text_cm);
        $this->setState('change_comment', $change_comment);
        $this->setState('state_comment', $state_comment);
        $this->setState('star_page_cm', 0);
        $this->setState('page_cm', $page_commnet);
        $this->setState('limit_commnet', $limit_commnet);
        $this->setState('limits_Follow', $limits_Follow);
        $this->setState('limits_Board_Pin', $limits_Board_Pin);
        $this->setState('limit_like', $limit_like);
        $this->setState('limit_pin', $limit_pin);
        $this->setState('limitstar', $limitstart);
        $this->setState('limit', $limit);
        $this->setState('check_status', $check_status);
        $this->setState('max_text_title', $max_title);
        $this->setState('max_text_descript', $max_introtex);
    }


    function  __construct()
    {
        parent::__construct();
    }

// start board
    /*
    * method display category
    */
    function getCategory()
    {
        $db = JFactory::getDbo();
        $sql = " select id, title from #__tz_pinboard_category";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }


    /*
     * method show board
     */
    function getBoarpin()
    {
        $limit = $this->getState('limit');
        $limitStart = $this->getState('limitstar');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT  id as id_board, title as name_board, created_user_id
                            from #__tz_pinboard_boards
                            where created_user_id=$id_user AND state=1 order by created_time desc";
        $sql2 = "SELECT  id as id_board, title as name_board, created_user_id
                            from #__tz_pinboard_boards
                            where created_user_id=$id_user AND state=1 order by created_time desc";
        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh);
        $this->pagNav = new JPagination($total, $limitStart, $limit);
        $db->setQuery($sql2, $this->pagNav->limitstart, $this->pagNav->limit);
        $row = $db->loadObjectList();
        foreach ($row as $item) {
            $pins = $this->getShowpin($item->id_board);
            $countpins = $this->getCountpin($item->id_board);
            $item->countpins = $countpins;
            $item->pins = $pins;
        }
        return $row;
    }

    /*
     * method paging
    */
    function getPagination()
    {
        if (!$this->pagNav)
            return '';
        return $this->pagNav;
    }

    /*
     * method display image of the pin under the board
    */
    function getShowpin($boardId)
    {
        $star_img = $this->getState('limit_img_b');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT pt.images AS img, created_by  as id_users
                FROM #__tz_pinboard_xref_content AS pt
                LEFT JOIN #__tz_pinboard_pins AS c ON pt.contentid = c.id
                LEFT JOIN #__tz_pinboard_boards AS ca ON c.catid = ca.id
                WHERE c.catid =$boardId
                AND created_by =$id_user AND c.state=1 order by c.created desc
                LIMIT 0 , $star_img";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;

    }


    /*
     * method display number of the pin under the board
    */
    function getCountpin($boardId)
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT  count(c.id) as numberpin
                            FROM   #__tz_pinboard_pins AS c INNER JOIN #__tz_pinboard_boards AS ca ON c.catid = ca.id
                            WHERE c.catid = $boardId  AND c.state=1 and  created_by=$id_user ";


        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * method displays details of the selected board pins
    */
    function getShowBoarAndPin()
    {
        $limit = $this->getState('limits_Board_Pin');
        $limitStart = $this->getState('limitstar');
        $id_board = JRequest::getInt('id_board');
        if (isset($id_board)) {
            $user_guest = JRequest::getInt('id_guest');
            $user = JFactory::getUser();
            $id_user = $user->id;
            if (isset($user_guest) && !empty($user_guest)) {
                $id_user = $user_guest;
            }
            $db = JFactory::getDbo();
            $sql = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.attribs as c_attribs,  pz.video as pz_video,
                                      c.hits as content_hit, pz.images as poro_img, w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user
                                FROM #__users AS u
                                LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                WHERE c.created_by =$id_user AND c.catid=$id_board AND c.state = 1";
            $sql2 = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.attribs as c_attribs, pz.video as pz_video,
                                 c.hits as content_hit, pz.images as poro_img, w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user
                                FROM #__users AS u
                                LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                WHERE c.created_by =$id_user AND c.catid=$id_board AND c.state = 1 order by c.created desc";
            $db->setQuery($sql);
            $tinh = $db->query();
            $total = $db->getNumRows($tinh);
            $this->pagNavBoardPin = new JPagination($total, $limitStart, $limit);
            $db->setQuery($sql2, $this->pagNavBoardPin->limitstart, $this->pagNavBoardPin->limit);
            $row = $db->loadObjectList();
            foreach ($row as $item) {
                $check_l = $this->chekcLikeUser($item->content_id);
                $item->checl_l = $check_l;
                $number_like = $this->CountLike($item->content_id);
                $item->number_like = $number_like;
                $number_comment = $this->countComment($item->content_id);
                $item->number_comment = $number_comment;
                $tangs = $this->DetailTag($item->content_id);
                $item->tags = $tangs;
                $show_comment = $this->getShowComment($item->content_id);
                $item->showcomment = $show_comment;
            }
            return $row;
        }
    }


    /*
    * method paging detail board
    */
    function getPaginationBoardPin()
    {
        if (!$this->pagNavBoardPin)
            return '';
        return $this->pagNavBoardPin;
    }

    function  getShowcategoryBoarAndPin()
    {
        $id_board = JRequest::getInt('id_board');
        if (isset($id_board)) {
            $user_guest = JRequest::getInt('id_guest');
            $user = JFactory::getUser();
            $id_user = $user->id;
            if (isset($user_guest) && !empty($user_guest)) {
                $id_user = $user_guest;
            }
            $db = JFactory::getDbo();
            $sql = "SELECT id, title from #__tz_pinboard_boards where id = $id_board AND created_user_id  =$id_user ";

            $db->setQuery($sql);
            $row = $db->loadObject();

            return $row;
        }
    }

    // and board


    // start pin


    /*
     * method display pins
    */
    function getPins()
    {
        $limit = $this->getState('limit_pin');
        $limitStart = $this->getState('limitstar');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.hits as content_hit, c.attribs as c_attribs,
                                    pz.images as poro_img,  pz.video as pz_video,
                                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                    c.catid as catidc
                            FROM #__users AS u
                                LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                            WHERE c.created_by =$id_user and c.state=1 order by c.created desc ";
        $sql2 = "SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.hits as content_hit, c.attribs as c_attribs,
                                pz.images as poro_img,  pz.video as pz_video,
                                w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                c.catid as catidc
                        FROM #__users AS u
                                LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                        WHERE c.created_by =$id_user and c.state=1 order by c.created desc ";
        $db->setQuery($sql);
        $number = $db->query();
        $total = $db->getNumRows($number);
        $this->pagNavPins = new JPagination($total, $limitStart, $limit);
        $db->setQuery($sql2, $this->pagNavPins->limitstart, $this->pagNavPins->limit);
        $row = $db->loadObjectList();

        foreach ($row as $item) {
            $check_l = $this->chekcLikeUser($item->content_id);
            $item->checl_l = $check_l;
            $number_like = $this->CountLike($item->content_id);
            $item->number_like = $number_like;
            $number_comment = $this->countComment($item->content_id);
            $item->number_comment = $number_comment;
            $tangs = $this->DetailTag($item->content_id);
            $item->tags = $tangs;
            $show_comment = $this->getShowComment($item->content_id);
            $item->showcomment = $show_comment;

        }
        return $row;
    }


    /*
    * method paging
    */
    function getPaginationPins()
    {
        if (!$this->pagNavPins)
            return '';
        return $this->pagNavPins;
    }

    /*
     * method show tag
    */
    function detailTag($id)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT t.id as tagid, t.name as tagname
                     FROM #__tz_pinboard_tags AS t
                          LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                     WHERE tx.contentid =$id";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * method check user like or not like
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
     * method display detail tag
    */
    function DetailsTag($id)
    {
        if (isset($id) && !empty($id)) {
            $db = JFactory::getDbo();
            $sql = "SELECT t.id as tagid, t.name as tagname
                         FROM #__tz_pinboard_tags AS t
                              LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                         WHERE tx.contentid =$id";
            $db->setQuery($sql);
            $row = $db->loadObjectList();
            return $row;
        }
    }


    /*
     * method check user follow or not follow
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

    /*
     * method display board when the edit
    */
    function  getShowBoarname()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "select id, title from #__tz_pinboard_boards where  created_user_id=$id_user ";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * method display a pin when the edit
     */
    function getShoweditpins()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_content = JRequest::getInt('id_pins');
        if (isset($id_content)) {
            $db = JFactory::getDbo();
            $sql = "SELECT im.images as img_im, c.id as content_id, c.title as content_title,
                                    c.introtext as content_introtext, c.catid as content_catid, c.alias as alias_content,
                                    w.url as url, tg.name as tag
                            FROM  #__tz_pinboard_pins AS c  LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                            LEFT JOIN #__tz_pinboard_tags_xref AS t ON t.contentid = c.id
                            LEFT JOIN #__tz_pinboard_tags AS tg ON tg.id = t.tagsid
                            LEFT JOIN #__tz_pinboard_xref_content AS im ON c.id = im.contentid
                            where c.id=$id_content and c.created_by=$id_user";
            $db->setQuery($sql);
            $row = $db->loadObject();
            if (!empty($row)) {
                $tangs = $this->DetailsTag($row->content_id);
                $row->tags = $tangs;
                return $row;
            }
        }
    }


    /*
     * method check alias pin
    */
    function checkAlias_pins()
    {
        $name = strip_tags(htmlspecialchars(JRequest::getString('edittitle')));
        $alias = strip_tags(htmlspecialchars(JRequest::getString('aliaspins')));
        $db = JFactory::getDbo();
        $sql = 'select title, alias from #__tz_pinboard_pins where title="' . $name . '" || alias="' . $alias . '"';
        $db->setQuery($sql);
        $num_row = $db->query();
        $row = $db->getAffectedRows($num_row);
        return $row;
    }


    /*
     * method update content pin
    */
    function  updateContentpin()
    {
        $id_c = strip_tags(htmlspecialchars($_POST['id_pins']));
        $title = strip_tags(htmlspecialchars($_POST['edittitle']));
        $introtext = strip_tags(htmlspecialchars($_POST['textreaname']));
        $catid = strip_tags(htmlspecialchars($_POST['select_catogory']));
        $alias = strip_tags(htmlspecialchars($_POST['aliaspins']));
        $_price = trim(strip_tags(htmlspecialchars($_POST['tz_edit_price'])));
        if ($alias) {
            $alias = $alias;
        } else {
            $alias = $title;
        }
        $alias = JApplication::stringURLSafe($alias); // create alias
        $title = str_replace("'", "\'", $title);
        $introtext = str_replace("'", "\'", $introtext);
        $user = JFactory::getUser();
        $id_user = $user->id;
        $dt = JFactory::getDate();
        $modified = $dt->toSql();
        $db = JFactory::getDbo();
        if ($_price != 'f2') {
            if (!empty($_price)) {
                $arr_price = array();
                $arr_price['price'] = $_price;
                $price = new JRegistry();
                $price->loadArray($arr_price);
                $priceR = $price->toString();
            } else {
                $priceR = "";
            }
            $sql = "UPDATE #__tz_pinboard_pins SET title='" . $title . "', introtext='" . $introtext . "', catid='" . $catid . "',
                                             modified='" . $modified . "', alias='" . $alias . "',attribs='" . $priceR . "'
                                             WHERE id=$id_c AND created_by =$id_user ";
        } else {
            $sql = "UPDATE #__tz_pinboard_pins SET title='" . $title . "', introtext='" . $introtext . "', catid='" . $catid . "',
                                             modified='" . $modified . "', alias='" . $alias . "'
                                            WHERE id=$id_c AND created_by =$id_user ";
        }
        $db->setQuery($sql);
        $db->query();
    }


    /*
     * method delete tags edit
    */
    function deleteEditTang()
    {
        $id_conten = strip_tags(htmlspecialchars($_POST['id_pins']));
        $db = JFactory::getDbo();
        $sql = "delete from #__tz_pinboard_tags_xref where contentid=$id_conten";
        $db->setQuery($sql);
        $db->query();
    }


    /*
     * method check tags
     */
    function  getChecktag()
    {
        $keywords = strip_tags(htmlspecialchars($_POST['editkeywords']));
        if (empty($keywords)) return $keywords = array();
        $keywords = trim($keywords);
        $keywords = mb_strtolower($keywords);
        $arr_key = array(',', '\'', '"', '.', '?', '/', '\\', '<', '>', '(', ')', '*', '&', '^', '%', '$', '#', '@', '!', '-', '+', '|', '`', '~');
        $keywords = str_replace($arr_key, ',', $keywords);
        $keywords = explode(",", $keywords);
        $keywords = array_unique($keywords);
        $arr = array();
        for ($i = 0; $i < count($keywords); $i++) {
            $keywords[$i] = trim($keywords[$i]);
            if (!empty($keywords[$i])) {
                $arr[] = $keywords[$i];
            }
        }
        $db = JFactory::getDbo();
        $newkey = array();
        for ($i = 0; $i < count($arr); $i++) {
            $sql = " select id from #__tz_pinboard_tags where name='" . trim($arr[$i]) . "'";
            $db->setQuery($sql);
            $row = $db->loadResult();
            if (empty($row)) {
                $key[] = $arr[$i];
            } else {
                $row_id[] = $row;
            }
        }
        $newkey['new'] = $key;
        $newkey['id'] = $row_id;
        return $newkey;
    }


    /*
     * method insert Tags
     */
    function  insertUrltag()
    {
        $db = JFactory::getDbo();
        $new = $this->getChecktag();
        $keywords = $new['new'];
        $row_k = $new['id'];
        if (is_array($keywords)) {
            $check_key = count($keywords);
            $row_is = null;
            if ($check_key != 0 && !empty($check_key)) {
                for ($i = 0; $i < $check_key; $i++) {
                    $sql_tag = "INSERT INTO #__tz_pinboard_tags VALUES(NULL,'" . trim($keywords[$i]) . "','1','')";
                    $sql = " select id from #__tz_pinboard_tags where name='" . trim($keywords[$i]) . "'";
                    $db->setQuery($sql_tag);
                    $db->query();
                    $db->setQuery($sql);
                    $row = $db->loadResult();
                    $row_is[] = $row;
                }
            } else {
                return null;
            }
        } else if (!empty($keywords)) {
            $sql_tag = "INSERT INTO #__tz_pinboard_tags VALUES(NULL,'" . trim($keywords) . "','1','')";
            $sql = " select id from #__tz_pinboard_tags where name='" . $keywords . "'";
            $db->setQuery($sql_tag);
            $db->query();
            $db->setQuery($sql);
            $row = $db->loadResult();
            $row_is[] = $row;
        }
        if (empty($row_is)) {
            $mang = $row_k;
        } else if (!empty($row_k)) {
            $mang = array_merge($row_k, $row_is);
        } else {
            $mang = $row_is;
        }

        return $mang;
    }


    /*
     * method insert tag to the Connection tag and content
     */
    function  insertUrlTangconten()
    {
        $id_conten = strip_tags(htmlspecialchars($_POST['id_pins']));
        $id_tag = $this->insertUrltag();
        if (is_array($id_tag) && count($id_tag) != 0) {
            $db = JFactory::getDbo();
            for ($i = 0; $i < count($id_tag); $i++) {
                $sql_insert = "INSERT INTO #__tz_pinboard_tags_xref VALUES(NULL,'" . $id_tag[$i] . "','" . $id_conten . "')";
                $db->setQuery($sql_insert);
                $db->query();
            }
        }
    }

    /*
     * method update pins all
    */
    function  updatePins()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $this->deleteEditTang();
        $this->insertUrlTangconten();
        $this->updateContentpin();
        $id_c = strip_tags(htmlspecialchars($_POST['id_pins']));
        return $id_c;
    }


    /*
     * method delete pin content
    */
    function  deletePinscontent()
    {
        $id_content = JRequest::getInt('id_pins');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($id_content)) {
            $db = JFactory::getDbo();
            $sql = " delete from #__tz_pinboard_pins where id=$id_content AND created_by=$id_user";
            $db->setQuery($sql);
            $db->query();
            return 1;
        }
    }

    /*
     * method delete active
    */
    function deleteActive()
    {
        $id_content = JRequest::getInt('id_pins');
        if (isset($id_content)) {
            $db = JFactory::getDbo();
            $sql = "delete from #__tz_pinboard_active where target=$id_content";
            $db->setQuery($sql);
            $db->query();
        }
    }

    /*
     * method delete website pin
    */
    function deletewebPins()
    {
        $id_content = JRequest::getInt('id_pins');
        if (isset($id_content)) {
            $db = JFactory::getDbo();
            $sql = "delete from #__tz_pinboard_website where contentid=$id_content";
            $db->setQuery($sql);
            $db->query();
        }
    }

    /*
     * method delete images pins
    */
    function deleteImgPins()
    {
        $id_content = JRequest::getInt('id_pins');
        if (isset($id_content)) {
            $db = JFactory::getDbo();
            $sql = "delete from #__tz_pinboard_xref_content where contentid=$id_content";
            $db->setQuery($sql);
            $db->query();
        }
    }

    /*
     * method delete tag delete tags pins
    */
    function deleteTagPins()
    {
        $id_content = JRequest::getInt('id_pins');
        $db = JFactory::getDbo();
        $sql = "delete from #__tz_pinboard_tags_xref where contentid=$id_content";
        $db->setQuery($sql);
        $db->query();
    }

    function deleteComments()
    {
        $id_content = JRequest::getInt('id_pins');
        $db = JFactory::getDbo();
        $sql = "delete from #__tz_pinboard_comment where content_id=$id_content";
        $db->setQuery($sql);
        $db->query();
    }


    /*
     * method delete pins all
    */
    function deletePins()
    {
        $id_board = JRequest::getInt('id_board');
        $check_delete = $this->deletePinscontent();
        if ($check_delete == 1) {
            $this->deleteimg_content();
            $this->deleteImgPins();
            $this->deletewebPins();
            $this->deleteTagPins();
            $this->deleteComments();
            $this->deleteActive();
        }
        return $id_board;
    }


// and layout pin

    /*
     *  method pins display like
     */
    function getLike()
    {
        $limit = $this->getState('limit_like');
        $limitStart = $this->getState('limitstar');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }

        $db = JFactory::getDbo();
        $sql = "SELECT u.id as id_user, u.name as user_name, c.title as conten_title,  c.id as content_id,  c.attribs as c_attribs,
                                    c.hits as content_hit, pz.images as poro_img, pz.video as pz_video,
                                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                    l.like_p as likes
                                FROM #__users AS u
                                    LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                    LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                    LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                    LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                    LEFT JOIN #__tz_pinboard_like AS l ON c.id = l.id_content
                                WHERE l.id_user_p =$id_user AND l.like_p=1 AND c.state =1  order by c.created desc";
        $sql2 = "SELECT u.id as id_user, u.name as user_name, c.title as conten_title,  c.id as content_id, c.attribs as c_attribs,
                                    c.hits as content_hit, pz.images as poro_img, pz.video as pz_video,
                                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                                    l.like_p as likes
                            FROM #__users AS u
                                LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                                LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                                LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                                LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                                LEFT JOIN #__tz_pinboard_like AS l ON c.id = l.id_content
                            WHERE l.id_user_p =$id_user AND l.like_p=1 AND c.state =1 order by c.created desc";
        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh);
        $this->pagNavLike = new JPagination($total, $limitStart, $limit);
        $db->setQuery($sql2, $this->pagNavLike->limitstart, $this->pagNavLike->limit);
        $row = $db->loadObjectList();
        foreach ($row as $item) {
            $check_l = $this->chekcLikeUser($item->content_id);
            $item->checl_l = $check_l;
            $number_like = $this->CountLike($item->content_id);

            $item->number_like = $number_like;
            $number_comment = $this->countComment($item->content_id);
            $item->number_comment = $number_comment;
            $tangs = $this->DetailTag($item->content_id);
            $item->tags = $tangs;
            $show_comment = $this->getShowComment($item->content_id);
            $item->showcomment = $show_comment;
        }
        return $row;
    }


    /*
     * method paging like
     */
    function getPaginationLike()
    {
        if (!$this->pagNavLike)
            return '';
        return $this->pagNavLike;
    }


    /*
     * method count the number like to pin
     */
    function CountLike($id_content)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT count(id) as num_like
                    FROM #__tz_pinboard_like
                    WHERE like_p =1
                    AND id_content =$id_content";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    /*
     *  method count the number comment to pin
     */
    function countComment($id_content)
    {
        $db = JFactory::getDbo();
        $sql = "select count(id) as count_l from #__tz_pinboard_comment where content_id=$id_content";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

// and get like pin


    /*
     *  method check follow
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
     * method insert follow
     */
    function inserFollow()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_user_guest = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        $checklik = $this->checkFoolow();
        if (isset($id_user) && !empty($id_user)) {
            if (isset($checklik) AND !empty($checklik)) {
                $sql = "update #__tz_pinboard_follow set folowing ='1' where id_user =$id_user AND id_guest =$id_user_guest";
            } else if ($checklik == "") {
                $sql = "INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'1','" . $id_user . "','" . $id_user_guest . "') ";
            }
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
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_user_guest = $_POST['id_user_guest'];
        $db = JFactory::getDbo();
        $checklik = $this->checkFoolow();
        if (isset($checklik) AND !empty($checklik)) {
            $sql = "update #__tz_pinboard_follow set folowing ='0' where id_user =$id_user AND id_guest =$id_user_guest";

        } else if (empty($checklik)) {
            $sql = "INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'0','" . $id_user_guest . "','" . $id_user . "') ";
        }
        $db->setQuery($sql);
        $db->query();
    }


// start follow

    /*
     * method display user follow
    */
    function getShowFollow()
    {
        $limit = $this->getState('limits_Follow');
        $limitStart = $this->getState('limitstar');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT u.id AS uid, u.name AS uname, tz.images AS tzimages, f.id_guest as id_guests
                                FROM #__tz_pinboard_follow AS f
                                INNER JOIN #__users AS u ON f.id_guest = u.id
                                LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                                WHERE f.id_user =$id_user AND f.folowing =1";
        $sql2 = "SELECT u.id AS uid, u.name AS uname, tz.images AS tzimages, f.id_guest as id_guests
                                FROM #__tz_pinboard_follow AS f
                                INNER JOIN #__users AS u ON f.id_guest = u.id
                                LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                                WHERE f.id_user =$id_user AND f.folowing =1";
        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh);
        $this->pagNavFolloing = new JPagination($total, $limitStart, $limit);
        $db->setQuery($sql2, $this->pagNavFolloing->limitstart, $this->pagNavFolloing->limit);
        $row = $db->loadObjectList();
        foreach ($row as $item) {
            $follow_user = $this->ShowContentFollow($item->uid);
            $item->follow = $follow_user;
            $followsCheck = $this->checkFollow($item->id_guests);
            $item->followCheck = $followsCheck;
        }
        return $row;
    }


    /*
     * method paging folloing
    */
    function getPaginationFolloing()
    {
        if (!$this->pagNavFolloing)
            return '';
        return $this->pagNavFolloing;
    }

    /*
     * method  show image of usert follow
    */
    function ShowContentFollow($id_use)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT  c.catid AS bordid, c.created_by AS cid, tz.images AS tzimgaes
                        FROM #__tz_pinboard_pins AS c
                        LEFT JOIN #__tz_pinboard_xref_content AS tz ON c.id = tz.contentid
                        WHERE c.created_by =$id_use
                        AND tz.type = 'image' AND c.state =1
                        ORDER BY c.id DESC
                        LIMIT 0 , 4";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }


// START Followers

    /*
     * method dislay user Followers
    */
    function  getShowFollowers()
    {
        $limit = $this->getState('limits_Follow');
        $limitStart = $this->getState('limitstar');
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT id_user from #__tz_pinboard_follow where id_guest=$id_user AND folowing=1";
        $sql2 = "SELECT id_user from #__tz_pinboard_follow where id_guest=$id_user AND folowing=1";
        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh);
        $this->pagNavFollow = new JPagination($total, $limitStart, $limit);
        $db->setQuery($sql2, $this->pagNavFollow->limitstart, $this->pagNavFollow->limit);
        $row = $db->loadObjectList();
        foreach ($row as $item) {
            $thongtinUser = $this->ShowThongtinUserFollowers($item->id_user);
            $item->thongtin = $thongtinUser;
            $contenFollower = $this->ShowContenFollower($item->id_user);
            $item->content = $contenFollower;
            $followsCheck = $this->checkFollow($item->id_user);
            $item->followCheck = $followsCheck;
        }
        return $row;
    }


    /*
     * method paging
    */
    function getPaginationFollow()
    {
        if (!$this->pagNavFollow)
            return '';
        return $this->pagNavFollow;
    }


    /*
     * method display infomation user
    */
    function ShowThongtinUserFollowers($id_user)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT u.id AS uid, u.name AS uname, tz.images AS tzimages
                    FROM #__users AS u LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                    WHERE u.id=$id_user";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    function ShowContenFollower($id_user)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT  c.catid AS bordid, c.created_by AS cid, tz.images AS tzimgaes
                    FROM #__tz_pinboard_pins AS c
                    LEFT JOIN #__tz_pinboard_xref_content AS tz ON c.id = tz.contentid
                    WHERE c.created_by =$id_user
                    AND tz.type = 'image' AND c.state = 1
                    ORDER BY c.id DESC
                    LIMIT 0 , 4";
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }


//start board
    /*
     *  method check alias
     */
    function checkAlias()
    {
        $user = JFactory::getUser();
        $created_user_id = $user->id;
        $name = strip_tags(htmlspecialchars(JRequest::getString('boardname')));
        $alias = strip_tags(htmlspecialchars(JRequest::getString('aliasboard')));
        if (empty($alias)) {
            $alias = $name;
        }
        $db = JFactory::getDbo();
        $sql = 'select title, alias from #__tz_pinboard_boards where created_user_id ="' . $created_user_id . '" AND title="' . $name . '" || alias="' . $alias . '"';
        $db->setQuery($sql);
        $num_row = $db->query();
        $row = $db->getAffectedRows($num_row);
        return $row;
    }


    /*
     * method insert board
    */
    function  InsertBoard()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $user = JFactory::getUser();
        $dt = JFactory::getDate();
        $state_b = $this->getState('state_boar');
        $title = strip_tags(htmlspecialchars($_POST['boardname']));
        $alias = strip_tags(htmlspecialchars($_POST['aliasboard']));
        if ($alias) {
            $alias = $alias;
        } else {
            $alias = $title;
        }
        $alias = JApplication::stringURLSafe($alias);
        $description = strip_tags(htmlspecialchars($_POST['decsipt']));
        $created_time = $dt->toSql();
        $catid = strip_tags(htmlspecialchars($_POST['catego']));
        $created_user_id = $user->id;
        $erro = $this->checkAlias();

        if ($erro == "0" && isset($created_user_id) && !empty($created_user_id)) {
            $db = JFactory::getDbo();
            $sql = 'INSERT INTO #__tz_pinboard_boards
                        VALUES(NULL,"' . $title . '","' . $alias . '","' . $description . '","' . $state_b . '","' . $created_time . '","","' . $catid . '","' . $created_user_id . '")';
            $db->setQuery($sql);
            $db->query();
        }

    }

    /*
     * method check delete board
     */
    function checkDeleteboard($id_b)
    {
        if (isset($id_b)) {
            $db = JFactory::getDbo();
            $sql = "select count(id) as count_id from  #__tz_pinboard_pins   where catid=$id_b";
            $db->setQuery($sql);
            $row = $db->loadObject();
            return $row;
        }
    }


    /*
     * method edit board
    */
    function getEditboard()
    {
        $id_b = JRequest::getInt('id_board');
        if (isset($id_b) && !empty($id_b)) {
            $db = JFactory::getDbo();
            $sql = "SELECT catid, id as id_board, title as board, description, created_time, alias
                    from #__tz_pinboard_boards
                    where id =$id_b";
            $db->setQuery($sql);
            $row = $db->loadObject();
            if (!empty($row)) {
                $check = $this->checkDeleteboard($row->id_board);
                $row->check = $check;
                return $row;
            }
        }
    }

    /*
     * method update board
    */
    function updateboard()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $user = JFactory::getUser();
        $dt = JFactory::getDate();
        $dtime = $dt->toSql();
        $id_user = $user->id;
        $id_b = JRequest::getInt('id_boar');
        $name = strip_tags(htmlspecialchars(JRequest::getString('editname')));
        $alias = strip_tags(htmlspecialchars($_POST['aliasboard']));
        if ($alias) {
            $alias = $alias;
        } else {
            $alias = $name;
        }
        $alias = JApplication::stringURLSafe($alias);
        $name = str_replace("'", "\'", $name);
        $descript = strip_tags(htmlspecialchars(JRequest::getString('textreaname')));
        $descript = str_replace("'", "\'", $descript);
        $category = strip_tags(htmlspecialchars(JRequest::getInt('select_catogory')));
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_boards
                    SET title='" . $name . "', alias ='" . $alias . "', description ='" . $descript . "',modified_time='" . $dtime . "',catid='" . $category . "'
                    WHERE id=$id_b AND created_user_id=$id_user";
        $db->setQuery($sql);
        $db->query();

    }


    /*
     * method get title , alias of board
    */
    function getUploadnameboard()
    {
        $id_b = JRequest::getInt('id_boar');
        $name = strip_tags(htmlspecialchars(JRequest::getString('editname')));
        $alias = strip_tags(htmlspecialchars(JRequest::getString('aliasboard')));
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = 'select title, alias from #__tz_pinboard_boards where (title="' . $name . '" || alias="' . $alias . '") AND  not id = ' . $id_b . ' AND created_user_id=' . $id_user . '';
        $db->setQuery($sql);
        $num_row = $db->query();
        $row = $db->getAffectedRows($num_row);
        return $row;
    }

    /*
     * method check and update board
     */
    function getUpadateboard()
    {
        $phpA = $this->getUploadnameboard();
        if ($phpA == "0") {
            $this->updateboard();
        } else {
            $erros[] = " ERRO";
            return $erros;
        }
    }


    /*
     * method delete board
     */
    function delteboard()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $id_b = JRequest::getInt('id_board');
        $db = JFactory::getDbo();
        $sql = "delete from #__tz_pinboard_boards where id =$id_b AND created_user_id =$id_user";
        $db->setQuery($sql);
        $db->query();
    }


    /*
     * method get id of user
    */
    function getSosanhuser()
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        return $id_user;
    }

    /*
     * method check create board
    */
    function getCheckNewboar()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = 'select created_user_id from #__tz_pinboard_boards where created_user_id=' . $id_user . '';
        $db->setQuery($sql);
        $row = $db->loadResult();
        return $row;
    }


    function getCheckUserId()
    {
        $user_guest = JRequest::getInt('id_guest');
        $id_user = "";
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        return $id_user;
    }


    function getNumberBoars()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "select count(id) as id from #__tz_pinboard_boards where created_user_id=$id_user and state = 1";

        $db->setQuery($sql);
        $row = $db->loadObject();

        return $row;

    }


    // count pin
    function getNumberPin()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "SELECT count(c.id) as id
                        FROM #__users AS u
                        LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                        LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                        LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                        LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                        WHERE c.created_by =$id_user  and c.state =1";
        $db->setQuery($sql);
        $row = $db->loadObject();

        return $row;
    }

    function getNumberLike()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "select count(l.id) as id from #__tz_pinboard_like as l inner join #__tz_pinboard_pins as c on c.id = l.id_content  where l.id_user_p=$id_user AND l.like_p=1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;

    }

    function getNumberFollow()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "select count(id) as id from #__tz_pinboard_follow where id_guest=$id_user AND folowing=1";
        $db->setQuery($sql);
        $row = $db->loadObject();

        return $row;

    }

    function getNumberFollowing()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id_user = $user_guest;
        }
        $db = JFactory::getDbo();
        $sql = "select count(id) as id from #__tz_pinboard_follow where id_user=$id_user AND folowing=1";
        $db->setQuery($sql);
        $row = $db->loadObject();

        return $row;

    }


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


    function getDemcommnet()
    {
        $id_conten = $_POST['id_content'];
        $db = JFactory::getDbo();
        $sql = "select count(id) as number_id from #__tz_pinboard_comment where content_id =$id_conten";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


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

    function deleteimg_content()
    {
        $artId = JRequest::getInt('id_pins');
        $urlparams = JComponentHelper::getParams('com_tz_pinboard');
        $sizes = array();
        $sizes['XS'] = $urlparams->get('tz_image_xsmall', 100);
        $sizes['S'] = $urlparams->get('tz_image_small', 200);
        $sizes['M'] = $urlparams->get('tz_image_medium', 400);
        $sizes['L'] = $urlparams->get('tz_image_large', 600);
        $sizes['XL'] = $urlparams->get('tz_image_xlarge', 900);
        $query = "SELECT * FROM #__tz_pinboard_xref_content
        WHERE contentid = $artId";
        $db = JFactory::getDbo();
        $db->setQuery($query);
        if (!$db->query()) {
            echo $db->getErrorMsg();
            return false;
        }

        if ($rows = $db->loadObjectList()) {
            foreach ($rows as $item) {
                $path = null;
                foreach ($sizes as $key => $size) {
                    //Delete Image
                    if (!empty($item->images)) {
                        $str = str_replace('.' . JFile::getExt($item->images),
                            '_' . $key . '.' . JFile::getExt($item->images), $item->images);
                        $str = str_replace('/', DIRECTORY_SEPARATOR, $str);
                        $path = JPATH_SITE . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $str);

                        if (JFile::exists($path)) {
                            JFile::delete($path);
                        }
                    }
                }
            }
        }


    }

    function getInfoUSer()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            $id = $user_guest;
        }
        $db = JFactory::getDbo();
        $SQL = " SELECT u.id as uid, u.name as uname, u.email as uemail, u.registerDate as udate,
        tz.twitter as tztwitter,tz.images as tzimg, tz.facebook as tzfacebook, tz.google_one as tzgoogle_one,
        tz.description as tzdescription
        FROM #__users  as u left join
        #__tz_pinboard_users as tz on u.id=tz. 	usersid
        WHERE u.id=$id ";
        $db->setQuery($SQL);
        $row = $db->loadObject();
        return $row;
    }

    function getCheckInfo()
    {
        $user_guest = JRequest::getInt('id_guest');
        $user = JFactory::getUser();
        $id_user = $user->id;
        if (isset($user_guest) && !empty($user_guest)) {
            if ($id_user == $user_guest) {

                return "tr";
            }
        } else if (isset($id_user)) {
            return "tr";
        }
    }
}

?>

