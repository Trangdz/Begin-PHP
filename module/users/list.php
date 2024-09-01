<?php
if(!defined('_INCODE')==1)
{
    die('Access deined');
}
if(isLogin())
{
    $tokenLogin=$_SESSION['loginToken'];
    var_dump($tokenLogin);
    echo 'Da Dang nhap thanh cong';
}
