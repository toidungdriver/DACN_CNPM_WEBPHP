<main>

    <h2 class="dash-title">Danh mục</h2>

    <div class="offcanvas offcanvas-end" id="demothem">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title">Thêm danh mục</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="" class="mt-3" method="post" enctype="multipart/form-data">
                <div class=" card my-3 ">
                    <input class="form-control" type="text" name="name" placeholder="Nhập tên danh mục">
                </div>

                <div class=" card my-3 ">
                   
                    <select name="parent" id="">
                        <option value="0">Không chọn menu cha</option>

                        <?php if(!empty($post->get_val('cates'))){?>
                        <?php foreach($post->get_val('cates') as $val): extract($val)?>
                        <option value="<?=$id_cate?>"><?=$name_cate?></option>
                        <?php endforeach;?>
                        <?php }?>
                    </select>

                </div>

                <input type="submit" name="them_dm" value="Thêm" class="dang_nhap_dk btn btn-danger">

            </form>
        </div>
    </div>
    <button class="btn them my-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demothem">
        Thêm danh mục
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
                    <th>Tên danh mục</th>
                    <th>danh mục cha con</th>
                    <th>Sửa</th>
                </tr>
            </thead>
            <tbody>
                <?php //var_dump($post->get_val('users'));
                // if(isset($_POST['delete_user'])){
                //     var_dump($_POST);
                // }
                if (!empty($post->get_val('cates'))) {
                    foreach ($post->get_val('cates') as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_cate ?>"></td>
                                <td><?= $name_cate ?></td>
                                <td><?= $parent_cate ?></td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=sua_dm&id=<?= $id_cate ?>" class="btn btn-warning">Sửa</a></td>
                        </tr>
                <?php endforeach;
                } ?>
            </tbody>

        </table>
        <tr>
            <td><input onclick="return confirm('bạn muốn xóa theo lua chon');" class="btn btn-danger" type="submit" name="delete_cate" value="xóa click" id="checkall"></td>
        </tr>
        </form>
    </div>




</main>