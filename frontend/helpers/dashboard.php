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
		}
