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
$doc->addStyleSheet('components/com_tz_pinboard/css/manageruser.css');
$doc->addStyleSheet('components/com_tz_pinboard/css/more_pin.css');

?>
<script type="text/javascript">

    /*
     * method calculated width of tags div
     */
    function tz_init(defaultwidth) {
        var contentWidth = jQuery('.tz_pin_following_warp').width();

        var columnWidth = defaultwidth;
        if (columnWidth > contentWidth) {
            columnWidth = contentWidth;
        }
        var curColCount = Math.floor(contentWidth / columnWidth);
        var newwidth = columnWidth * curColCount;
        var newwidth2 = contentWidth - newwidth;
        var newwidth3 = newwidth2 / curColCount;
        var newColWidth = Math.floor(columnWidth + newwidth3);
        jQuery('.tz_pin_following_user').css("width", newColWidth); // running masonry
    }
    var resizeTimer = null;
    jQuery(window).bind('load resize', function () { // when the browser changes the div tag changes accordingly
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout("tz_init(" + "<?php echo $this->width_follow; ?>)", 100);
    });

    jQuery(document).ready(function () {
        jQuery('.tz_followers').toggle(function () {
            jQuery(this).addClass('disabled');
            jQuery(this).html('<span> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.follow',
                type: 'post',
                data: {
                    id_user_guest: jQuery(this).attr('data-option-id')
                }
            }).success(function (data) {
                    data = data.replace(/^\s+|\s+$/g, '');
                    if (data == 'f') {
                        window.location = "<?php echo JURI::root() . "index.php?option=com_users&view=login"; ?>";
                    }
                });
        }, function () {
            jQuery(this).removeClass('disabled');
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unfollow',
                type: 'post',
                data: {
                    id_user_guest: jQuery(this).attr('data-option-id')
                }
            }).success(function () {
                });
        });


        jQuery('.untz_followers').toggle(function () {
            jQuery(this).removeClass('disabled');
            jQuery(this).html('<span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.unfollow',
                type: 'post',
                data: {
                    id_user_guest: jQuery(this).attr('data-option-id')
                }
            }).success(function () {
                });
        }, function () {
            jQuery(this).addClass('disabled');
            jQuery(this).html('<span> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?></span>');
            jQuery.ajax({
                url: 'index.php?option=com_tz_pinboard&view=manageruser&task=tz.pin.follow',
                type: 'post',
                data: {
                    id_user_guest: jQuery(this).attr('data-option-id')
                }
            }).success(function () {
                });
        });

    });
</script>

<div id="tz_pinboard_warp">
    <?php
    echo $this->loadtemplate('menu');
    ?>
    <div class="cler"></div>
</div>
<div class="tz_pin_following">
    <div class="tz_pin_following_warp">
        <?php
        if (isset($this->ShowFollowers) && !empty($this->ShowFollowers)) {
            foreach ($this->ShowFollowers as $followers) {
                ?>
                <div class="tz_pin_following_user">
                    <div class="tz_pin_following_warp_user">
                        <div class="tz_pin_following_left">
                            <?php if (isset($followers->thongtin->tzimages) && !empty($followers->thongtin->tzimages)) { ?>
                                <img class="tz_pin_following_left_img"
                                     src="<?php echo JUri::root() . '/' . $followers->thongtin->tzimages; ?>">
                            <?php } else { ?>
                                <img class="tz_pin_following_left_img"
                                     src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
                            <?php } ?>
                        </div>
                        <div class="tz_pin_following_right">
                            <ul>
                                <li class="tz_pin_following_right_li1">
                                    <a href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($followers->thongtin->uid)); ?>"
                                       rel="nofollow">
                                        <?php echo $followers->thongtin->uname; ?>
                                    </a>
                                    <?php
                                    if ($followers->thongtin->uid != $this->sosanhuser) {
                                        if ($followers->followCheck['f'] == '0' || $followers->followCheck['f'] == '') {
                                            ?>
                                            <button class="tz_pin_following_button btn tz_followers"
                                                    data-option-id="<?php echo $followers->thongtin->uid ?>">
                                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOW'); ?>
                                            </button>
                                        <?php
                                        } else if ($followers->followCheck['f'] == '1') {
                                            ?>
                                            <button style="background: #c0c0c0"
                                                    class="tz_pin_following_button btn disabled untz_followers"
                                                    data-option-id="<?php echo $followers->thongtin->uid ?>">
                                                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_UNFOLLOW'); ?>
                                            </button>
                                        <?php
                                        }
                                    }
                                    ?>
                                </li>
                                <li class="tz_pin_following_right_li2">
                                    <?php
                                    $count = count($followers->content);
                                    for ($i = 0; $i < $count; $i++) {
                                        $img_size = $this->img_size;
                                        $img_type = JFile::getExt($followers->content[$i]->tzimgaes);
                                        if ($img_type == 'gif') {
                                            $img_type_replaca = $followers->content[$i]->tzimgaes;
                                        } else {
                                            $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $followers->content[$i]->tzimgaes);
                                        }
                                        ?>
                                        <a class="tz_pin_following_button_a"
                                           href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.more.board&id_guest=' . $followers->content[$i]->cid . '&id_board=' . $followers->content[$i]->bordid); ?>"
                                           rel="nofollow">
                                            <img class="tz_pin_following_left_img"
                                                 src="<?php echo JUri::root() . '/' . $img_type_replaca ?>">
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <a class="cler"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="cler"></div>
                    </div>
                </div>
            <?php
            }

        } else {
            ?>
            <div class="tz_not_followers">
            <span class="tz_not_fol_sp">
                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOWERS_NOT_DS'); ?>
            </span>
            </div>
        <?php
        }
        ?>
        <div class="cler"></div>
    </div>
    <div class="pagination pagination-toolbar ">
        <?php echo $this->PaginationFollow->getPagesLinks(); ?>
    </div>
</div>