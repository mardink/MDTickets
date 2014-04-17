<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdticketsHelperComputers
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
    public static function inuse($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USE_TYPE_SELECT').' -');
        $options[] = JHTML::_('select.option','1',JText::_('COM_MDTICKETS_USE_TYPE_INUSE'));
        $options[] = JHTML::_('select.option','0',JText::_('COM_MDTICKETS_USE_TYPE_NOTINUSE'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
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

    // get te requesters from the database
    public static function user($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT user_id'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY user_id ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->user_id,$value->user_id);
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

}
