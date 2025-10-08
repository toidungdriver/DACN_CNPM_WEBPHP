<main>

    <h2 class="dash-title">Chi tiết đơn hàng</h2>
    <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh" class="btn them">danh sách bình luận
    </a>

    <div class="table-responsive">
        <table class="table table-xuly ">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="" id="checkall" hidden>
                        <button class="btn btn-danger">
                            <label for="checkall" class="select">chọn tất</label>
                            <label for="checkall" class="unselect" style="display: none;">bỏ chọn</label>
                        </button>
                    </th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Sale</th>
                    <th>Ngày thêm</th>
                    <th>Đặc biệt</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <pre>
                <?php 
                if (!empty($post->thongke_order_detail($_GET['id']))) {
                    foreach ($post->thongke_order_detail($_GET['id']) as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_detail ?>"></td>
                                <td><?= $title_pro ?></td>
                                <td><?= substr($content_pro, 0, 50) ?></td>
                                <td><img src="<?= IMAGE ?><?= $image_pro ?>" width="100px" height="100px" alt=""></td>
                                <td><?= $quantity_detail ?></td>
                                <td><?= number_format($sale_chinh = $price_pro - $price_pro * ($sale_pro / 100))  ?></td>
                                <td><?= $sale_pro ?></td>
                                <td><?= $date_pro ?></td>
                                <td><?php echo $special_pro = $special_pro < 1 ? "Đặc biệt" : "Không đặc biệt"; ?></td>
                                <td><?= $view_pro ?></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>

        </table>
        <tr>
            <td><input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger" type="submit" name="delete_user" value="xóa click" id="checkall"></td>
        </tr>
        </form>
    </div>
</main>