<?php

namespace Cartgeek\PincodeImport\Model\ResourceModel\PincodeDataUpload;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    protected $_idFieldName = 'id';
	protected $_eventPrefix = 'cartgeek_pincode_data_collection';
	protected $_eventObject = 'data_collection';

protected function _construct() {

$this->_init('Cartgeek\PincodeImport\Model\PincodeDataUpload', 'Cartgeek\PincodeImport\Model\ResourceModel\PincodeDataUpload');

}

}