<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
defined('_JEXEC') or die();

class MdticketsControllerItem extends FOFController {
   public function onBeforeApplySave(&$data) {
       $model = $this->getThisModel();
       $item = $model->getItem();
       $remark = $item->get('remark');
       $modified = $item->get('modified');
       $detail = $item->get('detail');
       $status = $item->get('status');
       $completion_date = $item->get('completion_date');
       if(!$modified){
           $modified_on = date("Y-m-d H:i:s");
           $data['modified_on'] = $modified_on;
       }
        if($status == 'Cancelled' || 'Closed') {
            if($completion_date == '0000-00-00') {
                $date = date("Y-m-d H:i:s");
                $data['completion_date'] = $date;
            }
        }

// uplaod files
       jimport('joomla.filesystem.file');
       jimport('joomla.filesystem.folder');
       $num = $item->get('mdtickets_item_id');
       $ticketNum = sprintf("%04d", $num);
       // get the file
       $input = JFactory::getApplication()->input;
       $files = $input->files->get('bijlage');
       $savepath = JPATH_COMPONENT . "/bijlage/" . $ticketNum;
       if(isset($files)){
           if (!JFolder::exists($savepath)) {
               JFolder::create($savepath);
           }
           $max = ini_get('upload_max_filesize');
           //$file_type = $params->get( 'type' );
           $file_type = "*";
           foreach ($files as $file){
               foreach ($file as $file1) {
               //if($files['size'] > $max) $msg = JText::_('ONLY_FILES_UNDER').' '.$max;
               //Set up the source and destination of the file
                   //Clean up filename to get rid of strange characters like spaces etc
                   $filename = JFile::makeSafe($file1['name']);
               $src = $file1['tmp_name'];
               $dest = $savepath . "/" . $filename;
                //First check if the file has the right extension, we need jpg only
                   if ($file1['type'] == $file_type || $file_type == '*') {
                       JFile::upload($src, $dest);
                   }
               }
           }
       }


           return $data;
   }

  public function onAfterApplySave(){
        $model = $this->getThisModel();
        $id = $model->getId();
        $item = $model->getItem();
        $jinput = JFactory::getApplication()->input;
        $remark = $jinput->get('remark', '', 'string');
        $detail = $item->get('detail');
        $user =& JFactory::getUser();
        $name = $user->name;
        $datum = date("Y-m-d H:i:s");
        // Collect all data and form a new string.
        $text = $datum .' : ' . $name . ' ' . $remark . '<hr>' . $detail;
        $remark_new = '';

        if ($remark != "") {
            // Get a db connection.
            $db = JFactory::getDbo();
            // Create a new query object.
            $query = $db->getQuery(true);
            $query
                ->update($db->qn('#__mdtickets_items'))
                ->set($db->qn('detail').' = '.$db->q($text))
                ->set($db->qn('remark').' = '.$db->q($remark_new))
                ->where($db->qn('mdtickets_item_id').' = '.$db->q($id));
            $db->setQuery($query);

            try {
                $result = $db->execute(); // Use $db->execute() for Joomla 3.0.
            } catch (Exception $e) {
                // Catch the error.
            }
        }
        return true;

    }

}