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

if (isset($this->ShowCommnet) && !empty($this->ShowCommnet)) {
    $count = count($this->ShowCommnet);
    for ($i = $count - 1; $i >= 0; $i--) {

        ?>
        <li>
            <?php if (isset($this->ShowCommnet[$i]->img_user) && !empty($this->ShowCommnet[$i]->img_user)) { ?>
                <img class="tz_comment_imgs" src="<?php echo JUri::root() . '/' . $this->ShowCommnet[$i]->img_user; ?>">
            <?php } else { ?>
                <img class="tz_comment_imgs"
                     src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/avata.jpg' ?>">
            <?php } ?>
            <p class="tz_detail_name_d">
                <a class="tz_comment_name"
                   href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($this->ShowCommnet[$i]->id_user)); ?>">
                    <?php
                    $name = $this->ShowCommnet[$i]->user_name;
                    echo ucwords($name);
                    ?>
                </a>
                <?php if (isset($this->show_date) && $this->show_date == 1) { ?>
                    <span class="tz_comment_dt">
                                    <?php echo date(JText::_('TZ_PINBOARD_DATE_FOMAT_COMMENT'), strtotime($this->ShowCommnet[$i]->dates)); ?>
                                </span>
                <?php } ?>

            <p class="cler">
            </p>
            </p>
            <p class="tz_comment_cn">
                <?php echo $this->ShowCommnet[$i]->content_cm; ?>
            </p>

            <?php if ($this->sosanhuser == $this->ShowCommnet[$i]->id_user || $this->sosanhuser == $this->ShowCommnet[$i]->create_by) { ?>
                <img class="tz_comment_delete" data-option-id="<?php echo $this->ShowCommnet[$i]->id_comment ?>"
                     data-option-text="<?php echo $this->ShowCommnet[$i]->content_id_cm; ?>"
                     src="<?php echo JUri::root() . '/components/com_tz_pinboard/images/delete3.png' ?>">
            <?php } ?>
        </li>

    <?php
    }

}
?>