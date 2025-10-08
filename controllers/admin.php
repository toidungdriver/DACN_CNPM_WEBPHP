<?php
if (!isset($_COOKIE['id_admin'])) {
    header("location:../controllers/user.php");
    exit;
}

// ✅ gọi thư viện PhpSpreadsheet
require_once __DIR__ . '/../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include_once "../models/function.php";
include_once "../controllers/admin/post.php";

// ✅ Chức năng xuất Excel theo tháng đã chọn (dựa vào $save_mon hiển thị trên màn hình)
if (isset($_POST['export_excel'])) {

    if (!empty($save_mon)) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tiêu đề cột
        $sheet->setCellValue('A1', 'Tổng');
        $sheet->setCellValue('B1', 'Phone');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Địa chỉ');
        $sheet->setCellValue('E1', 'Họ và tên');
        $sheet->setCellValue('F1', 'Ngày đặt');

        // Ghi dữ liệu từ $save_mon (dữ liệu đã lọc theo tháng)
        $row = 2;
        foreach ($save_mon as $val) {
            $sheet->setCellValue('A' . $row, $val['total_order']);
            $sheet->setCellValue('B' . $row, $val['phone_order']);
            $sheet->setCellValue('C' . $row, $val['email_order']);
            $sheet->setCellValue('D' . $row, $val['adress_order']);
            $sheet->setCellValue('E' . $row, $val['name_order']);
            $sheet->setCellValue('F' . $row, $val['date_order']);
            $row++;
        }

        // ✅ đặt tên file theo tháng đã chọn trong $_POST['date']
        $selectedMonth = $_POST['date'] ?? 0;
        $filename = "donhang_thang_" . ($selectedMonth > 0 ? $selectedMonth : "") . ".xlsx";

        // Xuất file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } else {
        echo "<script>alert('Không có dữ liệu để xuất file!');</script>";
    }
}

// ✅ include layout
include_once "../views/admin/nav.php";

// Routing
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "main":
            include_once "../views/admin/main.php";
            break;
        case "danhsachtk":
            include_once "../views/admin/users.php";
            break;
        case "danhsachsp":
            include_once "../views/admin/sanpham.php";
            break;
        case "themsp":
            include_once "../views/admin/themsp.php";
            break;
        case "sua_atri":
            include_once "../views/admin/suatri.php";
            break;
        case "thuoctinh_sp":
            include_once "../views/admin/thuoctinh_sp.php";
            break;
        case "them_sl_sp":
            include_once "../views/admin/soluong_sp.php";
            break;
        case "sua_user":
            include_once "../views/admin/sua_user.php";
            break;
        case "danhmuc":
            include_once "../views/admin/danhmuc.php";
            break;
        case "sua_dm":
            include_once "../views/admin/suadanhmuc.php";
            break;
        case "sua_sp":
            include_once "../views/admin/suasanpham.php";
            break;
        case "danhsachbl":
            include_once "../views/admin/binhluan.php";
            break;
        case "chitiet_cm":
            include_once "../views/admin/bl_chitiet.php";
            break;
        case "danhsachdh":
            include_once "../views/admin/donhang.php";
            break;
        case "chitiet_order":
            include_once "../views/admin/donhang_ct.php";
            break;
        case "danhsach":
            include_once "../views/admin/donhang_ct.php";
            break;
        case "thongkesp":
            include_once "../views/admin/thongkesp.php";
            break;
        case "danhsachinfo":
            include_once "../views/admin/info.php";
            break;
        case "dsbanner":
            include_once "../views/admin/banner.php";
            break;
        case "dsyeuthich":
            include_once "../views/admin/yeuthich.php";
            break;
        case "dsalbum":
            include_once "../views/admin/album.php";
            break;
        case "danhsachnew":
            include_once "../views/admin/new.php";
            break;
        case "them_new":
            include_once "../views/admin/them_new.php";
            break;
        case "sua_new":
            include_once "../views/admin/sua_new.php";
            break;
        default:
            include_once "../views/admin/main.php";
            break;
    }
} else {
    include_once "../views/admin/main.php";
}

include_once "../views/admin/footer.php";
