<main>

    <h2 class="dash-title">ảnh chi tiết</h2>

    <div class="offcanvas offcanvas-end" id="demothem">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title">Thêm ảnh chi tiết</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="" class="mt-3" method="post" enctype="multipart/form-data">

                <div class=" card my-3 ">
                    <input class="form-control" type="file"  multiple="muitiple" name="image[]" placeholder="Chọn ảnh">
                </div>

                <div class=" card my-3 ">
                    <select class="form-control" name="special" id="">
                        <?php foreach($post->get_val('products') as $val): extract($val)?>
                        <option value="<?=$id_pro?>"><?=$title_pro?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <input type="submit" name="them_img_ct" value="Thêm" class="dang_nhap_dk btn btn-danger">

            </form>
        </div>
    </div>
   
    <button class="btn them my-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demothem">
        Thêm ảnh chi tiết
    </button>

    <div class="table-responsive">
        <table class="table table-xuly table-dark text-white">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="" id="checkall" hidden>
                        <button class="btn btn-danger">
                            <label for="checkall" class="select">Chọn tất</label>
                            <label for="checkall" class="unselect" style="display: none;">Bỏ chọn</label>
                        </button>
                    </th>
                    <th>id</th>
                    <th>Ảnh</th>
                    <th>id sản phẩm</th>
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
                if (!empty($post->get_val('albums'))) {
                    foreach ($post->get_val('albums') as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id ?>"></td>
                                <td><?= $id ?></td>
                                <td><img src="<?= IMAGE ?><?= $image_album ?>" width="100px" height="100px" alt=""></td>
                                <td><?= $id_product ?></td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=sua_album&id=<?= $id_banner ?>" class="btn btn-warning">Sửa</a></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>

        </table>
        <tr>
            <td><input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger" type="submit" name="delete_album" value="xóa click" id="checkall"></td>
        </tr>
        </form>
    </div>
</main>