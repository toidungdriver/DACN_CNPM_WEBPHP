<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrderTest extends TestCase {
    private static $results = [];
    private $cart = [];

    protected function setUp(): void {
        // Giả lập giỏ hàng mặc định có sản phẩm
        $this->cart = [
            ['id' => 1, 'name' => 'Giày XYZ', 'qty' => 1]
        ];
    }

    private function addOrder($data) {
        // Nếu giỏ hàng rỗng
        if (empty($this->cart)) {
            throw new Exception("Giỏ hàng trống, không thể đặt hàng");
        }

        // Kiểm tra tên
        if (strlen($data['name']) > 255) {
            throw new Exception("Tên quá dài, tối đa 255 ký tự");
        }

        // Kiểm tra số điện thoại
        if (empty($data['phone'])) {
            throw new Exception("Vui lòng nhập số điện thoại");
        }
        if (!preg_match('/^[0-9]{9,11}$/', $data['phone'])) {
            throw new Exception("Số điện thoại không hợp lệ");
        }

        // Nếu dữ liệu ok → trả về đơn hàng thành công
        return [
            'order_id' => rand(1000, 9999),
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'items' => $this->cart
        ];
    }

    private function runTestCase($id, $scenario, $pre, $steps, $data, $expected, callable $func) {
        $status = "Pass";
        try {
            $func();
        } catch (AssertionFailedError $e) {
            $status = "Fail";
        } catch (Exception $e) {
            $status = "Fail";
        }

        self::$results[] = [$id, $scenario, $pre, $steps, $data, $expected, $status];
    }

    public function testAddOrderSuccess() {
        $this->runTestCase(
            "TC_01",
            "Thêm đơn hàng thành công với dữ liệu hợp lệ",
            "Người dùng đã đăng nhập, giỏ hàng có sản phẩm",
            "1. Vào giỏ hàng → 2. Chọn sản phẩm → 3. Nhập thông tin giao hàng → 4. Xác nhận đặt hàng",
            "Họ tên: Nguyễn Văn A; Địa chỉ: Hà Nội; SĐT: 0912345678; Sản phẩm: Giày XYZ",
            "Đơn hàng được tạo thành công, hiển thị mã đơn hàng",
            function () {
                $data = ['name' => 'Nguyễn Văn A', 'address' => 'Hà Nội', 'phone' => '0912345678'];
                $order = $this->addOrder($data);
                $this->assertArrayHasKey('order_id', $order);
            }
        );
    }

    public function testAddOrderMissingPhone() {
        $this->runTestCase(
            "TC_02",
            "Thêm đơn hàng thiếu thông tin bắt buộc",
            "Người dùng đã đăng nhập, giỏ hàng có sản phẩm",
            "Nhập thiếu số điện thoại → Xác nhận đặt hàng",
            "Họ tên: Nguyễn Văn A; Địa chỉ: Hà Nội; SĐT: (trống)",
            "Hệ thống báo lỗi 'Vui lòng nhập số điện thoại'",
            function () {
                $this->expectException(Exception::class);
                $this->expectExceptionMessage("Vui lòng nhập số điện thoại");
                $data = ['name' => 'Nguyễn Văn A', 'address' => 'Hà Nội', 'phone' => ''];
                $this->addOrder($data);
            }
        );
    }

    public function testAddOrderInvalidPhone() {
        $this->runTestCase(
            "TC_03",
            "Thêm đơn hàng với số điện thoại sai định dạng",
            "Người dùng đã đăng nhập, giỏ hàng có sản phẩm",
            "Nhập sai định dạng số điện thoại → Xác nhận đặt hàng",
            "SĐT: abc12345",
            "Hệ thống báo lỗi 'Số điện thoại không hợp lệ'",
            function () {
                $this->expectException(Exception::class);
                $this->expectExceptionMessage("Số điện thoại không hợp lệ");
                $data = ['name' => 'Nguyễn Văn A', 'address' => 'Hà Nội', 'phone' => 'abc12345'];
                $this->addOrder($data);
            }
        );
    }

    public function testAddOrderEmptyCart() {
        $this->runTestCase(
            "TC_04",
            "Thêm đơn hàng khi giỏ hàng rỗng",
            "Người dùng đã đăng nhập, giỏ hàng trống",
            "Nhấn nút đặt hàng",
            "Không có sản phẩm",
            "Hệ thống báo lỗi 'Giỏ hàng trống, không thể đặt hàng'",
            function () {
                $this->cart = []; // làm giỏ hàng rỗng
                $this->expectException(Exception::class);
                $this->expectExceptionMessage("Giỏ hàng trống, không thể đặt hàng");
                $data = ['name' => 'Nguyễn Văn A', 'address' => 'Hà Nội', 'phone' => '0912345678'];
                $this->addOrder($data);
            }
        );
    }

    public function testAddOrderLongName() {
        $this->runTestCase(
            "TC_05",
            "Kiểm tra giới hạn độ dài tên khách hàng",
            "Người dùng đã đăng nhập",
            "Nhập tên dài 256 ký tự → Xác nhận đặt hàng",
            "Tên: (chuỗi 256 ký tự)",
            "Hệ thống báo lỗi 'Tên quá dài, tối đa 255 ký tự'",
            function () {
                $this->expectException(Exception::class);
                $this->expectExceptionMessage("Tên quá dài, tối đa 255 ký tự");
                $longName = str_repeat("A", 256);
                $data = ['name' => $longName, 'address' => 'Hà Nội', 'phone' => '0912345678'];
                $this->addOrder($data);
            }
        );
    }

    public static function tearDownAfterClass(): void {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["Mã TC", "Kịch bản kiểm thử", "Điều kiện tiên quyết", "Các bước thực hiện", "Dữ liệu kiểm thử", "Kết quả mong đợi", "Trạng thái"];
        $sheet->fromArray($headers, null, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
            ]
        ];
        $sheet->getStyle("A1:G1")->applyFromArray($headerStyle);

        // Data
        $row = 2;
        foreach (self::$results as $result) {
            $sheet->fromArray($result, null, "A{$row}");
            $row++;
        }

        // Auto size
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle("A1:G" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/order_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ Kết quả đã được ghi vào {$filePath}\n";
    }
}
