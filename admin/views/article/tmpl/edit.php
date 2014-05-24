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
jimport('joomla.html.toolbar.button');
jimport('joomla.html.toolbar.button.popup');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
$add = JFactory::getDocument();
$add->addStyleSheet('components/com_tz_pinboard/css/anythingslider.css');
$add->addCustomTag('<script type="text/javascript" src="components/com_tz_pinboard/js/jquery.anythingslider.js"></script>');
// Create shortcut to parameters.
$params = $this->state->get('params');

//
$params = $params->toArray();

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params['show_publishing_options']);

if (!$editoroptions):
    $params['show_publishing_options'] = '1';
    $params['show_article_options'] = '1';
    $params['show_urls_images_backend'] = '0';
    $params['show_urls_images_frontend'] = '0';
endif;

// Check if the article uses configuration settings besides global. If so, use them.
if (!empty($this->item->attribs['show_publishing_options'])):
    $params['show_publishing_options'] = $this->item->attribs['show_publishing_options'];
endif;
if (!empty($this->item->attribs['show_article_options'])):
    $params['show_article_options'] = $this->item->attribs['show_article_options'];
endif;
if (!empty($this->item->attribs['show_urls_images_backend'])):
    $params['show_urls_images_backend'] = $this->item->attribs['show_urls_images_backend'];
endif;

$type = '';
$mediavalue = '';
$media = array();
$list = $this->listEdit;


if ($list) {
    $type = $list->type;
}

?>

<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery('#buttom_url').click(function () {
            var srt3 = /^http(s)?:\/\/(www\.)?([a-zA-Z0-9\_])+\.([a-zA-Z0-9\/]{1,5})+(\.[A-Za-z0-9\/]{1,4})?([a-zA-Z0-9\/\.&=_\+\#\-\?]*)?$/;
            var check_url_img = jQuery('#image-url').val();
            if (check_url_img == "") {
                alert("<?php echo JText::_('Not  URL'); ?>");
                document.getElementById('image-url').focus();
                return false;
            } else if (srt3.test(check_url_img) == false) {
                alert("<?php echo JText::_('Not  URL'); ?>");
                document.getElementById('image-url').focus();
                return false;
            }
            jQuery("#tz_img_ajax").html("<img src='<?php echo JURI::base(true).'/components/com_tz_pinboard/images/loading-icon.gif'?>' />").fadeIn('fast');
            jQuery(".tz_img_slid").fadeOut();
            jQuery.ajax({
                url: "index.php?option=com_tz_pinboard&task=article.website",
                type: "post",
                data: {
                    link: jQuery('#image-url').val()
                }
            }).success(function (data) {
                    jQuery('#tz_img_ajax').fadeOut('fast');
                    jQuery('#load_img_url').html(data);
                    jQuery('#slider').anythingSlider({
                        enableArrows: true,      // if false, arrows will be visible, but not clickable.
                        enableNavigation: false,      // if false, navigation links will still be visible, but not clickable.
                        enableStartStop: false
                    });


                });
        });

        jQuery('#tz_select_img').change(function () {
            var checkselec = jQuery(this).val();
            if (checkselec == 1) {
                jQuery('#tz_img_local').css("display", "block");
                jQuery('#tz_image_usrl').css("display", "none");
            } else {
                jQuery('#tz_image_usrl').css("display", "block");
                jQuery('#tz_img_local').css("display", "none");
            }
        });

    });
</script>
<script type="text/javascript">

Joomla.submitbutton = function (task) {
    var srcc = jQuery('#slider li.activePage > img').attr("src");
    jQuery('#img_hidder').attr('value', srcc);
    if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
        <?php echo $this->form->getField('articletext')->save(); ?>
        Joomla.submitform(task, document.getElementById('item-form'));
    }
    else {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
        if ($('jform_type_of_media').hasClass('invalid')) {
            $$('#jform_type_of_media_chzn a').setStyle('border', '1px solid red');
        }
        else {
            $$('#jform_type_of_media_chzn a').removeClass('invalid');
        }
    }
}

// extra fields


