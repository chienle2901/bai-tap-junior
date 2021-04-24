<?php

namespace Magenest\SpecialChapter1\Model\ResourceModel;

/**
 * Class Delivery
 * @package Magenest\SpecialChapter1\Model\ResourceModel
 */
class Delivery extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('magenest_delivery', 'id');
    }

    /**
     * Insert data to table
     * @param $id
     * @param $data
     */
    public function insertStores($id, $data)
    {
        $tableName = $this->getTable('magenest_delivery_store');
        $this->deleteData($tableName, $id);
        $dataImport = $this->prepareData($id, $data);
        $this->getConnection()->insertOnDuplicate($tableName, $dataImport);
    }

    /**
     * Insert data to table
     * @param $id
     * @param $data
     */
    public function insertCustomerGroup($id, $data)
    {
        $tableName = $this->getTable('magenest_delivery_customer_group');
        $this->deleteData($tableName, $id);
        $dataImport = $this->prepareData($id, $data);
        $this->getConnection()->insertOnDuplicate($tableName, $dataImport);
    }

    /**
     * Prepare data to insert
     * @param $id
     * @param $data
     * @return array
     */
    protected function prepareData($id, $data)
    {
        $result = [];
        foreach ($data as $value) {
            $result[] = ['delivery_id' => $id, 'value' => $value];
        }
        return $result;
    }

    /**
     * Get store id by delivery id
     * @param $id
     * @return array
     */
    public function getStoreByDeliveryId($id)
    {
        $connection = $this->getConnection();
        $sql = $connection->select()->from([$this->getTable('magenest_delivery_store')], 'value')
            ->where('delivery_id = ?', $id);
        return $connection->fetchCol($sql);
    }

    /**
     * Get customer group id by delivery id
     * @param $id
     * @return array
     */
    public function getCustomerGroupByDeliveryId($id)
    {
        $connection = $this->getConnection();
        $sql = $connection->select()->from([$this->getTable('magenest_delivery_customer_group')], 'value')
            ->where('delivery_id = ?', $id);
        return $connection->fetchCol($sql);
    }

    /**
     * Delete data
     * @param $tableName
     * @param $deliveryId
     */
    public function deleteData($tableName, $deliveryId)
    {
        $connection = $this->getConnection();
        $connection->delete($tableName, ['delivery_id = ?' => $deliveryId]);
    }

    public function getDeliveryTime($storeId, $cusGroupId)
    {
        $connection = $this->getConnection();
        $sql = $connection->select()->from(['main_table' => $this->getTable('magenest_delivery')], 'delivery_time')
            ->joinLeft(
                ['store' => $this->getTable('magenest_delivery_store')],
                "store.delivery_id = main_table.id",
                []
            )->joinLeft(
                ['customer_group' => $this->getTable('magenest_delivery_customer_group')],
                "customer_group.delivery_id = main_table.id",
                []
            )->where("store.value = ?", $storeId)
            ->where("customer_group.value = ?", $cusGroupId);
        return $connection->fetchCol($sql);
    }
}
