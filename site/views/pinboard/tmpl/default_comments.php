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
    $count = count($this->displayComment);
    for($i=$count-1; $i >=0; $i--){

        ?>
    <li>

        <?php if(isset($this->displayComment[$i]->img_user) && !empty($this->displayComment[$i]->img_user)){  ?>
        <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/'.$this->displayComment[$i]->img_user;  ?>">
        <?php }else{ ?>
        <img class="tz_more_conten_comment_imgs"  src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
        <?php } ?>

        <a rel="nofollow" href="<?php echo JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($this->displayComment[$i]->id_user)); ?>">
            <p class="tz_more_conten_comment_p_names">
                <?php echo $this->displayComment[$i]->user_name; ?>
            </p>
        </a>
        <p class="tz_more_conten_comment_ps">
            <?php echo $this->displayComment[$i]->content_cm; ?>
        </p>
        <?php if(isset($this->show_date) && $this->show_date ==1){ ?>
            <p class="tz_more_conten_comment_dates">

                <?php echo JText::sprintf("TZ_PINBOARD_TIME_DETAIL",date(JText::_('TZ_PINBOARD_DATE_FOMAT_COMMENT'),strtotime($this->displayComment[$i]->dates ))) ?>
            </p>
         <?php } ?>
    </li>
    <?php
    }
}
?>