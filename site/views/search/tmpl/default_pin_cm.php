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

if(isset($this->ShowCommnet) && !empty($this->ShowCommnet)){
    foreach($this->ShowCommnet as $row_cm){
    ?>
        <li>
            <?php if(isset($row_cm->img_user) && !empty($row_cm->img_user)){  ?>
                <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/'.$row_cm->img_user;  ?>">
            <?php }else{ ?>
                <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
            <?php   }?>

            <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=tz.follow&id_guest='.$row_cm->id_user); ?>" rel="nofollow">
                <p class="tz_more_conten_commnet_p_names">
                <?php echo $row_cm->user_name; ?>
                </p>
            </a>
            <p class="tz_more_conten_commnet_ps">
                <?php echo $row_cm->content_cm; ?>
            </p>
            <p class="tz_more_conten_commnet_dates">
                <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_TIME'); ?>:  <?php echo $row_cm->dates ?>
            </p>
        </li>
    <?php
    }
}
?>

