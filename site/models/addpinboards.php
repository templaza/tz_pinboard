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
jimport('joomla.application.component.modellist');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');
require(JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_tz_pinboard' . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . 'addpinboards.php');
class Tz_pinboardModelAddpinboards extends JModelList
{

    /**
     * Method to auto-populate the model state.

     */
    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        $this->setState('params', $params);
        $remove_comment = $params->get('remove_comment');
        $changecomment = $params->get('changecomment');
        $check_status = $params->get('tz_pin_approve');
        $max_keywoard = $params->get('text_keyword');
        $max_title = $params->get('text_title');
        $max_introtex = $params->get('text_descript_pin');
        $state_board = $params->get('state_boar');
        $limit_img = $params->get('limit_img');
        $CurlApi = $params->get('curl_api');
        $CurlKey = $params->get('curl_key');
        $senMail = $params->get('tz_sendMail');
        $sizeImage = array();
        $sizeImage['XS'] = $params->get('tz_image_xsmall', 100);
        $sizeImage['S'] = $params->get('tz_image_small', 200);
        $sizeImage['M'] = $params->get('tz_image_medium', 400);
        $sizeImage['L'] = $params->get('tz_image_large', 600);
        $sizeImage['XL'] = $params->get('tz_image_xlarge', 900);
        $this->setState('sendMail', $senMail);
        $this->setState('curl_key', $CurlKey);
        $this->setState('curl_api', $CurlApi);
        $this->setState('limit_img', $limit_img);
        $this->setState('size_img', $sizeImage);
        $this->setState('remove_comment', $remove_comment);
        $this->setState('change_comment', $changecomment);
        $this->setState('state_boar', $state_board);
        $this->setState('check_status', $check_status);
        $this->setState('max_text_keyword', $max_keywoard);
        $this->setState('max_text_title', $max_title);
        $this->setState('max_text_descript', $max_introtex);
    }

    function  __construct()
    {
        parent::__construct();
    }

    /*
    * Method insert content
    */
    function InsertContent()
    {
        $table = JTable::getInstance('Addpinboards', 'Table');
        $dt = JFactory::getDate();
        $dtime = $dt->toSql();
        $user = JFactory::getUser();
        $id_usert = $user->id;
        $status = $this->getState('check_status');
        $delete_text = $this->setState('remove_comment');
        $change_comment = $this->setState('change_comment');
        $arr_commnet = explode(",", $delete_text);
        $table->id = "";
        $table->title = strip_tags(htmlspecialchars($_POST['title_pin_local']));
        $table->title = str_replace($arr_commnet, $change_comment, $table->title);
        $table->introtext = strip_tags(htmlspecialchars($_POST['tz_descript_url']));
        $table->introtext = str_replace($arr_commnet, $change_comment, $table->introtext);
        $table->catid = strip_tags(htmlspecialchars($_POST['board']));
        $alias = trim($table->title);
        $table->alias = JApplication::stringURLSafe($alias);
        $table->state = $status;
        $table->created = $dtime;
        $table->created_by = $id_usert;
        $_price = trim(strip_tags(htmlspecialchars($_POST['tz_price'])));
        if (isset($_price) && !empty($_price)) {
            $arr_price = array();
            $arr_price['price'] = $_price;
            $price = new JRegistry();
            $price->loadArray($arr_price);
            $priceR = $price->toString();
            $table->attribs = $priceR;
        }
        if (empty($table->catid)) return false;
        $table->store();
        $db = JFactory::getDbo();
        $sql_select = "select id from #__tz_pinboard_pins where created_by=$id_usert order by id desc ";
        $db->query();
        $db->setQuery($sql_select);
        $row = $db->loadObject();
        return $row;
    }

    /*
     * Method check tag
     */
    function  getChecktag()
    {
        $keywords = strip_tags(htmlspecialchars($_POST['keywords_pin_local']));
        if (empty($keywords)) return $keywords = array();
        $keywords = trim($keywords);
        $keywords = mb_strtolower($keywords);
        $arr_key = array(',', '\'', '"', '.', '?', '/', '\\', '<', '>', '(', ')', '*', '&', '^', '%', '$', '#', '@', '!', '-', '+', '|', '`', '~');
        $keywords = str_replace($arr_key, ',', $keywords);
        $keywords = explode(",", $keywords);
        $keywords = array_unique($keywords);
        $arr = array();
        for ($i = 0; $i < count($keywords); $i++) { // get tag !empty
            $keywords[$i] = trim($keywords[$i]);
            if (!empty($keywords[$i])) {
                $arr[] = $keywords[$i];
            }
        }
        $db = JFactory::getDbo();
        $newkey = array();
        for ($i = 0; $i < count($arr); $i++) { // get tag name and id
            $sql = "select id from #__tz_pinboard_tags where name='" . trim($arr[$i]) . "'";
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
     * Method insert into table tag
     */
    function  InsertTags()
    {
        $db = JFactory::getDbo();
        $new = $this->getChecktag();
        $keywords = $new['new'];
        $row_k = $new['id'];
        if (is_array($keywords)) {
            $check_key = count($keywords);
            $row_is = null;
            if ($check_key != 0 && !empty($check_key)) { // insert into table tag and get id tag
                for ($i = 0; $i < $check_key; $i++) {
                    $sql_tag = "INSERT INTO #__tz_pinboard_tags VALUES(NULL,'" . trim($keywords[$i]) . "','1','')";
                    $sql = "select id from #__tz_pinboard_tags where name='" . trim($keywords[$i]) . "'";
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
            $sql = "select id from #__tz_pinboard_tags where name='" . $keywords . "'";
            $db->setQuery($sql_tag);
            $db->query();
            $db->setQuery($sql);
            $row = $db->loadResult();
            $row_is[] = $row;
        }
        if (empty($row_is)) { // if array $ros_is is empty
            $arrs = $row_k;
        } else if (!empty($row_k)) { // if array $row_k !empty
            $arrs = array_merge($row_k, $row_is); // Gross array
        } else {
            $arrs = $row_is;
        }
        return $arrs; // return if  of tag
    }


    /*
     * method insert into table tag content
     */
    function  InsertTagContent($id_content)
    {
        $id_tag = $this->InsertTags();
        if (is_array($id_tag) && count($id_tag) != 0) {
            $db = JFactory::getDbo();
            for ($i = 0; $i < count($id_tag); $i++) {
                $sql_insert = "INSERT INTO #__tz_pinboard_tags_xref VALUES(NULL,'" . $id_tag[$i] . "','" . $id_content . "')";
                $db->setQuery($sql_insert);
                $db->query();
            }
        }
    }

    /*
    * method insert into table tag img
    */
    function insertImg($id_content, $path_img)
    {
        $video = strip_tags(htmlspecialchars(JRequest::getString('video_hidden')));
        if (!empty($video)) {
            $referer = parse_url($video);
            $url_return = $referer['scheme'] . '://' . $referer['host'];
            if ($url_return == "http://vimeo.com") {
                $url = explode("=", $referer['query']);
                $url = "http://player.vimeo.com/video/" . $url[1] . "?autoplay=true";
            } else if ($url_return == "http://www.youtube.com") {
                $url = str_replace("/v/", "/embed/", $video);
                $url = $url . "&wmode=transparent&autoplay=1";

            }
        }
        $db = JFactory::getDbo();
        $sql = 'INSERT INTO #__tz_pinboard_xref_content VALUES(NULL, ' . $id_content . ',"","' . $path_img . '","", "", "' . $url . '", "image", "","", "", "", "", "", "")';
        $db->setQuery($sql);
        $db->query();
    }


    // start pin to website

    /**
     * Method check for length of text.
     */
    function length_character($arr, $text)
    {
        $text = $text;
        $count_text = strlen($arr);
        if ($count_text >= $text) {
            $new_arr = substr($arr, 0, $text);
            $array = explode(' ', $new_arr);
            array_pop($array);
            $string = implode(' ', $array);
        } else {
            $string = $arr;
        }

        return $this->malicious_characters($string);
    }

    /**
     * Method check the text containing the words malicious or not.
     */
    function malicious_characters($string)
    {
        $remove_comment = $this->getState('remove_comment');
        $remove_comment = explode(",", $remove_comment);
        for ($i = 0; $i < count($remove_comment); $i++) {
            if (!empty($remove_comment[$i])) {
                $str = strstr($string, $remove_comment[$i]);
                if ($str != false) {
                    $erro[] = $str;
                }
            }
        }
        if (isset($erro)) {
            return 'f';
        } else {
            return $string;
        }
    }


    /**
     * Method get the title,keywords,description image url.
     */
    function  getWebsite()
    {
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'HTTPFetcher.php');
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'readfile.php');
        $link_url = strip_tags(htmlspecialchars($_POST['link']));
        $link_url = trim($link_url);
        if (isset($link_url) && !empty($link_url)) {
            $data = $link_url;
            $content = array();
            $check_text = array("\\", "?", "~", "+", "-", "$", "#", "\"", "=", "/");
            $docUrl = new Services_Yadis_PlainHTTPFetcher();
            if ($contentURL = $docUrl->get($data)) {
                if (empty($content['title'])) {
                    if (preg_match('/<title>(.*?)<\/title>/i', $contentURL->body, $match)) { // get title
                        $title_url = str_replace($check_text, '', $match[1]);
                        $content['title'] = $this->length_character($title_url, $this->getState('max_text_title'));

                    }
                }
                if (preg_match('/<meta.*?name="description".*?\/>/i', $contentURL->body, $match)) { // get description
                    if (preg_match_all('/content="(.*?)"/', $match[0], $_match))
                        $introtext = array_pop($_match[0]);
                    $key_woards = explode("=", $introtext);
                    $introtext_url = str_replace($check_text, '', $key_woards[1]);
                    $content['introtext'] = $this->length_character($introtext_url, $this->getState('max_text_descript'));
                }


                if (preg_match('/<meta.*?name="keywords".*?\/>/i', $contentURL->body, $_match)) { // get keywords
                    if (preg_match_all('/content="(.*?)"/', $_match[0], $key)) {
                        $arr_s_key = array_pop($key[0]);
                        $key_woards = explode("=", $arr_s_key);
                        $keyword_url = str_replace($check_text, '', $key_woards[1]);
                        $content['keywoa'] = $this->length_character($keyword_url, $this->getState('max_text_keyword'));
                    }
                }

                // get host name
                $referer = parse_url($link_url);
                $url_return = $referer['scheme'] . '://' . $referer['host'];
                $content['url'] = $url_return;

                // get host name 2
                $slash = strrpos($link_url, '/') + 1;
                $link_url = substr($link_url, 0, $slash);
                $content['url2'] = $link_url;


                if (preg_match('/<meta\s*?property="og:image".*?content="(.*?)">/i', $contentURL->body, $match_img)) { // get img meta
                    $aar_icon = array();
                    $aar_icon[] = $match_img[1];
                }

                if (preg_match_all('/<img.*?src="(.*?)".*?/i', $contentURL->body, $match)) { // get img
                    $arr = array();
                    $arr = $match[1];
                } else {
                    return 'notimage';
                }
                if (!empty($aar_icon)) {
                    $new_arr = array();
                    $new_arr = array_merge($aar_icon, $arr);
                    $content['img'] = $new_arr;
                } else {
                    $content['img'] = $arr;
                }
                if (preg_match('/<meta\s*?property="og:video".*?content="(.*?)">/i', $contentURL->body, $match_v)) { // get img meta
                    $content['video'] = $match_v[1];
                }
                return $content;
            }
        }

    }

    /**
     * Method checks and return card img a valid.
     */
    function getImageURL($host, $image)
    {
        $image_return = '';
        if (preg_match('/^http:\/\/.*/i', $image) || preg_match('/^https:\/\/.*/i', $image)) {
            $image_return = $image;
        } elseif (preg_match('/^\/.*/i', $image)) {
            $referer = parse_url($host);
            $image_return = $referer['scheme'] . '://' . $referer['host'] . $image;
        } else {
            $slash = strrpos($host, '/') + 1;
            $host = substr($host, 0, $slash);
            $image_return = $host . $image;
        }
        return $image_return;
    }


    /**
     * Method Display board .
     */
    function showBoardweb()
    {
        $user = JFactory::getUser();
        $id = $user->id;
        $db = JFactory::getDbo();
        $sqk = "select id, title from #__tz_pinboard_boards where created_user_id=$id";
        $db->setQuery($sqk);
        $row = $db->loadObjectList();
        return $row;
    }


    /*
     * Method when  get tags " add_pin_website"  start  running  ajax  when the pin from the url
    */
    function ajaxUploadweb()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) return false;
        $refer = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($refer);
        if (isset($url_arr['port']) && $url_arr['port'] != '80') {
            $check = $url_arr['host'] . ":" . $url_arr['port'];
        } else {
            $check = $url_arr['host'];
        }
        if ($_SERVER['HTTP_HOST'] != $check) return null;

        $check_erro = $this->getWebsite();


        if (isset($check_erro['title']) && !empty($check_erro['title'])) {

            if ($check_erro['title'] == 'f') return false;
        }
        if (isset($check_erro['keywoa']) && !empty($check_erro['keywoa'])) {

            if ($check_erro['keywoa'] == 'f') return false;
        }
        if (isset($check_erro['introtext']) && !empty($check_erro['introtext'])) {
            if ($check_erro['introtext'] == 'f') return false;
        }

        return $check_erro;
    }

    /*
     * method insert into tale url
     */
    function  isertUrlwebsite($id_content)
    {
        $curl = $this->getState('curl_api');
        $key = trim($this->getState('curl_key'));
        $url = trim(strip_tags(htmlspecialchars(JRequest::getString('url_img'))));

        if ($curl == 1) {
            require(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'googleApi.php');
            $Google = new GoogleURL($key);
            $url = $Google->shorten($url);

        } else {
            $url = $url;
        }
        $db = JFactory::getDbo();
        $sql_inert = "INSERT INTO #__tz_pinboard_website VALUES(NULL,'" . $url . "','" . $id_content . "','0','0')";
        $db->setQuery($sql_inert);
        $db->query();
    }


    /**
     * Method upload img to url.
     */
    function UploadImgUrl()
    {
        $file = JRequest::getString('img_hidde');
        $tzFolderPath = JPATH_ROOT . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'tz_pinboard' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . 'cache';
        if (!JFolder::exists($tzFolderPath)) {
            JFolder::create($tzFolderPath);
        }
        if (empty($file)) return null;
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'HTTPFetcher.php');
        require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'readfile.php');
        $image = new Services_Yadis_PlainHTTPFetcher();
        $image = $image->get($file);

        $size_img = $this->getState('size_img');
        $FileName_img = 'Pin_' . time() . uniqid() . '.' . str_replace('image/', '', $image->headers['Content-Type']);

        $type = $this->_getImageType($FileName_img);

        if ($type == 1) {
            $basename = basename($image->final_url);
            $basename = $FileName_img;
            $uploadfile = $tzFolderPath . '/' . $basename;
            JFile::write($uploadfile, $image->body);
            $desttamp = $tzFolderPath . DIRECTORY_SEPARATOR . $FileName_img;
            preg_match('/media.*?$/', $desttamp, $path_img);
            return $path_img1 = str_replace('\\', '/', $path_img[0]);

        } else {
            $desttamp = $tzFolderPath . DIRECTORY_SEPARATOR . $FileName_img;
            JFile::write($desttamp, $image->body);
            $obj = new JImage($desttamp);
            $width = $obj->getWidth();
            $height = $obj->getHeight();
            $arr_upload = array();
            foreach ($size_img as $key => $value) {
                $destPath = $tzFolderPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $FileName_img);
                $destPath = str_replace('.' . JFile::getExt($destPath), '_' . $key . '.' . JFile::getExt($destPath), $destPath);
                $newHeight = ($height * $value) / $width;
                $newImage = $obj->resize($value, $newHeight, true);

                $arr_upload[] = $newImage->toFile($destPath, $type);
            }
            preg_match('/media.*?$/', $desttamp, $path_img);
            JFile::delete($desttamp);
            $path_img1 = str_replace('\\', '/', $path_img[0]);
            if ($arr_upload[0] == true) {
                return $path_img1;
            } else {
                return false;
            }
        }
    }

    /*
    * method insert active comment
   */
    function InsertActivePins($id_content)
    {
        $user = JFactory::getUser();
        $id_user = $user->id;
        $db = JFactory::getDbo();
        $sql = "INSERT INTO #__tz_pinboard_active  VALUES(NULL,'p','" . $id_content . "','" . $id_user . "','content') ";
        $db->setQuery($sql);
        $db->query();
    }

    /*
     * method insert Pins to website
     */
    function InsertPinHost()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $SendMial = $this->getState('sendMail');
        $path_img = $this->UploadImgUrl();
        if ($path_img == false) return false;
        $id_content = $this->InsertContent()->id;
        if (isset($id_content) && !empty($id_content)) {
            $this->insertImg($id_content, $path_img);
            $this->InsertTagContent($id_content);
            $this->isertUrlwebsite($id_content);
            $this->InsertActivePins($id_content);
            if ($SendMial == 1) {
                $this->TzSendEmail($id_content);
            }
            return $id_content;
        } else {
            return false;
        }
    }

    //end  pin  website

    //start upload pin  local
    /*
     * method returns extensions the card img
    */
    function _getImageType($filename)
    {
        if ($filename) {
            $type = JFile::getExt($filename);
            if (strtolower($type) == 'png') {
                return IMAGETYPE_PNG;
            } elseif (strtolower($type) == 'gif') {
                return IMAGETYPE_GIF;
            } else {
                return IMAGETYPE_JPEG;
            }
        }
        return false;
    }


    /*
     * method upload img to local
    */
    function uploadLocal()
    {
        $img = $_FILES['upload_pinl'];
        $arr = array('image/jpeg', 'image/jpg', 'image/bmp', 'image/gif', 'image/png', 'image/ico');
        $maxSize = 10 * 1024 * 1024;
        $erro = array();
        $size_img = $this->getState('size_img');
        $tzFolderPath = JPATH_ROOT . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'tz_pinboard' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . 'cache';
        if (!JFolder::exists($tzFolderPath)) {
            JFolder::create($tzFolderPath);
        }


        $check_file_type = in_array(strtolower($img['type']), $arr);
        if ($check_file_type == false) {
            $erro[] = "incorrect file type";
        }
        if ($img['size'] > $maxSize) {
            $erro[] = "file too large";
        }

        $_erro = count($erro);
        if ($_erro == '0') {
            $FileName_img = 'Pin_' . time() . uniqid() . '.' . str_replace('image/', '', $img['type']);
            $_FILES['upload_pinl']['name'] = $FileName_img;
            $type = $this->_getImageType($FileName_img);
            if ($type == 1) {
                $uploadfile = $tzFolderPath . '/' . basename($_FILES['upload_pinl']['name']);
                move_uploaded_file($_FILES['upload_pinl']['tmp_name'], $uploadfile);
                $desttamp = $tzFolderPath . DIRECTORY_SEPARATOR . $FileName_img;
                preg_match('/media.*?$/', $desttamp, $path_img);
                return $path_img1 = str_replace('\\', '/', $path_img[0]);
            } else {
                $desttamp = $tzFolderPath . DIRECTORY_SEPARATOR . $FileName_img;
                $obj = new JImage($img['tmp_name']);
                $width = $obj->getWidth();
                $height = $obj->getHeight();
                $arr_upload = array();
                foreach ($size_img as $key => $newWidth) {
                    $destPath = $tzFolderPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $FileName_img);
                    $destPath = str_replace('.' . JFile::getExt($destPath), '_' . $key . '.' . JFile::getExt($destPath), $destPath);
                    $newHeight = ($height * (int)$newWidth) / $width;
                    $newImage = $obj->resize($newWidth, $newHeight, true);
                    $arr_upload[] = $newImage->toFile($destPath, $type);
                }
                if ($arr_upload[0] == true) {
                    preg_match('/media.*?$/', $desttamp, $path_img);
                    return $path_img1 = str_replace('\\', '/', $path_img[0]);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /*
     * method insert Pins to local
    */
    function InsertLocal()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $SendMial = $this->getState('sendMail');
        $path_img = $this->uploadLocal();

        if ($path_img == false) return false;
        $id_content = $this->InsertContent()->id;
        if (isset($id_content) && !empty($id_content)) {
            $this->InsertTagContent($id_content);
            $this->insertImg($id_content, $path_img);
            $this->InsertActivePins($id_content);
            if ($SendMial == 1) {
                $this->TzSendEmail($id_content);
            }
            return $id_content;
        } else {
            return false;
        }
    }

// end insert local


// create Borad
    function checkAlias()
    {
        $user = JFactory::getUser();
        $created_user_id = $user->id;
        $name = strip_tags(htmlspecialchars(JRequest::getString('boardname')));
        $alias = strip_tags(htmlspecialchars(JRequest::getString('aliasname')));
        if (isset($alias) && !empty($alias)) {
            $check = 'WHERE ( title="' . $name . '" OR alias="' . $alias . '" ) AND created_user_id=' . $created_user_id . '';
        } else {
            $check = 'WHERE title="' . $name . '" AND  created_user_id=' . $created_user_id . '';
        }
        $db = JFactory::getDbo();
        $sql = 'select title, alias from #__tz_pinboard_boards ' . $check . '';
        $db->setQuery($sql);
        $num_row = $db->query();
        $row = $db->getAffectedRows($num_row);
        return $row;
    }

    function  InsertCategory()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $user = JFactory::getUser();
        $dt = JFactory::getDate();
        $state_b = $this->getState('state_boar');
        $title = strip_tags(htmlspecialchars($_POST['boardname']));
        $alias = strip_tags(htmlspecialchars($_POST['aliasname']));
        if ($alias) {
            $alias = $alias;
        } else {
            $alias = $title;
        }
        $alias = JApplication::stringURLSafe($alias);
        $description = strip_tags(htmlspecialchars($_POST['decsipt']));
        $created_time = $dt->toSql();
        $catid = $_POST['catego'];
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

    function getCheckUser()
    {
        $user = JFactory::getUser();
        $id = $user->id;
        return $id;
    }


    /*
     * send email
    */

    function TzSendEmail($id)
    {
        $title = "Add Pinboard";
        $url_Detal = JRoute::_(TZ_PinboardHelperRoute::getPinboardDetailRoute($id), true, -1);
        $doc = JFactory::getConfig();
        $arr = $doc->toArray();
        $body = JText::sprintf("TZ_PINBOARD_SEND_EMAIL", $arr['fromname'], '<a href="' . $url_Detal . '">' . $url_Detal . '</a>');
        $contact = $arr['mailfrom'];
        $mail = JFactory::getMailer();
        $mail->addRecipient($contact, 'Admin');
        $mail->setSubject($title);
        $mail->setBody($body);
        $mail->IsHTML(true);
        $sent = $mail->Send();
    }
}

?>