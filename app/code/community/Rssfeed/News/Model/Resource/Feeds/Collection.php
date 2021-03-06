<?php
/**
 * News collection
 *
 * @author Magento
 */
class Rssfeed_News_Model_Resource_Feeds_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define collection model
     */
    protected function _construct()
    {
        $this->_init('rssfeed_news/feeds');
    }

    /**
     * Prepare for displaying in list
     *
     * @param integer $page
     * @return Magentostudy_News_Model_Resource_News_Collection
     */
    public function prepareForList($page)
    {
        //$this->setPageSize(Mage::helper('rssfeed_news')->getNewsPerPage());
        //$this->setCurPage($page)->setOrder('pubdate', Varien_Data_Collection::SORT_ORDER_DESC);
        return $this;
    }
}