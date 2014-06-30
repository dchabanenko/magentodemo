<?php
/**
 * News Item block
 *
 * @author Magento
 */
class RssFeed_News_Block_Item extends Mage_Core_Block_Template
{
    /**
     * Current news item instance
     *
     * @var Magentostudy_News_Model_News
     */
    protected $_item;

    /**
     * Return parameters for back url
     *
     * @param array $additionalParams
     * @return array
     */
    protected function _getBackUrlQueryParams($additionalParams = array())
    {
        return array_merge(array('p' => $this->getPage()), $additionalParams);
    }

    /**
     * Return URL to the news list page
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/', array('_query' => $this->_getBackUrlQueryParams()));
    }
}
