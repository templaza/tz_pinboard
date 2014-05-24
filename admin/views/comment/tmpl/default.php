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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
$listDirn = $this->state2;
$listOrder = $this->state1;
$sortFields = $this->getSortFields();


?>
<script type="text/javascript">
    Joomla.orderTable = function () {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<form action="index.php?option=com_tz_pinboard&view=comment" method="post" name="adminForm" id="adminForm">
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <div id="j-main-container">
            <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                    <input type="text" name="filter_search"
                           placeholder="<?php echo JText::_('COM_TZ_PINBOARD_COMMENT_SEARCH'); ?>" id="filter_search"
                           value="<?php echo $this->searchs; ?>"
                           title="<?php echo JText::_('COM_TZ_PINBOARD_COMMENT_SEARCH_TITLE'); ?>"/>
                </div>
                <div class="btn-group pull-left hidden-phone">
                    <button class="btn tip hasTooltip" type="submit"
                            title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i>
                    </button>
                    <button class="btn tip hasTooltip" type="button"
                            onclick="document.id('filter_search').value='';this.form.submit();"
                            title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit"
                           class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                    <?php echo $this->pagination->getLimitBox(); ?>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="directionTable"
                           class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                    <select name="directionTable" id="directionTable" class="input-medium"
                            onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                        <option
                            value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                        <option
                            value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                    </select>
                </div>
                <div class="btn-group pull-right">
                    <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                    <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                        <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
                    </select>
                </div>

            </div>
            <div class="clearfix"></div>
            <table class="table table-striped" id="articleList">
                <thead>
                <tr>
                    <th width="1%" class="hidden-phone">
                        <input type="checkbox" name="checkall-toggle" value=""
                               title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
                    </th>
                    <th width="8%" class="class=" hidden-phone
                    ">
                    <?php echo JHtml::_('grid.sort', 'JSTATUS', 'tz.state', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_CONTENT', 'tz.content', $listDirn, $listOrder); ?>
                    </th>
                    <th width="20%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_AUTHOR', 'tz.author', $listDirn, $listOrder); ?>
                    </th>

                    <th width="10%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_DATE', 'tz.date', $listDirn, $listOrder); ?>
                    </th>
                    <th width="8%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_TP', 'tz.ip', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_MORE_CHECKIP', 'tz.check', $listDirn, $listOrder); ?>
                    </th>
                    <th width="8%" style="min-width:55px" class="nowrap center">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_CONTENTID', 'tz.contentid', $listDirn, $listOrder); ?>
                    </th>

                    <th width="5%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_TZ_PINBOARD_COMMENT_ID', 'tz.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->contents as $i => $content) {
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="small hidden-phone">
                            <?php echo JHtml::_('grid.id', $i, $content->cm_id); ?>
                        </td>

                        <td class="small hidden-phone">
                            <?php
                            echo JHtml::_('jgrid.published', $content->state_cm, $i, 'comment.', true, 'cb');
                            ?>
                        </td>
                        <td class="nowrap has-context">

                            <a href="<?php echo JRoute::_('index.php?option=com_tz_pinboard&view=comment&task=more&id=' . $content->cm_id); ?>">
                                <?php
                                $string_content = $content->cm_content;
                                $string_content = explode(' ', $string_content);
                                $row_cm = array_slice($string_content, 0, 10);
                                $row_cm = implode(' ', $row_cm);
                                echo $row_cm . "...";
                                ?>
                            </a>


                        </td>
                        <td class="small hidden-phone">
                            <?php echo $content->u_name; ?>
                        </td>
                        <td class="small hidden-phone">
                            <?php echo $content->cm_date; ?>
                        </td>

                        <td class="small hidden-phone">
                            <?php echo $content->cm_ip; ?>
                        </td>
                        <td class="small hidden-phone">
                            <?php
                            echo JHtml::_('jgrid.published', $content->checkip, $i, 'check.', true, 'cb');
                            ?>
                        </td>

                        <td class="center">
                            <?php echo $content->cm_idcontent; ?>
                        </td>


                        <td class="small hidden-phone">
                            <?php echo $content->cm_id; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="8">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <input type="hidden" name="option" value="com_tz_pinboard">
    <input type="hidden" name="view" value="comment">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
</form>