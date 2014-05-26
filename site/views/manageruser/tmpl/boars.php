<?php
/*------------------------------------------------------------------------

# TZ PINBOARD Extension

# ------------------------------------------------------------------------

# author   TuNguyenTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
defined("_JEXEC") or die;
$doc = JFactory::getDocument();
$doc->addStyleSheet('components/com_tz_pinboard/css/manageruser.css');
$pth_c = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR .
    'com_tz_pinboard' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'category.php';
require_once $pth_c;
jimport('joomla.html');


?>
<script type="text/javascript">
    /*
     * method calculated width of tags div
     */
    function tz_init(defaultwidth) {
        var contentWidth = jQuery('#tz_conten_board_1').width();
        var columnWidth = defaultwidth;
        if (columnWidth > contentWidth) {
            columnWidth = contentWidth;
        }
        var curColCount = Math.floor(contentWidth / columnWidth);
        var newwidth = columnWidth * curColCount;
        var newwidth2 = contentWidth - newwidth;
        var newwidth3 = newwidth2 / curColCount;
        var newColWidth = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_conten_board_class').css("width", newColWidth); // running masonry
    }
    var resizeTimer = null;
    jQuery(window).bind('load resize', function () { // when the browser changes the div tag changes accordingly
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init(" + "<?php echo $this->width_board; ?>)", 100);
    });

    jQuery(document).ready(function () {


        tz_init(<?php echo $this->width_columns; ?>); //call functon tz_init

        var ua = navigator.userAgent, // Check device
            event = (ua.match(/iPad/i)) ? "touchstart" : "click";


        jQuery('#Tz_create_boar_new').live(event, function () {
            jQuery('#create_board').fadeIn();
        });
        jQuery('#create_board_warp_form_img').click(function () {
            jQuery('#create_board_Form').val();
            jQuery('#create_board').fadeOut();
        });

        // count text
        jQuery('#board_name').focus(function () {
            var inpName = jQuery('#board_name').attr('value');
            var p_title = document.getElementById("p_boardname");
            jQuery('#board_name').keyup(function () {
                var maxName = jQuery('#board_name').attr('maxlength');
                var inpName = jQuery('#board_name').attr('value');
                var countTen = inpName.length;
                var HieuName = maxName - countTen;
                if (HieuName > 0) {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?>" + HieuName;
                } else {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
                }
            });
        });
        jQuery('#board_name').blur(function () {
            var p_title = document.getElementById("p_boardname");
            p_title.innerHTML = "";
        });

        // text alias
        jQuery('#aliasboard').focus(function () {
            var inpName = jQuery('#aliasboard').attr('value');
            var p_title = document.getElementById("p_create_aliasboard");
            jQuery('#aliasboard').keyup(function () {
                var maxName = jQuery('#aliasboard').attr('maxlength');
                var inpName = jQuery('#aliasboard').attr('value');
                var countTen = inpName.length;
                var HieuName = maxName - countTen;
                if (HieuName > 0) {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE'); ?>" + HieuName;
                } else {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_TITLE_0'); ?>";
                }
            });
        });
        jQuery('#aliasboard').blur(function () {
            var p_title = document.getElementById("p_create_aliasboard");
            p_title.innerHTML = "";
        });

        // count text Description
        jQuery('#tz_board_textra').focus(function () {
            var inpName = jQuery('#tz_board_textra').attr('value');
            var p_title = document.getElementById("p_create_decsipt");
            jQuery('#tz_board_textra').keyup(function () {
                var maxName = jQuery('#tz_board_textra').attr('maxlength');
                var inpName = jQuery('#tz_board_textra').attr('value');
                var countTen = inpName.length;
                var HieuName = maxName - countTen;
                if (HieuName > 0) {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION'); ?>" + HieuName;
                } else {
                    p_title.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_PIN_WEBSITE_DESCRIPTION_0'); ?>";
                }
            });
        });
        jQuery('#tz_board_textra').blur(function () {
            var p_title = document.getElementById("p_create_decsipt");
            p_title.innerHTML = "";
        });


        // submit
        jQuery('#subcreate').click(function () {
            var inpName = jQuery('#board_name').attr('value');
            var erro_name = document.getElementById("p_boardname");
            var inpCategory = jQuery('#category_board').val();
            var inpCate = document.getElementById('p_create_decsipt');
            if (inpName == "") {
                erro_name.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CHECK_TITLE'); ?>";
                jQuery('#board_name').focus();
                return false;
            }
            if (inpCategory == "") {
                inpCate.innerHTML = "<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_NOTICE_CATEGORY') ?>";
                jQuery('#category_board').focus();
                return false;
            }

        });

    });
