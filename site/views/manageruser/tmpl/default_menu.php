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
if(isset($this->CheckIdGuest) && !empty($this->CheckIdGuest)){
    $href ="&id_guest=$this->CheckIdGuest";
  }else{
      $href="";
  }

    $task = JRequest::getString('task');


?>
<div id="tz_pinboard_warp_menu">
            <ul>
                <li <?php if($task=='board' || $task==""){ echo"class='active'";} ?> >
                   <a href="<?php echo  JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=board'.$href.'') ?>" rel="nofollow">
                      <strong><?php echo $this->numberboard->id; ?></strong>
                      <span> <?php  echo     JText::_('COM_TZ_PINBOARD_MANAGERUSER_BOARD'); ?></span>
                   </a>
                </li>
                <li <?php if($task=='pins'){ echo"class='active'";} ?> >
                     <a  href="<?php echo  JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=pins'.$href.'') ?>" rel="nofollow" >
                         <strong><?php echo $this->NumberPin->id; ?></strong>
                        <span><?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_PINS'); ?></span>
                    </a>
                </li>
                <li <?php if($task=='likes'){ echo"class='active'";} ?> >
                    <a href="<?php echo  JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=likes'.$href.'') ?>" rel="nofollow" >
                        <strong><?php echo $this->NumberLike->id; ?></strong>
                        <span> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_LIKES'); ?></span>
                    </a>
                </li>
                <li <?php if($task=='followers'){ echo"class='active'";} ?> >
                    <a href="<?php echo  JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=followers'.$href.'') ?>" rel="nofollow" >
                        <strong><?php echo $this->NumberFollow->id; ?></strong>
                        <span> <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOWERS'); ?> </span>
                    </a>
                </li>
                <li <?php if($task=='following'){ echo"class='active'";} ?> >
                    <a href="<?php echo  JRoute::_('index.php?option=com_tz_pinboard&view=manageruser&task=following'.$href.'') ?>"  rel="nofollow">
                        <strong><?php echo $this->NumberFollowing->id; ?></strong>
                        <span>  <?php echo JText::_('COM_TZ_PINBOARD_MANAGERUSER_FOLLOWING'); ?></span>
                     </a>
                </li>

            </ul>
</div>