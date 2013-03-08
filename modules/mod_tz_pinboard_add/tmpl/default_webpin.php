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



?>

<div id="tz_pin_url_name">
    <span>
    <?php echo JText::_("MOD_TZ_PINBOARD_ADD_A_PIN_WEB"); ?>
    </span>
    <img id="tz_pin_url_img"  src="<?php echo JUri::root().'/modules/mod_tz_pinboard_add/images/delete_board.png' ?>"/>
</div>
<div id="tz_pin_url_content">
    <form name="frmupload" action="" method="post" enctype="multipart/form-data">
        <div id="tz_pin_url_content_1">
            <input type="text" name="url_img" id="tz_url_img" placeholder="<?php echo JText::_('MOD_TZ_PINBOARD_ADD_A_YOUR_WEBSITE'); ?>" >
            <span id="tz_pin_url_button">
            <?php echo JText::_("Find Images"); ?>
            </span>
        <div class="cler"></div>
        </div>
        <div id="tz_pin_loadding">
        </div>
        <div id="tz_pin_url_content_2">
        </div>
        <input type="hidden" name="option" value="com_tz_pinboard" />
        <input type="hidden" name="view" value="addpinboards" />
    </form>
</div>
