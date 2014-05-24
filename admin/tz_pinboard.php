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

// no direct access
defined('_JEXEC') or die;

$option = JRequest::getCmd('option', 'com_tz_pinboard');
$view = JRequest::getCmd('view', 'articles');
$task = JRequest::getCmd('task', null);

JLoader::register('TZ_PinboardHelper', __DIR__ . '/helpers/tz_pinboard.php');

if ($view != 'categories' && $view != 'category' && $view != 'articles' && $view != 'article' && $view != 'featured'
    && $view != 'users'
) {
    $controllerName = $view;

    $path = JPATH_COMPONENT_ADMINISTRATOR . '/controllers' . '/' . $controllerName . '.php';

    if (file_exists($path))

        require_once($path);
    else
        JError::raiseError(500, 'Invalid controller');

    $controllerClass = 'TZ_PinboardController' . ucfirst($controllerName);

    if (class_exists($controllerClass)) {

        $controller = new $controllerClass;


    } else
        JError::raiseError(500, 'Invalid class controller');
    $controller->execute($view);

} else {

    // Register helper class
    JLoader::register('TZ_PinboardHelper', dirname(__FILE__) . '/helpers/tz_pinboard.php');

    // Access check.
    if (!JFactory::getUser()->authorise('core.manage', JRequest::getCmd('extension'))) {
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
    }

    // Execute the task.
    $controller = JControllerLegacy::getInstance('TZ_Pinboard');


    $controller->execute(JRequest::getVar('task'));

}

$controller->redirect();
