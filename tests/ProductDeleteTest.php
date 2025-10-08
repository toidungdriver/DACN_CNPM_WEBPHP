<?php
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductDeleteTest extends TestCase
{
    private static $results = [];
    private static $products = [];

    protected function setUp(): void
    {
        // Danh sách sản phẩm ban đầu
        self::$products = [
            ['code' => 'SP001', 'name' => 'Nike Air'],
            ['code' => 'SP002', 'name' => 'Adidas']
        ];
    }

    private function deleteProduct($code)
    {
        // Kiểm tra mã rỗng
        if (empty($code)) {
            throw new Exception("Mã sản phẩm không được để trống");
        }

        // ❌ BUG 1: không phân biệt hoa thường
        $found = false;
        foreach (self::$products as $i => $p) {
            if (strtolower($p['code']) === strtolower($code)) { 
                unset(self::$products[$i]);
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new Exception("Sản phẩm không tồn tại");
        }

        return true;
    }

    private function runTestCase($stt, $id, $desc, $input, $expected, callable $func)
    {
        $actual = '';
        $status = 'Pass';

        try {
            $funcResult = $func();
            $actual = is_string($funcResult) ? $funcResult : 'Xóa thành công';
        } catch (Exception $e) {
            $actual = $e->getMessage();
        }

        if ($expected !== $actual) {
            $status = 'Fail';
        }

        self::$results[] = [$stt, $id, $desc, $input, $expected, $actual, $status];
    }

    // Test cases
    public function test_TC01_DeleteValid()
    {
        $this->runTestCase(
            1, "TC_DEL_01", "Xóa sản phẩm hợp lệ",
            'code="SP001"', "Xóa thành công",
            function () { return $this->deleteProduct("SP001"); }
        );
    }

    public function test_TC02_DeleteNotExist()
    {
        $this->runTestCase(
            2, "TC_DEL_02", "Xóa sản phẩm không tồn tại",
            'code="SP999"', "Sản phẩm không tồn tại",
            function () { return $this->deleteProduct("SP999"); }
        );
    }

    public function test_TC03_DeleteEmptyCode()
    {
        $this->runTestCase(
            3, "TC_DEL_03", "Xóa khi mã rỗng",
            'code=""', "Mã sản phẩm không được để trống",
            function () { return $this->deleteProduct(""); }
        );
    }

    public function test_TC04_DeleteTwice()
    {
        $this->runTestCase(
            4, "TC_DEL_04", "Xóa sản phẩm đã bị xóa trước đó",
            'code="SP001"', "Sản phẩm không tồn tại",
            function () { return $this->deleteProduct("SP001"); }
        );
    }

    public function test_TC05_DeleteCaseInsensitive()
    {
        $this->runTestCase(
            5, "TC_DEL_05", "Xóa sản phẩm với mã viết thường",
            'code="sp002"', "Sản phẩm không tồn tại",
            function () { return $this->deleteProduct("sp002"); }
        );
    }

    public static function tearDownAfterClass(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["STT", "Mã Unit Test", "Mô tả", "Input", "Expected Output", "Actual Output", "Pass/Fail"];
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

        // Auto size
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle("A1:G" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/product_delete_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ File Excel đã được tạo tại: $filePath\n";
    }
}
