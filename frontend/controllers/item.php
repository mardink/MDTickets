<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
defined('_JEXEC') or die();

class MdticketsControllerItem extends FOFController {
   /*
    * Before saving the ticket the following will be done
    * When creating a new ticket the modified date will be set with the current date
    * When a ticket is closed or cancelled and no completion date is set the current date will be set
    * When a file is given teh file will be cleaned from strange letters and upload to a subfolder bijlage
    *
    */

    public function onBeforeApplySave(&$data) {
       $model = $this->getThisModel();
       $item = $model->getItem();
       $jinput = JFactory::getApplication()->input;
       $modified = $item->get('modified');
       $status = $jinput->get('status', '', 'string');
       $completion_date = $jinput->get('completion_date', '', 'date');
       if(!$modified){
           $modified_on = date("Y-m-d H:i:s");
           $data['modified_on'] = $modified_on;
       }
        if($status == 'Cancelled' || $status == 'Closed') {
            if($completion_date == '') {
                $date = date("Y-m-d H:i:s");
                $data['completion_date'] = $date;
            }
        }

// upload files to the subfolder
       jimport('joomla.filesystem.file');
       jimport('joomla.filesystem.folder');
       $num = $item->get('mdtickets_item_id');
       $ticketNum = sprintf("%04d", $num);
        //Get options
        jimport('joomla.application.component.helper');
        $location = JComponentHelper::getParams('com_mdtickets')->get('location');
       // get the file
       $input = JFactory::getApplication()->input;
       $files = $input->files->get('bijlage');
       $savepathbase = JPATH_BASE . $location;
        //create folder if not exists
        if (!JFolder::exists($savepathbase)) {
            JFolder::create($savepathbase);
        }
       $savepath =  $savepathbase . "/" . $ticketNum; // should be changed to a parameter from teh component
       // check if folder excist if not create folder. Foldername is ticket number in 4 digits


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
                //First check if the file has the right extension, current all files are allowed
                   if ($file1['type'] == $file_type || $file_type == '*') {
                       if ($file1['name'] !=""){
                           if (!JFolder::exists($savepath)) {
                               JFolder::create($savepath);
                           }
                       JFile::upload($src, $dest);
                       }
                   }
               }
           }



           return $data;
   }

    /*
     * When the ticket is saved and before returning to the view the following will be executed
     * The remark text will be added in the detail desciption
     * First the date and the user will be added followed by the remark(update text) followed by a hr line
     * The new detail description will be set in the database
     */
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