<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdticketsModelItems extends FOFModel
{
    public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'));

        $fltCategory		= $this->getState('category', null, 'string');
        if($fltCategory) {
            $fltCategory = "$fltCategory";
            $query->where($db->qn('category').' LIKE '.$db->q($fltCategory));
        }

        $fltPrio		= $this->getState('prio', null, 'string');
        if($fltPrio) {
            $query->where($db->qn('prio').' = '.$db->q($fltPrio));
        }

        $fltShort	= $this->getState('short', null, 'string');
        if($fltShort) {
            $fltShort = "%$fltShort%";
            $query->where('('.
            '('.$db->qn('short').' LIKE '.$db->quote($fltShort).') OR'.
            '('.$db->qn('detail').' LIKE '.$db->quote($fltShort).')'.
            ')'
            );
        }

        $fltDetail	= $this->getState('detail', null, 'string');
        if($fltDetail) {
            $fltDetail = "%$fltDetail%";
            $query->where($db->qn('detail').' LIKE '.$db->q($fltDetail));
        }

        $fltItoncall	= $this->getState('itoncall', null, 'string');
        if($fltItoncall) {
            $fltItoncall = "%$fltItoncall%";
            $query->where($db->qn('itoncall').' LIKE '.$db->q($fltItoncall));
        }

        $fltMdticket	= $this->getState('mdtickets_item_id', null, 'string');
        if($fltMdticket) {
            $fltMdticket = "%$fltMdticket";
            $query->where($db->qn('mdtickets_item_id').' LIKE '.$db->q($fltMdticket));
        }

        $fltStatus		= $this->getState('status', null, 'string');
        if($fltStatus) {
            $query->where($db->qn('status').' LIKE '.$db->q($fltStatus));
        }

        $fltAssigned		= $this->getState('assigned', null, 'string');
        if($fltAssigned) {
            $query->where($db->qn('assigned').' LIKE '.$db->q($fltAssigned));
        }

        $fltPeriodOverview		= $this->getState('checkbox_dateoverview', null, 'string');
        $fltPeriodCategorie     = $this->getState('dateOverview', null, 'string');
        $fltPeriodFrom          = $this->getState('fromdate', null, 'date');
        $fltPeriodTo            = $this->getState('todate', null, 'string');
        if($fltPeriodCategorie !='' && $fltPeriodFrom !='0000-00-00'&&  $fltPeriodTo !='0000-00-00') {
            $query->where($db->qn($fltPeriodCategorie).' BETWEEN '.$db->q($fltPeriodFrom).' AND '.$db->q($fltPeriodTo));
        }

        $fltFinished		= $this->getState('finished', null, 'string');
        if($fltFinished == '0' && $fltPeriodCategorie !='completion_date') {
            jimport('joomla.application.component.helper');
            $Finisheddays = JComponentHelper::getParams('com_mdtickets')->get('completeddays');
        $show_date = date("Y-m-d", strtotime("- $Finisheddays day"));
            $query->where(
                '('.
                '('.$db->qn('completion_date').' >= '.$db->q($show_date).') OR'.
                '('.$db->qn('status').' != '.$db->quote('Closed').') AND'.
                '('.$db->qn('status').' != '.$db->quote('Cancelled').')'.
                ')'
            );
        }
        $fltAccess		= $this->getState('access', null, 'cmd');
        if($fltAccess) {
            $query->where($db->qn('access').' = '.$db->q($fltAccess));
        }

        $fltPublished	= $this->getState('published', null, 'cmd');
        if($fltPublished != '') {
            $query->where($db->qn('published').' = '.$db->q($fltPublished));
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
                '('.$db->qn('short').' LIKE '.$db->quote($search).') OR'.
                '('.$db->qn('detail').' LIKE '.$db->quote($search).') OR'.
                '('.$db->qn('itoncall').' LIKE '.$db->quote($search).') OR'.
                '('.$db->qn('mdtickets_item_id').' LIKE '.$db->quote($search).')'.
                ')'
            );
        }

        $order = $this->getState('filter_order', 'ordering', 'cmd');
        if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'mdtickets_item_id';
        $dir = $this->getState('filter_order_Dir', 'ASC', 'cmd');
        $query->order($order.' '.$dir);

        return $query;
    }

    /*public function getPagination()
    {
        if (empty($this->pagination))
        {
            // Import the pagination library
            JLoader::import('joomla.html.pagination');

            // Prepare pagination values
            $total = $this->getTotal();
            //$limitstart = $this->getState('limitstart');
            //$limit = $this->getState('limit');
            $limit = '1111';
            $limitstart = '0';

            // Create the pagination object
            $this->pagination = new JPagination($total, $limitstart, $limit);
        }

        return $this->pagination;
    }*/
}