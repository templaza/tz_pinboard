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
jimport( 'joomla.filesystem.folder');

class TZ_PinboardModelPinboard extends JModelList{



    /**
     * Method to auto-populate the model state.

     */
    function populateState(){
        $app            = &JFactory::getApplication();
        $params         = $app -> getParams();
        $this -> setState('params',$params);
        $catid          = $params->get('catid');
        $limit_pin      = $params->get('tz_article_limit');
        $limitstart     = JRequest::getCmd('limitstart',0);
        $width_columns  = $params->get('width_columns');
        $type_detail    =$params->get('type_detail');
        $tz_layout      = $params->get('tz_pinboard_layout');
        $limit_commnet  = $params->get('Limits_comment');
        $state_comment  = $params->get('state_comment');
        $change_comment = $params->get('changecomment');
        $delete_text_cm = $params->get('remove_comment');
        $page_commnet   = $params->get('page_commnet');
        $type_show_pin  = $params->get('type_show_pin');
        $arrangements_pins = $params->get('arrangements_pins');
        $tz_pin_approve = $params->get('tz_pin_approve');
        $this->setState('type_detail',$type_detail);
        $this->setState('arrangements_pins',$arrangements_pins);
        $this->setState('check_status',$tz_pin_approve);
        $this->setState('type_show_pin',$type_show_pin);
        $this->setState('tz_layout',$tz_layout);
        $this->setState('page_cm',$page_commnet);
        $this->setState('star_page_cm',0);
        $this->setState('limit_commnet', $limit_commnet);
        $this->setState('remove_comment',$delete_text_cm);
        $this->setState('change_comment',$change_comment);
        $this->setState('state_comment',$state_comment);
        $this->setState('width_columns',$width_columns);
        $this->setState('catids',$catid);
        $this->setState('limit_pin',$limit_pin);
        $this->setState('limitstar',$limitstart);
    }

    /*
     * MEthod Display the category name when selected in the menu
     */

    function getNameCategory(){
        $catids = $this->getState('catids');
        $check = count($catids);
        if($check > 1 && $catids[0]==""){
            array_shift($catids);            // delete array empty
        }
        $catids = implode(',',$catids);
        if(isset($catids) && !empty($catids)){
            $catids = "where id in($catids)";
            $db = JFactory::getDbo();
            $sql ='select title FROM #__tz_pinboard_category '.$catids.'';
            $db->setQuery($sql);
            $row = $db->loadObjectList();
            return $row ;
        }else{
            return 0;
        }
    }



    /*
     * method display pins
     */
    function getPins(){
        $limit          = $this->getState('limit_pin');
        $limitStart     = $this->getState('limitstar');
        $type_show_pin  = $this->getState('type_show_pin');
        $arrangements   = $this->getState('arrangements_pins');
        $catids         = $this->getState('catids');
        $check          = count($catids);
        if($check > 1 && $catids[0]==""){
            array_shift($catids);               // delete array empty
        }
        $catids         = implode(',',$catids);
        $tz_layout      = $this->getState('tz_layout');
        if(isset($catids) && !empty($catids) && $catids !=""){
            $catids     = "where ca.catid in($catids) and c.state=1 order by c.$type_show_pin $arrangements";
        }else{
            $catids     =  "where c.state=1 order by c.$type_show_pin $arrangements";
        }
        $db = &JFactory::getDbo();
        $sql ="SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.hits as content_hit , pz.images as poro_img,
                        w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                        c.catid as catidc, u.name as user_name,  us.images as user_img , us.url as usurl, us.gender as usgender,
                        us.twitter as ustwitter, us.facebook as usfacebook, us.google_one as usgoogle_one, us.description as usdescription
                FROM #__users AS u
                    LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                    LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                    LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                    LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                    LEFT JOIN #__tz_pinboard_users as us ON u.id = us.usersid  $catids";

        $sql2 ="SELECT u.id as id_user, c.title as conten_title,  c.id as content_id, c.hits as content_hit, pz.images as poro_img,
                        w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                        c.catid as catidc, u.name as user_name,  us.images as user_img, us.url as usurl, us.gender as usgender,
                        us.twitter as ustwitter, us.facebook as usfacebook, us.google_one as usgoogle_one, us.description as usdescription
                FROM #__users AS u
                    LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                    LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                    LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                    LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                    LEFT JOIN #__tz_pinboard_users as us ON u.id = us.usersid  $catids  ";
        $db->setQuery($sql);
        $tinh  = $db->query();
        $total = $db->getNumRows($tinh);
        $this -> pagNavPins         = new JPagination($total,$limitStart,$limit);

        if($tz_layout =="default"){ // Select the type of paging
            $db->setQuery($sql2,$this -> pagNavPins -> limitstart,$this -> pagNavPins -> limit);
        }else{
            $db->setQuery($sql2,$limitStart,$limit);
        }

        $row = $db->loadObjectList();
        foreach($row as $item){
            $check_l = $this->chekcLikeUser($item->content_id);
            $item->checl_l = $check_l;
            $demL = $this->countLike($item->content_id);
            $item->demL = $demL;
            $countComment = $this->countComment($item->content_id);
            $item->countComment = $countComment;
            $show_comment = $this->getShowCommnet($item->content_id);
            $item->showcomment = $show_comment;
            $tangs = $this->DetailTag($item->content_id);
            $item->tags = $tangs;
        }
        return $row;
    }

