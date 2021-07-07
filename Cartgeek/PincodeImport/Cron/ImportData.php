<?php

namespace Cartgeek\PincodeImport\Cron;

class ImportData
{

/**
 * @var \Magento\Framework\HTTP\Client\Curl
 */
protected $_curl;

/**
 * @param Context                             $context
 * @param \Magento\Framework\HTTP\Client\Curl $curl
 */
public function __construct(
    \Magento\Framework\HTTP\Client\Curl $curl,
    \Cartgeek\PincodeImport\Model\PincodeDataUploadFactory $pincodeDataUploadFactory,
    \Magento\Framework\App\ResourceConnection $resource
) {
    $this->_curl = $curl;
    $this->pincodeDataUploadFactory= $pincodeDataUploadFactory;
    $this->resource = $resource;
}
	public function execute()
	{
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
		$logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $url= "https://api.data.gov.in/resource/04cbe4b1-2f2b-4c39-a1d5-1c2e28bc0e32?api-key=579b464db66ec23bdd0000012e2a594f5d03433b567cd52d79a5bf40&format=json";
        $this->_curl->get($url);
        $params=[];
        $this->_curl->get($url, $params);
        $response = $this->_curl->getBody();
        $responseArray=  json_decode($response, true);
        $connection  = $this->resource->getConnection();
        $tableName = $connection->getTableName("pincode_data");
        foreach($responseArray['records'] as $records){
                $pincode= $records['pincode'];
                $state= $records["statename"];
                $districtname= $records["districtname"];
                $divisionname= $records["divisionname"];
                $data = [
                    "pincode" => $pincode,
                    "state" => $state,
                    "districtname" => $districtname,
                    "divisionname" => $divisionname
                ];
                $query = "SELECT * FROM `" . $tableName . "` WHERE pincode = $pincode ";
                $result1 = $connection->fetchAll($query);
                if(!empty($result1)){
                    $where = ['pincode = ?' => (int)$pincode];
                    $connection->update($tableName, $data, $where);
                }
                else{
                    $model = $this->pincodeDataUploadFactory->create();
                    $model->addData($data);
                    $saveData = $model->save();
                }
        }
		return $this;

	}
}