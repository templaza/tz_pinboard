<?php
/*------------------------------------------------------------------------

# TZ Portfolio Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgUserTZ_Pinboard extends JPlugin
{
    function plgUserTZ_Pinboard(&$subject, $config) {

        parent::__construct($subject, $config);
    }

    function onUserAfterSave($user, $isnew, $success, $msg){
        return $this -> onAfterSaveUser($user, $isnew, $success, $msg);
    }



    function onAfterSaveUser($user, $isnew, $success, $msg){

        $mainframe = &JFactory::getApplication();
        $task = JRequest::getCmd('task');

        if($mainframe->isSite() && $task != 'activate'){
            require_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'
                         .DIRECTORY_SEPARATOR.'com_tz_pinboard'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'user.php');
            $model              = new TZ_PinboardModelUser();

            $TZavatar             = JRequest::getVar('jform','','files','array');
            $description        = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
            $deleteImage        = JRequest::getCmd('delete_images');
            $currentImage       = JRequest::getString('current_images');
            $userData['url']    = JRequest::getVar( 'url', '', 'post', 'string', JREQUEST_ALLOWRAW );

            $description        = trim($description);
            $userData['usersid']        = $user ['id'];
            $userData['gender']         = JRequest::getCmd('gender');
            $userData['description']    = $description;
            $userData['twitter']        = JRequest::getVar( 'url_twitter', '', 'post', 'string', JREQUEST_ALLOWRAW );
            $userData['facebook']       = JRequest::getVar( 'url_facebook', '', 'post', 'string', JREQUEST_ALLOWRAW );
            $userData['google_one']     = JRequest::getVar( 'url_google_one_plus', '', 'post', 'string', JREQUEST_ALLOWRAW );


            if(!$userData['gender'])
                $userData['gender'] = 'm';

            if(!empty($TZavatar['name']['TZclient_images'])){
                $image  = $TZavatar;
            }
            else{
                if(!empty($data['url_images']))
                    $image  = $data['url_images'];
            }

            if($image){
                $model -> deleteImages($currentImage);

                if(!$userData['images'] = $model -> uploadImages($image)){
                    $this -> setError($this -> getError());
                    return false;
                }
            }
            else
                $userData['images'] = $currentImage;



            if($deleteImage == 1){
                $model -> deleteImages($currentImage);
                $userData['images'] = '';
            }

            if(!$model -> saveUser($userData)){
                $this -> setError($this -> getError());
                return false;
            }

        }

    }
    
}
