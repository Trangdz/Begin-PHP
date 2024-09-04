<?php
if (!defined('_INCODE')) die('Access Denied...');

layout('header-login');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản trị</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>" />
</head>

<body>
    <div class="container" style="display: flex; align-items: center; flex-direction: column; height: 100vh; justify-content: center;">
        <h1 class="text-center">HỆ THỐNG QUẢN TRỊ</h1>
        <p class="text-center">
            <a href="?module=users" class="btn btn-success btn-lg">Vào hệ thống</a>
        </p>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/custom.js"></script>
</body>

</html>
<?php
layout('footer-login');