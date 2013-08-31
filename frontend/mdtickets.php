<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

require_once JPATH_LIBRARIES.'/fof/include.php';

FOFDispatcher::getTmpInstance('com_mdtickets')->dispatch();