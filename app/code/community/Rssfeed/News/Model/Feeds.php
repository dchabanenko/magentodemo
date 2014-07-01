<?php
/**
 * News item model
 *
 * @author Magento
 */
class Rssfeed_News_Model_Feeds extends Mage_Core_Model_Abstract
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('rssfeed_news/feeds');
    }

    /**
     * If object is new adds creation date
     *
     * @return Rssfeed_News_Model_News
     */
//    protected function _beforeSave()
//    {
//        parent::_beforeSave();
//        if ($this->isObjectNew()) {
//            $this->setData('hash', hash('md5', $this->getData('title').$this->getData('description'));
//        }
//        return $this;
//    }
}