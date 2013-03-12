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


class TZ_PinboardModelDetail extends JModelList{

        function populateState(){
            $app            = &JFactory::getApplication();
            $params         = $app -> getParams();
            $this -> setState('params',$params);
            $show_date_comment  = $params->get('show_date_comment');
            $page_commnet       = $params->get('page_commnet_detail');
            $detail_image_size  = $params->get('pinboard_image_size');
            $delete_text_cm     = $params->get('remove_comment');
            $change_comment     = $params->get('changecomment');
            $state_comment      =  $params->get('state_comment');
            $limit_commnet      = $params->get('Limits_comment');
            $show_tags_detail   = $params->get('show_tags_detail');
            $show_tags_title    = $params->get('show_tags_title');

            $this->setState('show_date',$show_date_comment);
            $this->setState('pinboard_image_size',$detail_image_size);
            $this->setState('show_tags_title',$show_tags_title);
            $this->setState('show_tags_detail',$show_tags_detail);
            $this->setState('remove_comment',$delete_text_cm);
            $this->setState('change_comment',$change_comment);
            $this->setState('state_comment',$state_comment);
            $this->setState('Limits_comment', $limit_commnet);
            $this->setState('page_cm',$page_commnet);
            $this->setState('star_page_cm',0);
        }


        // function display detail pin
        function  getDetailPins(){
            $id_content =JRequest::getInt('id_pins');
            $this->updateHist();
            if($id_content =='f') return false;
            if(isset($id_content) && !empty($id_content)){
                $db = &JFactory::getDbo();
                $sql ="SELECT u.id as id_user, u.name as name_user, tz_u.images as img_user,
                                ca.id as category_id,  ca.title as boar_title,
                                c.title as conten_title, c.introtext as content_introtext,
                                c.id as content_id, c.created as c_created, pz.images as poro_img, w.url as website
                      FROM #__users AS u  LEFT join  #__tz_pinboard_users as tz_u  on tz_u.usersid  = u.id
                              LEFT JOIN #__tz_pinboard_boards AS ca ON u.id = ca.created_user_id
                              LEFT JOIN #__tz_pinboard_pins AS c ON ca.id = c.catid
                              LEFT JOIN #__tz_pinboard_xref_content AS pz ON c.id = pz.contentid
                              LEFT JOIN #__tz_pinboard_website AS w ON c.id = w.contentid
                      WHERE  c.id=$id_content";
                $db->setQuery($sql);
                $row            = $db->loadObject();
                $pin_boar       = $this->DetailBoardpins($row->category_id);
                $row->pinboard  = $pin_boar;
                $follows        = $this->checkFollow($row->id_user);
                $row->follow    = $follows;
                $tangs          = $this->DetailTag($row->content_id);
                $row->tags      = $tangs;

                return $row;
            }

        }


        function DetailBoardpins($id){
            $db = &JFactory::getDbo();
            $sql ="SELECT c.catid AS catid_cm, c.created_by as created_by_c, xr.images AS xr_img
                    FROM #__tz_pinboard_pins AS c
                        LEFT JOIN #__tz_pinboard_xref_content AS xr ON c.id = xr.contentid
                    WHERE c.catid=$id order by c.created desc limit 0,12";
            $db->setQuery($sql);
            $row = $db->loadObjectList();
            return $row;
        }

        function checkFollow($id_guest){
            $user       = JFactory::getUser();
            $id_user    = $user->id;
            $db         = JFactory::getDbo();
            $sql        = "select folowing as f from #__tz_pinboard_follow where id_user=$id_user AND id_guest=$id_guest ";
            $db->setQuery($sql);
            $row        = $db->loadAssoc();
            return $row;
        }

        function DetailTag($id){
            $db     = &JFactory::getDbo();
            $sql    = "select t.id as tagid, t.name as tagname
                        from  #__tz_pinboard_tags AS t
                          LEFT JOIN #__tz_pinboard_tags_xref AS tx on t.id = tx.tagsid
                        WHERE tx.contentid =$id" ;
            $db->setQuery($sql);
            $row = $db->loadObjectList();
            return $row;
        }

        function updateHist(){
            $id_content =JRequest::getInt('id_pins');
            $db = &JFactory::getDbo();
            $sql = "update #__tz_pinboard_pins set hits = hits+1 where  id=$id_content";

            $db->setQuery($sql);
            $db->query();
        }

