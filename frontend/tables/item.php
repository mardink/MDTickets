<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
defined('_JEXEC') or die();

class MdticketsTableItem extends FOFTable {
    /*Copy of the FOF Class so the actual time will be set
     *
     * The event which runs before storing (saving) data to the database
     *
     * @param   boolean  $updateNulls  Should nulls be saved as nulls (true) or just skipped over (false)?
     *
     * @return  boolean  True to allow saving
     */
    protected function onBeforeStore($updateNulls)
    {
        // Do we have a "Created" set of fields?
        $created_on  = $this->getColumnAlias('created_on');
        $created_by  = $this->getColumnAlias('created_by');
        $modified_on = $this->getColumnAlias('modified_on');
        $modified_by = $this->getColumnAlias('modified_by');
        $locked_on   = $this->getColumnAlias('locked_on');
        $locked_by   = $this->getColumnAlias('locked_by');
        $title       = $this->getColumnAlias('title');
        $slug        = $this->getColumnAlias('slug');

        $hasCreatedOn = in_array($created_on, $this->getKnownFields());
        $hasCreatedBy = in_array($created_by, $this->getKnownFields());

        if ($hasCreatedOn && $hasCreatedBy)
        {
            $hasModifiedOn = in_array($modified_on, $this->getKnownFields());
            $hasModifiedBy = in_array($modified_by, $this->getKnownFields());

            if (empty($this->$created_by) || ($this->$created_on == '0000-00-00 00:00:00') || empty($this->$created_on))
            {
                $uid = FOFPlatform::getInstance()->getUser()->id;

                if ($uid)
                {
                    $this->$created_by = FOFPlatform::getInstance()->getUser()->id;
                }
                JLoader::import('joomla.utilities.date');
                $date = new JDate();

                if (FOFPlatform::getInstance()->checkVersion(JVERSION, '3.0', 'ge'))
                {
                    $this->$created_on = date("Y-m-d H:i:s");
                }
                else
                {
                    $this->$created_on = date("Y-m-d H:i:s");
                }
            }
            elseif ($hasModifiedOn && $hasModifiedBy)
            {
                $uid = FOFPlatform::getInstance()->getUser()->id;

                if ($uid)
                {
                    $this->$modified_by = FOFPlatform::getInstance()->getUser()->id;
                }
                JLoader::import('joomla.utilities.date');
                $date = new JDate();

                if (FOFPlatform::getInstance()->checkVersion(JVERSION, '3.0', 'ge'))
                {
                    $this->$modified_on = $date->toSql();
                }
                else
                {
                    $this->$modified_on = $date->toMysql();
                }
            }
        }

        // Do we have a set of title and slug fields?
        $hasTitle = in_array($title, $this->getFields());
        $hasSlug  = in_array($slug, $this->getFields());

        if ($hasTitle && $hasSlug)
        {
            if (empty($this->$slug))
            {
                // Create a slug from the title
                $this->$slug = FOFStringUtils::toSlug($this->$title);
            }
            else
            {
                // Filter the slug for invalid characters
                $this->$slug = FOFStringUtils::toSlug($this->$slug);
            }

            // Make sure we don't have a duplicate slug on this table
            $db    = $this->getDbo();
            $query = $db->getQuery(true)
                ->select($db->qn($slug))
                ->from($this->_tbl)
                ->where($db->qn($slug) . ' = ' . $db->q($this->$slug))
                ->where('NOT ' . $db->qn($this->_tbl_key) . ' = ' . $db->q($this->{$this->_tbl_key}));
            $db->setQuery($query);
            $existingItems = $db->loadAssocList();

            $count   = 0;
            $newSlug = $this->$slug;

            while (!empty($existingItems))
            {
                $count++;
                $newSlug = $this->$slug . '-' . $count;
                $query   = $db->getQuery(true)
                    ->select($db->qn($slug))
                    ->from($this->_tbl)
                    ->where($db->qn($slug) . ' = ' . $db->q($newSlug))
                    ->where($db->qn($this->_tbl_key) . ' = ' . $db->q($this->{$this->_tbl_key}), 'AND NOT');
                $db->setQuery($query);
                $existingItems = $db->loadAssocList();
            }

            $this->$slug = $newSlug;
        }

        // Execute onBeforeStore<tablename> events in loaded plugins
        if ($this->_trigger_events)
        {
            $name       = FOFInflector::pluralize($this->getKeyName());
            $result     = FOFPlatform::getInstance()->runPlugins('onBeforeStore' . ucfirst($name), array(&$this, $updateNulls));

            if (in_array(false, $result, true))
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        return true;
    }

}