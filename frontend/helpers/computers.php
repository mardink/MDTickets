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

    // get te users from the database
    public static function user($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        //$query = 'SELECT a.user_id, b.mdtickets_user_id, b.shortname' //Shortname van users tabel moet er nog in
        //    . ' FROM #__mdtickets_computers as a'
        //    . ' '
        //   . ' ORDER BY user_id ASC';
        // Create a new query object.
        $query = $db->getQuery(true);
        // Select all users from the computerdataba.

        $query
            ->select($db->quoteName(array('a.user_id', 'b.mdtickets_user_id', 'b.shortname')))
            ->from($db->quoteName('#__mdtickets_computers', 'a'))
            ->join('INNER', $db->quoteName('#__mdtickets_users', 'b') . ' ON (' . $db->quoteName('a.user_id') . ' = ' . $db->quoteName('b.mdtickets_user_id') . ')')
            ->order($db->quoteName('b.shortname') . ' ASC');
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->user_id,$value->shortname);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    // get the type of computers from the database
    public static function type($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT type'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY type ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->type,$value->type);
        endforeach;

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

    // get the windows versions from the database
    public static function windows($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT windows'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY windows ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->windows,$value->windows);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    // get the office versions from the database
    public static function office($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT office'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY office ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->office,$value->office);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    // get the Virus software from the database
    public static function virus($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT software1'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY software1 ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->software1,$value->software1);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

    // get the Virus software from the database
    public static function pdf($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT software2'
            . ' FROM #__mdtickets_computers'
            . ' ORDER BY software2 ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_USER_TYPE_SELECT').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->software2,$value->software2);
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

    //get the shortnamee from the mdtickets_users database
    //  $id Userid should be set as parameter
    public static function username_short($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('shortname');
        $query->from('#__mdtickets_users');
        $query->where($db->qn('mdtickets_user_id').' = '.$db->q($id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $username_short = $db->loadResult();

        return $username_short;
    }
}
