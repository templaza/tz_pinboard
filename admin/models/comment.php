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
defined('_JEXEC') or die;
jimport('joomla.html.pagination');
class TZ_PinboardModelComment extends JModelList
{
    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();

        // Adjust the context to support modal layouts.
        if ($layout = $app->input->get('layout')) {
            $this->context .= '.' . $layout;
        }


        $filer_auto = $this->getUserStateFromRequest($this->context . '.filter.author.id', 'filter_author_id', '');
        $filer_search = $this->getUserStateFromRequest($this->context . '.filler.search', 'filter_search', '');
        $filer_state = $this->getUserStateFromRequest($this->context . '.filter_published', 'filter_published', '');

        $filer_auto = $this->getUserStateFromRequest($this->context . '.filter.author.id', 'filter_author_id', '');
        $filert_order = $this->getUserStateFromRequest($this->context . '.filter.order', 'filter_order', '');
        $filert_order_dir = $this->getUserStateFromRequest($this->context . '.filert.order.dir', 'filter_order_Dir', '');
        $limit = $this->getUserStateFromRequest($this->context . 'limit', 'limit', '');
        $limitstartt = $this->getUserStateFromRequest($this->context . 'limitstart', 'limitstart', '');
        $id_cm = $this->getUserStateFromRequest($this->context . '.id_cm', 'id', '');
        $this->setState('state', $filer_state);
        $this->setState('id_cm', $id_cm);
        $this->setState('autho', $filer_auto);
        $this->setState('lab1', $filert_order);
        $this->setState('lab2', $filert_order_dir);
        $this->setState('search', $filer_search);
        if (isset($_POST['cid'])) {
            $this->setState('id_input', $_POST['cid']);
        }
        $this->setState('detail2', JRequest::getInt('id'));
        $this->setState('limi', $limit);
        $this->setState('limitstar', $limitstartt);


    }

    function  __construct()
    {
        parent::__construct();
    }

    function getAuthors()
    {
        $db = JFactory::getDbo();
        $sql = "SELECT u.id AS value, u.name AS text
           FROM  #__users as u inner join #__tz_pinboard_comment as c on u.id = c.id_user group by u.id";
        $db->setQuery($sql);
        $row = $db->loadObjectList();

        return $row;

    }

    function getContents()
    {
        $lisd = $this->getState('lab1');
        $lisd2 = $this->getState('lab2');
        $limit = $this->getState('limi', 5);
        $limitstart = $this->getState('limitstar', 0);
        $author = $this->getState('autho');
        $search = $this->getState('search');
        $states = $this->getState('state');
        switch ($lisd) {
            case'tz.title':
                $ord = "order by cm.content $lisd2";
                break;
            case'tz.state':
                $ord = "order by cm.state $lisd2";
                break;
            case'tz.contentid':
                $ord = "order by cm.content_id $lisd2";
                break;
            case'tz.id':
                $ord = "order by cm.id $lisd2";
                break;
            case'tz.author':
                $ord = "order by u.name $lisd2 ";
                break;
            case'tz.date':
                $ord = "order by cm.dates $lisd2";
                break;
            case'tz.check':
                $ord = "order by cm.checkIP $lisd2";
                break;
            default:
                $ord = "order by cm.dates desc";
                break;
        }
        // search state
        switch ($states) {
            case'1':
                $state_sql = 'cm.state=1 ';
                break;
            case'0':
                $state_sql = 'cm.state=0';
                break;
            default:
                $state_sql = 'cm.state in (0,1)';
        }

        // search by author
        if (isset($author) && $author > 0) {
            $author = " AND cm.id_user = $author ";
        } else {
            $author = "";
        }
        // search results
        if (isset($search) && !empty($search)) {
            if (is_numeric($search) == true) {
                $sear = " AND cm.id= $search ";
            } else if (is_numeric($search) == false) {
                $sear = ' AND cm.content like "%' . $search . '%" ';
            } else {
                $sear = null;
            }
        } else {
            $sear = null;
        }

        $db = JFactory::getDbo();
        $sql = "select u.name as u_name, cm.ip as cm_ip, cm.content as cm_content, cm.content_id as cm_idcontent, cm.dates as cm_date, cm.id as cm_id,
                          cm.state as state_cm, cm.checkIP as checkip
                   from #__tz_pinboard_comment as cm left join #__users as u on cm.id_user = u.id
                   where $state_sql $author $sear  $ord";

        $sql2 = "select u.name as u_name, cm.ip as cm_ip, cm.content as cm_content, cm.content_id as cm_idcontent, cm.dates as cm_date, cm.id as cm_id,
                        cm.state as state_cm, cm.checkIP as checkip
                   from #__tz_pinboard_comment as cm left join #__users as u on cm.id_user = u.id
                   where $state_sql $author $sear  $ord";

        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh); //  return the number of rows from query
        $this->pagNav = new JPagination($total, $limitstart, $limit); // creating a new objects
        $db->setQuery($sql2, $this->pagNav->limitstart, $this->pagNav->limit); //  query with conditions
        $row = $db->loadObjectList();
        return $row;
    }

    function getPagination()
    {
        if (!$this->pagNav)
            return '';
        return $this->pagNav;
    }

    function delete()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "delete from  #__tz_pinboard_comment  WHERE id in($rr)";

        $db->setQuery($sql);
        $db->query();
    }

    function unpulich()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_comment SET state =0 WHERE id in($rr)";
        $db->setQuery($sql);
        $db->query();
    }

    function publish()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_comment SET state =1 WHERE id in($rr)";
        $db->setQuery($sql);
        $db->query();

    }

    function getCheckIP()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "select IP from #__tz_pinboard_comment where id in($rr)";
        $db->setQuery($sql);
        $row = $db->loadObject();
        return $row;
    }

    function unpulichIP()
    {
        $IP = $this->getCheckIP()->IP;
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_comment SET checkIP =0 WHERE IP='" . $IP . "'";
        $db->setQuery($sql);
        $db->query();
    }

    function publishIP()
    {
        $IP = $this->getCheckIP()->IP;
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_comment SET checkIP =1 WHERE IP='" . $IP . "'";
        $db->setQuery($sql);
        $db->query();

    }

    function getMore()
    {
        $id_input = $this->getState('id_input'); // lay ve mang
        $id_input = $id_input[0];
        $id_link = $this->getState('detail2');
        if (isset($id_input) && !empty($id_input)) {
            $id = $id_input;
        } else if (isset($id_link) && !empty($id_link)) {
            $id = $id_link;
        }
        if (isset($id) && !empty($id)) {
            $db = JFactory::getDbo();
            $sql = "select u.name as u_name,  cm.ip as cm_ip, cm.content as cm_content, cm.content_id as cm_idcontent, cm.dates as cm_date, cm.id as cm_id,
                      cm.state as cm_state
                      from #__tz_pinboard_comment as cm left join #__users as u on cm.id_user = u.id left join #__content as c on cm.content_id=c.id
                      where cm.id=$id";
            $db->setQuery($sql);
            $db->query();
            $row = $db->loadObject();

            return $row;
        }
    }
}

?>