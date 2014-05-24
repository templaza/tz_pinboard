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
jimport('joomla.html.pagination');
class TZ_PinboardModelBoard extends JModelList
{
    function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();
        if ($layout = $app->input->get('layout')) {
            $this->context .= '.' . $layout;
        }
        $filer_auto = $this->getUserStateFromRequest($this->context . '.filter.author.id', 'filter_author_id', '');

        $filer_search = $this->getUserStateFromRequest($this->context . '.filler.search', 'filter_search', '');

        $filert_order = $this->getUserStateFromRequest($this->context . '.filter.order', 'filter_order', '');
        $filert_order_dir = $this->getUserStateFromRequest($this->context . '.filert.order.dir', 'filter_order_Dir', '');
        $limit = $this->getUserStateFromRequest($this->context . 'limit', 'limit', '');
        $limitstartt = $this->getUserStateFromRequest($this->context . 'limitstart', 'limitstart', '');
        $filter_published = $this->getUserStateFromRequest($this->context . 'filter_published', 'filter_published', '');

        $id_cm = $this->getUserStateFromRequest($this->context . '.id_cm', 'id', '');
        $this->setState('status', $filter_published);

        $this->setState('id_cm', $id_cm);
        // $this->setState('autho',$filer_auto);
        $this->setState('lab1', $filert_order);
        $this->setState('lab2', $filert_order_dir);
        $this->setState('search', $filer_search);
        $this->setState('autho', $filer_auto);
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

    function getBoard()
    {
        $lisd = $this->getState('lab1');
        $lisd2 = $this->getState('lab2');
        $limit = $this->getState('limi', 5);
        $limitstart = $this->getState('limitstar', 0);
        $author = $this->getState('autho');

        $search = $this->getState('search');
        $status = $this->setState('status');

        switch ($lisd) {

            case'tz.title':
                $ord = "  order by b.title $lisd2";
                break;
            case'tz.email':

                $ord = " order by u.email $lisd2";
                break;
            case'tz.id':
                $ord = " order by b.id $lisd2";
                break;

            case'tz.author':
                $ord = " order by b.created_user_id $lisd2 ";
                break;
            case'tz.category':
                $ord = " order by b.catid $lisd2";
                break;
            case'tz.date':
                $ord = " order by b.created_time $lisd2";
                break;
            default:
                $ord = " order by b.created_time desc";
                break;
        }
        // ket qua tim tac gia
        if (isset($author) && $author > 0) {
            $author = "AND b.created_user_id=$author";
        } else {
            $author = null;
        }


        if (isset($search) && !empty($search)) {
            if (is_numeric($search) == true) {
                $search = "AND b.id= $search ";
            } else {
                $search = 'AND b.title like "%' . $search . '%"';
            }
        }

        switch ($status) {
            case'1':
                $satrus = ' b.state = 1';
                break;
            case'0':
                $satrus = ' b.state = 0';
                break;
            default:
                $satrus = "b.state in (0,1)";
                break;
        }

        $db = JFactory::getDbo();
        $sql = "select b.id as id_b, b.title as title_b , b.catid  as catid_b, u.name as name_u, b.state as state_b, b.created_time as created_time_b,
                                c.title  as title_c
                      from #__tz_pinboard_boards as b inner join #__tz_pinboard_category as c on b.catid = c.id left join  #__users as u on b.created_user_id  = u.id
                       where $satrus  $author $search $ord";
        $sql2 = "select b.id as id_b, b.title as title_b , b.catid  as catid_b, u.name as name_u, b.state as state_b, b.created_time as created_time_b,
                            c.title  as title_c
                        from   #__tz_pinboard_boards as b inner join #__tz_pinboard_category as c on b.catid = c.id left join  #__users as u on b.created_user_id  = u.id
                        where $satrus  $author $search $ord";

        $db->setQuery($sql);
        $tinh = $db->query();
        $total = $db->getNumRows($tinh);
        $this->pagNav = new JPagination($total, $limitstart, $limit);
        $db->setQuery($sql2, $this->pagNav->limitstart, $this->pagNav->limit);
        $row = $db->loadObjectList();

        return $row;

    }

    function getPagination()
    {
        if (!$this->pagNav)
            return '';
        return $this->pagNav;
    }

    function getAuthors()
    {
        $db = JFactory::getDbo();
        $sql = "SELECT u.id AS value, u.name AS text
                   FROM #__users as u  inner join #__tz_pinboard_boards as b on u.id = b.created_user_id group by u.id";
        $db->setQuery($sql);
        $row = $db->loadObjectList();

        return $row;

    }

    function unpulich()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_boards SET state =0 WHERE id in($rr)";
        $db->setQuery($sql);
        $db->query();
    }

    function publish()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "UPDATE #__tz_pinboard_boards SET state =1 WHERE id in($rr)";
        $db->setQuery($sql);
        $db->query();

    }

    function delete()
    {
        $idd = $this->getState('id_input');
        $rr = implode(",", $idd);
        $db = JFactory::getDbo();
        $sql = "delete from  #__tz_pinboard_boards  WHERE id in($rr)";
        $db->setQuery($sql);
        $db->query();
    }

    function getMore()
    {

        $id2 = $this->getState('id_input'); // lay ve mang

        $id1 = $this->getState('detail2');
        $id3 = $id2[0];
        if (isset($id3) && $id3 != "") {
            $id = $id3;

        } else if (isset($id1) && $id1 != "") {
            $id = $id1;
        } else {
            $id = 0;
        }

        $db = JFactory::getDbo();
        $sql = "SELECT b.id  as id_b, b.title as title_b, b.alias as  	alias_b, b.description as description_b, b.state as state_b,
                              b.created_time as created_time_b, b.modified_time as modified_time_b, b.catid as  	catid_b,
                              u.name as name_b
                        FROM
                        #__users AS u RIGHT JOIN #__tz_pinboard_boards AS b
                         ON b.created_user_id  = u.id
                        WHERE b.id = $id";

        $db->setQuery($sql);
        $db->query();
        $row = $db->loadObject();

        return $row;
    }
}

?>