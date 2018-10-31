<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       

       //操作mongodb
    	
    	$mongo = new \MongoClient("mongodb://root:root@127.0.0.1:27017");
    	$db = $mongo->oa_db;
    	//$db->oa_doc->insert(array('name'=>'duan'));
    	
    	//$db->oa_doc->remove(array('name'=>'duan'));
 	}   
}