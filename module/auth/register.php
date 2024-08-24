<?php
// Kiểm tra xem hằng số _INCODE đã được định nghĩa chưa
// echo _INCODE;
if (defined('_INCODE') != 1) {
    die('Access Denied');
}
// Không bao giờ đạt đến dòng này vì die() đã dừng thực thi mã
$data=[
    'pageTitle'=>'System Register'
];

layout('header-login',$data);
?>
  
  
    <div class="login-form">
        <h2 class="title">Đăng Nhập</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="fullname">Email</label>
                <input type="text" id="fullname" class="form-control" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <label for="Phone number">Mật khẩu</label>
                <input type="text" id="phonenumber" class="form-control" placeholder="Phone number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="comfirmpassword">Comfirm password</label>
                <input type="password" id="password" class="form-control" placeholder="Comfirm password" required>
            </div>
            <button type="submit">Sign In </button>
            <div class="link">
                <p><a href="?module=auth&action=login">Login</a></p>
                
            </div>
        </form>
    
<?php
// Sửa dấu gạch ngược thành dấu gạch chéo trong đường dẫn

layout('footer-login',$data);
