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

$doc = JFactory::getDocument();
$doc->addStyleSheet('components/com_tz_pinboard/css/edit_pins.css');

?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#tz_pins_delete_b').click(function () {
            jQuery('#tz_delete_pins').fadeIn();
            jQuery('#tz_delete_pins_all').slideDown(600);
        });
        jQuery('#button_cancel').click(function () {
            jQuery('#tz_delete_pins').fadeOut();
            jQuery('#tz_delete_pins_all').css('display', 'none');
        });
        var reg = /(\s)?\$(\s)?[0-9\.]{1,100}/;     // check price
        var key_cost = /(\s)?\$(\s)?[0-9].*?$/; // check price
        jQuery('#tz_pins_edit_textra').focus(function () {
            jQuery('#tz_pins_edit_textra').keyup(function () {
                var text_key = jQuery('#tz_pins_edit_textra').val();

                if (key_cost.test(text_key) == true) {
                    var Results = text_key.match(reg);
                    jQuery('.tz_price_edit').html(Results);
                } else {
                    jQuery('.tz_price_edit').html('');
                }
            });
        });
        jQuery('#tz_pins_upload').click(function () {
            var srcc = jQuery('.tz_price_edit').html();
            jQuery('#tz_edit_price').attr('value', srcc);
        });
    });
</script>
<div id="tz_pins_warp_edit">
    <div id="tz_pins_edit_herder">
        <img id="tz_pins_edit_img" src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/edit.png' ?>">
        <span>
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDIT_PIN'); ?>
        </span>
        <button id="tz_pins_delete_b">
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DELETE_PIN'); ?>
        </button>
    </div>
    <div id="tz_pins_edit_content">
        <div class="tz_price_edit">f2</div>
        <form action="index.php?option=com_tz_pinboard" method="post">
            <div class="tz_pins_edit_content_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_KEY_PIN'); ?></label>
                <input class="tz_pins_input" type="text" name="editkeywords" value="<?php
                if (isset($this->editpin->tags)) {
                    $i = 0;
                    $j = count($this->editpin->tags);
                    foreach ($this->editpin->tags as $row_tag) {
                        if ($i == $j - 1) {
                            echo $row_tag->tagname;
                        } else {
                            echo $row_tag->tagname . ", ";
                        }
                        $i++;
                    }
                }
                ?>"/>
                <input type="hidden" id="id_pin_content" name="id_pins"
                       value="<?php echo $this->editpin->content_id; ?>">
            </div>
            <div class="tz_pins_edit_content_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_TITLE_PIN'); ?></label>
                <input class="tz_pins_input" type="text" name="edittitle"
                       value="<?php echo $this->editpin->content_title; ?>"/>
            </div>
            <div class="tz_pins_edit_content_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_PINS_ALIAS'); ?></label>
                <input class="tz_pins_input" type="text" name="aliaspins"
                       value="<?php echo $this->editpin->alias_content; ?>"/>

            </div>
            <?php
            if (isset($this->editpin->url) && !empty($this->editpin->url)) {
                ?>
                <div class="tz_pins_edit_content_1">
                    <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_WEBSITE_PIN'); ?></label>
                    <input class="tz_pins_input" disabled="false" type="text" name="editweb"
                           value="<?php echo $this->editpin->url; ?>"/>
                </div>
            <?php
            }
            ?>
            <div class="tz_pins_edit_content_1">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_BOARD'); ?></label>
                <select id="tz_pins_edit_select" name="select_catogory">
                    <?php
                    if (isset($this->ShowBoarname)) {
                        foreach ($this->ShowBoarname as $cato) {
                            ?>
                            <option
                                value="<?php echo $cato->id; ?>"
                                <?php
                                if ($cato->id == $this->editpin->content_catid) {
                                    ?>
                                    selected="true"
                                <?php
                                }
                                ?>
                                >
                                <?php echo $cato->title ?>
                            </option>
                        <?php
                        }
                    }
                    ?>

                </select>
            </div>
            <div class="tz_pins_edit_content_2">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DESCRIPTION'); ?></label>
                <textarea name="textreaname" id="tz_pins_edit_textra"
                          style="width: 370px; height: 110px;"><?php echo strip_tags($this->editpin->content_introtext); ?></textarea>
            </div>
            <div class="tz_pins_edit_content_2">
                <label><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDIT_IMAGES'); ?></label>
                <?php
                $img_size = 'S';
                $img_type = JFile::getExt($this->editpin->img_im);
                if ($img_type == 'gif') {
                    $img_type_replaca = $this->editpin->img_im;
                } else {
                    $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $this->editpin->img_im);
                }
                ?>
                <p>
                    <img data-option-id-img="<?php echo $this->editpin->content_id; ?>" class="dasd"
                         src="<?php echo JUri::root() . '/' . $img_type_replaca ?>" ">
                </p>

                <div class="cler"></div>
            </div>
            <div id="tz_pinbs_edit_submit">
                <input type="hidden" name="tz_edit_price" id="tz_edit_price" value="">
                <input type="hidden" name="task" value="tz.update.pins">
                <input id="tz_pins_upload" type="submit" name="submit_edit"
                       value="<?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_SAVE_PIN'); ?>">
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </form>
    </div>
    <div id="tz_delete_pins">
        <div id="tz_delete_pins_warp">
        </div>
        <div id="tz_delete_pins_all">
            <p id="tz_delete_pins_p">
                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_DATELETE_PIN'); ?>
            </p>
            <button id="button_cancel" class="btn btn-primary">

                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_CANCEL'); ?>

            </button>
            <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.delete.pins&id_board=' . $this->editpin->content_catid . '&id_pins=' . $this->editpin->content_id); ?>"
               rel="nofollow">
                <button id="button_delete" class="btn btn-danger">

                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DELETE_PIN'); ?>

                </button>
            </a>
        </div>
        <div id="tz_notice_edit">
            <p>
                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NOTICE_UPDATE'); ?>
            </p>
        </div>
    </div>
</div>