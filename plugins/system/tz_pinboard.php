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

class plgSystemTZ_Pinboard extends JPlugin {




    // Extend user forms with TZ Portfolio fields
	function onAfterDispatch() {
        JFactory::getLanguage() -> load('com_tz_pinboard');
        $mainframe = &JFactory::getApplication();
        
		if($mainframe->isAdmin())return;

		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$layout = JRequest::getCmd('layout');
		$user = &JFactory::getUser();

        if($option == 'com_users' && $view == 'registration' && !$layout){
                require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_users'.DIRECTORY_SEPARATOR.'controller.php');
                $controller = new UsersController;
                $views = $controller->getView($view, 'html');
                $views->addTemplatePath(JPATH_SITE.DIRECTORY_SEPARATOR.'components'
                                       .DIRECTORY_SEPARATOR.'com_tz_pinboard'
                                       .DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'manageruser'.DIRECTORY_SEPARATOR.'tmpl');
                $views->setLayout('register');

                ob_start();
                $views->display();
                $contents = ob_get_clean();
                $document = &JFactory::getDocument();
                $document->setBuffer($contents, 'component');
        }
        if($user -> username && $option == 'com_users'
           && $view == 'profile' && ($layout == 'edit' || $task == 'profile.edit')){


            require_once (JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_users'.DIRECTORY_SEPARATOR.'controller.php');

            $controller = new UsersController;

            $views = $controller->getView($view, 'html');
            $views->addTemplatePath(JPATH_SITE.DIRECTORY_SEPARATOR.'components'
                                   .DIRECTORY_SEPARATOR.'com_tz_pinboard'
                                   .DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'manageruser'.DIRECTORY_SEPARATOR.'tmpl');
            $views->setLayout('profile');

            require_once(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'
                         .DIRECTORY_SEPARATOR.'com_tz_pinboard'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'user.php');
            $model  = new TZ_PinboardModelUser;

            $userData   = $model -> getUsers($user -> id);


            $views -> assign('TZUser',$userData);

            ob_start();
            $active = JFactory::getApplication()->getMenu()->getActive();
            if (isset($active->query['layout']) && $active->query['layout'] != 'profile')
            {
                $active->query['layout'] = 'profile';
            }
            $views -> assign('user',$user);
            $views->display();
            $contents = ob_get_clean();
            $document = &JFactory::getDocument();
            $document->setBuffer($contents, 'component');
        }

    }
    
}
?>