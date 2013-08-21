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
    //get number of normal prio calls
    public static function getCallsPrioNormal() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Normaal' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    //get number of low prio calls
    public static function getCallsPrioLow() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Laag' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    //get number of tzt prio calls
    public static function getCallsPrioTzt() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'tzt' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    //get number of periodoiek prio calls
    public static function getCallsPrioPeriodiek() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Periodiek' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    //get number of user calls
    public static function getCallsUser($user) {
        if ($user!=''){
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where ( assigned = '$user' or assigned = 'MHI-HvT' ) and (status != 'Cancelled' or status != 'Closed') ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
        }
        else {
            return 'Log in';
        }
    }
    //get number of ITON calls
    public static function getCallsIton() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where assigned = 'ITON' and (status != 'Cancelled' or status != 'Closed') ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    // Count calls per categories
    public static function getCallsCategorie() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT category, COUNT(*) as count FROM #__mdtickets_items GROUP BY category";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    // Count new calls per month
    public static function getCallsCountNew() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(created_on) as month, COUNT(*) as count FROM #__mdtickets_items GROUP BY MONTH(created_on)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    // Count closed calls per month
    public static function getCallsCountClosed() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(completion_date) as month, COUNT(*) as count FROM #__mdtickets_items where completion_date !='0000-00-00' GROUP BY MONTH(completion_date)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    // Count ITON calls per month
    public static function getCallsCountIton() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(created_on) as month, COUNT(*) as count FROM #__mdtickets_items where assigned ='ITON' GROUP BY MONTH(created_on)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
}
