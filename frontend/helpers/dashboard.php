<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 7-8-13
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */
defined('_JEXEC') or die();

class MdticketsHelperDashboard {
// test helper
	public static function test() {
	return 'Dit is een test en nog een';
	}
	// sql test helper
	public static function sql() {
	// Get a db connection.
            $db = JFactory::getDbo();
            // Create a new query object.
            $query = $db->getQuery(true);
            $query
                ->select('short')
				->from($db->quoteName('#__mdtickets_items'))
				->where($db->qn('mdtickets_item_id').' = '.$db->q('1'));
            $db->setQuery($query);
            $result = $db->loadResult();
			return $result;
        }
    /*
     * $number = number of items to show (mandatory)
     */
    public static function getLatestNew($number) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'))
            ->where(
                '('.
                '('.$db->qn('status').' != '.$db->quote('Closed').') OR'.
                '('.$db->qn('status').' != '.$db->quote('Cancelled').')'.
                ')'
            )
            ->order($db->qn('created_on').' desc');
        $db->setQuery($query,0,$number); //set the limit
        $result = $db->loadObjectList();
        return $result;
    }

    /*
     * $number = number of items to show (mandatory)
     */
    public static function getLatestChanged($number) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'))
            ->order($db->qn('modified_on').' desc');
        $db->setQuery($query,0,$number); //set the limit
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * $number = number of items to show (mandatory)
     */
    public static function getLatestFinished($number) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'))
            ->where(
                '('.
                '('.$db->qn('status').' = '.$db->quote('Closed').') OR'.
                '('.$db->qn('status').' = '.$db->quote('Cancelled').')'.
                ')'
            )
            ->order($db->qn('completion_date').' desc');
        $db->setQuery($query,0,$number); //set the limit
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * $number = number of items to show (mandatory)
     */
    public static function getDeadlines($number) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'))
            ->where(
                '('.
                '('.$db->qn('status').' != '.$db->quote('Closed').') AND'.
                '('.$db->qn('status').' != '.$db->quote('Cancelled').') AND'.
                '('.$db->qn('deadline').' != '.$db->quote('0000-00-00').')'.
                ')'
            )
            ->order($db->qn('deadline').' asc');
        $db->setQuery($query,0,$number); //set the limit
        $result = $db->loadObjectList();
        return $result;
    }
        //get number of open calls
    public static function getCallsOpen() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    //get number of high prio calls
    public static function getCallsPrioHigh() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Hoog' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
}
