<?php
if (!defined('_INCODE') == 1) {
    die('Access deined');
}



if (!isLogin()) {
    redirect('?module=auth&action=login');
}
if (isLogin()) {
    //Process division page
    $allUserNumber = getRow('SELECT id FROM user');

    //Identify records on a page
    $perPage = 2;

    //Caculator the number of pages

    $maxPage = ceil($allUserNumber / $perPage);

    //Process base on method GET
    if (!empty(getBody()['page'])) {
        $page = getBody()['page'];
        if ($page < 1 || $page > $maxPage) {
            $page = 1;
        }
    } else {
        $page = 1;
    }
    echo $page;

    $offset = ($page - 1) * $perPage;
    //Use LIMIT to take number user conform
    $listAllUser = getRaw("SELECT * FROM user ORDER BY updateAt LIMIT $offset,$perPage");
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
                            <td><?php echo $item['status'] == 1 ? '<button type="submit" class="btn btn-success btn-sm" style="padding-left:11px; padding-right:11px">Active</button>' : '<button type="submit" class="btn btn-warning btn-sm">Passive</button>'; ?></td>
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
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                if ($page > 1) {
                    $prevPage = $page - 1;
                    echo '<li class="page-item"><a class="page-link" href="'._WEB_HOST_ROOT.'?module=users&action=list&page=' . $prevPage . '">Trước</a></li>';
                }
                ?>

                <?php for ($index = 1; $index <= $maxPage; $index++) : ?>
                    <li class="page-item <?php echo ($index == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo _WEB_HOST_ROOT.'?module=users&action=list&page=' . $index; ?>">
                            <?php echo $index; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php
                if ($page < $maxPage) {
                    $nextPage = $page + 1;
                    echo '<li class="page-item"><a class="page-link" href="' . _WEB_HOST_ROOT. '?module=users&action=list&page=' . $nextPage . '">Sau</a></li>';
                }
                ?>
            </ul>
        </nav>

    </div>

<?php
    layout('footer');
}
