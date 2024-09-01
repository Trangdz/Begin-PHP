<?php
if (!defined('_INCODE') == 1) {
    die('Access deined');
}
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
if (isLogin()) {

    $listAllUser = getRaw("SELECT * FROM user ORDER BY updateAt");
    layout('header');
?>
    <div class="container">
        <hr />
        <h3>Quản lý người dùng</h3>
        <a class="btn btn-success btn-sm"><i class="fa fa-plus"></i>
            Add user</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">Serial</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Status</th>
                    <th width="5%">Sửa</th>
                    <th width="5%">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listAllUser)) : ?>
                    <?php
                    $count = 0; // Khởi tạo biến đếm để hiển thị số thứ tự
                    foreach ($listAllUser as $item) :
                        $count++;
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $item['fullname']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['phone']; ?></td>
                            <td><?php echo $item['status']==1?'<button type="submit" class="btn btn-success btn-sm" style="padding-left:11px; padding-right:11px">Active</button>':'<button type="submit" class="btn btn-warning btn-sm">Passive</button>'; ?></td>
                            <td><a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a></td>
                            <td><a href="#" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-danger text-center">Không có người dùng</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

            </td>
            </tr>

            </tbody>
        </table>
        <hr />
    </div>

<?php
    layout('footer');
}
