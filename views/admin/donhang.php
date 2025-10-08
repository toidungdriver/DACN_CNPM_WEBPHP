<main>

    <h2 class="dash-title">Đơn hàng</h2>
    <nav class="navbar navbar-expand-lg sticky">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item btn">
                        <a class="nav-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh">Tất cả đơn hàng</a>
                    </li>
                    <li class="nav-item btn">
                        <a class="nav-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh&tele=chon_order&role=0">Chờ xử lý</a>
                    </li>
                    <li class="nav-item btn">
                        <a class="nav-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh&tele=chon_order&role=1">Đang gửi</a>
                    </li>
                    <li class="nav-item btn">
                        <a class="nav-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh&tele=chon_order&role=2">Đã nhận</a>
                    </li>
                    <li class="nav-item btn">
                        <a class="nav-link" href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh&tele=chon_order&role=3">Bị hủy</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
                    <th>Tổng giá tiền</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Họ và tên</th>
                    <th>Nội dung</th>
                    <th>Ngày đặt</th>
                    <th>Trang thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (!empty($save_menu)) {
                    foreach ($save_menu as $val) : extract($val); ?>
                        <tr>
                            <form action="" method="post">
                                <td><input type="checkbox" name="checkbox[]" id="check" value="<?= $id_order ?>"></td>
                                <td><?= number_format($total_order) ?></td>
                                <td><?= $phone_order ?></td>
                                <td><?= $email_order ?></td>
                                <td><?= $adress_order ?></td>
                                <td><?= htmlspecialchars($name_order) ?></td>
                                <td><?= htmlspecialchars($content_order) ?></td>
                                <td><?= $date_order ?></td>
                                <td><a href="#" class="" data-bs-toggle='dropdown'>
                                        <?php if ($action < 1) {
                                            echo "<span class='btn btn-warning'>Chờ xử lý</span>";
                                        }
                                        if ($action == 1) {
                                            echo "<span class='btn btn-danger'>Đang gửi</span>";
                                        }
                                        if ($action == 2) {
                                            echo "<span class='btn btn-success'>Đã nhận</span>";
                                        }
                                        if ($action == 3) {
                                            echo "<span class='btn btn-danger'>Đã hủy</span>";
                                        }  ?></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item d-flex" href="<?= GET ?>?action=sua_order&id=<?= $id_order ?>&role=0">Chờ xử lý</a></li>
                                        <li><a class="dropdown-item d-flex" href="<?= GET ?>?action=sua_order&id=<?= $id_order ?>&role=1">Đang gửi</a></li>
                                        <li><a class="dropdown-item d-flex" href="<?= GET ?>?action=sua_order&id=<?= $id_order ?>&role=2">Đã nhận</a></li>
                                        <li><a class="dropdown-item d-flex" href="<?= GET ?>?action=sua_order&id=<?= $id_order ?>&role=3">Bị hủy</a></li>
                                    </ul>
                                </td>
                                <td><a href="<?= CONTROLLERS_ADMIN ?>?action=chitiet_order&id=<?= $id_order ?>" class="btn btn-warning">Chi tiết</a></td>
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