    /*
     * Method paging in joomla
     */
    function getPaginationPins(){
        if(!$this->pagNavPins)
            return '';
            return $this->pagNavPins;
    }


    /*
     * Method check users like or not
     */
    function  chekcLikeUser($id_content){
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql ="select like_p as p from #__tz_pinboard_like where id_content=$id_content AND id_user_p =$id_user";
        $db->setQuery($sql);
        $row = $db->loadAssoc();
        return $row;
    }
    
    
    /*
     * Method count Like 
    */
    function countLike($id_content){
        $db = JFactory::getDbo();
        $sql ="select count(id) as count_l from #__tz_pinboard_like where id_content=$id_content AND like_p =1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }
    
    /*
     * Method count comment
     */
    function countComment($id_content){
        $db = JFactory::getDbo();
        $sql ="select count(id) as count_l from #__tz_pinboard_comment where content_id=$id_content";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     *  Method get logo user
     */
    function getUserImgLogin(){
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql ="select images from #__tz_pinboard_users where usersid=$id_user";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    /*
     *  Method get id user
     */
    function getIdUser(){
        $user   = JFactory::getUser();
        $id_user =$user->id;
        return $id_user;
    }

    /*
     * method check user like or not like and get id user like
     */
    function checklike(){
        $user   = JFactory::getUser();
        $id_user =$user->id;
        $id_content= $_POST['id_conten'];
        $db = JFactory::getDbo();
        $SQL="SELECT id_user_p from #__tz_pinboard_like where id_user_p=$id_user AND id_content=$id_content";
        $db->setQuery($SQL);
        $row = $db->loadObject();
        return $row;
    }


    /*
     *  Method insert into table like
     */
    function inserLike(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        $user   = JFactory::getUser();
        $id_user =$user->id;
        $id_content= $_POST['id_conten'];
        $db = JFactory::getDbo();
        if(isset($this->checklike()->id_user_p)){
            $checklik = $this->checklike()->id_user_p;
        }
        if(isset($id_user) && !empty($id_user)){
            if(isset($checklik) AND !empty($checklik)){
                $sql ="update #__tz_pinboard_like set like_p ='1' where id_content=$id_content AND id_user_p=$id_user";
            }else if(empty($checklik)){
                $sql="INSERT INTO #__tz_pinboard_like  VALUES(NULL,'1','".$id_content."','".$id_user."') ";
            }
            $db->setQuery($sql);
            $db->query();
            $lik =  $this->countLike($id_content)->count_l;
            return $lik;
        }else{
         return "f";
        }
    }


    /*
     *  Method insert  unlike
     */
    function insertUnlike(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        $user   = JFactory::getUser();
        $id_user =$user->id;
        $id_content= $_POST['id_conten'];
        $db = JFactory::getDbo();
        $checklik = $this->checklike()->id_user_p;
        if(isset($id_user) && !empty($id_user)){
            if(isset($checklik) AND !empty($checklik)){
                $sql ="update #__tz_pinboard_like set like_p ='0' where id_content=$id_content AND id_user_p=$id_user   ";
            }else if(empty($checklik)){
                $sql="INSERT INTO #__tz_pinboard_like  VALUES(NULL,'0','".$id_content."','".$id_user."') ";
            }
                $db->setQuery($sql);
                $db->query();
                $lik =  $this->countLike($id_content)->count_l;
                return $lik;
        }else{
            return "f";
        }
    }


    /*
     * Method get board user repin
     */
    function showBoardweb(){
        $user = JFactory::getUser();
        $id = $user->id;
        $db = &JFactory::getDbo();
        $sqk = " select id, title from #__tz_pinboard_boards where created_user_id=$id";
        $db->setQuery($sqk);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * Method get data repin
     */
    function  getRepin(){
        $id_conten = $_POST['id_conten'];
        if(isset($id_conten) && !empty($id_conten)){
            $db = &JFactory::getDbo();
            $sql ="SELECT u.id as id_user, u.name as name_user, ca.id as category_id, c.title as conten_title, c.introtext as content_introtext
                          ,c.id as content_id, pz.images as poro_img, w.url as website, c.alias as content_alias, c.access as content_access
                   FROM #__users AS u
                       LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                       LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                       LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                       LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                   WHERE  c.id=$id_conten";
            $db->setQuery($sql);
            $row = $db->loadObject();
            $tangs = $this->detailTag($row->content_id);
            $row->tags = $tangs;
            return $row;
        }

    }


    /*
     * Method ajax repins
     */
    function ajaxRepins(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        $user = JFactory::getUser();
        $id = $user->id;
        if(isset($id) && !empty($id)){ // check id exists or not ?
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view = new TZ_PinboardViewPinboard();
            $param_porfolio = &JComponentHelper::getParams('com_tz_pinboard');
            $img_size = $param_porfolio->get('image_repin');
            $view->assign('img_size',$img_size);
            $view->assign('repin',$this->getRepin());
            $sate= $this->getState('params');
            $max_title = $sate->get('text_title');
            $max_introtext = $sate->get('text_descript_pin');
            $view -> assign('max_introtext',$max_introtext);
            $view->assign('max_title',$max_title);
            $view -> assign('Showboardd',$this->showBoardweb());
            return $view -> loadTemplate('more_repin');
        }else{
            return 0;
        }

    }


    /*
     * MEthod insert content
     */
    function insertRepinconten(){
        $title =strip_tags(htmlspecialchars($_POST['title_content']));
        $title = str_replace("'","\'",$title);
        $board = strip_tags(htmlspecialchars($_POST['id_category']));
        $tz_descript =strip_tags(htmlspecialchars($_POST['introtex_content']));
        $tz_descript = str_replace("'","\'",$tz_descript);
        $alias = strip_tags(htmlspecialchars($_POST['tz_content_alias']));
        $access =strip_tags(htmlspecialchars($_POST['tz_content_access']));
        $dt = JFactory::getDate();
        $dtime = $dt->toSql();
        $user = JFactory::getUser();
        $id_usert = $user->id;
        $status = $this->getState('check_status');
        $db = &JFactory::getDbo();
        $sql_inert = "INSERT INTO #__tz_pinboard_pins VALUES (NULL, '0', '".$title."', '".$alias."', '".$tz_descript."', '', '$status', '$board', '$dtime', '$id_usert', '', '0000-00-00 00:00:00', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '1', '0', '', '', '".$access."', '0', '', '0', '', '')";
        $sql_select ="select id from #__tz_pinboard_pins where created_by=$id_usert order by id desc ";
        $db->setQuery($sql_inert);
        $db->query();
        $db->setQuery($sql_select);
        $row = $db->loadObject();
        $this->setState('id_content',$row->id);
        return $row;
    }


    /*
     * Method insert website
     */
    function  isertRepinwebsite(){
        $id_conten = $this->getState('id_content');
        $url = strip_tags(htmlspecialchars( $_POST['websit_conten']));
        $id_user_repin = $_POST['id_usert'];
        $tz_user_name =strip_tags(htmlspecialchars($_POST['tz_user_name']));
        $user = JFactory::getUser();
        $id_usert = $user->id;
        if($id_usert ==$id_user_repin){
           $id_user_repin =0;
           $tz_user_name =0;
        }
        $db = &JFactory::getDbo();
        $sql_inert ="INSERT INTO #__tz_pinboard_website VALUES(NULL,'".$url."','.$id_conten.','$id_user_repin','".$tz_user_name."')";
        $db->setQuery($sql_inert);
        $db->query();
    }

    /*
     *  method insert images
     */
    function  insertRepinimg(){
        $id_conten = $this->getState('id_content');
        $path_img=$_POST['img_conten'];
        $db = &JFactory::getDbo();
        $sql = 'INSERT INTO #__tz_pinboard_xref_content VALUES (NULL, '.$id_conten.',"","'.$path_img.'","", "", "", "image", "","", "", "", "", "", "")';
        $db->setQuery($sql);
        $db->query();
    }


    /*
     * method insert tag
     */
    function insertTag(){
        $id_conten = $this->getState('id_content');
        $tz_tag = $_POST['tz_tag'];
        $tz_tag = explode(",",$tz_tag);
        array_pop($tz_tag);
        $db = &JFactory::getDbo();
        for($i= 0; $i< count($tz_tag); $i++){
            $sql_insert = "INSERT INTO #__tz_pinboard_tags_xref VALUES(NULL,'".trim($tz_tag[$i])."','".$id_conten."')";
            $db->setQuery($sql_insert);
            $db->query();
        }
    }


    /*
     * Method insert repin
     */
    function insertRepinAll(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        $this->insertRepinconten();
        $this->isertRepinwebsite();
        $this->insertTag();
        $this->getimageCopy();
        require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
        $view   = new TZ_PinboardViewPinboard();
        $param_pinboard = &JComponentHelper::getParams('com_tz_pinboard');
        $img_size = $param_pinboard->get('portfolio_image_size');
        $width_columns = $param_pinboard->get('width_columns');
        $text_commnet = $param_pinboard->get('Limits_comment');
        $type_detail = $this->getState('type_detail');
        $view->assign('type_detail',$type_detail);
        $view->assign('Limit_comment',$text_commnet);
        $view->assign('width_columns',$width_columns);
        $view->assign('img_size',$img_size);
        $view->assign('Pins',$this->selectRepin());
        $view->assign('UserImgLogin',$this->getUserImgLogin());
        $view->assign('sosanhuser',$this->getIdUser());
        return ($view -> loadTemplate('pinboard'));
    }

    /*
     * method returns the result repin
     */
    function selectRepin(){
        $user = JFactory::getUser();
        $id_usert = $user->id;
        $catids = $this->getState('catids');
        if(isset($catids) && !empty($catids)){
            $catids = implode(',',$catids);
            $catids = "where ca.catid in($catids) AND c.created_by =$id_usert order by c.created desc limit 0,1";
        }else{
            $catids="where c.created_by =$id_usert order by c.created desc limit 0,1";
        }
        $sql ="SELECT u.id as id_user, c.title as conten_title,  c.id as content_id,  c.hits as content_hit, pz.images as poro_img,
                    w.url as website , w.id_user_repin as id_user_repin, w.name_user_repin as name_user_repin,
                    c.catid as catidc, u.name as user_name,  us.images as user_img
                FROM #__users AS u
                    LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                    LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                    LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                    LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                    LEFT JOIN #__tz_pinboard_users as us ON u.id = us.usersid
                    $catids  ";
        $db = JFactory::getDbo();
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        foreach($row as $item){
            $check_l = $this->chekcLikeUser($item->content_id);
            $item->checl_l = $check_l;
            $demL = $this->countLike($item->content_id);
            $item->demL = $demL;
            $countComment = $this->countComment($item->content_id);
            $item->countComment = $countComment;
            $tangs = $this->DetailTag($item->content_id);
            $item->tags = $tangs;
            $item->tags = $tangs;
        }
        return $row;
    }

    function detailTag($id){
        $db = &JFactory::getDbo();
        $sql ="select t.id as tagid, t.name as tagname
                from #__tz_pinboard_tags AS t
                    LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                WHERE tx.contentid =$id" ;
        $db->setQuery($sql);
        $row = $db->loadObjectList();
        return $row;
    }

    /*
     * method  start  ajax paging khen tags = add_ajax
     */
    function PinAjax(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
        $view   = new TZ_PinboardViewPinboard();
        $page = JRequest::getInt('page');
        $type_detail = $this->getState('type_detail');
        $limit  = $this ->getState('limit_pin');
        $limitstart1=   $limit * ($page-1);
        $offset = (int) $limitstart1;
        $this -> setState('limitstar',$offset);
        $param_pinboard = &JComponentHelper::getParams('com_tz_pinboard');
        $text_commnet = $param_pinboard->get('Limits_comment');
        $img_size = $param_pinboard->get('portfolio_image_size');
        $width_columns = $param_pinboard->get('width_columns');
        $tz_layout = $param_pinboard->get('tz_pinboard_layout');
        $page_cm = $this->getState('page_cm');
        $view->assign('page_com',$page_cm);
        $view->assign('type_detail',$type_detail);
        $view->assign('Limit_comment',$text_commnet);
        $view->assign('UserImgLogin',$this->getUserImgLogin());
        $view->assign('sosanhuser',$this->getIdUser());
        $view->assign('tz_layout',$tz_layout);
        $view->assign('width_columns',$width_columns);
        $view->assign('img_size',$img_size);
        $view->assign('Pins',$this->getPins());
        return ($view -> loadTemplate('pinboard'));
    }



    /*
     * method check comment
     */
    function  checkInsertComment(){
        $user = JFactory::getUser();
        $id_user = $user->id;
        $IP =  $_SERVER['REMOTE_ADDR'];
        $db = &JFactory::getDbo();
        $sql="select checkIP FROM #__tz_pinboard_comment WHERE id_user=$id_user and IP ='".$IP."' limit 0,1";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * method insert commnet
     */
    function Tz_comment_Content(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php');
        $view   = new TZ_PinboardViewPinboard();
        $state = $this->getState('params');
        $id_content =strip_tags(htmlspecialchars($_POST['id_content']));
        $content_cm =strip_tags(htmlspecialchars( $_POST['content']));
        $content_cm = str_replace("'","\'",$content_cm);
        $delete_text = $this->setState('remove_comment');
        $change_comment = $this->setState('change_comment');
        $arr_commnet = explode(",",$delete_text);
        $arr_commnet = array_map("trim",$arr_commnet);
        $commnet_replace = str_replace($arr_commnet,$change_comment,$content_cm);
        $state = $this->setState('state_comment');
        $IP =  $_SERVER['REMOTE_ADDR'];
        $user = JFactory::getUser();
        $id_user = $user->id;
        $dt = JFactory::getDate();
        $dtime = $dt->toSql();
        $db =& JFactory::getDbo();
        $checkIP = $this->checkInsertComment();
        if($checkIP==""){
            $sql = "INSERT INTO #__tz_pinboard_comment VALUES('NULL','".$commnet_replace."', '$id_content', '$id_user','".$state."','".$dtime."','".$IP."','1')";
        }else{
            $checkIP = $this->checkInsertComment()->checkIP;
            $sql = "INSERT INTO #__tz_pinboard_comment VALUES('NULL','".$commnet_replace."', '$id_content', '$id_user','".$state."','".$dtime."','".$IP."','.$checkIP.')";
        }
        $db->setQuery($sql);
        $db->query();
    }

    /*
     * method display comment
     */
//    function getShowCommnet(){
//        $id_conten = $_POST['id_conten'];
//        $limit_star = $this->getState('star_page_cm');
//        $limit = $this->getState('page_cm');
//        $db = JFactory::getDbo();
//        $sql="SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
//                     c.created_by as create_by
//                FROM #__users AS u
//                    LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
//                    LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
//                    LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
//                WHERE cm.content_id =$id_conten AND cm.state=1 AND cm.checkIP=1  order by cm.id desc limit $limit_star,$limit";
//        $db->setQuery($sql);
//        if($row = $db->loadObjectList()){
//            return $row;
//        }
//        return false;
//    }
    function ajaxPTCommnet(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewPinboard();
        $page = $_POST['page'];
        $limit  = $this ->getState('page_cm');
        $limitstart1=   $limit * ($page-1);
        $offset = (int) $limitstart1;
        $this -> setState('star_page_cm',$offset);
        $view->assign('displayComment',$this->getPT_comment());
        return $view->loadTemplate('commentall');
    }
    function getPT_comment(){
        $id_conten = $_POST['id_pins'];
        $limit_star = $this->getState('star_page_cm');
        $limit = $this->getState('page_cm');
        $db = JFactory::getDbo();
        $sql="SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
                     c.created_by as create_by
                FROM #__users AS u
                    LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                    LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
                    LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
                WHERE cm.content_id =$id_conten AND cm.state=1 AND cm.checkIP=1  order by cm.id desc limit $limit_star,$limit";
        $db->setQuery($sql);
        if($row = $db->loadObjectList()){
            return $row;
        }
        return false;
    }
    function getShowCommnet($id_content){
        $limit_star = $this->getState('star_page_cm');
        $limit = $this->getState('page_cm');
        $db = JFactory::getDbo();
        $sql="SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
                     c.created_by as create_by
                FROM #__users AS u
                    LEFT JOIN #__tz_pinboard_users AS tz ON u.id = tz.usersid
                    LEFT JOIN #__tz_pinboard_comment AS cm ON cm.id_user = u.id
                    LEFT JOIN #__tz_pinboard_pins AS c ON cm.content_id = c.id
                WHERE cm.content_id =$id_content AND cm.state=1 AND cm.checkIP=1  order by cm.id desc limit $limit_star,$limit";
        $db->setQuery($sql);
        if($row = $db->loadObjectList()){
            return $row;
        }
        return false;
    }


    /*
     *  method count the number of comment
     */
    function getDemcommnet(){
        $id_conten = $_POST['id_content'];
        $db= JFactory::getDbo();
        $sql="select count(id) as number_id from #__tz_pinboard_comment where content_id =$id_conten";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }


    /*
     * method Display comments as insert complete
     */
    function getShowcommnetInsert(){
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db=JFactory::getDbo();
        $content_id = JRequest::getInt('id_content');
        $sql="SELECT u.name as user_name,cm.content_id  as content_id_cm, u.id as id_user, tz.images as img_user, cm.content as content_cm, cm.dates as dates, cm.id as id_comment,
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

    function ajaxcommnet_cm(){
        if (!isset($_SERVER['HTTP_REFERER'])) return null;
        $refer  =   $_SERVER['HTTP_REFERER'];
        $url_arr=   parse_url($refer);
        if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
        $user   = JFactory::getUser();
        $id_user =$user->id;
        if(!isset($id_user) && empty($id_user)) return null;
        $this->Tz_comment_Content();
        require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pinboard'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
        $view = new TZ_PinboardViewPinboard();
        $view-> assign('sosanhuser',$this->getIdUser());
        $view->assign('ShowCommnet',$this->getShowcommnetInsert());
        $arr = array();
        $arr['contents'] = $view->loadTemplate('pin_cm');
        $arr['count_number'] = $this->getDemcommnet()->number_id;
        return $arr;

    }


    /*
     * method copy image repin
     */
    function getimageCopy(){
        $id_conten = $this->getState('id_content');
        $path_img=$_POST['img_conten'];
        //Copy image fields
        $rowimages=$path_img;
        $row = explode("/",$rowimages);
        $name = $row[count($row)-1];
        $urlparams = &JComponentHelper::getParams('com_tz_pinboard');
        $sizes = array();
        $sizes['XS']  = $urlparams->get('tz_image_xsmall',100);
        $sizes['S']  = $urlparams->get('tz_image_small',200);
        $sizes['M'] = $urlparams->get('tz_image_medium',400);
        $sizes['L'] = $urlparams->get('tz_image_large',600);
        $sizes['XL']  = $urlparams->get('tz_image_xlarge',900);
        if(!empty($rowimages)){
            $imageName    = 'Pin_'.time().uniqid().'.' .JFile::getExt($name);;
            $path   = JPATH_SITE.DIRECTORY_SEPARATOR.$rowimages;
            $path22="media/tz_pinboard/article/cache/".$imageName;
            $path2   = JPATH_SITE.DIRECTORY_SEPARATOR.$path22;
            foreach($sizes as $key => $size){
                $dest   = str_replace('.'.JFile::getExt($path),'_'.$key.'.'.JFile::getExt($path),$path);
                $destPath   = str_replace('.'.JFile::getExt($path2),'_'.$key.'.'.JFile::getExt($path2),$path2);
                if(JFile::exists($dest)){
                    JFile::copy($dest,$destPath);
                }
            }
        }
        $db = &JFactory::getDbo();
        $sql = 'INSERT INTO #__tz_pinboard_xref_content VALUES (NULL, '.$id_conten.',"","'.$path22.'","", "", "", "image", "","", "", "", "", "", "")';
        $db->setQuery($sql);
        $db->query();
    }




}
?>