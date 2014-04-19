<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdticketsHelperUsers
{
    protected static function genericlist($list, $name, $attribs, $selected, $idTag)
    {
        if(empty($attribs))
        {
            $attribs = null;
        }
        else
        {
            $temp = '';
            foreach($attribs as $key=>$value)
            {
                $temp .= $key.' = "'.$value.'"';
            }
            $attribs = $temp;
        }

        return JHTML::_('select.genericlist', $list, $name, $attribs, 'value', 'text', $selected, $idTag);
    }

    // Set the published fields
    public static function published($selected = null, $id = 'enabled', $attribs = array())
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_ARS_COMMON_STATE_SELECT_LABEL').' -');
        $options[] = JHTML::_('select.option',0,JText::_('JUNPUBLISHED'));
        $options[] = JHTML::_('select.option',1,JText::_('JPUBLISHED'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    // Set the pagination fields
    public static function pagination($selected = null, $id = 'limit', $attribs = array())
    {
        $options = array();
        $options[] = JHTML::_('select.option','8888',JText::_('COM_MDTICKETS_NOPAGINATION'));
        $options[] = JHTML::_('select.option','20','20');
        $options[] = JHTML::_('select.option','50','50');
        $options[] = JHTML::_('select.option','100','100');


        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    // get the country from the database
    public static function country($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT country'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY country ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->country,$value->country);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    //get the lastlogin date from the mdtickets_lastlogins database
    //  $id Userid should be set as parameter
    public static function getLastlogin($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('previouslogin');
        $query->from('#__mdtickets_lastlogins');
        $query->where($db->qn('user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $previouslogin = $db->loadResult();

        return $previouslogin;
    }

    //get the mobilenr from the mdtickets_phones database
    //  $id phonenr should be set as parameter
    public static function phonenr($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('phone_number');
        $query->from('#__mdtickets_phones');
        $query->where($db->qn('user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $result = $db->loadResult();

        return $result;
    }
    //get the mobilenr from the mdtickets_phones database
    //  $id phonenr should be set as parameter
    public static function phone_id($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('mdtickets_phone_id');
        $query->from('#__mdtickets_phones');
        $query->where($db->qn('user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $result = $db->loadResult();

        return $result;
    }
    //get the computername from the mdtickets_computers database
    //  $id should be set as parameter
    public static function computername($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('computername');
        $query->from('#__mdtickets_computers');
        $query->where($db->qn('user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $result = $db->loadResult();

        return $result;
    }
    //get the computerid from the mdtickets_computers database
    //  $id  should be set as parameter
    public static function computer_id($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('mdtickets_computer_id');
        $query->from('#__mdtickets_computers');
        $query->where($db->qn('user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $result = $db->loadResult();

        return $result;
    }
}
