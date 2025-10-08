<?php

$_GET['action'] = isset($_GET['action']) ? $_GET['action'] : "";

//-------------------------hien thi form trong dat hang---------------------------
if (isset($id)) {
    foreach ($post->get_val_id('users', 'id_user', $id) as $val) : extract($val);
        $sdt = $phone;
        $name = $name;
        $diachi = $adress;
        $gmail = $email;
    endforeach;
}
//-------------------------dang ky---------------------------
if (isset($_POST['dangky_tk'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $adress = $_POST['adress'];
    $pass = $_POST['pass'];
    $avatar = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../public/img/" . $avatar);
    if (empty($email) || empty($phone) || empty($name) || empty($adress) || empty($pass)) {
        $error['one'] = "<script>alert('Bạn nhập thông tin chưa đầy đủ');</script>";
    }

    foreach ($post->get_val('users') as $val) {
        if ($email == $val['email'] || $phone == $val['phone']) {
            $error['two'] = "<script>alert('Tài khoản này đã tồn tại');</script>";
        }
    }


    if (empty($error)) {
        if (empty($avatar)) {
            $avatar = "hinh-avatar-trang.jpg";
            $post->insert_user($email, $phone, $name, $adress, $pass, $avatar);
        } else {
            $post->insert_user($email, $phone, $name, $adress, $pass, $avatar);
        }
        header("location:" . CONTROLLERS_USER . "?action=login");
        setcookie('error', "<script>alert('Bạn đăng ký tài khoản thành công');</script>", time() + 48000);
    }
}

//-------------------------dang nhap---------------------------
// var_dump($post->get_val('users'));
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    foreach ($post->get_val('users') as $val) :
        if ($email == $val['email'] && $pass == $val['pass']) {
            $id = $val['id_user'];
            $role = $val['role'];
        }
    endforeach;

    if (!empty($id)) {
        if (isset($_POST['save'])) {
            setcookie('email', $email, time() + 48000);
            setcookie("pass", $pass, time() + 48000);
        }
        if ($role > 0) {
            setcookie('id_admin', $id, time() + 3600);
            setcookie('role', $role, time() + 3600);
            setcookie('error', "<script>alert('Bạn đăng nhập vào trang quản trị thành công');</script>", time() + 48000);
            header("location:" . CONTROLLERS_ADMIN . "");
        } else {
            setcookie('id_user', $id, time() + 3600);
            setcookie('role', $role, time() + 3600);
            setcookie('error', "<script>alert('Bạn đăng nhập tài khoản thành công');</script>", time() + 48000);
            header("location:" . CONTROLLERS_USER . "");
        }
    }
    if (empty($id)) {
        setcookie('error', "<script>alert('Bạn nhập sai tài khoản mật khẩu');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=login");
    }
}

if (isset($_POST['gui_ma_mk'])) {
    var_dump($_POST);
    $email = $_POST['email'];
    foreach ($post->get_val('users') as $val) {
        if ($email != $val['email']) {
            $error['two'] = "<script>alert('Email này chưa được đăng ký');</script>";
        } else {
            $save_id = $val['id_user'];
        }
    }

    if (!empty($save_id)) {
        $macode = rand(100000, 10000000);
        $post->update_ma_code($save_id, $macode);
        $mail->sendMail('Mã để lấy mật khẩu tài khoản của shop BBK', 'Mã của bạn là: ' . $macode, $email);
        setcookie('error', "<script>alert('Bạn gửi mã thành công vào email để nhận mã');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=doimk_quen");
    }
}

if (isset($_POST['doi_mk_quen'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $code = $_POST['code'];
    foreach ($post->get_val('users') as $val) {
        if ($code != $val['code_mk'] && $email != $val['email']) {
            $error['one'] = "<script>alert('Bạn nhập sai mã hoặc mail để đổi mật khẩu');</script>";
        } else {
            $save_id = '';
            $save_id = $val['id_user'];
        }
    }
    // if($pass != $pass2){
    //     $error['two'] = "<script>alert('Bạn nhập mật khẩu không khớp');</script>";
    // }

    if (!empty($save_id)) {
        $post->update_mk($pass, $save_id, 'code_mk', $code);
        setcookie('error', "<script>alert('Bạn đổi mật khẩu thành công');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=login");
    }
}

if (isset($_POST['doi_tt'])) {
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $adress = $_POST['adress'];
    $avatar = $_FILES['avatar']['name'];
    $tmp = $_FILES['avatar']['tmp_name'];

    if (empty($avatar)) {
        foreach ($post->get_val_id('users', 'id_user', $id) as $val) {
            $post->update_user($phone, $name, $adress, $val['avatar'], $id);
        }
    } else {
        move_uploaded_file($tmp, "../public/img/" . $avatar);
        $post->update_user($phone, $name, $adress, $avatar, $id);
    }
    $error['one'] = "<script>alert('Bạn sửa thành công');</script>";
}

if (isset($_POST['doi_mk'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    if (empty($email) || empty($pass)) {
        $error['one'] = "<script>alert('Bạn nhập thông tin chưa đầy đủ');</script>";
    }
    if (empty($error['one'])) {
        foreach ($post->get_val_id('users', 'id_user', $id) as $val) {
            if ($email == $val['email']) {
                $post->update_mk($pass, $id);
                $error['two'] = "<script>alert('Bạn đổi mật khẩu thành công');</script>";
            } else {
                $error['two'] = "<script>alert('Bạn chưa nhập đúng email');</script>";
            }
        }
    }
}
//-------------------------them binh luan cha---------------------------
if (isset($_POST['submit_bl_main'])) {
    if (isset($id)) {
        $id_pro = $_GET['id_chitiet'];
        $id_user = $id;
        $comment = $_POST['comment'];
        $post->insert_comment($comment, $id_pro, $id_user, 0);
        header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_chitiet']);
    } else {
        header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $_GET['id_chitiet']);
    }
}
//-----------------------love------------------------------------------
if (isset($_GET['id_like'])) {
    if (isset($_COOKIE['id_user'])) {
        $check = $post->check_loves($_GET['id_like'], $id);
        if (!$check) {
            $post->insert_loves($_GET['id_like'], $_COOKIE['id_user']);
            header("location:" . CONTROLLERS_USER);
        } else {
            setcookie('error', "<script>alert('Bạn đã từng thêm vào yêu thích');</script>", time() + 48000);
            header("location:" . CONTROLLERS_USER);
        }
    } else {
        setcookie('error', "<script>alert('Bạn chưa có tài khoản');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER);
    }
}
//----------------------nav-----------------------------------
if (isset($id)) {
    $tym = 0;
    if (!empty($post->get_val_id('loves', 'user_id', $id))) {
        foreach ($post->get_val_id('loves', 'user_id', $id) as $val) :
            $tym++;
        endforeach;
    }
} else {
    $tym = 0;
}

$gh_nav = 0;
if (isset($_SESSION['cart_pro'])) {
    $tong = 0;
    foreach ($_SESSION['cart_pro'] as $val) {
        extract($val);
        $tong += 1;
    }
    $gh_nav = $tong;
} else {
    $gh_nav = 0;
}
//----------------------------------lienhe----------------------------------
if (isset($_POST['lienhe'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['title']) || empty($_POST['content'])) {
        $kt = "kt";
        setcookie('error', "<script>alert('Bạn nhập chưa đầy đủ thông tin');</script>", time() + 48000);
    }
    if (empty($kt)) {
        $mail->sendMail('Gmail: ' . $email, $title . '<br> Đối tượng tên là: ' . $name . '<br> Nội dung liên hê: ' . $content, 'bachctph16049@fpt.edu.vn');
        header("location:" . CONTROLLERS_USER . "?action=contact");
    }
}
//------------------------------them vao gio hang-----------------------------


if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id_chitiet'];
    $save = $post->get_val_id('products', 'id_pro', $id);
    foreach ($post->get_val_id('products', 'id_pro', $id) as $val) {
        extract($val);
        $save_img = $image_pro;
        $save_title = $title_pro;
        $save_price = $price_pro;
        $save_quantity = $_POST['quantity'];
        $save_sale = $sale_pro;
    }
    if (!isset($_SESSION['cart_pro'][$id]) || !array_key_exists($id, $_SESSION['cart_pro'])) {
        $_SESSION['cart_pro'][$id] = array(
            'id_pro' => $id,
            'anh_pro' => $save_img,
            'title_pro' => $save_title,
            'price_pro' => $save_price,
            'quantity_pro' =>  $save_quantity,
            'sale_pro' => $save_sale
        );
    } else {
        $_SESSION['cart_pro'][$id]['quantity_pro'] += $save_quantity;
    }

    setcookie('error', "<script>alert('Bạn thêm hàng thành công');</script>", time() + 48000);
    header("location:" . CONTROLLERS_USER . "?action=chitiet&id_chitiet=" . $id);
}

//-----------------------------checkbox chuyen hang---------------------------------
if ($_GET['action'] == "dathang") {

    //--------gửi id và số lượng tạo mảng mới--------------
    if (isset($_POST['capnhat_cart'])) {
        foreach ($_POST['number_cart'] as $key => $val) {
            foreach ($_POST['id_cart'] as $key2 => $val2) {
                if ($key == $key2) {
                    // echo $val;
                    // echo '<br>';
                    // echo $val2;
                    $mang[$val2] = $val;
                }
            }
        }
        //--------cập nhật sản phẩm--------------
        foreach ($mang as $key1 => $val1) {
            foreach ($_SESSION['cart_pro'] as $key2 => $val2) {
                if ($key1 == $key2) {
                    $_SESSION['cart_pro'][$key2]['quantity_pro'] = $val1;
                    header("location:" . CONTROLLERS_USER . "?action=card");
                }
            }
        }
    }

    //--------gửi dữ liệu check qua trang đặt hàng--------------
    if (isset($_POST['detal_check'])) {
        if (!empty($_POST['checkbox'])) {
            //unset($_SESSION['dattrong']);
            // var_dump($_POST['checkbox']);
            // var_dump($_SESSION['cart_pro']);
            foreach ($_SESSION['cart_pro'] as $key => $val) {
                extract($val);
                foreach ($_POST['checkbox'] as $val2) {
                    if ($key == $val2) {
                        $_SESSION['mang_dathang'][$val2] = array( // mảng con nó sẽ lặp 2 lần và bị trùng key sẽ bị lỗi nên phải thêm key mới là $val2 để phân biệt
                            'id_pro' => $id_pro,
                            'anh_pro' => $anh_pro,
                            'title_pro' => $title_pro,
                            'price_pro' => $price_pro,
                            'quantity_pro' => $quantity_pro,
                            'sale_pro' => $sale_pro
                        );
                    }
                }
            }
            // var_dump($mang_dathang);
        } else {
            setcookie('error', "<script>alert('Bạn chưa chọn sản phẩm');</script>", time() + 48000);
            //$_SESSION['dattrong'] = "<script>alert('Bạn chưa chọn sản phẩm');</script>";
            header("location:" . CONTROLLERS_USER . "?action=card"); //chuyển trang nên phải dùng session
        }
    }
}
//------------------------------dat hang vao database---------------------
if (isset($_POST['thanhtoan_donhang'])) {
    echo "<pre>";
    var_dump($_POST);
    $name = $_POST['ten_dathang'];
    $diachi = $_POST['diachi_dathang'];
    $email = $_POST['email_dathang'];
    $phone = $_POST['phone_dathang'];
    $content = $_POST['noidung_dathang'];
    $tong = $_POST['tong_all'];
    if (empty($name) || empty($diachi) || empty($email) || empty($phone) || empty($content)) {
        setcookie('error', "<script>alert('Bạn chưa nhập đầy đủ thông tin');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=card");
    } else {
        $zero = 0;
        //them tong don hang
        $post->insert_order($tong, $phone, $email, $diachi, $name, $content);

        //tao chi tiet san pham vao mang moi 
        foreach ($_POST['id_dathang'] as $key => $val) :
            foreach ($_POST['quantity_dathang'] as $key2 => $val2) {
                if ($key == $key2) {
                    $save[$zero] = array(
                        'id' => $val,
                        'quantity' => $val2
                    );
                }
            }
            $zero++;
        endforeach;

        //lay id tong don hang vua them lam tham so truyen vao va lay cai mang moi tao them vao
        foreach ($post->id_order() as $val) :
            foreach ($save as $val2) {
                extract($val2);
                $post->insert_order_detail($quantity, $val['id'], $id);
            }
        endforeach;

        //cap nhat lai kho hang 
        foreach ($post->get_val('products') as $val) : extract($val);
            foreach ($save as $val2) {
                extract($val2);
                if ($id == $id_pro) { //so sanh 2 id roi cap nhat lai gio hang
                    $quantity_save = 0;
                    $quantity_save = $quantity_pro - $quantity;
                    $post->update_quantity($quantity_save, $id);
                    unset($_SESSION['cart_pro'][$id]);
                }
            }
        endforeach;

        if (isset($_COOKIE['id_user'])) {
            $id_user = $_COOKIE['id_user'];
            foreach ($post->id_order() as $val) :
                extract($val);
                $post->insert_histrory($id_user, $id); //phải tạo mới 1 bảng lưu lịch sử vì dùng giỏ hàng bằng session
            endforeach;
        }
        $mail1 = $mail->sendMail('Cảm ơn bạn đặt hàng tại shop BBK', $name . ' bạn đặt hàng thành công và chờ xử lý đơn hàng', $email);
        setcookie('error', "<script>alert('Bạn mua hàng thành công');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=card");
    }
}

if (isset($_POST['lichsu_sdt'])) {
    if (isset($_SESSION['phone'])) {
        unset($_SESSION['phone']);
    }

    foreach ($post->get_val('orders') as $val) {
        extract($val);
        if ($_POST['phone'] == $phone_order) {
            $save = $_POST['phone'];
            break;
        }
        //  else { 
        //     setcookie('error', "<script>alert('Số điện thoại này chưa từng đặt hàng');</script>", time() + 48000);
        //     header("location:" . CONTROLLERS_USER . "?action=lichsu");
        // }
    }

    if (!empty($save)) {
        $_SESSION['phone'] =  $save;
    } else {
        setcookie('error', "<script>alert('Số điện thoại này chưa từng đặt hàng');</script>", time() + 48000);
        header("location:" . CONTROLLERS_USER . "?action=lichsu");
    }
}

//-----------------------------------------loc-----------------------------------

if (isset($_POST['loc'])) {
    //loc hang va gia
    $mang_gia = explode('-', $_POST['price']);
    $mang_gia[1] = !empty($mang_gia[1]) ? $mang_gia[1] : 0;
    $id_cate = !empty($_POST['cate']) ? $_POST['cate'] : '';
    $save_dm = $post->loc_sp($mang_gia[0], $mang_gia[1], $id_cate);

    // lay tong so san pham dc loc theo gia va hang cho vao lam tong sp

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sp_dtb = $post->get_val('products');
    $tongsp = count($save_dm);

    $mang = phantrang($tongsp, 4, $page);
    // var_dump($mang);

    $save_dm = $post->loc_sp($mang_gia[0], $mang_gia[1], $id_cate, '', $mang['start'], $mang['sp']);
} else {
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sp_dtb = $post->get_val('products');
    $tongsp = count($sp_dtb);
    $mang = phantrang($tongsp, 4, $page);
    $save_dm = $post->loc_sp(0, 0, '', '', $mang['start'], $mang['sp']);
}

if (isset($_POST['timkiem'])) {
    $save_dm = $post->loc_sp(0, 0, '', $_POST['search']);
    // lay tong so san pham dc loc ten cho vao lam tong sp
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sp_dtb = $post->get_val('products');
    $tongsp = count($save_dm);
    $mang = phantrang($tongsp, 4, $page);
    $save_dm = $post->loc_sp(0, 0, '', $_POST['search'], $mang['start'], $mang['sp']);
}


//----------------------------------------kiểm lỗi---------------------------------------------/
if (isset($_COOKIE['error'])) {
    echo $_COOKIE['error'];
    setcookie('error', "", time() - 48000);
}
if (!empty($error['one'])) {
    echo $error['one'];
}
if (!empty($error['two'])) {
    echo $error['two'];
}
