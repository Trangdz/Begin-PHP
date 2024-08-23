<?php
if(defined("_INCODE")!=1) die("Access denail");
function layout($layoutName='header',$data=[]){
    if(file_exists(_WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php')){
        require_once _WEB_PATH_TEMPLATE.'/layouts/'.$layoutName.'.php';
    }
}
?>