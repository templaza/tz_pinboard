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

// No direct access.
defined('_JEXEC') or die;
echo JHtml::_('bootstrap.startAccordion', 'categoryOptions', array('active' => 'collapse0'));
$fieldSets = $this->form->getFieldsets('params');
$i = 0;

foreach ($fieldSets as $name => $fieldSet) :
    $label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_CATEGORIES_' . $name . '_FIELDSET_LABEL';
    echo JHtml::_('bootstrap.addSlide', 'categoryOptions', JText::_($label), 'collapse' . $i++);
    if (isset($fieldSet->description) && trim($fieldSet->description)) :
        echo '<p class="tip">' . $this->escape(JText::_($fieldSet->description)) . '</p>';
    endif;
    ?>
    <?php foreach ($this->form->getFieldset($name) as $field) : ?>
    <div class="control-group">
        <?php if ($field->name != 'jform[params][tz_fieldsid_content]'): ?>
            <div class="control-label">
                <?php echo $field->label; ?>
            </div>
            <div class="controls">
                <?php echo $field->input; ?>
            </div>
        <?php else: ?>
            <div class="control-label">
                <?php echo $field->label; ?>
            </div>
            <div class="controls">
                <div id="tz_fieldsid_content"></div>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

    <?php if ($name == 'basic'): ?>
    <div class="control-group">
        <div class="control-label">
            <?php echo $this->form->getLabel('note'); ?>
        </div>
        <div class="controls">
            <?php echo $this->form->getInput('note'); ?>
        </div>
    </div>
<?php endif;
    echo JHtml::_('bootstrap.endSlide');
endforeach;
echo JHtml::_('bootstrap.endAccordion');
?>

