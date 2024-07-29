<?php

use Joomla\CMS\Factory;

class Core_Model_Core{
    /**
     * doOptimize thực hiện tới ưu hóa dữ liệu trong Mysql
     */
    public function doOptimize(){
        $sql = 'SHOW TABLES';
        $db = Factory::getDbo();
        $db->setQuery($sql);
        $tables = $db->loadAssocList();
        for ($i = 0,$n=count($tables); $i < $n; $i++) {
           
            foreach ($tables[$i] as $key => $tablename)
           	 {
           	    // var_dump($tablename);
            	// mysql_query("OPTIMIZE TABLE '".$tablename."'") or die(mysql_error());
            	$sql = "OPTIMIZE TABLE `".$tablename."`";
            	$db->setQuery($sql);
            	$db->query();
           	 }
        }
    }
}