</script>

<div id="tz_pinboard_warp">
    <?php
    echo $this->loadtemplate('menu');
    ?>
    <div class="cler"></div>
</div>
<div id="tz_conten_board">
<div id="tz_conten_board_1">
    <?php
    if (isset($this->Boarpin)) {
        foreach ($this->Boarpin as $rowname) {
            ?>
            <div class="tz_conten_board_class">
                <div class="tz_board_class">
                    <h6 class="tz_conten_board_class_h5">
                        <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManagetuset2('', $rowname->created_user_id, $rowname->id_board)); ?>"
                           rel="nofollow">
                            <?php echo $rowname->name_board; ?>
                        </a>
                            <span>
                                <?php
                                echo $rowname->countpins->numberpin;
                                ?>
                                <?php echo JText::_('COM_TZ_PINBOARD_SUBMENU_PINS_NUMBER'); ?>
                            </span>
                    </h6>

                    <div class="tz_conten_board_firs">
                        <ul>
                            <li class="tz_conten_board_firs_2">
                                <?php if (!empty($rowname->pins)) {
                                    $img_size = $this->img_size;
                                    $img_type = JFile::getExt($rowname->pins[0]->img);
									 if ($img_type == 'gif') {
                                        $img_type_replaca = $rowname->pins[0]->img;
                                    } else {
                                        $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $rowname->pins[0]->img);
                                    }                                    
                                    ?>
                                    <img id="tz_pin_more_warp_name_img"
                                         src="<?php echo JUri::root() . '/' . $img_type_replaca ?>" alt="">
                                <?php
                                }
                                ?>
                            </li>
                            <li class="tz_conten_board_firs_3">
                                <?php
                                $count = count($rowname->pins);
                                for ($i = 1; $i < $count; $i++) {
                                    $img_size = $this->img_size;
                                    $img_type = JFile::getExt($rowname->pins[$i]->img);
                                    if ($img_type == 'gif') {
                                        $img_type_replaca = $rowname->pins[$i]->img;
                                    } else {
                                        $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $rowname->pins[$i]->img);
                                    }

                                    ?>
                                    <a>
                                        <img src="<?php echo JUri::root() . '/' . $img_type_replaca ?>" alt="">
                                    </a>
                                <?php } ?>
                                <div class="cler"></div>
                            </li>
                            <?php
                            if ($rowname->created_user_id == $this->sosanhuser) {
                                ?>
                                <li class="tz_conten_board_firs_4">

                                    <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.edit&id_board=' . $rowname->id_board); ?>"
                                       rel="nofollow">

                                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EDITS'); ?>

                                    </a>

                                </li>
                            <?php
                            }

                            ?>
                        </ul>

                    </div>
                </div>
            </div>
        <?php

        }
    }
    ?>
    <?php if (isset($this->newboard) && $this->newboard == $this->sosanhuser) { ?>
        <div id="Tz_board_new" class="tz_conten_board_class">
            <div id="Tz_create_boar_new">

            </div>
        </div>
    <?php } ?>
    <div class="cler"></div>
</div>
<div class="pagination pagination-toolbar ">
    <?php
    echo $this->pagination->getPagesLinks();
    ?>
</div>

