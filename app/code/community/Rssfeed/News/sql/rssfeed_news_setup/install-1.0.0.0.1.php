<?php
/**
 * News installation script
 *
 * @author Magento
 */

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;

/**
 * Creating table rssfeed_news
 */

// $db->query('create table feeds(id int not null auto_increment primary key,
//                  url varchar (200));');

$table = $installer->getConnection()
    ->newTable($installer->getTable('rssfeed_news/news'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
    ), 'Title')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
        'default'  => null,
    ), 'Description')
    ->addColumn('pubdate', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'Creation Time')
    ->addColumn('source_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => true,
    ), 'source id')
    ->addColumn('hash', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
    ), 'Hash')
    ->addIndex($installer->getIdxName(
            $installer->getTable('rssfeed_news/news'),
            array('pubdate'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
        array('pubdate'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )
    ->addIndex($installer->getIdxName(
            $installer->getTable('rssfeed_news/news'),
            array('hash'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
        ),
        array('hash'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )
    ->setComment('News item');

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('rssfeed_news/feeds'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Id')
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => true,
    ), 'Title')
    ->setComment('RssFeed item');
$installer->getConnection()->createTable($table);
