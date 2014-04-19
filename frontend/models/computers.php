<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdticketsModelComputers extends FOFModel
{
    public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdtickets_computers'));


        $fltInuse	= $this->getState('inuse', null, 'cmd');
        if($fltInuse != '') {
            $query->where($db->qn('published').' = '.$db->q($fltInuse));
        }

        $fltNoBEUnpub	= $this->getState('nobeunpub', null, 'int');
        if($fltNoBEUnpub) {
            $query->where('NOT('.$db->qn('published').' = '.$db->q('0').')');
        }

        $fltLanguage	= $this->getState('language', null, 'cmd');
        $fltLanguage2	= $this->getState('language2', null, 'string');
        if($fltLanguage && ($fltLanguage != '*')) {
            $query->where($db->qn('language').' IN('.$db->q('*').','.$db->q($fltLanguage).')');
        } elseif($fltLanguage2) {
            $query->where($db->qn('language').' = '.$db->q($fltLanguage2));
        }

        $search = $this->getState('search',null);
        if($search)
        {
            $search = '%'.$search.'%';
            $query->where(
                '('.
                '('.$db->qn('computername').' LIKE '.$db->quote($search).')'.
                ')'
            );
        }

        $order = $this->getState('filter_order', 'ordering', 'cmd');
        if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'computername';
        jimport('joomla.application.component.helper');
        $Start_order = JComponentHelper::getParams('com_mdtickets')->get('start_order');
        //$Start_order = 'DESC';
        $dir = $this->getState('filter_order_Dir', $Start_order, 'cmd');
        $query->order($order.' '.$dir);

        return $query;
    }


}