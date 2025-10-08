<?php
//cookie
//-------------------------bien luu ca 2 truong hop---------------------------
if (isset($_COOKIE['id_admin'])) {
    $id = $_COOKIE['id_admin'];
}
if (isset($_COOKIE['id_user'])) {
    $id = $_COOKIE['id_user'];
}

define("IMAGE", "../public/img/");
define("CONTROLLERS_USER", "../controllers/user.php");
define("CONTROLLERS_ADMIN", "../controllers/admin.php");
define("GET", "../controllers/get.php");

include_once "../models/database.php";
include_once "../mail/index.php";

class xuly extends database
{
    public function delete($table, $name_id, $id, $nameid_2 = '', $id_2 = '')
    {
        $sql = "DELETE FROM `$table` WHERE `$name_id` = $id";
        if ($nameid_2 != '' && $id_2 != '') {
            $sql .= " OR `$nameid_2` = $id_2";
        }
        $this->execute($sql);
    }
    public function select_product()
    {
        $sql = "SELECT * FROM `products` WHERE `quantity_pro` > 0  ORDER BY `date_pro` DESC  LIMIT 0,8";
        $gan = $this->select($sql);
        return $gan;
    }

    public function new_product($id)
    {
        $sql = "SELECT * FROM `products` WHERE NOT `id_pro` = $id ORDER BY `date_pro` DESC LIMIT 0,8";
        $gan = $this->select($sql);
        return $gan;
    }
    public function get_val($table)
    {
        $sql = "SELECT * FROM `$table` WHERE 1";
        $gan = $this->select($sql);
        return $gan;
    }
    public function get_val_id($table, $name_id, $id)
    {
        $sql = "SELECT * FROM `$table` WHERE $name_id = $id";
        $gan = $this->select($sql);
        return $gan;
    }
    public function get_val_join($table1, $table2, $join1, $join2)
    {
        $sql = "SELECT * FROM `$table1` JOIN $table2 ON $join1 = $join2 WHERE 1";
        $gan = $this->select($sql);
        return $gan;
    }
    public function get_val_id_join($id_name, $id, $table1, $table2, $join1, $join2)
    {
        $sql = "SELECT * FROM `$table1` JOIN $table2 ON $join1 = $join2 WHERE $id_name = $id";
        $gan = $this->select($sql);
        return $gan;
    }
    public function insert_user($email, $phone, $name, $adress, $pass, $avatar)
    {
        $sql = "INSERT INTO `users`(`email`, `phone`, `name`, `adress`, `pass`, `avatar`) VALUES
         ('$email','$phone','$name','$adress','$pass','$avatar')";
        $this->execute($sql);
    }
    public function insert_cate($name, $parent)
    {
        $sql = "INSERT INTO `cates`(`name_cate`, `parent_cate`) VALUES ('$name','$parent')";
        $this->execute($sql);
    }
    public function update_cate($name_cate, $parent, $id_cate)
    {
        $sql = "UPDATE `cates` SET `name_cate`='$name_cate',`parent_cate`='$parent' WHERE `id_cate` = $id_cate";
        $this->execute($sql);
    }
    public function insert_product($title, $content, $thongtin, $image, $quantity, $price, $sale, $special, $cate_id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `products`( `title_pro`, `content_pro`, `thongtin`, `image_pro`, `quantity_pro`,
         `price_pro`, `sale_pro`, `date_pro`, `special_pro`, `cate_id`) VALUES ('$title','$content','$thongtin','$image','$quantity',
         '$price','$sale','$date','$special','$cate_id')";
        $this->execute($sql);
    }
    // public function insert_atribute($color,$size,$number,$pro)
    // {
    //     $sql = "INSERT INTO `attributes`(`color`, `size`,`number_atri`,`pro_id`) VALUES ('$color','$size','$number','$pro')";
    //     $this->execute($sql);
    // }
    // public function update_atribute($color,$size,$number,$id_atri)
    // {
    //     $sql = " UPDATE `attributes` SET `color`='$color'
    //     ,`size`='$size',`number_atri`='$number'
    //      WHERE `id_attri` = $id_atri";
    //     $this->execute($sql);
    // }

    // public function max_id_pro()
    // {
    //     $sql = "SELECT MAX(`id_pro`) as 'id_pro' FROM `products` WHERE 1";
    //     $gan = $this->select($sql);
    //     return $gan;
    // }

