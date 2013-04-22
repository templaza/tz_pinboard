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
$lang = JFactory::getLanguage();
$lang -> load('mod_tz_pinboard_active');

if(isset($this->data) && !empty($this->data)){
    $count = count($this->data);
    for($i=$count-1; $i >=0; $i--){
        ?>
        <li id="<?php echo $this->data[$i]->aid."tz_activi"; ?>">

        <?php if(isset($this->data[$i]->us_img) && !empty($this->data[$i]->us_img)){  ?>
            <img class="TzACtiviImg"     src="<?php echo JUri::root().'/'.$this->data[$i]->us_img; ?>">
        <?php }else{ ?>
        <img  class="TzACtiviImg"   src="<?php echo JUri::root().'/components/com_tz_pinboard/images/avata.jpg'?>">
            <?php }?>
        <p class="TzActiviContent">
                <span class="TzActiviName">
                    <?php echo $this->data[$i]->u_user; ?>
                </span>
                <span>
                    <?php
                    switch($this->data[$i]->a_active){
                        case'l':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_LIKE');
                            break;
                        case'ul':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_NOT_LIKE');
                            break;
                        case'r':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_REPIN');
                            break;
                        case'p':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_PIN');
                            break;
                        case'f':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_FOLLOW');
                            break;
                        case'uf':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_UNFOLLOW');
                            break;
                        case'c':
                            echo JText::_('MOD_TZ_PINBOARD_ACTIVE_COMMENT');
                            break;
                        default;
                            break;
                    }
                    ?>
                </span>
                 <span>

                    <?php
        if($this->data[$i]->a_active=='f' || $this->data[$i]->a_active=='uf'){
                              echo "<a href='".JRoute::_(TZ_PinboardHelperRoute::getPinboardManageruserRoute($this->data[$i]->a_target))."'>".$this->data[$i]->follow->u_name."</a>";
                          }else{

                              echo "<a href='".JRoute::_('index.php?option=com_tz_pinboard&view=detail&id_pins='.$this->data[$i]->a_target)."'>".$this->data[$i]->p_title."</a>";
                          }
                     ?>
                </span>

        </p>
        <div class="cler"></div>
    </li>
    <?php
    }
}
?>