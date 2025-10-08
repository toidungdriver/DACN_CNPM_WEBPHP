<?php
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductTest extends TestCase
{
    private static $results = [];
    private static $products = [];

    /**
     * Thêm sản phẩm (giả lập DB)
     * Có bug bỏ qua kiểm tra name, price > 0, quantity > 0
     */
    private function addProduct(array $data)
    {
        if (!is_numeric($data['price'])) {
            throw new Exception("Giá bán phải là số");
        }

        foreach (self::$products as $p) {
            if ($p['code'] === $data['code']) {
                throw new Exception("Mã sản phẩm đã tồn tại");
            }
        }

        self::$products[] = $data;
        return true;
    }

    /**
     * Chạy 1 test case
     */
    private function runTestCase($stt, $id, $desc, $input, $expected, callable $func)
    {
        try {
            $result = $func();
            $actual = is_string($result) ? $result : 'Thêm thành công';
        } catch (Exception $e) {
            $actual = $e->getMessage();
        }

        $status = ($expected === $actual) ? "Pass" : "Fail";

        self::$results[] = [$stt, $id, $desc, $input, $expected, $actual, $status];
    }

    # ================= Test Cases =================

    public function test_TC01_ValidProduct()
    {
        $this->runTestCase(
            1, "TC_ADD_01", "Thêm sản phẩm hợp lệ",
            'SP001 | Nike Air | size=42 | Trắng | 2000000 | sl=10',
            "Thêm thành công",
            fn() => $this->addProduct([
                'code' => 'SP001', 'name' => 'Giày Nike Air', 'size' => 42,
                'color' => 'Trắng', 'price' => 2000000, 'quantity' => 10
            ])
        );
    }

    public function test_TC02_AnotherValidProduct()
    {
        $this->runTestCase(
            2, "TC_ADD_02", "Thêm sản phẩm hợp lệ khác",
            'SP002 | Adidas | size=41 | Đen | 1800000 | sl=15',
            "Thêm thành công",
            fn() => $this->addProduct([
                'code' => 'SP002', 'name' => 'Giày Adidas', 'size' => 41,
                'color' => 'Đen', 'price' => 1800000, 'quantity' => 15
            ])
        );
    }

    public function test_TC03_SmallSize()
    {
        $this->runTestCase(
            3, "TC_ADD_03", "Thêm size nhỏ",
            'SP003 | Converse | size=36 | Đỏ | 950000 | sl=20',
            "Thêm thành công",
            fn() => $this->addProduct([
                'code' => 'SP003', 'name' => 'Giày Converse', 'size' => 36,
                'color' => 'Đỏ', 'price' => 950000, 'quantity' => 20
            ])
        );
    }

    public function test_TC04_EmptyName()
    {
        $this->runTestCase(
            4, "TC_ADD_04", "Thiếu tên sản phẩm",
            'SP004 | "" | size=40 | Đen | 1200000 | sl=5',
            "Tên sản phẩm không được để trống",
            fn() => $this->addProduct([
                'code' => 'SP004', 'name' => '', 'size' => 40,
                'color' => 'Đen', 'price' => 1200000, 'quantity' => 5
            ])
        );
    }

    public function test_TC05_InvalidPriceFormat()
    {
        $this->runTestCase(
            5, "TC_ADD_05", "Sai định dạng giá",
            'SP005 | Vans | size=42 | Trắng | "hai triệu" | sl=8',
            "Giá bán phải là số",
            fn() => $this->addProduct([
                'code' => 'SP005', 'name' => 'Giày Vans', 'size' => 42,
                'color' => 'Trắng', 'price' => "hai triệu", 'quantity' => 8
            ])
        );
    }

    public function test_TC06_DuplicateCode()
    {
        $this->runTestCase(
            6, "TC_ADD_06", "Trùng mã",
            'SP001 | Puma | size=41 | Xanh | 1300000 | sl=7',
            "Mã sản phẩm đã tồn tại",
            fn() => $this->addProduct([
                'code' => 'SP001', 'name' => 'Giày Puma', 'size' => 41,
                'color' => 'Xanh', 'price' => 1300000, 'quantity' => 7
            ])
        );
    }

    public function test_TC07_NegativePrice()
    {
        $this->runTestCase(
            7, "TC_ADD_07", "Giá âm",
            'SP006 | Bitis | size=39 | Vàng | -500000 | sl=10',
            "Giá phải lớn hơn 0",
            fn() => $this->addProduct([
                'code' => 'SP006', 'name' => 'Giày Bitis', 'size' => 39,
                'color' => 'Vàng', 'price' => -500000, 'quantity' => 10
            ])
        );
    }

    public function test_TC08_NegativeQuantity()
    {
        $this->runTestCase(
            8, "TC_ADD_08", "Số lượng âm",
            'SP007 | MLB | size=40 | Nâu | 1500000 | sl=-3',
            "Số lượng phải lớn hơn 0",
            fn() => $this->addProduct([
                'code' => 'SP007', 'name' => 'Giày MLB', 'size' => 40,
                'color' => 'Nâu', 'price' => 1500000, 'quantity' => -3
            ])
        );
    }

    /**
     * Xuất báo cáo Excel sau khi chạy tất cả test
     */
    public static function tearDownAfterClass(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ["STT", "Mã Unit Test", "Mô tả", "Input", "Expected", "Actual", "Kết quả"];
        $sheet->fromArray($headers, null, 'A1');

        $sheet->getStyle("A1:G1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $sheet->fromArray(self::$results, null, 'A2');

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle("A1:G" . (count(self::$results) + 1))
              ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $filePath = __DIR__ . "/product_report.xlsx";
        (new Xlsx($spreadsheet))->save($filePath);

        echo "\n✅ File Excel đã được tạo tại: $filePath\n";
    }
}
