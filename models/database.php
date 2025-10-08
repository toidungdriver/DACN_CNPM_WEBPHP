<?php
session_start();
define('DB_HOST','mysql:host=127.0.0.1;dbname=sangdatabase;charset=utf8');
define('DB_USER','root');
define('DB_PASS','');
class database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $connect;

    public function __construct(){
        $this->connect = new PDO($this->host,$this->user,$this->pass);
    }

    //$sql truyen cau lenh truy van
    public function select($sql){
        $select = $this->connect->prepare($sql);
        $select->execute();
        $post = $select->fetchAll();
        return $post;
    }
    
    public function execute($sql){
        $query = $this->connect->prepare($sql);
        $query->execute();
    }
} 
// function dbConnect() {
//     // Thông tin DB của bạn
//     $host = "127.0.0.1";      // hoặc IP server
//     $username = "root";       // user MySQL
//     $password = "";           // mật khẩu MySQL
//     $dbname = "sangdatabase";      // tên database

//     // Kết nối
//     $conn = new mysqli($host, $username, $password, $dbname);

//     // Kiểm tra lỗi
//     if ($conn->connect_error) {
//         die("Kết nối thất bại: " . $conn->connect_error);
//     }

//     // Set charset để tránh lỗi tiếng Việt
//     $conn->set_charset("utf8");

//     return $conn;
// }

// function getOrders($month = '') {
//     $conn = dbConnect(); // dùng hàm vừa tạo
//     $sql = "SELECT * FROM orders";

//     if (!empty($month)) {
//         $sql .= " WHERE DATE_FORMAT(date_order, '%Y-%m') = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("s", $month);
//         $stmt->execute();
//         $result = $stmt->get_result();
//     } else {
//         $result = $conn->query($sql);
//     }

//     $orders = [];
//     while ($row = $result->fetch_assoc()) {
//         $orders[] = $row;
//     }

//     $conn->close();
//     return $orders;
// }

?>