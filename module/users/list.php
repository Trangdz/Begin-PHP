<?php
if(!defined('_INCODE')==1)
{
    die('Access deined');
}
// $checkLogin=false;
// if (getSession('loginToken')) {
//     $tokenLogin = getSession('loginToken');
//     $queryToken = firstRaw("SELECT userId FROM login_token WHERE token='$tokenLogin'");
//     if (!empty($queryToken)) {
//         $checkLogin=true;
//     } else {
//         removeSession('loginToken');
//     }
// }
if(isLogin())
{
    redirect('?module=auth&action=login');
}

echo 'Day la list cua tôi';