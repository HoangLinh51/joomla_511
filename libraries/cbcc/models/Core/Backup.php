<?php
/**
* @file: Backbup.php
* @author: huuthanh3108@gmaill.com
* @date: 06-04-2015
* @company : http://dnict.vn
* 
**/
class Core_Model_Backup{
    public function read(){
        $xmlfile = JPATH_LIBRARIES.'/cbcc/backup.xml';
        $xml = JFactory::getXML($xmlfile,true);
        //var_dump($xml->ll_theo);
        //$this->item = json_decode(json_encode((array)$xml), TRUE);
        $item = array(
            'll_theo'=>$xml->ll_theo->__toString(),
            'weekly'=>$xml->weekly->__toString(),
            'monthly'=>$xml->monthly->__toString(),
            'hour'=>$xml->hour->__toString(),
            'is_bk_fdk'=>$xml->is_bk_fdk->__toString(),
            'is_bk_csdl'=>$xml->is_bk_csdl->__toString(),
            'thumuc_dich'=>$xml->thumuc_dich->__toString(),
            'domain'=>$xml->domain->__toString(),
            'admistrator'=>$xml->admistrator->__toString(),
            'pass_admistrator'=>$xml->pass_admistrator->__toString()
        );
        return $item;
    }
    public function save($formData){
        $config = Core::config();        
        $data = '<?xml version="1.0" encoding="UTF-8"?>
<backup>
	<ll_theo>'.$formData['ll_theo'].'</ll_theo>
	<weekly>'.$formData['weekly'].'</weekly>
	<monthly>'.$formData['monthly'].'</monthly>
	<hour>'.$formData['hour'].'</hour>
	<is_bk_fdk>'.$formData['is_bk_fdk'].'</is_bk_fdk>
	<is_bk_csdl>'.$formData['is_bk_csdl'].'</is_bk_csdl>
	<thumuc_dich>'.$formData['thumuc_dich'].'</thumuc_dich>
	<domain>'.$formData['domain'].'</domain>
	<admistrator>'.$formData['admistrator'].'</admistrator>
	<pass_admistrator>'.$formData['pass_admistrator'].'</pass_admistrator>
</backup>';
        $cmon_mysql = ($formData['is_bk_csdl'] == 1)?'mysqldump –user='.$config->user.' –password='.$config->password.' > $FILENAME '.$config->db.'
            tar -zcf $FILENAME.tar.gz $FILENAME
            ':'';
        $cmon_source = ($formData['is_bk_fdk'] == 1)?'cp -r '.JPATH_ROOT.'/* '.$formData['thumuc_dich'].'            
        ':'';
        $mysql_backup = '#!/bin/bash
FILENAME='.$formData['thumuc_dich'].'mysql-`date +%s`.sql
'. $cmon_mysql .'
'. $cmon_source .'
tar -zcvf backup-`date +%s`.tar.gz  '.$formData['thumuc_dich'].'/
';
        file_put_contents(JPATH_LIBRARIES.'/cbcc/backup.xml',$data) or die('ERROR:Can not write file backup.xml');
        file_put_contents(JPATH_ROOT.'/bin/mysql_backup.sh',$mysql_backup) or die('ERROR:Can not write file mysql_backup.sh');
        chmod(JPATH_ROOT.'/bin/mysql_backup.sh',0777);
        $this->createCronTab($formData);
    }
    public function doBackup(){       
       // echo shell_exec('chmod 700'.JPATH_ROOT.'/bin/mysql_backup.sh');       
       // echo shell_exec('sh '.JPATH_ROOT.'/bin/mysql_backup.sh');
        JLog::add(shell_exec('sh '.JPATH_ROOT.'/bin/mysql_backup.sh'), JLog::INFO, 'com_core');
       // exit;
    }
    public function createCronTab($args){
        $filePath= 'sh '.JPATH_ROOT.'/bin/mysql_backup.sh';
        $cmd = '';
        $hour           =$args["hour"];
        $day_of_month   =$args["monthly"];
        $month          =$args["month"];
        $day_of_week    =$args["weekly"];
        if ($args['ll_theo'] == 'daily') {
           $cmd = "(crontab -l ; echo '0 ".$hour." * * * ".$filePath."' ) | crontab -";
        }elseif($args['ll_theo'] == 'weekly'){
            $cmd = "(crontab -l ; echo '0 ".$hour." * * ".$day_of_week." ".$filePath."' ) | crontab -";
        }
        elseif($args['ll_theo'] == 'monthly'){
            $cmd = "(crontab -l ; echo '0 ".$hour." ".$day_of_month." * * ".$filePath."' ) | crontab -";
        }

        if (empty($cmd)) {           
            JLog::add(shell_exec($cmd), JLog::INFO, 'com_core');
        }
        
    }
}