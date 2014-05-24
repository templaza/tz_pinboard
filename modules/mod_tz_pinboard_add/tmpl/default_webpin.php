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
                <div id="tz_pin_url_content_2_left">
                    <div class="tz_upload_price"></div>
                    <ul id="slider">
                    </ul>
                    <div class="cler"></div>
                </div>
                <div id="tz_pin_url_content_2_right">
                    <div class="tz_pin_url_input">
                        <input id="tz_pin_url_keygord" type="text" name="keywords_pin_local"  maxlength="<?php echo $text_key; ?>"  value="">
                        <input type="hidden" name="tz_price" id="tz_url_price" value="">
                        <p id="tz_url_p_keyword">
                        </p>
                    </div>
                    <div class="tz_pin_url_input">
                        <input id="tz_pin_url_title" type="text" name="title_pin_local" title="Title" maxlength="<?php echo $text_title; ?>"  value="">
                        <input type="hidden" name="img_hidde" id="img_hidder" value="">
                        <input type="hidden" name="video_hidden" id="video_hidden" value="">

                        <p id="tz_url_p_title">
                        </p>
                    </div>
                    <div class="tz_pin_url_input">
                        <select name="board" id="tz_pin_url_select">
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
                    <div class="tz_pin_url_input">
                        <textarea id="tz_pin_url_textarea" title="Descript" name="tz_descript_url" style="width: 299px; height: 118px;" maxlength="<?php echo $text_title_ds; ?>"  ></textarea>
                        <p id="tz_url_p_textarea"></p>
                    </div>
                    <div class="tz_pin_url_input">
                        <input type="hidden" name="task" value="task_upload_pin">
                        <input  class="btn btn-large" id="url_a_pin" type="submit" name="uploadpin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_WEB_PIN'); ?>">
                        <p class="tz_click_button"> </p>
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                </div>
                <div class="cler"></div>
        </div>
        <input type="hidden" name="option" value="com_tz_pinboard" />
        <input type="hidden" name="view" value="addpinboards" />
    </form>
</div>
