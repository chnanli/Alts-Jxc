<?php

namespace Jxc\Impl\Dao;

use Exception;
use Jxc\Impl\Core\MySQLDao;
use Jxc\Impl\Vo\VoProduct;

/**
 * 产品库存表
 * Class ProductDao
 * @package Jxc\Impl\Dao
 */
class ProductDao extends MySQLDao {

    public function __construct($config) {
        parent::__construct($config);
    }

    public function selectById($ids) {
        $inId = implode(",", $ids);
        $query = "SELECT * FROM tb_product WHERE pdt_id IN ({$inId});";
        $datas = $this->mysqlDB()->ExecuteSQL($query);
        $map = array();
        foreach ($datas as $data) {
            $voProduct = new VoProduct();
            $voProduct->convert($data);
            $map[$voProduct->pdt_id] = $voProduct;
        }
        return $map;
    }

    public function selectPdtIdList() {
        $query = "SELECT pdt_id FROM tb_product;";
        $resultSet = $this->mysqlDB()->ExecuteSQL($query);
        return $resultSet;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function selectAll() {
        $query = $this->mysqlDB()->sqlSelectWhere('tb_product', '*');
        $datas = $this->mysqlDB()->ExecuteSQL($query);
        $array = array();
        foreach($datas as $data) {
            $voProduct = new VoProduct();
            $voProduct->convert($data);
            $array[] = $voProduct;
        }
        return $array;
    }

    /**
     * @param $voProduct VoProduct
     * @return VoProduct
     * @throws Exception
     */
    public function insert($voProduct) {
        $query = $this->mysqlDB()->sqlInsert('tb_product', $voProduct->toArray());
        $this->mysqlDB()->ExecuteSQL($query);
//        $voProduct->pdt_id = $this->mysqlDB()->getInsertId();
        return $voProduct;
    }

    /**
     * @param $voProduct VoProduct
     * @param array $fields
     */
    public function updateByFields($voProduct, $fields = array()) {
        $query = $this->mysqlDB()->sqlUpdateWhere('tb_product', $voProduct->toArray($fields), array('id' => $voProduct->id));
        $this->mysqlDB()->ExecuteSQL($query);
    }

    /**
     * @param $id  int  数据库唯一ID
     * @throws Exception
     */
    public function delete($id) {
        $query = $this->mysqlDB()->sqlDeleteWhere('tb_product', array('id' => $id));
        $this->mysqlDB()->ExecuteSQL($query);
    }


    //

}