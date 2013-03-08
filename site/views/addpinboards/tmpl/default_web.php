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
if(isset($this->showweb_img)){
    $results  = $this->showweb_img;

}

?>
<div id="tz_pin_url_content_2_left">
    <?php
    if(isset($results['img']) && !empty($results['img'])){
        $count = count($results['img']);
        if($count ==1){
            ?>
            <ul id="tz_ul_web">
                <li class="activePage">
                    <img  src="<?php echo $results ['img'][0]; ?> " alt=""/>
                </li>
            </ul>
    <?php
        }else if($count > 1){
    ?>

        <ul id="slider">
                    <?php
                        for($i =0; $i<$count; $i++){
                    ?>
                        <li>
                            <img  src="<?php echo $results ['img'][$i]; ?> " alt=""/>
                        </li>
                    <?php
                        }
                    ?>

        </ul>
    <?php
         }
    }

    ?>
    <div class="cler"></div>
</div>
<div id="tz_pin_url_content_2_right">
    <div class="tz_pin_url_input">
        <input id="tz_pin_url_keygord" type="text" name="keywords_pin_local"  maxlength="<?php echo $this->max_keywords; ?>" value="<?php if(isset($results['keywoa']) && !empty($results['keywoa'])){ echo $results['keywoa'];} ?>">
        <p id="tz_url_p_keyword">
        </p>
    </div>
    <div class="tz_pin_url_input">
        <input id="tz_pin_url_title" type="text" name="title_pin_local" title="Title" maxlength="<?php echo $this->text_title; ?>" value="<?php if(isset($results['title']) && !empty($results['title'])) {echo $results['title']; } ?>">
        <input type="hidden" name="img_hidde" id="img_hidder" value="">
        <p id="tz_url_p_title">
        </p>
    </div>
    <div class="tz_pin_url_input">
        <select name="board" id="tz_pin_url_select">
            <?php
            if(isset($this->Showboardd)){
                foreach($this->Showboardd as $row){
                    ?>
                    <option value="<?php echo $row->id ?>">
                        <?php echo $row->title; ?>
                    </option>
                    <?php
                }
            }
            else{
                ?>
                <option value="">
                </option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="tz_pin_url_input">
        <textarea id="tz_pin_url_textarea" title="Descript" name="tz_descript_url" style="width: 299px; height: 118px;" maxlength=<?php echo $this->text_descript; ?> ><?php if(isset($results ['introtext']) && !empty($results ['introtext'])){ echo $results ['introtext']; }?></textarea>
        <p id="tz_url_p_textarea"></p>
    </div>
    <div class="tz_pin_url_input">
        <input type="hidden" name="task" value="task_upload_pin">
        <input  class="btn btn-large" id="url_a_pin" type="submit" name="uploadpin" value="<?php echo JText::_('COM_TZ_PINBOARD_ADDPINBOARD_WEB_PIN'); ?>">
        <?php echo JHtml::_('form.token'); ?>
    </div>
</div>
<div class="cler"></div>



