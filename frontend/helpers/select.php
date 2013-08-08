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
public static function items($selected = null, $id = 'category', $attribs = array())
{
    $items = FOFModel::getTmpInstance('Items','MdticketsModel')
        ->nobeunpub(1)
        ->getItemList(true);

    $options = array();
    $options[] = JHTML::_('select.option',0,'- '.JText::_('COM_ARS_COMMON_CATEGORY_SELECT_LABEL').' -');
    if(count($items)) foreach($items as $item)
    {
        $options[] = JHTML::_('select.option',$item->mdtickets_item_id,$item->category);
    }
    return self::genericlist($options, $id, $attribs, $selected, $id);
}
}