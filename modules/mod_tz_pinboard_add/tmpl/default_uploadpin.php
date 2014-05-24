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


<div id="tz_pin_upload_name">
    <span>
    <?php echo JText::_('MOD_TZ_PINBOARD_LOCAL_PIN'); ?>
    </span>
    <img id="tz_pin_upload_img"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/delete_board.png' ?>"/>
</div>
<div id="tz_pin_upload_content">
    <form name="frmupload" action=<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=addpinboards'); ?> method="post" enctype="multipart/form-data">
        <div id="tz_pin_upload_content_1">
            <input onchange="readURL(this);" id="upload_pin" type="file" name="upload_pinl">
        </div>
        <div id="tz_pin_upload_content_2">
            <div id="tz_pin_upload_left">

                <div id="tz_pin_upload_left_img">
                    <div class="tz_upload_price"></div>
                    <img id="tz_pin_upload_left_img_load" src="#" >
                </div>
            </div>
            <div id="tz_pin_upload_right">
                <div class="tz_pin_upload_input">
                    <input id="tz_pin_upload_keyword"  type="text" name="keywords_pin_local" maxlength="<?php echo $text_key; ?>" placeholder="<?php echo JText::_('MOD_TZ_PINBOARD_YOUR_KEYWORDS'); ?>" value="">
                    <input   type="hidden" id="tz_pinPrice" name="tz_price"  value="">
                    <p id="tz_p_local_keyword">
                    </p>
                </div>
                <div class="tz_pin_upload_input">
                    <input id="tz_pin_upload_title" type="text" name="title_pin_local" maxlength="<?php echo $text_title; ?>" placeholder="<?php echo JText::_('MOD_TZ_PINBOARD_YOUR_TITLE'); ?>" value="">
                    <p id="tz_p_title">
                    </p>
                </div>
                <div class="tz_pin_upload_input">
                    <select name="board" id="tz_pin_upload_select">
                        <option value=""><?php echo JText::_('MOD_TZ_PINBOARD_SELECT_CATEGORY') ?></option>
                        <?php
                        foreach($bord as $row){
                        ?>
                            <option value="<?php echo $row->id ?>">
                                    <?php echo $row->title; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="tz_pin_upload_input">
                    <textarea name="tz_descript_url" id="tz_pin_pin_textarea" maxlength="<?php echo $text_title_ds; ?>" placeholder="<?php echo JText::_('MOD_TZ_PINBOARD_YOUR_DESCRIPTION'); ?>" style="width: 300px; height: 110px;"></textarea>
                    <p id="tz_p_textarea"></p>
                </div>
                <div class="tz_pin_upload_input">
                    <input type="hidden" name="task" value="upload.local.pin">
                    <input  class="btn btn-large" id="upload_a_pin" type="submit" name="uploadpin" value="<?php echo JText::_('MOD_TZ_PINBOARD_WEB_PIN'); ?>">
                    <p class="tz_click_button"> </p>
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </div>
            <div class="cler"></div>
        </div>
    </form>
</div>