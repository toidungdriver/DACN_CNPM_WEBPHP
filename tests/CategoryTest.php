<?php
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CategoryTest extends TestCase
{
    private static $results = [];
    private static $categories = [];

    private function addCategory($data)
    {
        // TC-03: Mã danh mục rỗng
        if (empty($data['code'])) {
            throw new Exception("InvalidInputException: Mã danh mục không được để trống");
        }

        // TC-04: Tên danh mục rỗng (không kiểm tra để Fail)
        // if (empty($data['name'])) {
        //     throw new Exception("InvalidInputException: Tên danh mục không được để trống");
        // }

        // TC-06: Dữ liệu quá dài
        if (strlen($data['code']) > 20 || strlen($data['name']) > 50) {
            throw new Exception("InvalidInputException: Dữ liệu quá dài");
        }

        // TC-02: Không throw lỗi trùng mã → để test Fail
        foreach (self::$categories as $cat) {
            if ($cat['code'] === $data['code']) {
                break; // vẫn thêm
            }
        }

        self::$categories[] = $data;
        return true;
    }

    private function runTestCase($stt, $id, $desc, $input, $expected, callable $func)
    {
        $actual = '';
        $status = 'Pass';

        try {
            $funcResult = $func();
            $actual = is_string($funcResult) ? $funcResult : 'Hàm trả về true, danh mục được lưu thành công';
        } catch (Exception $e) {
            $actual = $e->getMessage();
        }

        if ($expected !== $actual) {
            $status = 'Fail';
        }

        self::$results[] = [
            $stt,         // STT
            $id,          // Mã Unit Test
            $desc,        // Mô tả
            $input,       // Input
            $expected,    // Expected
            $actual,      // Actual
            $status       // Pass/Fail
        ];
    }

    // Các test case
    public function test_TC01_ValidCategory()
    {
        $this->runTestCase(
            1, "TC-01", "Thêm danh mục hợp lệ",
            'code="C001", name="Giày thể thao nam", desc="Giày chạy bộ, gym, thể thao"',
            "Hàm trả về true, danh mục được lưu thành công",
            function () {
                return $this->addCategory([
                    'code' => 'C001',
                    'name' => 'Giày thể thao nam',
                    'desc' => 'Giày chạy bộ, gym, thể thao'
                ]);
            }
        );
    }

    public function test_TC02_DuplicateCode()
    {
        $this->runTestCase(
            2, "TC-02", "Thêm danh mục trùng mã",
            'code="C001", name="Giày khác", desc="Test"',
            "Hàm trả về false hoặc ném DuplicateCodeException",
            function () {
                return $this->addCategory([
                    'code' => 'C001',
                    'name' => 'Giày khác',
                    'desc' => 'Test'
                ]);
            }
        );
    }

    public function test_TC03_EmptyCode()
    {
        $this->runTestCase(
            3, "TC-03", "Mã danh mục rỗng",
            'code="", name="Giày dép nữ", desc="Test"',
            "Hàm ném InvalidInputException",
            function () {
                return $this->addCategory([
                    'code' => '',
                    'name' => 'Giày dép nữ',
                    'desc' => 'Test'
                ]);
            }
        );
    }

    public function test_TC04_EmptyName()
    {
        $this->runTestCase(
            4, "TC-04", "Tên danh mục rỗng",
            'code="C002", name="", desc="Dép nam"',
            "Hàm ném InvalidInputException",
            function () {
                return $this->addCategory([
                    'code' => 'C002',
                    'name' => '',
                    'desc' => 'Dép nam'
                ]);
            }
        );
    }

    public function test_TC05_EmptyDesc()
    {
        $this->runTestCase(
            5, "TC-05", "Mô tả rỗng",
            'code="C003", name="Dép nữ", desc=""',
            "Hàm trả về true, danh mục được lưu thành công",
            function () {
                return $this->addCategory([
                    'code' => 'C003',
                    'name' => 'Dép nữ',
                    'desc' => ''
                ]);
            }
        );
    }

    public function test_TC06_TooLongInput()
    {
        $this->runTestCase(
            6, "TC-06", "Trường dữ liệu quá dài",
            'code="C001234567890123456789", name="Tên danh mục dài 51 ký tự...", desc="Giày đẹp thời trang"',
            "Hàm ném InvalidInputException",
            function () {
                return $this->addCategory([
                    'code' => str_repeat("C", 21),
                    'name' => str_repeat("A", 51),
                    'desc' => 'Giày đẹp thời trang'
                ]);
            }
        );
    }

    public static function tearDownAfterClass(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["STT", "Tên Unit Test", "Mô tả", "Input (Dữ liệu kiểm thử)", "Expected Output (Kết quả mong đợi)", "Actual Output (Kết quả thực tế)", "Pass/Fail"];
        $sheet->fromArray($headers, null, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        $sheet->getStyle("A1:G1")->applyFromArray($headerStyle);

        // Write results
        $row = 2;
        foreach (self::$results as $resultRow) {
            $sheet->fromArray($resultRow, null, "A{$row}");
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border all
        $sheet->getStyle("A1:G" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/category_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ File Excel đã được tạo tại: $filePath\n";
    }
}
