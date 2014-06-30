<?php


class Rssfeed_News_Model_Parser {

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('rssfeed_news/parser');
    }


    public function parseNewRecords()
    {
        $feedsCollection = Mage::getResourceModel('rssfeed_feeds/feeds_collection');
        $newsModel = Mage::getModel('rssfeed_news/news');
        //$r = $this->feedsDbClient->getAllFeedsArray();
        foreach ($feedsCollection as $row) {
            $url = $row['url'];
            $source = $row['id'];
            //echo "<br>$url";
            //$xmldata =  file_get_contents($url);
            $structdata = simplexml_load_file($url);
            $newsArray = $structdata->channel->item;
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
                $sameRecord = $newsModel->getCollection()->AddFieldToFilter('hash', $hash)->getFirstItem()->getData();
                //var_dump($sameRecord);
                if (!$sameRecord) {
                    $newsModel->setData($item)->setOrigData()->save();
                }
            }
        }
    }
}