    public function update_product($id_name, $id, $title, $content, $thongtin, $image, $quantity, $price, $sale, $special, $hiden, $cate_id)
    {
        $sql = "UPDATE `products` SET `title_pro`='$title',`content_pro`='$content',`thongtin`='$thongtin',`image_pro`='$image',
        `quantity_pro`='$quantity',`price_pro`='$price',`sale_pro`='$sale',`special_pro`='$special',`hiden_pro`='$hiden',
        `cate_id`='$cate_id' WHERE $id_name = $id";
        $this->execute($sql);
    }
    public function insert_comment($content, $id_pro, $id_user, $parent)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `comments`( `content_cm`, `product_id`, `user_id`, `date`, `parent_cm`) 
        VALUES ('$content','$id_pro','$id_user','$date','$parent')";
        $this->execute($sql);
    }

    public function update_view($view, $id_pro)
    {
        $sql = "UPDATE `products` SET `view_pro`='$view' WHERE `id_pro` = $id_pro";
        $this->execute($sql);
    }
    public function insert_loves($id_pro, $id_user)
    {
        $sql = "INSERT INTO `loves`(`pro_id`, `user_id`) VALUES ('$id_pro','$id_user')";
        $this->execute($sql);
    }
    public function check_loves($id_pro, $id_user)
    {
        $sql = "SELECT * FROM `loves` 
        JOIN users ON users.id_user = loves.user_id
        JOIN products ON products.id_pro = loves.pro_id
        WHERE users.id_user = $id_user AND products.id_pro = $id_pro ";
        $gan = $this->select($sql);
        return $gan;
    }

    public function insert_banner($image, $title, $id_pro)
    {
        $sql = "INSERT INTO `banners`(`image_banner`, `title_banner`, `id_product`) VALUES ('$image','$title','$id_pro')";
        $this->execute($sql);
    }
    public function insert_album($image, $id_pro)
    {
        $sql = "INSERT INTO `albums`( `image_album`, `id_product`) VALUES ('$image','$id_pro')";
        $this->execute($sql);
    }
    public function insert_info($email, $logo, $phone, $adress, $content)
    {
        $sql = "INSERT INTO `info`(`email_info`, `logo`, `phone_info`, `adress_info`, `thongtin`) VALUES ('$email','$logo','$phone','$adress','$content')";
        $this->execute($sql);
    }
    public function update_user($phone, $name, $adress, $avatar, $id)
    {
        $sql = "UPDATE `users` SET `phone`='$phone',`name`='$name',`adress`='$adress',`avatar`='$avatar' WHERE `id_user` = $id";
        $this->execute($sql);
    }
    public function update_ma_code($id, $code)
    {
        $sql = "UPDATE `users` SET `code_mk`='$code' WHERE `id_user` = $id";
        $this->execute($sql);
    }
    public function update_mk($pass, $id, $code_mk = '', $code = '')
    {
        $sql = "UPDATE `users` SET `pass`='$pass' WHERE `id_user` = $id";
        if (!empty($code_mk) && !empty($code)) {
            $sql .= " AND `$code_mk` = '$code'";
        }
        $this->execute($sql);
    }
    public function update_nhanvien($email, $phone, $name, $address, $pass, $avatar, $role, $look, $id)
    {
        $sql = "UPDATE `users` SET `email`='$email',`phone`='$phone',`name`='$name',`adress`='$address',`pass`='$pass',`avatar`='$avatar',`role`='$role',`look`='$look' WHERE `id_user` = $id";
        $this->execute($sql);
    }
    //----------------------đơn hàng và chi tiết đơn hàng----------------------------
    public function select_order($action = "")
    {
        $sql = "SELECT * FROM `orders`";
        if($action != ""){
            $sql .= " WHERE `action` = $action ORDER BY `date_order` DESC";
        }else{
            $sql .=" ORDER BY `date_order` DESC";
        }
        $gan = $this->select($sql);
        return $gan;
    }
    public function select_order_date()
    {
        $sql = "SELECT * FROM `orders` WHERE `action` = 2 ORDER BY `date_order` DESC ";
        $gan = $this->select($sql);
        return $gan;
    }
    public function insert_order($tong, $phone, $email, $adress, $name, $content)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `orders`(`total_order`, `phone_order`, `email_order`, `adress_order`, `name_order`, `content_order`, `date_order`) VALUES ('$tong','$phone','$email','$adress','$name','$content','$date')";
        $this->execute($sql);
    }
    public function insert_order_detail($quantity, $order_id, $pro_id)
    {
        $sql = "INSERT INTO `order_detail`( `quantity_detail`, `order_id`, `product_id`) VALUES ('$quantity','$order_id','$pro_id')";
        $this->execute($sql);
    }
    public function update_quantity($quantity, $id)
    {
        $sql = "UPDATE `products` SET `quantity_pro`='$quantity' WHERE `id_pro` = $id";
        $this->execute($sql);
    }
    public function id_order()
    {
        $sql = "SELECT MAX(`id_order`) as 'id' FROM `orders` WHERE 1";
        $gan = $this->select($sql);
        return $gan;
    }
    public function insert_histrory($id_user, $id_order)
    {
        $sql = "INSERT INTO `histrorys`(`id_user`, `id_order`) VALUES ('$id_user','$id_order')";
        $this->execute($sql);
    }
    public function get_histrory($id_user)
    {
        $sql = "SELECT * FROM `histrorys` JOIN users ON users.id_user = histrorys.id_user
        JOIN orders ON orders.id_order = histrorys.id_order WHERE users.id_user = $id_user";
        $gan = $this->select($sql);
        return $gan;
    }
    public function gui_dh($action, $id)
    {
        $sql = "UPDATE `orders` SET `action`='$action' WHERE `id_order` = $id";
        $this->execute($sql);
    }
    public function select_love_join()
    {
        $sql = "SELECT*FROM `loves` 
        JOIN products ON products.id_pro = loves.pro_id  
        JOIN users ON users.id_user = loves.user_id ";
        $gan = $this->select($sql);
        return $gan;
    }
    public function insert_news($title, $content, $image, $author)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $day = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `news`( `title`, `content`, `image`, `date`, `author`) 
        VALUES ('$title','$content','$image','$day','$author')";
        $this->execute($sql);
    }
    public function update_news($id, $title, $content, $image, $author)
    {
        $sql = "UPDATE `news` SET `title`='$title',`content`='$content',`image`='$image'
        ,`author`='$author' WHERE `id_news` = $id";
        $this->execute($sql);
    }
    //-----------------------------------thong ke cm---------------------
    public function thongke_cm()
    {
        $sql = "SELECT products.id_pro AS 'id_pro',products.title_pro AS 'ten_pro',COUNT(comments.id_cm) AS 'so_cm',MAX(comments.date) AS 'max_bl',MIN(comments.date) AS 'min_bl' 
        FROM `comments` 
        JOIN users ON comments.user_id = users.id_user
        JOIN products ON products.id_pro = comments.product_id 
        GROUP BY products.id_pro";
        $gan = $this->select($sql);
        return $gan;
    }
    public function thongke_cm_chitiet($id)
    {
        $sql = "SELECT comments.id_cm AS 'id',users.name AS 'name_bl', comments.content_cm AS 'content', comments.date AS 'date'  FROM `comments` 
        JOIN users ON comments.user_id = users.id_user
        JOIN products ON products.id_pro = comments.product_id 
        WHERE products.id_pro = $id";
        $gan = $this->select($sql);
        return $gan;
    }
    //-----------------------------------hien thi don hang---------------------
    public function thongke_order_detail($id)
    {
        $sql = "SELECT * FROM `order_detail` 
        JOIN products ON products.id_pro = order_detail.product_id
        WHERE order_detail.`order_id` = $id";
        $gan = $this->select($sql);
        return $gan;
    }

    //------------------------------------so hang ban duoc-----------------------
    public function thongke_buy_pro()
    {
        $sql = "SELECT products.title_pro AS 'tensp',SUM(order_detail.quantity_detail) AS 'soct_theosp',
        products.price_pro AS 'gia' ,products.sale_pro AS 'sale'
        FROM `orders` 
        JOIN order_detail ON orders.id_order = order_detail.order_id
        JOIN products ON products.id_pro = order_detail.product_id WHERE orders.`action` = 2 GROUP BY products.id_pro";
        $gan = $this->select($sql);
        return $gan;
    }
    public function banchay()
    {
        $sql = "SELECT products.title_pro AS 'name',SUM(order_detail.quantity_detail) AS 'banchay' ,products.image_pro as 'image'
        FROM `orders` 
        JOIN order_detail ON orders.id_order = order_detail.order_id
        JOIN products ON products.id_pro = order_detail.product_id WHERE orders.`action` = 2 GROUP BY products.id_pro
        ORDER BY order_detail.quantity_detail DESC LIMIT 1";
        $gan = $this->select($sql);
        return $gan;
    }
    public function view_thongke()
    {
        $sql = "SELECT sum(`view_pro`) AS 'view' FROM `products` WHERE 1";
        $gan = $this->select($sql);
        return $gan;
    }
    public function ngay_thongke($thang)
    {
        $sql = "SELECT * FROM orders WHERE action = 2 AND MONTH(date_order)='$thang'";
        $gan = $this->select($sql);
        return $gan;
    }

    //-----------------------------------loc------------------------------
    public function loc_sp($start = 0, $end = 0, $id_cate = '', $search = '', $one = '', $two = '')
    {
        //ham loc nay bat buoc phai co tham so truyen day du tham so cuoi k can cung dc
        $sql = "SELECT * FROM `products` JOIN cates ON cates.id_cate = products.cate_id
        WHERE 1";
        if ($id_cate != '') {
            $sql .= " AND products.cate_id = $id_cate";
        }
        if ($start != 0 && $end != 0) {
            $sql .= " AND products.price_pro BETWEEN $start AND $end";
        } else if ($start != 0) {
            $sql .= " AND products.price_pro > $start";
        }
        if ($search != '') {
            $sql .= " AND products.title_pro LIKE '%$search%'";
        }
        if ($one != '' && $two != '') {
            $sql .= " LIMIT $one,$two";
        }


        $gan = $this->select($sql);
        return $gan;
    }
}
$error = array();
$post = new xuly();
$mail = new Mailer();
//--------------------------loc------------------------------------
function phantrang($tongsp, $sp, $page)
{

    $start = ($page - 1) * $sp; //0-4
    $sum_page = ceil($tongsp / $sp);
    $mang = array(
        'start' => $start,
        'tong_page' => $sum_page,
        'sp' => $sp
    );

    return $mang;
}



//var_dump($post->loc_sp(0,0,null));
