<?php
if (!defined('_INCODE') == 1) {
    die('Access denied');
}

if (!isLogin()) {
    redirect('?module=auth&action=login');
}

$data = [
    'pageTitle' => 'Add users'
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Kiểm tra nếu form đã được gửi
    // Lấy tất cả dữ liệu từ form
    $body = getBody(); 

    // Gán giá trị mặc định nếu không có giá trị nào được nhập
    $body['fullname'] = isset($body['fullname']) ? $body['fullname'] : '';
    $body['phonenumber'] = isset($body['phonenumber']) ? $body['phonenumber'] : '';
    $body['email'] = isset($body['email']) ? $body['email'] : '';
    $body['password'] = isset($body['password']) ? $body['password'] : '';
    $body['confirmpassword'] = isset($body['confirmpassword']) ? $body['confirmpassword'] : '';
    $body['status'] = isset($body['status']) ? $body['status'] : '';

    // Validate fullname
    if (empty(trim($body['fullname']))) {
        $errors['fullname']['required'] = 'Full name is required';
    } else if (strlen(trim($body['fullname'])) < 5) {
        $errors['fullname']['min'] = 'Fullname must be at least 5 characters';
    }

    // Validate phonenumber
    if (empty(trim($body['phonenumber']))) {
        $errors['phonenumber']['required'] = 'Phone number is required';
    } else if (!isPhone(trim($body['phonenumber']))) {
        $errors['phonenumber']['isPhone'] = 'Phone number is not valid';
    }

    // Validate email
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Email is required';
    } else if (!isEmail(trim($body['email']))) {
        $errors['email']['isEmail'] = 'Email is not valid';
    } else {
        // Kiểm tra email đã tồn tại trong database chưa
        $email = trim($body['email']);
        $sql = "SELECT id FROM user WHERE email='$email'";
        if (getRow($sql) > 0) {
            $errors['email']['unique'] = 'Email already exists';
        }
    }

    // Validate password
    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Password is required';
    } else if (strlen(trim($body['password'])) < 8) {
        $errors['password']['min'] = 'Password must be at least 8 characters';
    }

    // Validate confirm password
    if (empty(trim($body['confirmpassword']))) {
        $errors['confirmpassword']['required'] = 'Confirm password is required';
    } else if (trim($body['password']) !== trim($body['confirmpassword'])) {
        $errors['confirmpassword']['match'] = 'Passwords do not match';
    }

    if (empty($errors)) {
        // Nếu không có lỗi thì tiến hành thêm người dùng
        setFlashData('msg', 'You have successfully added a new user');
        setFlashData('msg_type', 'success');

        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'email' => $body['email'],
            'fullname' => $body['fullname'],
            'phone' => $body['phonenumber'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'status' => $body['status'],
            'createAt' => date('Y-m-d H:i:s'),
        ];

        $insertStatus = insert('user', $dataInsert);

        if ($insertStatus) {
            setFlashData('msg', 'User added successfully!');
            setFlashData('msg_type', 'success');
            redirect('?module=users&action=list');
        } else {
            setFlashData('msg', 'The system encountered a problem. Please try again.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        // Nếu có lỗi thì hiển thị thông báo lỗi
        setFlashData('msg', 'Please correct the errors and try again.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('content', $body);
    }

    // redirect('?module=users&action=add');
}

layout('header', $data);
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$content = getFlashData('content');
?>

<!-- Form HTML -->
<div class='container'>
    <h3><?php echo $data['pageTitle']; ?></h3>
    <?php getMsg($msg, $msg_type); ?>

    <form action="" method='post'>
        <div class="row">
            <div class='col'>
                <div class='form-group'>
                    <label>Fullname</label>
                    <input type='text' class='form-control' name='fullname' placeholder="fullname" value="<?php echo htmlspecialchars($content['fullname'] ?? ''); ?>">
                    <?php echo (!empty($errors['fullname'])) ? '<span class="errors" style="color: red;">' . reset($errors['fullname']) . '</span>' : ''; ?>
                </div>

                <div class='form-group'>
                    <label>Phone Number</label>
                    <input type='text' class='form-control' name='phonenumber' placeholder="phonenumber" value="<?php echo htmlspecialchars($content['phonenumber'] ?? ''); ?>">
                    <?php echo (!empty($errors['phonenumber'])) ? '<span class="errors" style="color: red;">' . reset($errors['phonenumber']) . '</span>' : ''; ?>
                </div>

                <div class='form-group'>
                    <label>Email</label>
                    <input type='text' class='form-control' name='email' placeholder="email" value="<?php echo htmlspecialchars($content['email'] ?? ''); ?>">
                    <?php echo (!empty($errors['email'])) ? '<span class="errors" style="color: red;">' . reset($errors['email']) . '</span>' : ''; ?>
                </div>
            </div>

            <div class='col'>
                <div class='form-group'>
                    <label>Password</label>
                    <input type='password' class='form-control' name='password' placeholder="password" value="">
                    <?php echo (!empty($errors['password'])) ? '<span class="errors" style="color: red;">' . reset($errors['password']) . '</span>' : ''; ?>
                </div>

                <div class='form-group'>
                    <label>Confirm Password</label>
                    <input type='password' class='form-control' name='confirmpassword' placeholder="confirm password" value="">
                    <?php echo (!empty($errors['confirmpassword'])) ? '<span class="errors" style="color: red;">' . reset($errors['confirmpassword']) . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="0" <?php echo (isset($content['status']) && $content['status'] == 0) ? 'selected' : ''; ?>>Passive</option>
                        <option value="1" <?php echo (isset($content['status']) && $content['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='button-submit'>
            <button class="btn btn-primary add-user" type="submit">Add User</button>
            <a href='#' class='btn btn-success'>Back</a>
        </div>
    </form>
</div>

<?php
layout('footer');
