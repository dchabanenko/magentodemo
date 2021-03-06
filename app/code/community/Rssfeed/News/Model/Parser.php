<?php


class Rssfeed_News_Model_Parser {

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('rssfeed_news/parser');
    }

    protected function getFeedsFromRss($url, $source)
    {
        $structdata = simplexml_load_file($url);
        $newsArray = $structdata->channel->item;
        $itemArray = array();
        $itemHashesArray = array();
        for ($j = 0; $j< count($newsArray); $j++) {
            $title = $newsArray[$j]->title->__toString();
            $description = $newsArray[$j]->description->__toString();
            $pubDate = $newsArray[$j]->pubDate->__toString();
            $pubDateTimestamp = strtotime($pubDate);
            $pubDateForDB = date('Y-m-d H:i:s',$pubDateTimestamp);
            $hash = hash ('md5', $title.$description, false);
            $item = array(
                'title' => $title,
                'description' => $description,
                'pubdate' => $pubDateForDB,
                'hash' => $hash,
                'source_id' => $source,
            );
            array_push($itemArray, $item);
            array_push($itemHashesArray, $hash);
        }
        return array($itemArray, $itemHashesArray);
    }


    public function parseNewRecords()
    {
        $feedsCollection = Mage::getResourceModel('rssfeed_news/feeds_collection');
        $newsModel = Mage::getModel('rssfeed_news/news');
        $newsCollection = $newsModel->getCollection();
        $newsArray = array();

        foreach ($feedsCollection as $row) {
            $url = $row['url'];
            $source = $row['id'];
            list($itemArray, $itemHashesArray) = $this->getFeedsFromRss($url, $source);

            $itemsExists = $newsModel->getCollection()->AddFieldToFilter('source_id', $source)
                ->addFieldToSelect('hash')
                ->AddFieldToFilter('hash', array('in' =>$itemHashesArray))
                ->getSelect()->query()->fetchAll(PDO::FETCH_COLUMN, 0);

            $newRecords = array_diff($itemHashesArray, $itemsExists);
            foreach ($newRecords as $id=>$hash) {
                array_push($newsArray, $itemArray[$id]);
            }
        }
        if (count($newsArray)>0) {
            $dbAdapter = Mage::getSingleton('core/resource')->getConnection('core_write');
            $columns =  array('title', 'description', 'pubdate', 'hash', 'source_id');
            $dbAdapter->insertArray('rssfeed_news', $columns, $newsArray);
        }
    }
}

