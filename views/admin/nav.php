<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <script src="https://kit.fontawesome.com/e123c1a84c.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

    <style>

    </style>
</head>

<body>

    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="brand">
                <span class="ti-unlink"></span>
                <span style="font-size: 22px;">Cre by HGiap</span> 
            </h3>
            <label for="sidebar-toggle" class="ti-menu-alt"></label>
        </div>


        <div class="sidebar-menu">
            <?php if ($_COOKIE['role'] == 1) { ?>
                <ul class="container">
                    <li>
                        <a href="" data-bs-toggle="collapse" data-bs-target="#demo12">
                            <span class="ti-bar-chart"></span>
                            <span>Thống kê</span>
                        </a>
                        <div id="demo12" class="collapse">
                            <ul class="container mt-3 nav-bar-b">
                                <li>
                                    <a href="<?= CONTROLLERS_ADMIN ?>?action=main">
                                        <span class="text-black">Danh sách</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="" data-bs-toggle="collapse" data-bs-target="#demo">
                            <span class="ti-home"></span>
                            <span>Thông tin cửa hàng</span>
                        </a>
                        <div id="demo" class="collapse">
                            <ul class="container mt-3 nav-bar-b">
                                <li>
                                    <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachinfo">
                                        <span class="text-black">Danh sách thông tin</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="" data-bs-toggle="collapse" data-bs-target="#demo2">
                            <span class="ti-user"></span>
                            <span>Tài khoản</span>
                        </a>
                        <div id="demo2" class="collapse">
                            <ul class="container mt-3 nav-bar-b">
                                <li>
                                    <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachtk">
                                        <span class="text-black">Danh sách tài khoản</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo3">
                        <span class="ti-agenda"></span>
                        <span>Danh mục</span>
                    </a>
                    <div id="demo3" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=danhmuc">
                                    <span class="text-black">Danh sách Danh mục</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo4">
                        <span class="ti-bag"></span>
                        <span>sản phẩm</span>
                    </a>
                    <div id="demo4" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachsp">
                                    <span class="text-black">danh sách sản phẩm</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=themsp">
                                    <span class="text-black">Thêm sản phẩm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo5">
                        <span class="ti-comment"></span>
                        <span>Bình luận</span>
                    </a>
                    <div id="demo5" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachbl">
                                    <span class="text-black">danh sách bình luận</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo6">
                        <span class="ti-bag"></span>
                        <span>Đơn hàng</span>
                    </a>
                    <div id="demo6" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachdh">
                                    <span class="text-black">danh sách đơn hàng</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=thongkesp">
                                    <span class="text-black">sản phẩm bán được</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo10">
                        <span class="ti-pencil-alt"></span>
                        <span>Tin tức</span>
                    </a>
                    <div id="demo10" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=danhsachnew">
                                    <span class="text-black">Danh sách tin tức</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=them_new">
                                    <span class="text-black">Thêm tin tức</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo7">
                        <span class="ti-blackboard"></span>
                        <span>Banner</span>
                    </a>
                    <div id="demo7" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=dsbanner">
                                    <span class="text-black">danh sách banner</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-bs-target="#demo8">
                        <span class="ti-image"></span>
                        <span>Album</span>
                    </a>
                    <div id="demo8" class="collapse">
                        <ul class="container mt-3 nav-bar-b">
                            <li>
                                <a href="<?= CONTROLLERS_ADMIN ?>?action=dsalbum">
                                    <span class="text-black">danh sách album</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../controllers/user.php">
                        <i class="ti-share-alt"></i>
                        <span>Website</span>
                    </a>
                </li>
                </ul>
        </div>
    </div>


    <div class="main-content">

        <header>
            <div class="search-wrapper">
                <form action="" method="post">
                    <span class="ti-search"></span>
                    <input type="search" name="title" placeholder="Search">
                    <input type="submit" name="tim_sp" hidden>
                </form>
            </div>

            <div class="social-icons">
                <span class="ti-bell"></span>
                <span class="ti-comment"></span>
                <?php foreach ($post->get_val_id('users', 'id_user', $_COOKIE['id_admin']) as $val) : extract($val); ?>
                    <div><img src="../public/img/<?= $avatar ?>" alt=""></div>
                <?php endforeach; ?>
            </div>
        </header>