        function getSosanhuser(){
            $user   = JFactory::getUser();
            $id_user =$user->id;
            return $id_user;
        }
        // function count the number of comment
        function getDemcommnet(){
            $id_conten = JRequest::getInt('id_pins');
            $db= JFactory::getDbo();
            $sql="select count(id) as number_id from #__tz_pinboard_comment where content_id =$id_conten";
            $db->setQuery($sql);
            $row = $db->loadObject();
            return $row;
        }
        // display comment
        function getShowCommnet(){
            $id_conten = JRequest::getInt('id_pins');
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
        function Insert_comment_Content(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            $id_content =strip_tags(htmlspecialchars(JRequest::getInt('id_pins')));
            $content_cm =strip_tags(htmlspecialchars(JRequest::getString('content')));
            $content_cm = str_replace("'","\'",$content_cm);
            $delete_text = $this->getState('remove_comment');
            $change_comment = $this->getState('change_comment');
            $arr_commnet = explode(",",$delete_text);
            $arr_commnet = array_map("trim",$arr_commnet);
            $commnet_replace = str_replace($arr_commnet,$change_comment,$content_cm);
            $state = $this->getState('state_comment');
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
        function getShowcommnetInsert(){
            $user = JFactory::getUser();
            $id_user = $user->id;
            $db=JFactory::getDbo();
            $content_id = JRequest::getInt('id_pins');
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
        function DeleteCommnet(){
            $id_cm = $_POST['id'];
            $db = &JFactory::getDbo();
            $sql ="delete from #__tz_pinboard_comment where id=$id_cm";
            $db->setQuery($sql);
            $db->query();
        }
        function ajaxcomment(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            $this->Insert_comment_Content();
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'detail'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view = new TZ_PinboardViewDetail();
            $showdate = $this->getState('show_date');
            $view->assign('show_date',$showdate);
            $view-> assign('sosanhuser',$this->getSosanhuser());
            $view->assign('ShowCommnet',$this->getShowcommnetInsert());
            $arr = array();
            $arr['contents'] = $view->loadTemplate('comment');
            $arr['count_number'] = $this->getDemcommnet()->number_id;
            return $arr;
        }

        function ajaxdeletecomment(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            $this->DeleteCommnet();
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'detail'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view = new TZ_PinboardViewDetail();
            $showdate = $this->getState('show_date');
            $view->assign('show_date',$showdate);
            $view-> assign('sosanhuser',$this->getSosanhuser());
            $view->assign('ShowCommnet',$this->getShowCommnet());
            $arr = array();
            $arr['contents'] = $view->loadTemplate('comment');
            $arr['count_number'] = $this->getDemcommnet()->number_id;
            return $arr;
        }

        function ajaxphantrangcomment(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'detail'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view = new TZ_PinboardViewDetail();
            $page = $_POST['page'];
            $limit  = $this ->getState('page_cm');
            $limitstart1=   $limit * ($page-1);
            $offset = (int) $limitstart1;

            $this -> setState('star_page_cm',$offset);
            $show_date = $this->getState('show_date');
            $view->assign('show_date',$show_date);
            $view-> assign('sosanhuser',$this->getSosanhuser());
            $view->assign('ShowCommnet',$this->getShowCommnet());
            return $view->loadTemplate('comment');
        }

        function ajaxDetail(){
            require_once(JPATH_COMPONENT.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'detail'.DIRECTORY_SEPARATOR.'view.html.php'); // chen file view.html.php vao
            $view = new TZ_PinboardViewDetail();

            $Limits_comment = $this->getState('Limits_comment');
            $show_tags_title = $this->getState('show_tags_title');
            $show_tags_detail = $this->getState('show_tags_detail');
            $page_cm = $this->getState('page_cm');

            $showdate = $this->getState('show_date');
            $view->assign('show_date',$showdate);
            $view->assign('page_commnet',$page_cm);
            $view->assign('show_title',$show_tags_title);
            $view->assign('show_tags',$show_tags_detail);
            $view->assign('limit_comment',$Limits_comment);
            $view->assign('show_detail',$this->getDetailPins());
            $view-> assign('sosanhuser',$this->getSosanhuser());
            $view->assign('Demcommnet',$this->getDemcommnet());
            $view->assign('ShowCommnet',$this->getShowCommnet());
            $param_pinboard = &JComponentHelper::getParams('com_tz_pinboard');
            $img_size = $this->getState('pinboard_image_size');
            $view->assign('img_size',$img_size);
            return $view->loadTemplate('ajaxpins');
        }


        function checkFoolow(){
            $user   = JFactory::getUser();
            $id_user =$user->id;
            $id_user_guest= $_POST['id_user_guest'];
            $db = JFactory::getDbo();
            $SQL="SELECT folowing from #__tz_pinboard_follow where id_user =$id_user AND id_guest =$id_user_guest";
            $db->setQuery($SQL);
            $row = $db->query();
            $num_row = $db->getNumRows($row);
            return $num_row;
        }

        function inserFollow(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            $user   = JFactory::getUser();
            $id_user =$user->id;
            $id_user_guest= $_POST['id_user_guest'];
            $db = JFactory::getDbo();

            if(isset($id_user) && !empty($id_user)){
            $checklik = $this->checkFoolow();

            if(isset($checklik) AND !empty($checklik) ){
            $sql ="update #__tz_pinboard_follow set folowing ='1' where id_user =$id_user AND id_guest =$id_user_guest";
            }else if($checklik == ""){

            $sql="INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'1','".$id_user."','".$id_user_guest."') ";
            }
            $db->setQuery($sql);
            $db->query();
            }else{
            return 'f';
            }
        }

        function insertUnfollow(){
            if (!isset($_SERVER['HTTP_REFERER'])) return null;
            $refer  =   $_SERVER['HTTP_REFERER'];
            $url_arr=   parse_url($refer);
            if ($_SERVER['HTTP_HOST'] != $url_arr['host']) return null;
            $user   = JFactory::getUser();
            $id_user =$user->id;
            $id_user_guest= $_POST['id_user_guest'];
            $db = JFactory::getDbo();
            if(isset($id_user) && !empty($id_user)){
            $checklik = $this->checkFoolow();
            if(isset($checklik) AND !empty($checklik)){
             $sql ="update #__tz_pinboard_follow set folowing ='0' where id_user =$id_user AND id_guest =$id_user_guest";

            }else if(empty($checklik)){
             $sql="INSERT INTO #__tz_pinboard_follow  VALUES(NULL,'0','".$id_user_guest."','".$id_user."') ";

            }
            $db->setQuery($sql);
            $db->query();
            }
            else{
            return 'f';
            }


        }
}


        ?>