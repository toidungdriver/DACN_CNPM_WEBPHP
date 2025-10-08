<main>

            <div class="container">
                <div class="form-group">
                    <h2>Quản lý tin tức</h2>
                </div>
                <table class="table table-dark table-striped">
                    <thead class="bg-black text-white">
                        <tr>
                            <th>
                                <input type="checkbox" name="" id="checkall" hidden>
                                <button class="btn btn-danger">
                                    <label for="checkall" class="select">Chọn tất</label>
                                    <label for="checkall" class="unselect" style="display: none;">Bỏ chọn</label>
                                </button>
                            </th>
                            <th>id</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Ảnh</th>
                            <th>Ngày</th>
                            <th>Người đăng</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($post->get_val('news'))) {
                            foreach ($post->get_val('news') as $val) : extract($val);?>
                                <form action="" method="post">
                                    <tr>
                                        <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_news ?>"></td>
                                        <td><?= $id_news?></td>
                                        <td><?=$title ?></td>
                                        <td><?=substr($content, 0, 100); ?></td>
                                        <td><img src="<?=IMAGE?><?= $image ?>" height="100px" width="100px" alt=""></td>
                                        <td><?= $date ?></td>
                                        <td><?= $author ?></td>
                                        <td><a href="<?=CONTROLLERS_ADMIN?>?action=sua_new&id_new=<?php echo $id_news ?>" onclick="return confirm('bạn muốn sửa');"><button type="button" class="btn btn-warning">Sửa</button></a></td>
                                    </tr>
                            <?php endforeach;
                        } ?>
                    </tbody>
                </table>
                <input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger mt-3" type="submit" name="check_delete_new" value="xóa click" id="checkall">
                </form>
            </div>
        </main>