<div id="tz_user_information">
    <h6 id="tz_title_info">
                    <span class="tz_info_span btn btn-large ">
                        <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_INFORMATION'); ?>
                    </span>
    </h6>

    <div id="tz_uset_info">
        <div id="tz_information_left">
            <p class="tz_info_img">
                <?php if (isset($this->userInfo->tzimg) && !empty($this->userInfo->tzimg)) { ?>
                    <img src="<?php echo JUri::root() . '/' . $this->userInfo->tzimg; ?>">
                <?php } else { ?>
                    <img class="tz_pin_img_user"
                         src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                <?php } ?>
            </p>
        </div>

        <div id="tz_information_right">
            <p class="tz_info_name">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_NAME_USER'); ?>
                            </span>
                <a>
                    <?php
                    if (isset($this->userInfo->uname)) {
                        echo $this->userInfo->uname;
                    }
                    ?>
                </a>

            <p class="cler"></p>
            </p>
            <p class="tz_info_name">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_EMAIL_USER'); ?>
                            </span>
                <a>
                    <?php
                    if (isset($this->userInfo->uemail)) {
                        echo $this->userInfo->uemail;
                    }
                    ?>
                </a>

            <p class="cler"></p>
            </p>
            <p class="tz_info_name">
                            <span>
                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DATE_USER'); ?>
                            </span>
                <a>
                    <?php
                    if (isset($this->userInfo->udate)) {
                        echo date(JText::_('TZ_PINBOARD_DATE_FOMAT'), strtotime($this->userInfo->udate));
                    }
                    ?>
                </a>

            <p class="cler"></p>
            </p>
            <?php if (isset($this->userInfo->tztwitter) && !empty($this->userInfo->tztwitter)) { ?>
                <p class="tz_info_name">
                                <span>
                                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_TWITTER_USER'); ?>
                                </span>
                    <a rel="nofollow" href="<?php echo $this->userInfo->tztwitter; ?>">
                        <?php echo $this->userInfo->tztwitter; ?>
                    </a>
                <p class="cler"></p>
                </p>
            <?php } ?>

            <?php if (isset($this->userInfo->tzfacebook) && !empty($this->userInfo->tzfacebook)) { ?>
                <p class="tz_info_name">
                                <span>
                                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FACEBOOK_USER'); ?>
                                </span>
                    <a href="<?php echo $this->userInfo->tzfacebook; ?>" rel="nofollow">
                        <?php echo $this->userInfo->tzfacebook; ?>
                    </a>
                <p class="cler"></p>
                </p>
            <?php } ?>

            <?php if (isset($this->userInfo->tzgoogle_one) && !empty($this->userInfo->tzgoogle_one)) { ?>
                <p class="tz_info_name">
                                <span>
                                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_GOOGLE_USER'); ?>
                                </span>
                    <a rel="nofollow" href="<?php echo $this->userInfo->tzgoogle_one; ?>">
                        <?php echo $this->userInfo->tzgoogle_one; ?>
                    </a>
                <p class="cler"></p>
                </p>
            <?php } ?>
            <?php
            if (isset($this->checkInfo) && $this->checkInfo == "tr") {
                if (isset($this->userInfo) && !empty($this->userInfo)) {
                    ?>
                    <p id="tz_buttom_option">
                        <a class="btn btn-small  btn-primary"
                           href="<?php echo JURI::root() . "index.php/component/users/profile?layout=edit"; ?>">
                            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_CHANGE_ACCOUNT'); ?>
                        </a>
                    </p>
                <?php
                }
            }
            ?>
        </div>
        <div class="cler"></div>
    </div>
</div>

<div id="create_board">
    <div id="create_board_warp">
    </div>
    <div id="create_board_warp_form">
        <h5 id="create_board_warp_form_h5">
            <span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_CREATE_A_BOARD'); ?></span>

            <img id="create_board_warp_form_img"
                 src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/delete_board.png' ?>"/>

        </h5>

        <form id="create_board_Form" action="" method="post">
            <div class="create_board_warp_form_name">
                <label>
                    <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_NAME'); ?>
                </label>
                <input type="text" id="board_name" name="boardname" maxlength="<?php echo $this->max_text_board; ?>"
                       value="">

                <p id="p_boardname"></p>
            </div>
            <div class="create_board_warp_form_name">
                <label>
                    <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_ALIAS'); ?>
                </label>
                <input type="text" id="aliasboard" name="aliasboard" maxlength="<?php echo $this->max_text_board; ?>"
                       value="">

                <p id="p_create_aliasboard"></p>
            </div>
            <div class="create_board_text">
                <label>
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_DESCRIPTION'); ?>
                </label>
                <textarea name="decsipt" id="tz_board_textra" maxlength="<?php echo $this->max_text_board_ds; ?>"
                          style="width: 305px; height: 110px;"></textarea>

                <p id="p_create_decsipt"></p>
            </div>
            <div class="create_board_warp_form_name">
                <label>
                    <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_CATEGORY'); ?>
                </label>
                <select name="catego" id="category_board">
                    <option value="">
                        <?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_BOARD_CATEGORY'); ?>
                    </option>
                    <?php
                    echo JHtml::_('select.options', JHtml::_('category.options', 'com_tz_pinboard'), 'value', 'text', '');
                    ?>

                </select>

                <div class="cler"></div>
            </div>

            <div id="create_board_warp_form_submit">
                <input type="hidden" name="task" value="tz.insert.board">
                <input type="submit" id="subcreate" name="create"
                       value="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_CREATE_A_BOARD') ?>">
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </form>

    </div>

    <div id="notice_top">
        <span><?php echo JText::_('COM_TZ_PINBOARD_THANKS_YOU'); ?><span>
    </div>
    <div id="notice_bottom">

    </div>
</div>

</div>

