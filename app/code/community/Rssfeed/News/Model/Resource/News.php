<?php
/**
 * News item resource model
 *
 * @author Magento
 */
class Rssfeed_News_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize connection and define main table and primary key
     */
    protected function _construct()
    {
        $this->_init('rssfeed_news/news', 'id');
    }
}