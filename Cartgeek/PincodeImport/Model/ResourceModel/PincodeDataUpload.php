<?php 
namespace Cartgeek\PincodeImport\Model\ResourceModel;
class PincodeDataUpload extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
 public function _construct(){
 $this->_init("pincode_data","entity_id");
 }
}
 ?>