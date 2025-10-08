<main>

    <h2 class="dash-title">Chi tiết bình luận</h2>
    <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachbl" class="btn them">danh sách bình luận
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
                    <th>Người bình</th>
                    <th>Nội dung bình luận </th>
                    <th>Ngày bình luận</th>
                </tr>
            </thead>
            <tbody>
                <pre>
                <?php
                if (!empty($post->thongke_cm_chitiet($_GET['id']))) {
                    foreach ($post->thongke_cm_chitiet($_GET['id']) as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id ?>"></td>
                                <td><?=  $name_bl ?></td>
                                <td><?= htmlspecialchars($content) ?></td>
                                <td><?= $date ?></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>

        </table>
        <tr>
            <td><input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger" type="submit" name="delete_bl_ct" value="xóa click" id="checkall"></td>
        </tr>
        </form>
    </div>
</main>