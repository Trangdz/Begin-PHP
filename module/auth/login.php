<?php
// Kiểm tra xem hằng số _INCODE đã được định nghĩa chưa
// echo _INCODE;
if (defined('_INCODE') != 1) {
    die('Access Denied');
}
// Không bao giờ đạt đến dòng này vì die() đã dừng thực thi mã
$data = [
    'pageTitle' => 'System Login'
];


//Check status login
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
if (isLogin()) {
    redirect('?module=users');
}
if (isPost()) {
    $body = getBody();
    if (!empty($body['email']) && !empty(trim($body['password']))) {
        //Check login
        $email = $body['email'];
        $password = $body['password'];
        //Query take inform fllowing email
        $userQuery = firstRaw("SELECT id, password FROM user WHERE email ='email'");
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {
                //Create token login
                $tokenLogin = sha1(uniqid() . time());

                //Insert data into table
                $dataToken = [
                    'userId' => $userId,
                    'token' => $tokenLogin,
                    'createAt' => date('Y-m-d H:i:s')
                ];
                $insertTokenStatus = insert('login_token', $dataToken);
                if ($insertTokenStatus) {
                    //Isert token success

                    //Save token_login into session
                    setSession('loginToken', $tokenLogin);

                    //Redirection across manager page
                    redirect('?module=users');
                } else {
                    setFlashData('msg', "Errors system , You can't login");
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', "Password no correct");
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', "Please , re-enter email and password");
            setFlashData('msg_type', 'danger');
        }
    }
    redirect('?module=users&action=list');
}

layout('header-login', $data);
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>
<div class="login-form">
    <h2 class="title">Đăng Nhập</h2>
    <?php
    getMsg($msg, $msg_type);
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" placeholder="Nhập email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <button type="submit">Đăng Nhập</button>
        <div class="link">
            <p><a href="?module=auth&action=forgot">Quên mật khẩu?</a></p>
            <p>Chưa có tài khoản? <a href="?module=auth&action=register">Đăng ký ngay</a></p>
        </div>
    </form>
</div>
<!-- <div class="registration-form">
        <h2 class="title">Đăng Ký</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <br/>
                <input type="text" id="name" class="form-control" placeholder="Nhập họ và tên" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <br/>
                <input type="email" id="email" class="form-control" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <br/>
                <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Nhập lại mật khẩu</label>
                <br/>
                <input type="password" id="confirm-password" class="form-control" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit">Đăng Ký</button>
            <div class="link">
                <p><a href="?module=auth&action=login">Đăng nhập tại đây</a></p>
                <p><a href="?module=auth&action=forgot">Forgot pass</a></p>
            </div>
        </form>
    </div> -->
<?php
// Sửa dấu gạch ngược thành dấu gạch chéo trong đường dẫn

layout('footer-login', $data);
