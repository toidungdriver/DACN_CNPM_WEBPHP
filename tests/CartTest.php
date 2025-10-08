<?php
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CartTest extends TestCase
{
    private static $results = [];
    private static $cart = [];

    private function addToCart($data)
    {
        // TC-02: Product ID rỗng
        if (empty($data['product_id'])) {
            throw new Exception("Mã sản phẩm không được để trống");
        }

        // TC-03: Quantity <= 0
        if ($data['quantity'] <= 0) {
            throw new Exception("Số lượng phải lớn hơn 0");
        }

        // TC-04: Giá trị không hợp lệ
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            throw new Exception("Giá sản phẩm không hợp lệ");
        }

        // TC-05: Nếu sản phẩm đã tồn tại trong giỏ hàng → cộng dồn
        foreach (self::$cart as &$item) {
            if ($item['product_id'] === $data['product_id']) {
                $item['quantity'] += $data['quantity'];
                return "Đã cập nhật số lượng sản phẩm trong giỏ hàng";
            }
        }

        self::$cart[] = $data;
        return "Thêm sản phẩm vào giỏ hàng thành công";
    }

    private function runTestCase($stt, $id, $desc, $input, $expected, callable $func)
    {
        $actual = '';
        $status = 'Pass';

        try {
            $funcResult = $func();
            $actual = is_string($funcResult) ? $funcResult : "Hàm trả về true";
        } catch (Exception $e) {
            $actual = $e->getMessage();
        }

        if ($expected !== $actual) {
            $status = 'Fail';
        }

        self::$results[] = [
            $stt, $id, $desc, $input, $expected, $actual, $status
        ];
    }

    // ✅ TC-01: Thêm sản phẩm hợp lệ
    public function test_TC01_AddValidProduct()
    {
        $this->runTestCase(
            1, "TC_CART_01", "Thêm sản phẩm hợp lệ",
            'product_id="P001", quantity=2, price=500000',
            "Thêm sản phẩm vào giỏ hàng thành công",
            function () {
                return $this->addToCart([
                    'product_id' => 'P001',
                    'quantity' => 2,
                    'price' => 500000
                ]);
            }
        );
    }

    // ❌ TC-02: Product ID rỗng
    public function test_TC02_EmptyProductId()
    {
        $this->runTestCase(
            2, "TC_CART_02", "Thiếu mã sản phẩm",
            'product_id="", quantity=1, price=300000',
            "Mã sản phẩm không được để trống",
            function () {
                return $this->addToCart([
                    'product_id' => '',
                    'quantity' => 1,
                    'price' => 300000
                ]);
            }
        );
    }

    // ❌ TC-03: Quantity <= 0
    public function test_TC03_InvalidQuantity()
    {
        $this->runTestCase(
            3, "TC_CART_03", "Số lượng không hợp lệ",
            'product_id="P002", quantity=0, price=200000',
            "Số lượng phải lớn hơn 0",
            function () {
                return $this->addToCart([
                    'product_id' => 'P002',
                    'quantity' => 0,
                    'price' => 200000
                ]);
            }
        );
    }

    // ❌ TC-04: Giá <= 0
    public function test_TC04_InvalidPrice()
    {
        $this->runTestCase(
            4, "TC_CART_04", "Giá sản phẩm không hợp lệ",
            'product_id="P003", quantity=1, price=-1000',
            "Giá sản phẩm không hợp lệ",
            function () {
                return $this->addToCart([
                    'product_id' => 'P003',
                    'quantity' => 1,
                    'price' => -1000
                ]);
            }
        );
    }

    // ✅ TC-05: Thêm sản phẩm trùng → cộng dồn
    public function test_TC05_AddDuplicateProduct()
    {
        $this->runTestCase(
            5, "TC_CART_05", "Thêm sản phẩm trùng",
            'product_id="P001", quantity=3, price=500000',
            "Đã cập nhật số lượng sản phẩm trong giỏ hàng",
            function () {
                return $this->addToCart([
                    'product_id' => 'P001',
                    'quantity' => 3,
                    'price' => 500000
                ]);
            }
        );
    }

    public static function tearDownAfterClass(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ["STT", "Tên Unit Test", "Mô tả", "Input (Dữ liệu kiểm thử)", "Expected Output", "Actual Output", "Pass/Fail"];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        $sheet->getStyle("A1:G1")->applyFromArray($headerStyle);

        // Ghi kết quả
        $row = 2;
        foreach (self::$results as $resultRow) {
            $sheet->fromArray($resultRow, null, "A{$row}");
            $row++;
        }

        // Auto size
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Viền
        $sheet->getStyle("A1:G" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $writer = new Xlsx($spreadsheet);
        $filePath = __DIR__ . "/cart_report.xlsx";
        $writer->save($filePath);

        echo "\n✅ File báo cáo giỏ hàng đã được tạo tại: $filePath\n";
    }
}
