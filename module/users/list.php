<?php
if(!defined('_INCODE')==1)
{
    die('Access deined');
}
if(!isLogin())
{
    redirect('?module=auth&action=login');
}
if(isLogin())
{
    
    $listAllUser=getRaw("SELECT * FROM user ORDER BY updateAt");
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
                    <th width="5%">STT</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Trạng thái</th>
                    <th width="5%">Sửa</th>
                    <th width="5%">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
              
                if (!empty($listAllUser)) {
                    $count = 0; // Khởi tạo biến đếm để hiển thị số thứ tự
                    foreach ($listAllUser as $item) {
                        $count++;
                        // Tiếp tục xử lý từng $item
                        // Ví dụ: echo "<tr><td>{$count}</td><td>{$item['name']}</td></tr>";
                    }
                }
             
                
                ?>
                <tr>
                    <td>1</td>
                    <td>Nguyễn Văn A</td>
                    <td>nguyenvana@example.com</td>
                    <td>0123456789</td>
                    <td>Active</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>

                </tr>
                <!-- Các hàng khác của bảng -->
            </tbody>
        </table>
        <hr />
    </div>

<?php
    layout('footer');
}

