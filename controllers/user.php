<?php

include_once "../models/function.php";
include_once "../controllers/user/post.php";


// $id = isset($_GET['id'])? $_GET['id']:"khong co id";
// echo $id;



include_once "../views/user/not-doi/nav.php";
//moi lan click vao the a chay url thi gui action = ... ta lay may cai ... ay de phan biet cac trang bang cac include 
// moi lan action thi chi giao luu voi chinh file user.php... tu user.php di chuyen duoc con cac file khac chuyen vao user.php thi khong
 
if(isset($_GET['action'])){
    switch($_GET['action']){
        case "danhmuc":
            include_once "../views/user/danhmuc.php";
        break;
        case "login":
            include_once "../views/user/login.php";
        break;
        case "chitiet":
            include_once "../views/user/chitiet.php";
        break;
        case "dangky":
            include_once "../views/user/dangky.php";
        break;
        case "card":
            include_once "../views/user/card.php";
        break;
        case "like":
            include_once "../views/user/like.php";
        break;
        case "contact":
            include_once "../views/user/contact.php";
        break;
        case "quenmk":
            include_once "../views/user/quenmk.php";
        break;
        case "doimk_quen":
            include_once "../views/user/doimk_quen.php";
        break;
        case "thongtin":
            include_once "../views/user/thongtin.php";
        break;
        case "doimk":
            include_once "../views/user/doimk.php";
        break;
        case "dathang":
            include_once "../views/user/dathang.php";
        break;
        case "gioithieu":
            include_once "../views/user/gioithieu.php";
        break;
        case "lichsu":
            include_once "../views/user/lichsu.php";
        break;
        case "chitiet_ls":
            include_once "../views/user/chitiet_ls.php";
        break;
        case "lichsu_sdt":
            include_once "../views/user/lichsu_sdt.php";
        break;
        case "tintuc":
            include_once "../views/user/tintuc.php";
        break;
        case "chitiet_new":
            include_once "../views/user/chitiet_new.php";
        break;
        default:
            include_once "../views/user/home.php";
        break;
    }
}else{
    include_once "../views/user/home.php";
}

include_once "../views/user/not-doi/footer.php";

?>