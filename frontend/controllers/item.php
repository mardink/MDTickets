<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 10-8-13
 * Time: 19:47
 * To change this template use File | Settings | File Templates.
 */
defined('_JEXEC') or die();

class MdticketsControllerItem extends FOFController {
   public function onBeforeApplySave(&$data) {
       $model = $this->getThisModel();
       $item = $model->getItem();
       $created_on = $item->get('created_on');
       $modified_on = $item->get('modified_on');
       if($modified_on == '0000-00-00 00:00:00'){
           $data['modified_on'] = $created_on;
       }
       $data['remark'] = $modified_on;
       return $data;
   }

  /*  public function onAfterApplySave(){
        $model = $this->getThisModel();
        $id = $model->getId();
        $item = $model->getItem();
        $created_on = $item->get('created_on');
        $modified_on = $item->get('modified_on');
        $remark = $item->get('remark');

        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->update($db->qn('#__mdtickets_items'))
            ->set($db->qn('remark').' = '.$db->q(""))
            ->where($db->qn('mdtickets_item_id').' = '.$db->q($id));
        $db->setQuery($query);

        try {
            $result = $db->execute(); // Use $db->execute() for Joomla 3.0.
        } catch (Exception $e) {
            // Catch the error.
        }
        return parent::onAfterApplySave();

    }*/
}