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

<?php if(isset($this->displayComment) && !empty($this->displayComment)){

    foreach($this->displayComment as $showComemnt){
        ?>
    <li>

        <?php if(isset($showComemnt->img_user) && !empty($showComemnt->img_user)){  ?>
        <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/'.$showComemnt->img_user;  ?>">
        <?php }else{ ?>
        <img class="tz_more_conten_commnet_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
        <?php } ?>

        <a rel="nofollow" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($showComemnt->id_user)); ?>">
            <p class="tz_more_conten_commnet_p_names">
                <?php echo $showComemnt->user_name; ?>
            </p>
        </a>
        <p class="tz_more_conten_commnet_ps">
            <?php echo $showComemnt->content_cm; ?>
        </p>
        <p class="tz_more_conten_commnet_dates">
            <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_COMMENT_TIME'); ?>:  <?php echo date('Y F d',strtotime( $showComemnt->dates )); ?>
        </p>
    </li>
    <?php
    }
}
?>