<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SearchTest extends TestCase {
    private $products;
    private static $results = [];
    private $dbConnected = true;

    protected function setUp(): void {
        // Giả lập dữ liệu DB
        $this->products = [
            ['id' => 1, 'name' => 'Adidas Ultraboost', 'price' => 3500000, 'image' => 'adidas.jpg'],
            ['id' => 2, 'name' => 'Giày Nike Air', 'price' => 2500000, 'image' => 'nike.jpg'],
            ['id' => 3, 'name' => 'Giày Converse', 'price' => 1200000, 'image' => 'converse.jpg'],
        ];
        $this->dbConnected = true;
    }

    private function searchProduct($keyword) {
        if (!$this->dbConnected) {
            throw new Exception("DB Connection Error");
        }
        $result = [];
        foreach ($this->products as $p) {
            if (stripos($p['name'], $keyword) !== false) {
                $result[] = $p;
            }
        }
        return $result;
    }

    private function runTestCase($id, $scenario, $pre, $steps, $expected, callable $func) {
        $status = "Pass";
        try {
            $func(); // chạy test thật
        } catch (AssertionFailedError $e) {
            $status = "Fail";
        } catch (Exception $e) {
            $status = "Fail";
        }

        self::$results[] = [$id, $scenario, $pre, $steps, $expected, $status];
    }

    public function testSearchSingleResult() {
        $this->runTestCase(
            "ITC01",
            "Tìm kiếm sản phẩm có trong DB",
            "DB có sản phẩm 'Adidas Ultraboost'",
            "1. Nhập 'Adidas'\n2. Nhấn Search",
            "Hiển thị danh sách chứa 'Adidas Ultraboost'",
            function () {
                $result = $this->searchProduct('Adidas');
                $this->assertNotEmpty($result);
                $this->assertEquals('Adidas Ultraboost', $result[0]['name']);
            }
        );
    }

    public function testSearchMultipleResults() {
        $this->runTestCase(
            "ITC02",
            "Tìm kiếm nhiều kết quả",
            "DB có nhiều sản phẩm chứa từ 'Giày'",
            "1. Nhập 'Giày'\n2. Nhấn Search",
            "Hiển thị danh sách >1 sản phẩm (tên + giá + ảnh)",
            function () {
                $result = $this->searchProduct('Giày');
                $this->assertGreaterThan(1, count($result));
            }
        );
    }

    public function testSearchNoResult() {
        $this->runTestCase(
            "ITC03",
            "Tìm kiếm không có kết quả",
            "DB không có sản phẩm chứa 'XYZ'",
            "1. Nhập 'XYZ'\n2. Nhấn Search",
            "Hiển thị thông báo 'Không tìm thấy sản phẩm'",
            function () {
                $result = $this->searchProduct('XYZ');
                $this->assertEmpty($result);
            }
        );
    }

    public function testSearchDbError() {
        $this->runTestCase(
            "ITC04",
            "DB lỗi kết nối",
            "DB ngắt kết nối",
            "1. Nhập 'Nike'\n2. Nhấn Search",
            "Hiển thị thông báo 'Không thể kết nối hệ thống'",
            function () {
                $this->dbConnected = false;
                $this->expectException(Exception::class);
                $this->searchProduct('Nike');
            }
        );
    }

    public function testSearchWrongFormat() {
        $this->runTestCase(
            "ITC05",
            "Kết quả hiển thị sai định dạng",
            "DB trả dữ liệu nhưng thiếu thông tin giá",
            "1. Nhập 'Nike'\n2. Nhấn Search",
            "Hiển thị lỗi format",
            function () {
                $this->products = [
                    ['id' => 10, 'name' => 'Nike Zoom'] // thiếu price, image
                ];
                $result = $this->searchProduct('Nike');
                // Ở đây deliberately fail vì thiếu field
                $this->assertArrayHasKey('price', $result[0]);
            }
        );
    }

    public static function tearDownAfterClass(): void {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["Test Case ID", "Test Scenario", "Precondition", "Test Steps", "Expected Result", "Status"];
        $sheet->fromArray($headers, null, 'A1');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
            ]
        ];
        $sheet->getStyle("A1:F1")->applyFromArray($headerStyle);

        // Data
        $row = 2;
        foreach (self::$results as $result) {
            $sheet->fromArray($result, null, "A{$row}");
            $row++;
        }

        // Auto size
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle("A1:F" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Save file
        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/search_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ Kết quả đã được ghi vào {$filePath}\n";
    }
}
