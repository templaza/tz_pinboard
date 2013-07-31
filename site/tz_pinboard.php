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
require_once JPATH_COMPONENT.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php';
        $option = JRequest::getCmd('option');
        $view =JRequest::getCmd('view','manageruser');
        $controllerName = $view;
        $controlletPath=JPATH_COMPONENT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controllerName.'.php';





        if(file_exists($controlletPath)){
            require_once($controlletPath);
        }
        else{
            echo JError::raiseError(500,'Invailid controller');;
        }

        $controllerClass='Tz_pinboardController'.ucfirst($controllerName);


        if(class_exists($controllerClass))
                $controller=new $controllerClass;
            else
                echo JError::raiseError(500,'Invailid Class controller!');

        jimport('joomla.filesystem.file');

        $controller->execute(JRequest::getCmd('task')); // chay task
        $controller->redirect(); // chen file controler vao
?>