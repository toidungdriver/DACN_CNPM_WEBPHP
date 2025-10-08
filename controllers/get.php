<?php

include_once "../models/function.php";
//file get nay la file chuyen trang xu ly
if (isset($_COOKIE['id_admin'])) {
    $id = $_COOKIE['id_admin'];
}
if (isset($_COOKIE['id_user'])) {
    $id = $_COOKIE['id_user'];
}

//-----------------------------unset cookie---------------------------------
if (isset($_GET['action'])) :
    $get = $_GET['action'];
    switch ($get) {
        case 'dangxuat':
            if(isset($id)){
                if (isset($_COOKIE['id_user'])) {
                    setcookie('id_user', "", time() - 3600);
                }
                if (isset($_COOKIE['id_admin'])) {
                    setcookie('id_admin', "", time() - 3600);
                }
                setcookie('error',"<script>alert('Bạn đăng xuất thành công');</script>",time() + 48000);
            }

            header("location:" . CONTROLLERS_USER . "?action=login");
            break;
    }
endif;

//-----------------------------tang view---------------------------------
if (isset($_GET['id_chitiet'])) {
    $chi_tiet = $_GET['id_chitiet'];
    foreach ($post->get_val_id('products', 'id_pro', $chi_tiet) as $val) {
        extract($val);
        if ($view_pro == 0) {
            $post->update_view(1, $chi_tiet);
        } else {
            $view_pro += 1;
            $post->update_view($view_pro, $chi_tiet);
        }
        header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_chitiet']);
    }
}
//------------------------------them bl con--------------------------------
if (isset($_POST['submit_bl_con'])) {
    if (isset($id)) {
        foreach ($post->get_val_id('comments', 'id_cm', $_GET['id_cm']) as $val) : extract($val);
            $id_pro = $_GET['id_sp'];
            $id_user = $id;
            $comment = $_POST['comment'];
            $post->insert_comment($comment, $id_pro, $id_user, $id_cm);
            header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_sp']);
        endforeach;
    } else {
        header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_sp']);
    }
}
if($_GET['action'] ==  'xoa_cm_cha'){
    $post->delete('comments','id_cm',$_GET['id_cm'],'parent_cm',$_GET['id_cm']);
    header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_sp']);
}
if($_GET['action'] ==  'xoa_cm'){
    $post->delete('comments','id_cm',$_GET['id_cm']);
    header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_sp']);
}

//------------------------------xoa theo id----------------
if (isset($_GET['id_cart_gh'])) {
    $id = $_GET['id_cart_gh'];
    unset($_SESSION['cart_pro'][$id]);
    header("location:" . CONTROLLERS_USER . "?action=card");
}

//------------------------------xoa tat ca trong gio hang ----------------

if ($_GET['action'] == "xoa_all_cart") {
    unset($_SESSION['cart_pro']);
    setcookie('error',"<script>alert('Bạn đã xóa sản phẩm trong giỏ hàng');</script>",time() + 48000);
    header("location:" . CONTROLLERS_USER . "?action=card");
}
//----------------------------------xoa like- -----------------------------

if($_GET['action'] == 'like'){
    $post->delete('loves', 'id_love', $_GET['id_chitiet']);
    header("location:" . CONTROLLERS_USER . "?action=like");
}

if($_GET['action'] == "sua_order"){

    
    // $save = $post->get_val_id('orders','id_order',$_GET['id']);
    $get_action = $_GET['role'];
    // foreach($save as $val){
    //     extract($val);
    //     if($order == 1){
    //         $post->gui_dh(0,$_GET['id']);
    //     }else{
    //         $post->gui_dh(1,$_GET['id']);
    //     }
    // }

    if ($get_action < 1) {
        $post->gui_dh(0,$_GET['id']);
    }
    if ($get_action == 1) {
        $post->gui_dh(1,$_GET['id']);
    }
    if ($get_action > 1) {
        $post->gui_dh(2,$_GET['id']);
    }
    if ($get_action > 2) {
        // echo '<pre>';
        $sav_pro = $post->get_val('products');
        $save_order = $post->get_val_id_join('orders.id_order',$_GET['id'],'orders','order_detail','orders.id_order','order_detail.order_id');
        // var_dump($save_order);
        // var_dump($sav_pro);
        foreach($sav_pro as $val){extract($val);
            echo $quantity_pro.'<br>';
            foreach($save_order as $val2){
                // extract($val2); k thich extract :))
                if($id_pro == $val2['product_id']){
                    $quantity_pro += $val2['quantity_detail'];
                    $post->update_quantity($quantity_pro,$id_pro);
                }
            }
        }
        $post->gui_dh(3,$_GET['id']);
    } 
    header("location:" . CONTROLLERS_ADMIN . "?action=danhsachdh");
}

if($_GET['action'] == "delete_atri"){
    $post->delete('attributes','id_attri',$_GET['atri_id']);
    header("location:" . CONTROLLERS_ADMIN . "?action=sua_sp&id=".$_GET['pro_id']);
}

?>