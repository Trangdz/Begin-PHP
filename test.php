<?php
const _HOST = 'localhost';           // Địa chỉ máy chủ (localhost cho máy cục bộ)
const _USER = 'root';                // Tên người dùng MySQL
const _PASS = '';                    // Mật khẩu của người dùng (Xampp có thể để trống)
const _DB = 'phponline';             // Tên cơ sở dữ liệu
const _DRIVER = 'mysql';  

// Kiểm tra xem lớp PDO có tồn tại không
if (class_exists('PDO')) {
    // Tạo chuỗi DSN cho kết nối PDO
    $dsn = _DRIVER.':dbname='._DB .';host='._HOST.';port=4444';

    // Thiết lập các tùy chọn cho kết nối PDO
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // Thiết lập charset là UTF-8
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION        // Đẩy lỗi vào ngoại lệ
    ];

    try {
        // Tạo đối tượng PDO để kết nối tới cơ sở dữ liệu
        $conn = new PDO($dsn, _USER, _PASS, $options);

        // Tạo câu lệnh SQL để lấy người dùng có ID = 13
        $sql = "SELECT * FROM user WHERE id = :id";

        // Chuẩn bị câu lệnh truy vấn
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho tham số :id
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $id = 14;

        // Thực thi câu lệnh truy vấn
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra và hiển thị kết quả
        if ($result) {
            echo "ID: " . $result['id'] . "<br>";
            echo "Name: " . $result['fullname'] . "<br>";
            echo "Email: " . $result['email'] . "<br>";
            // Hiển thị các thông tin khác của người dùng nếu có
        } else {
            echo "No user found with ID 14.";
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo "PDO is not supported on this server.";
}
?>
