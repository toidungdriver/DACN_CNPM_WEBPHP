<main>

    <h2 class="dash-title">Bình luận</h2>
    <div class="table-responsive">
        <table class="table table-xuly">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="" id="checkall" hidden>
                        <button class="btn btn-danger">
                            <label for="checkall" class="select">chọn tất</label>
                            <label for="checkall" class="unselect" style="display: none;">bỏ chọn</label>
                        </button>
                    </th>
                    <th>id sản phẩm</th>
                    <th>Tên sản phẩm </th>
                    <th>Số bình luận</th>
                    <th>Bình luận cũ nhất</th>
                    <th>Bình luận mới nhất</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <pre>
                <?php 
                if (!empty($post->thongke_cm())) {
                    foreach ($post->thongke_cm() as $val) : extract($val); ?>
                        <tr>
                            <form action="<?=GET?>?action=xoa_cm_admin" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_pro ?>"></td>
                                <td><?= $id_pro ?></td>
                                <td><?= $ten_pro ?></td>
                                <td><?= $so_cm ?></td>
                                <td><?= $max_bl ?></td>
                                <td><?= $min_bl ?></td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=chitiet_cm&id=<?= $id_pro ?>" class="btn btn-warning">Chi tiết</a></td>
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