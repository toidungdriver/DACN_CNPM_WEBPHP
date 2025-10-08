<main>

    <h2 class="dash-title">thông tin cửa hàng</h2>

    <div class="offcanvas offcanvas-end" id="demothem">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title">Thêm thông tin cửa hàng</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="" class="mt-3" method="post" enctype="multipart/form-data">
                <div class=" card my-3 ">
                    <input class="form-control" type="email" name="email" placeholder="Nhập email">
                </div>
                <div class=" card my-3 ">
                    <input class="form-control" type="file" name="image" placeholder="Chọn logo">
                </div>
                <div class=" card my-3 ">
                    <input class="form-control" type="number" name="phone" placeholder="Nhập số phone">
                </div>
                <div class=" card my-3 ">
                    <input class="form-control" type="text" name="adress" placeholder="Nhập địa chỉ">
                </div>
                <div class=" card my-3 ">
                    <textarea class="form-control" name="content" rows="5" id="editor" id="comment" placeholder="Nhập nội dung"></textarea>
                </div>
                <input type="submit" name="them_info" value="Thêm" class="dang_nhap_dk btn btn-danger">
            </form>
        </div>
    </div>

    <button class="btn them my-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demothem">
        Thêm ảnh thông tin
    </button>

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
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Phone</th>
                    <th>Địa chỉ</th>
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
                if (!empty($post->get_val('info'))) {
                    foreach ($post->get_val('info') as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_info ?>"></td>
                                <td><?= $email_info ?></td>
                                <td><img src="<?= IMAGE ?><?= $logo ?>" width="200px" height="100px" alt=""></td>
                                <td><?= $phone_info ?></td>
                                <td><?= $adress_info ?></td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=sua_info&id=<?= $id_info ?>" class="btn btn-warning">Sửa</a></td>
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