//Media
window.addEvent('load', function () {
    function tz_thumb() {
        <?php //if(!empty($list -> video -> thumb)):?>
        if ($('tz_thumb'))
            $('tz_thumb').dispose();
        <?php //endif;?>
        var myTr = new Element('tr', {id: 'tz_thumb'})
            .inject($('tz_media_code_outer'), 'after');
        var myThumbInner = new Element('td', {
            id: 'tz_thumb_inner',
            valign: "top",
            align: "right",
            style: "background: #F6F6F6; min-width:100px;"
        }).inject(myTr);
        var myElement = new Element('strong');
        myElement.appendText('<?php echo JText::_('COM_TZ_PINBOARD_THUMBNAIL');?>');
        myThumbInner.adopt(myElement);

        var myThumbPre = new Element('td', {
            id: 'tz_thumb_preview',
            class: 'input-prepend input-append'
        }).inject(myThumbInner, 'after');

        var tz_e = location.href.match(/^(.+)\/index\.php.*/i)[1];

        var icon = new Element('div', {
            class: 'add-on',
            html: '<\i class="icon-eye"></i>'
        }).inject($('tz_thumb_preview'));
        var tz_a = new Element('input', {
            type: "text",
            class: "inputbox image-select",
            name: "tz_thumb",
            id: "image-thumb",
            readonly: 'true',
            style: "width:200px;"
        });
        tz_a.inject($('tz_thumb_preview'));
        var tz_d = "image-thumb",
            tz_b = (new Element("button", {
                type: "button",
                class: "btn",
                "id": "tz_thumb_button"
            })).set('html', '<i class="icon-file"></i>&nbsp;<?php echo JText::_('COM_TZ_PINBOARD_BROWSE_SERVER');?>').inject(tz_a, 'after'),
            tz_f = (new Element("button", {
                "name": "tz_thumb_cancel",
                "id": "tz_thumb_cancel",
                class: 'btn',
                html: '<i class="icon-refresh"></i>&nbsp;<?php echo JText::_('COM_TZ_PINBOARD_RESET');?>'
            })).inject(tz_b, 'after'),
            tz_g = (new Element("div", {
                "class": "tz-image-preview",
                "style": "clear:both;"
            })).inject(tz_f, 'after');

        if (tz_g)
            tz_g.empty();

        tz_a.setProperty("id", tz_d);
        <?php
//        var_dump($list->video->type);
            if($list -> video -> type == 'default' AND !empty($list -> video -> thumb)):
                $src    = JURI::root().str_replace('.'.JFile::getExt($list -> video -> thumb)
                    ,'_S.'.JFile::getExt($list -> video -> thumb),$list -> video -> thumb);
                $src2   = JURI::root().str_replace('.'.JFile::getExt($list -> video -> thumb)
                    ,'_L.'.JFile::getExt($list -> video -> thumb),$list -> video -> thumb);
        ?>
        var tz_hidden = new Element('input', {
            type: 'hidden',
            name: 'tz_thumb_hidden',
            value: '<?php echo $list -> video -> thumb;?>'
        }).inject(tz_g);
        var tz_img = new Element("img", {
            src: '<?php echo $src;?>',
            style: 'cursor:pointer; max-width: 200px;'
        }).inject(tz_g);
        tz_img.addEvent('click', function () {
            SqueezeBox.fromElement(this, {
                handler: "image",
                url: '<?php echo $src2;?>'
            });
        });
        var tz_checkbox = new Element('input', {
            type: 'checkbox',
            style: 'clear:both;',
            name: 'tz_thumb_del',
            id: 'tz_thumb_del'
        }).inject(tz_img, 'after');
        var tz_label = new Element('label', {
            'for': 'tz_thumb_del',
            style: 'clear: none; margin: 2px 3px;',
            html: '<?php echo JText::_('COM_TZ_PINBOARD_DELETE_IMAGES');?>'
        }).inject(tz_checkbox, 'after');


        <?php endif;?>

        tz_f.addEvent("click", function (e) {
            e.stop();
            $('image-thumb').value = '';
            tz_a.setProperty("value", "");
        });

        tz_b.addEvent("click", function (h) {
            h.stop();
            SqueezeBox.fromElement(this, {
                handler: "iframe",
                url: "index.php?option=com_media&view=images&tmpl=component&asset=<?php echo JFactory::getUser() -> id;?>&author=<?php echo JFactory::getUser() -> id;?>&e_name=" + tz_d,
                size: {
                    x: 800,
                    y: 500
                }
            });

            window.jInsertEditorText = function (text, editor) {
                if (editor.match(/^image-thumb/)) {

                    var d = $(editor);
                    var src = text.match(/src=\".*?\"/i);
                    src = String.from(src);
                    src = src.replace(/^src=\"/g, '');
                    src = src.replace(/\"$/g, '');
                    d.setProperty("value", src);
                } else tinyMCE.execInstanceCommand(editor, 'mceInsertContent', false, text);
            };

        });

    }


});

// Image, Image gallery
window.addEvent("load", function () {
    var tz_count = 0;
    var tz_pinboard_image = function (id, name, value, title, i) {

        var tz_e = location.href.match(/^(.+)administrator\/index\.php.*/i)[1];

        var icon = new Element('div', {
            class: 'add-on',
            html: '<\i class="icon-eye"></i>'
        }).inject($(id));
        var tz_a = new Element('input', {
            type: "text",
            class: "inputbox image-select",
            name: name,
            id: "image-select-" + tz_count,
            readonly: 'true',
            style: "width:200px;"
        });
        tz_a.inject($(id));
        var tz_d = "image-select-" + tz_count,
            tz_b = (new Element("a", {
                class: 'btn',
                "id": "tz_img_button" + tz_count
            })).set('html', '<i class="icon-file"></i>&nbsp;<?php echo JText::_('COM_TZ_PINBOARD_BROWSE_SERVER');?>').inject(tz_a, 'after'),
            tz_f = (new Element("a", {
                class: 'btn',
                "name": "tz_img_cancel_" + i,
                html: '<i class="icon-refresh"></i>&nbsp;<?php echo JText::_('COM_TZ_PINBOARD_RESET');?>'
            })).inject(tz_b, 'after'),
            tz_g = (new Element("div", {
                "class": "tz-image-preview",
                "style": "clear:both;"
            })).inject(tz_f, 'after');

        tz_a.setProperty("id", tz_d);
        if (value) {
            var tz_h = (new Element("img", {
                src: value,
                style: 'max-width:300px; cursor:pointer;',
                title: title
            })).inject(tz_g, 'inside');
            tz_h.addEvent('click', function () {
                SqueezeBox.fromElement(this, {
                    handler: "image",
                    url: String.from(value.replace(/_S/, '_L'))
                });
            });
        }


        tz_f.addEvent("click", function (e) {
            e.stop();
            if (id == 'tz_img_server') {
                $('tz_img').value = '';
            }

            $('tz_img_client_' + i).value = '';

            if (id == 'tz_img_hover_server')
                $('tz_img_hover').value = '';
            tz_a.setProperty("value", "");
        });

        tz_b.addEvent("click", function (h) {
            (h).stop();
            SqueezeBox.fromElement(this, {
                handler: "iframe",
                url: "index.php?option=com_media&view=images&tmpl=component&e_name=" + tz_d,
                size: {
                    x: 800,
                    y: 500
                }
            });

            window.jInsertEditorText = function (text, editor) {
                if (editor.match(/^image-select-/)) {

                    var d = $(editor);
                    var src = text.match(/src=\".*?\"/i);
                    src = String.from(src);
                    src = src.replace(/^src=\"/g, '');
                    src = src.replace(/\"$/g, '');
                    d.setProperty("value", src);
                } else tinyMCE.execInstanceCommand(editor, 'mceInsertContent', false, text);
            };

        });
        tz_count++;
    }


    <?php
    if(!empty($list -> images)){
        $src    = null;
        if($pos = strpos($list -> images,'.')){
            $ext    = substr($list -> images,$pos,strlen($list -> images));

            $src    = JURI::root().str_replace($ext,'_S'.$ext,$list -> images);
        }

    ?>
    tz_pinboard_image('tz_img_server', 'tz_img_gallery_server[]', '<?php echo $src;?>', '<?php echo $list -> imagetitle?>', 0);
    var tz_hidden = new Element('input', {
        'type': 'hidden',
        'name': 'tz_image_current',
        'value': '<?php echo $list -> images; ?>'
    }).inject($('tz_img_server'));
    var tz_checkbox = new Element("input", {
        type: 'checkbox',
        id: 'tz_del_image',
        'name': 'tz_delete_image',
        'value': 0,
        style: 'clear: both'
    }).inject($('tz_img_server'));
    var tz_label = new Element('label', {
        'for': 'tz_del_image',
        style: 'clear: none; margin: 2px 3px;',
        html: '<?php echo JText::_('COM_TZ_PINBOARD_CURRENT_IMAGE_DESC');?>'
    }).inject($('tz_img_server'));

    <?php
    }
    else{
    ?>
    tz_pinboard_image('tz_img_server', 'tz_img_gallery_server[]', '', '', 0);
    <?php
    }
    ?>


});


// extra fields


</script>

<form action="<?php echo JRoute::_('index.php?option=com_tz_pinboard&layout=edit&id=' . (int)$this->item->id); ?>"
      method="post"
      name="adminForm"
      id="item-form"
      class="form-validate"
      enctype="multipart/form-data"" >
<div class="span8 form-horizontal">
<ul class="nav nav-tabs">
    <li class="active"><a href="#general" data-toggle="tab"><?php echo JText::_('COM_CONTENT_ARTICLE_DETAILS'); ?></a>
    </li>
    <li><a href="#permissions" data-toggle="tab"><?php echo JText::_('COM_CONTENT_FIELDSET_RULES'); ?></a></li>

</ul>
<div class="tab-content">
<!-- Begin Tabs -->
<div class="tab-pane active" id="general">
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('title'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('title'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('alias'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('alias'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label><?php echo JText::_('COM_TZ_PINBOARD_PINS_TAG'); ?></label>
            </div>
            <div class="controls">
                <input type="text" name="tz_tags" value="<?php echo $this->listsTags; ?>"
                       size="50"
                    />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('state'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('state'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('access'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('access'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('id'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('id'); ?>
            </div>
        </div>

    </div>
    <div class="span6">
        <div class="control-group">
            <div class="control-label"><label>Boards</label></div>
            <div class="controls">
                <input type="text" name="boar_name" value="<?php echo $this->item->board->title_c; ?>">
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                <label
                    title="<?php echo JText::_('COM_TZ_PINBOARD_PINS_MEDIA_TYPE') ?>::<?php echo JText::_('COM_TZ_PINBOARD_PINS_MEDIA_TYPE_DESCRIPT'); ?>"
                    class="hasTip required"
                    for="jform_type_of_media"
                    id="jform_type_of_media-lbl">
                    <?php echo JText::_('COM_TZ_PINBOARD_PINS_MEDIA_TYPE') ?>
                    <span class="star"> *</span>
                </label>
            </div>
            <div class="controls">
                <select id="jform_type_of_media" name="type_of_media" required="required" class="required">

                    <option value="image"><?php echo JText::_('COM_TZ_PINBOARD_PINS_OPTION_IMAGE'); ?></option>

                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo $this->form->getLabel('language'); ?>
            </div>
            <div class="controls">
                <?php echo $this->form->getInput('language'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                url
            </div>
            <div class="controls">
                <?php if ($this->item->web != null):
                    $link = $this->item->web->url;
                else:
                    $link = ""; endif; ?>
                <input type="text" disabled="false" value="<?php echo $link; ?>">
                <input type="hidden" name="url_Website" value="<?php echo $link; ?>">

            </div>
        </div>
    </div>


</div>
<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tz_content" data-toggle="tab">
            <?php echo JText::_('COM_TZ_PINBOARD_PINS_TAB_CONTENT'); ?>
        </a></li>
</ul>
<div class="span11">
    <!-- Begin Content -->
    <div class="tab-content">
        <!-- Begin Tabs -->
        <div class="tab-pane active" id="tz_content">
            <?php echo $this->form->getInput('articletext'); ?>
        </div>

        <div class="tab-pane" id="tztabsImage">
            <div id="tz_images">
                <div class="img_type">
                    <label>Images type</label>
                    <select id="tz_select_img" name="tz_select_img">
                        <option value="1"> Local</option>
                        <option
                            value="2" <?php if (isset($this->item->web->url) && !empty($this->item->web->url)) { ?> selected="true" <?php } ?>  >
                            Website
                        </option>
                    </select>
                </div>

                <table class="admintable" id="tz_img_local"
                       style="width: 100%;display:  <?php if (isset($this->item->web->url) || !empty($this->item->web->url)) {
                           echo "none";
                       } ?> ">
                    <tr>
                        <td style="background: #F6F6F6; min-width:100px;" align="right" rowspan="2" valign="top">
                            <strong><?php echo JText::_('COM_TZ_PINBOARD_FORM_IMAGE'); ?></strong>
                        </td>
                        <td>
                            <input name="tz_img" id="tz_img" type="file">

                        </td>
                    </tr>
                    <tr class="input-prepend input-append">
                        <td id="tz_img_server">
                        </td>
                    </tr>

                </table>


                <table class="admintable" id="tz_image_usrl"
                       style="display:  <?php if (!isset($this->item->web->url) || empty($this->item->web->url)) {
                           echo "none";
                       } ?>">
                    <tr>
                        <td align="left" id="tz_img_gallery">
                            <input type="text" class="inputbox image-select" name="imgurl" id="image-url" value=""
                                   style="width:283px;"/>

                            <button type="button" id="buttom_url" name="buttom" value="Pins"
                                    style="width: 90px; border: 1px solid #c0c0c0; height: 30px">Pins Url
                            </button>

                            <div id="tz_img_ajax">

                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td class="tz_img_slid">
                            <?php
                            $img_size = $this->img_size;
                            $img_type = JFile::getExt($list->images);
                            $img_type_replaca = str_replace(".$img_type", "_$img_size.$img_type", $list->images);

                            ?>
                            <img style="max-width: 300px; cursor: pointer; margin-left: 116px; margin-top: 10px"
                                 src="<?php echo JURI::root() . $img_type_replaca ?>">
                            <input type="hidden" name="edit_img" value="<?php if (isset($list->images)) {
                                echo $list->images;
                            } ?>">
                        </td>
                    </tr>

                    <tr>
                        <td id="url_imgs" style=" width: 100%; margin-top: 10px; height: auto">
                            <div id="load_img_url">
                                <?php echo $this->loadTemplate('edit_url'); ?>

                            </div>
                            <input type="hidden" name="img_hidde" id="img_hidder" value="">
                        </td>
                    </tr>
                </table>

            </div>
        </div>


        <!-- End Tabs -->
    </div>
    <!-- End Content -->
</div>
</div>
<div class="tab-pane" id="permissions">
    <?php echo $this->form->getInput('rules'); ?>
</div>
<!-- End Tabs -->
</div>

</div>
<div class="span4 form-vertical">
    <?php echo JHtml::_('bootstrap.startAccordion', 'menuOptions', array('active' => 'collapse0')); ?>

    <?php // Do not show the publishing options if the edit form is configured not to. ?>
    <?php if ($params['show_publishing_options'] || ($params['show_publishing_options'] = '' && !empty($editoroptions))): ?>
        <?php echo JHtml::_('bootstrap.addSlide', 'menuOptions', JText::_('COM_TZ_PINBOARD_PUBLISH'), 'collapse0'); ?>
        <fieldset>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
                <div class="controls">
                    <input type="text" name="name_user" value="<?php echo $this->item->board->name_u; ?>">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
                <div class="controls">
                    <input type="text" name="name_user" value="<?php echo $this->item->created; ?>">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
            </div>

            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
            </div>

            <?php if ($this->item->modified_by) : ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
                </div>

                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
                </div>
            <?php endif; ?>

            <?php if ($this->item->version) : ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('version'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('version'); ?></div>
                </div>
            <?php endif; ?>

            <?php if ($this->item->hits) : ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('hits'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
                </div>
            <?php endif; ?>
        </fieldset>
        <?php echo JHtml::_('bootstrap.endSlide'); ?>
    <?php endif; ?>

    <?php $fieldSets = $this->form->getFieldsets('attribs'); ?>
    <?php $i = 1; ?>
    <?php foreach ($fieldSets as $name => $fieldSet) : ?>
        <?php if ($params['show_article_options'] || (($params['show_article_options'] == '' && !empty($editoroptions)))): ?>
            <?php if ($name != 'editorConfig' && $name != 'basic-limited') : ?>
                <?php echo JHtml::_('bootstrap.addSlide', 'menuOptions', JText::_($fieldSet->label), 'collapse' . $i++); ?>
                <?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
                    <p class="tip"><?php echo $this->escape(JText::_($fieldSet->description)); ?></p>
                <?php endif; ?>
                <fieldset>
                    <?php foreach ($this->form->getFieldset($name) as $field) : ?>
                        <div class="control-group">
                            <?php if ($field->name != 'jform[attribs][tz_fieldsid_content]'): ?>
                                <div class="control-label"><?php echo $field->label; ?></div>
                                <div class="controls"><?php echo $field->input; ?></div>
                            <?php else: ?>
                                <div class="control-label"><?php echo $field->label; ?></div>
                                <div class="controls">
                                    <div id="tz_fieldsid_content"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <?php echo JHtml::_('bootstrap.endSlide'); ?>
            <?php endif ?>
        <?php elseif ($name == 'basic-limited'): ?>
            <?php foreach ($this->form->getFieldset('basic-limited') as $field) : ?>
                <?php echo $field->input; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($this->canDo->get('core.admin')): ?>
        <?php echo JHtml::_('bootstrap.addSlide', 'menuOptions', JText::_('COM_CONTENT_SLIDER_EDITOR_CONFIG'), 'configure-sliders'); ?>
        <fieldset>
            <?php $i = 0; ?>
            <?php foreach ($this->form->getFieldset('editorConfig') as $field) : ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $field->label; ?></div>
                    <div class="controls"><?php echo $field->input; ?></div>
                </div>
            <?php endforeach; ?>
        </fieldset>
        <?php echo JHtml::_('bootstrap.endSlide'); ?>
    <?php endif ?>
    <?php if ($params['show_urls_images_backend']): ?>
        <?php echo JHtml::_('bootstrap.addSlide', 'menuOptions', JText::_('COM_CONTENT_FIELDSET_URLS_AND_IMAGES'), 'urls_and_images-options'); ?>
        <fieldset class="panelform">
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('images'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('images'); ?></div>
            </div>
            <?php foreach ($this->form->getGroup('images') as $field): ?>
                <div class="control-group">
                    <div class="control-label">
                        <?php if (!$field->hidden): ?>
                            <?php echo $field->label; ?>
                        <?php endif; ?>
                    </div>
                    <div class="controls"><?php echo $field->input; ?></div>
                </div>
            <?php endforeach; ?>
            <?php foreach ($this->form->getGroup('urls') as $field): ?>
                <div class="control-group">
                    <div class="control-label">
                        <?php if (!$field->hidden): ?>
                            <?php echo $field->label; ?>
                        <?php endif; ?>
                    </div>
                    <div class="controls"><?php echo $field->input; ?></div>
                </div>
            <?php endforeach; ?>
        </fieldset>
        <?php echo JHtml::_('bootstrap.endSlide'); ?>
    <?php endif; ?>

    <?php echo JHtml::_('bootstrap.addSlide', 'menuOptions', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'meta-options'); ?>
    <fieldset class="panelform">
        <?php echo $this->loadTemplate('metadata'); ?>
        <?php echo JHtml::_('bootstrap.endSlide'); ?>
        <?php echo JHtml::_('bootstrap.endAccordion'); ?>

</div>
<div>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="return" value="<?php echo JRequest::getCmd('return'); ?>"/>
    <input type="hidden" name="contentid" id="contentid" value="<?php echo JRequest::getCmd('id'); ?>">
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>
