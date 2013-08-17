<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 17-8-13
 * Time: 21:09
 * To change this template use File | Settings | File Templates.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgUserMdticketslastlogin extends JPlugin
{
    /**
     * Constructor - note in Joomla 2.5 PHP4.x is no longer supported so we can use this.
     *
     * @access      protected
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
{
    parent::__construct($subject, $config);
    $this->loadLanguage();
}
    /**
     * Plugin method with the same name as the event will be called automatically.
     */
    function onUserLogin()
 {
     $app = JFactory::getApplication();
     $jinput = JFactory::getApplication()->input;

     $username = $jinput->get('username', '', 'string');
     $user = JFactory::getUser( 'beheerder' );

     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     // Select id from usertable.
        $query->select('*');
        $query->from('#__users');
        $query->where($db->qn('username').' = '.$db->q($username));

// Reset the query using our newly populated query object.
        $db->setQuery($query);

// Load the userid and lastvisit date
        $results = $db->loadRow();
        $user_id = $results['0'];
        $lastvisitDate =  $results['8'];
// check if the username exists in the mdtickets_lastlogin database and get the lastlogin date
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('lastlogin');
        $query->from('#__mdtickets_lastlogins');
        $query->where($db->qn('user_id').' = '.$db->q($user_id));
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        $currentlastlogin = $db->loadResult();
        // if the lastlogin is know the lastlogin must be copied to previouslogin
        // and lastlogin will be the lastvisitdate
        if ($currentlastlogin) {
            // get the current lastlogin
            $db = JFactory::getDbo();
            $query3 = $db->getQuery(true);
            //Build the query
            $query3->update("#__mdtickets_lastlogins");
            $query3->set('previouslogin = '.$db->quote($currentlastlogin));
            $query3->set('lastlogin = '.$db->quote($lastvisitDate));
            $query3->where('user_id = '. $db->quote($user_id));
            $db->setQuery($query3);
            $updated = $db->execute(); // update the table
        } else {
            // if users is not in teh table create the user
            $currentdate = date("Y-m-d H:i:s");
            $db = JFactory::getDbo();
            $query4 = $db->getQuery(true);
            //Build the query
            // Insert columns.
            $columns = array('user_id', 'previouslogin', 'lastlogin');
            // Insert values.
            $values = array($db->quote($user_id), $db->quote($currentdate), $db->quote($currentdate));
            // Prepare the insert query.
            $query4
                ->insert($db->quoteName('#__mdtickets_lastlogins'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
            // Reset the query using our newly populated query object.
            $db->setQuery($query4);
            $created = $db->execute(); // inserted the table
        }

        return true;
 }
}
?>