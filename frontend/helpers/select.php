<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 7-8-13
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */
defined('_JEXEC') or die();

class MdticketsHelperSelect
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
    // Get the prio fields
    public static function prio($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_PRIO_TYPE_SELECT').' -');
        $options[] = JHTML::_('select.option','normaal',JText::_('COM_MDTICKETS_PRIO_TYPE_NORMAL'));
        $options[] = JHTML::_('select.option','hoog',JText::_('COM_MDTICKETS_PRIO_TYPE_HIGH'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    // Get the category fields
    public static function category($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_CATEGORY_TYPE_SELECT').' -');
        $options[] = JHTML::_('select.option','Budget Generator',JText::_('COM_MDTICKETS_CATEGORY_TYPE_BUDGET'));
        $options[] = JHTML::_('select.option','Telefonie',JText::_('COM_MDTICKETS_CATEGORY_TYPE_PHONE'));
        $options[] = JHTML::_('select.option','Netwerk',JText::_('COM_MDTICKETS_CATEGORY_TYPE_NETWORK'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    // Get the status fields
    public static function status($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_STATUS_TYPE_SELECT').' -');
        $options[] = JHTML::_('select.option','Not Started',JText::_('COM_MDTICKETS_STATUS_TYPE_NOTSTARTED'));
        $options[] = JHTML::_('select.option','Started',JText::_('COM_MDTICKETS_STATUS_TYPE_STARTED'));
        $options[] = JHTML::_('select.option','Pauzed',JText::_('COM_MDTICKETS_STATUS_TYPE_PAUZED'));
        $options[] = JHTML::_('select.option','Waiting for ITON',JText::_('COM_MDTICKETS_STATUS_TYPE_ITON'));
        $options[] = JHTML::_('select.option','Waiting for supplier',JText::_('COM_MDTICKETS_STATUS_TYPE_SUPPLIER'));
        $options[] = JHTML::_('select.option','Waiting for other',JText::_('COM_MDTICKETS_STATUS_TYPE_OTHER'));
        $options[] = JHTML::_('select.option','Closed',JText::_('COM_MDTICKETS_STATUS_TYPE_CLOSED'));
        $options[] = JHTML::_('select.option','Cancelled',JText::_('COM_MDTICKETS_STATUS_TYPE_CANCELLED'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    // Get the assigned fields
    public static function assigned($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDTICKETS_ASSIGNED_TYPE_SELECT').' -');
        $options[] = JHTML::_('select.option','MHI', 'MHI' );
        $options[] = JHTML::_('select.option','HvT', 'HvT');
        $options[] = JHTML::_('select.option','MHI-HvT', 'MHI-HvT');
        $options[] = JHTML::_('select.option','ITON', 'ITON');

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
}
