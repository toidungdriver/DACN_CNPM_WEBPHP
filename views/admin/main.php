<main class="main">

    <h2 class="dash-title">Thống kê</h2>

    <div class="dash-cards">
        <div class="card-single">
            <div class="card-body">
                <span class="ti-briefcase"></span>
                <div>
                    <h5>Tổng doanh thu</h5>
                    <h4><?= number_format($tong1) ?></h4>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= CONTROLLERS_ADMIN ?>?action=thongkesp">View all</a>
            </div>
        </div>

        <div class="card-single">
            <div class="card-body">
                <span class="ti-reload"></span>
                <div>
                    <h5>Số sản phẩm bán được</h5>
                    <h4><?= $sp ?></h4>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= CONTROLLERS_ADMIN ?>?action=thongkesp">View all</a>
            </div>
        </div>

        <div class="card-single">
            <div class="card-body">
                <span class="ti-heart"></span>
                <div>
                    <h5>Lượt view sản phẩm</h5>
                    <h4><?= $view ?></h4>
                </div>
            </div>
            <div class="card-footer">
                <a href="">View all</a>
            </div>
        </div>
    </div>

    <section class="recent">
        <div class="activity-grid">
            <div class="activity-card">
                <div class="d-flex justify-content-between">
                    <h3>Đơn hàng bán được</h3>
                    <form action="" method="post" class="d-flex align-content-center mx-3" >
                        <select class="" name="date" id="" style="border:none;">
                            <option value="0">Chọn ngày tháng</option>
                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                <option value="<?= $i ?>">Tháng <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="submit" name="chon_date" value="Chọn tháng" class="dang_nhap_dk btn btn-dark">
                        <button type="submit" name="export_excel" class="btn btn-success">Xuất Excel</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tổng</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Họ và tên</th>
                                <th>Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($save_mon)) {
                                foreach ($save_mon as $val) : extract($val); ?>
                                    <tr>
                                        <td><?= number_format($total_order) ?></td>
                                        <td><?= $phone_order ?></td>
                                        <td><?= $email_order ?></td>
                                        <td><?= $adress_order ?></td>
                                        <td><?= htmlspecialchars($name_order) ?></td>
                                        <td>
                                            <span class="badge success"><?= $date_order ?></span>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="summary">
                <div class="summary-card">
                    <div class="summary-single">
                        <span class="ti-id-badge"></span>
                        <div>
                            <h5>Tổng giá</h5>
                            <small><?= number_format($tong_gia)?></small>
                        </div>
                    </div>
                    <div class="summary-single">
                        <span class="ti-calendar"></span>
                        <div>
                            <h5>Tháng đặt hàng</h5>
                            <small><?=$save_date?></small>
                        </div>
                    </div>
                    <div class="summary-single">
                        <span class="ti-face-smile"></span>
                        <div>
                            <h5>Số lượng đơn hàng</h5>
                            <small><?=$id_or?></small>
                        </div>
                    </div>
                </div>

                <div class="bday-card">
                    <div class="bday-flex">
                        <div class="bday-img">
                            <img src="<?=IMAGE?><?=$save_img?>" alt="" class="box_image">
                        </div>
                        <div class="bday-info">
                            <h5><?=$ten?></h5>
                            <small>Số lượng sản phẩm: <?=$save_max?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
