<?php
// Kiểm tra xem hằng số _INCODE đã được định nghĩa chưa
// echo _INCODE;
if (defined('_INCODE') != 1) {
    die('Access Denied');
}
// Không bao giờ đạt đến dòng này vì die() đã dừng thực thi mã
$data = [
    'pageTitle' => 'System Register'
];



layout('header-login', $data);

if (isPost()) {
    //validate form
    $body = getBody(); //Lay tat ca du lieu cua form

    var_dump($body);
    $errors = [];

    //validate name : bat buoc nhap >=5 character

    if (empty(trim(($body['fullname'])))) {
        $errors['fullname']['required'] = 'full name is required ';
    } else {
        if (strlen(trim($body['fullname'])) < 5) {
            $errors['fullname']['min'] = 'Ho ten phai >=5 ky tu';
        }
    }

    //Validate number phone
    if (empty(trim($body['phonenumber']))) {
        $errors['phonenumber']['required'] = 'Số điện thoại không được bỏ trống';
    } else {
        if (!isPhone(trim($body['phonenumber']))) {
            $errors['phonenumber']['isPhone'] = 'Số điện thoại không hợp lê';
        }
    }

    //validate email
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Email không được để rỗng';
    } else {
        if (!isEmail(trim($body['email']))) {
            $errors['email']['isEmail'] = 'Email không hợp lệ';
        } else {
            //Kiem tra email da ton tai trong data base chua
            $email = trim($body['email']);
            $sql = "SELECT id FROM user WHERE email='$email'";
            if (getRow($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }

    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Không được bỏ trống';
    } else {
        if (strlen(trim($body['password'])) < 8) {
            $errors['password']['min'] = 'Chưa nhập đủ kí tự';
        }
    }


    //Validate nhập lại mật khẩu: Bắt buộc phải nhập, giống trường mật khẩu
    if (empty(trim($body['confirmpassword']))) {
        $errors['confirmpassword']['required'] = 'Xác nhận mật khẩu không được để trống';
    } else {
        if (trim($body['password']) !== trim($body['confirmpassword'])) {
            $errors['confirmpassword']['match'] = 'Hai mật khẩu không khớp';
        }
    }

    if(empty($errors)){
        setFlashData('msg','You have login successfull');
        setFlashData('msg_type','success');
    }
    else{
        setFlashData('msg','Please re-enter information');
        setFlashData('msg_type','danger');
    }
    echo '<pre>';
    print_r($errors);
    echo '</pre>';
  
}

$msg=getFlashData('msg');
$msg_type=getFlashData('msg_type');


?>


<div class="login-form">
    <h2 class="title">Đăng Nhập</h2>
    <?php
       
            getMsg($msg,$msg_type);
        
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="fullname">Full name</label>
            <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full name" required>
        </div>
        <div class="form-group">
            <label for="Phone number">Phone number</label>
            <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Phone number" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <div class="form-group">
            <label for="confirmpassword">Comfirm password</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Comfirm password" required>
        </div>
        <button type="submit">Sign In </button>
        <div class="link">
            <p><a href="?module=auth&action=login">Login</a></p>

        </div>
    </form>

    <?php
    // Sửa dấu gạch ngược thành dấu gạch chéo trong đường dẫn

    layout('footer-login', $data);
