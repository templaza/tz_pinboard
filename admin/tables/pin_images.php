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
    class TableTz_Pins_img extends JTable{

        var  $id = null;
        var $contentid = null;
        var  $groupid = null;
        var $images = null;
        var $images_hover = null;
        var $gallery = null;
        var $video = null;
        var $type = null;
        var $imagetitle = null;
        var $gallerytitle = null;
        var $videotitle = null;
        var $attachfiles = null;
        var $attachtitle = null;
        var $attachold = null;
        function __construct(&$db) {
                  parent::__construct('#__tz_pinboard_xref_content','id',$db);

            }
    }
?>