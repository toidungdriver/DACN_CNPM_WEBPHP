<?php
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LoginTest extends TestCase {
    private $users;
    private static $results = [];

    protected function setUp(): void {
        // Giả lập dữ liệu từ DB
        $this->users = [
            ['id_user' => 1, 'email' => 'admin@gmail.com', 'pass' => '123456', 'role' => 1],
            ['id_user' => 2, 'email' => 'user@gmail.com', 'pass' => 'abc123', 'role' => 0],
        ];
    }

    private function checkLogin($email, $pass) {
        foreach ($this->users as $val) {
            if ($email === $val['email'] && $pass === $val['pass']) {
                return [
                    'id_user' => $val['id_user'],
                    'role' => $val['role']
                ];
            }
        }
        return null;
    }

    public function testLoginSuccessAdmin() {
        $result = $this->checkLogin('admin@gmail.com', '123456');
        $this->assertNotNull($result);
        $this->assertEquals(1, $result['id_user']);
        $this->assertEquals(1, $result['role']);

        self::$results[] = [
            "ITC01",
            "Đăng nhập thành công với admin",
            "DB có user admin@gmail.com/pass=123456",
            "1. Nhập email + password\n2. Nhấn Login",
            "Đăng nhập thành công, role=admin",
            "Pass"
        ];
    }

    public function testLoginSuccessUser() {
        $result = $this->checkLogin('user@gmail.com', 'abc123');
        $this->assertNotNull($result);
        $this->assertEquals(2, $result['id_user']);
        $this->assertEquals(0, $result['role']);

        self::$results[] = [
            "ITC02",
            "Đăng nhập thành công với user",
            "DB có user user@gmail.com/pass=abc123",
            "1. Nhập email + password\n2. Nhấn Login",
            "Đăng nhập thành công, role=user",
            "Pass"
        ];
    }

    public function testLoginFailWrongPassword() {
        $result = $this->checkLogin('admin@gmail.com', 'wrong');
        $this->assertNull($result);

        self::$results[] = [
            "ITC03",
            "Sai mật khẩu",
            "DB có user admin@gmail.com nhưng mật khẩu sai",
            "1. Nhập email + password sai\n2. Nhấn Login",
            "Thông báo 'Sai mật khẩu'",
            "Pass"
        ];
    }

    public function testLoginFailUnknownEmail() {
        $result = $this->checkLogin('notfound@gmail.com', '123456');
        $this->assertNull($result);

        self::$results[] = [
            "ITC04",
            "Email không tồn tại",
            "DB không có user notfound@gmail.com",
            "1. Nhập email không tồn tại\n2. Nhấn Login",
            "Thông báo 'Không tìm thấy tài khoản'",
            "Pass"
        ];
    }

    public static function tearDownAfterClass(): void {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["Test Case ID", "Test Scenario", "Precondition", "Test Steps", "Expected Result", "Status"];
        $sheet->fromArray($headers, null, 'A1');

        // Style cho header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
            ]
        ];
        $sheet->getStyle("A1:F1")->applyFromArray($headerStyle);

        // Ghi dữ liệu test case
        $row = 2;
        foreach (self::$results as $result) {
            $sheet->fromArray($result, null, "A{$row}");
            $row++;
        }

        // Auto width cho các cột
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Thêm border cho toàn bộ bảng
        $sheet->getStyle("A1:F" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Xuất file Excel
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/login_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ Kết quả đã được ghi vào {$filePath}\n";
    }
}
