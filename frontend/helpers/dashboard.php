<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdticketsHelperDashboard {

    /*
     * This helper gets the latest new tickets from the database where items are not closed or cancelled
     * Ordered by created date latest first
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
     * This helper gets the latest modified tickets from the database
     * ordered by modified date  latest first
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
            ->where('('.$db->qn('modified_by').' != '.$db->quote('0').')')
            ->order($db->qn('modified_on').' desc');
        $db->setQuery($query,0,$number); //set the limit
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * This helper gets the latest finished tickets from the database where items are closed or cancelled
     * ordered by the completion date latest first
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
 * This helper gets the periodic calls  from the tickets from the database where items are not closed or cancelled or empty
 * Ordered by deadline earliest deadline first
 * $number = number of items to show (mandatory)
 */
    public static function getPeriodiek($number) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from($db->quoteName('#__mdtickets_items'))
            ->where(
                '('.
                '('.$db->qn('prio').' = '.$db->quote('Periodiek').') AND'.
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
    /*
     * This helper gets the deadlines from the tickets from the database where items are not closed or cancelled or empty
     * Ordered by deadline earliest deadline first
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
        /*
         * This helper gets the number of open calls from the database
         */
    public static function getCallsOpen() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where status != 'Cancelled' and status != 'Closed' and prio !='Periodiek'";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }

    /*
     * This helper gets the number of high priority calls from the database
     */
    public static function getCallsPrioHigh() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Hoog' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }

    /*
     * This helper gets the number of normal priority calls from the database
     */
    public static function getCallsPrioNormal() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Normaal' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    /*
     * This helper gets the number of low priority calls from the database
     */
    public static function getCallsPrioLow() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Laag' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    /*
     * This helper gets the number of tzt calls from the database
     */
    public static function getCallsPrioTzt() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'tzt' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    /*
     * This helper gets the number of periodiek calls from the database
     */
    public static function getCallsPrioPeriodiek() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where prio = 'Periodiek' and status != 'Cancelled' and status != 'Closed' ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    /*
     * This helper gets the number calls from the current user from the database
     * User must be logged in
     */
    public static function getCallsUser($user) {
        if ($user!=''){
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where ( assigned = '$user' or assigned = 'MHI-HvT' ) and (status != 'Cancelled' and status != 'Closed') ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
        }
        else {
            return 'Log in';
        }
    }
    /*
     * This helper gets the number of ITON calls from the database
     */
    public static function getCallsIton() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT * from #__mdtickets_items where assigned = 'ITON' and (status != 'Cancelled' and status != 'Closed') ";
        $db->setQuery($query);
        $db->query();
        $numrow = $db->getNumRows();
        return $numrow;
    }
    /*
     * This helper gets the number of calls per category from the database
     * The result is used for the pie graph
     */
    public static function getCallsCategorie() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT category, COUNT(*) as count FROM #__mdtickets_items GROUP BY category";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * This helper gets the number new calls per month from the database
     * The result is used for the bar graph
     */
    public static function getCallsCountNew($months) {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(created_on) as month, COUNT(*) as count FROM #__mdtickets_items where created_on > DATE_SUB(now(), INTERVAL $months MONTH) GROUP BY  YEAR(created_on), MONTH(created_on)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * This helper gets the number closed calls per month from the database
     * The result is used for the bar graph
     */
    public static function getCallsCountClosed($months) {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(completion_date) as month, COUNT(*) as count FROM #__mdtickets_items where completion_date > DATE_SUB(now(), INTERVAL $months MONTH) and completion_date !='0000-00-00' GROUP BY  YEAR(completion_date), MONTH(completion_date)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * This helper gets the number of iton calls per month from the database
     * The result is used for the bar graph
     */
    public static function getCallsCountIton($months) {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT MONTHNAME(created_on) as month, COUNT(*) as count FROM #__mdtickets_items where assigned ='ITON' AND created_on > DATE_SUB(now(), INTERVAL $months MONTH) GROUP BY YEAR(created_on), MONTH(created_on)";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }
    /*
     * This helper gets periodical calls from the database
     */
    public static function PeriodicOverview() {
       // Get a db connection.
            $db = JFactory::getDbo();
        $query = "SELECT *, DATE_SUB(deadline, INTERVAL periodtime DAY) as warningdate FROM #__mdtickets_items where prio ='Periodiek' AND status != 'Cancelled' AND status != 'Closed' AND DATE_ADD(now(), INTERVAL periodtime DAY) > deadline ORDER BY warningdate ASC";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
            return $result;
        }
}
