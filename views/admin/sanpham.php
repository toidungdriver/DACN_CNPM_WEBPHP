<main>

    <h2 class="dash-title">Sản phẩm</h2>

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
                    <th>Thông tin</th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Sale</th>
                    <th>Ngày thêm</th>
                    <th>Đặc biệt</th>
                    <th>View</th>
                    <th>Ẩn</th>
                    <th>Danh mục</th>
                    <th>Sửa</th>
                </tr>
            </thead>
            <tbody>
                <pre>
                <?php
                //var_dump($post->get_val_join('products','cates','products.cate_id','cates.id_cate'));
                // if(isset($_POST['delete_user'])){
                //     var_dump($_POST);
                // }
                if (!empty($save)) {
                    foreach ($save as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_pro ?>"></td>
                                <td><?= $title_pro ?></td>
                                <td><?= substr($content_pro, 0, 50) ?></td>
                                <td><?php foreach (explode(',', $thongtin) as $val) { ?>
                                    <li><?= $val ?></li>
                                    <?php } ?>
                                </td>
                                <td><img src="<?= IMAGE ?><?= $image_pro ?>" width="100px" height="100px" alt=""></td>
                                <td><?= $quantity_pro ?></td>
                                <td><?= $price_pro ?></td>
                                <td><?= $sale_pro ?></td>
                                <td><?= $date_pro ?></td>
                                <td><?php echo $special_pro = $special_pro < 1 ? "Đặc biệt" : "Không đặc biệt"; ?></td>
                                <td><?= $view_pro ?></td>
                                <td><?php echo $hiden_pro = $hiden_pro < 1 ? "Hiện" : "Ẩn"; ?></td>
                                <td><?= $name_cate ?></td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=sua_sp&id=<?= $id_pro ?>" class="btn btn-warning">Sửa</a></td>
                        </tr>
                <?php endforeach;
                } ?>
                
            </tbody>

        </table>
        <ul class="pagination mt-5">
                      
                      <li class="page-item"><a class="page-link" href="">Trang đầu</a></li>
                      <?php for ($sum = 1; $sum <= $mang['tong_page']; $sum++) : ?>
                      <li class="page-item <?php if (isset($_GET['page']) && $_GET['page'] == $sum) {
                                                echo "active";
                                            }
                                            if (!isset($_GET['page']) && $sum == 1) {
                                                echo "active";
                                            } ?>"><a class="page-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachsp&page=<?= $sum ?>"><?= $sum ?></a></li>
                      <?php endfor; ?>
                      <li class="page-item"><a class="page-link" href="#">Trang cuối</a></li>
        </ul>
        <tr>
            <td><input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger" type="submit" name="delete_pro" value="xóa click" id="checkall"></td>
        </tr>
        </form>
    </div>
</main>