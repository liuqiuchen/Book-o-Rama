<?php
include('book_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

@$new = $_GET['new'];

// 为购物车添加内容
if($new) {
    // new item selected
    /**
     * 如果该用户此前没有在购物车中添加任何物品，那么该用户没有一个购物车，需要为其创建一个购物车。
     * 初始状态下，购物车是空的。
     */
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['items'] = 0;
        $_SESSION['total_price'] = '0.00';
    }
    // 建立了一个购物车后，可以将物品添加到购物车内：
    if(isset($_SESSION['cart'][$new])) {
        $_SESSION['cart'][$new]++;
    } else {
        $_SESSION['cart'][$new] = 1;
    }
    $_SESSION['total_price'] = calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
}

// 保存更新后的购物车
if(isset($_POST['save'])) {
    foreach($_SESSION['cart'] as $isbn =>$qty) {
        /**
         * 如果任何一个域设置为0，我们将使用unset()函数将购物车中该物品完全删除。
         * 否则，更新该购物车，使之与该表单域匹配。
         */
        if($_POST[$isbn] == '0') {
            unset($_SESSION['cart'][$isbn]);
        } else {
            $_SESSION['cart'][$isbn] = $_POST[$isbn];
        }
    }
    $_SESSION['total_price'] = calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
}

// 显示购物车
do_html_header('Your shopping cart');
echo '<br/>';

// PHP4, PHP5, PHP7, array_count_values - 统计数组中所有的值
if(@$_SESSION['cart'] && array_count_values($_SESSION['cart'])) {
    if(isset($_POST['save'])) {
        display_cart($_SESSION['cart'], false, 0);
    } else {
        display_cart($_SESSION['cart'], true, 0);
    }
} else {
    echo "<p>There are no items in your cart</p><hr>";
}

$target = 'index.php';

// if we have just added an item to the cart, continue shopping in that category
if($new) {
    $details = get_book_details($new);
    if($details['catid']) {
        $target = 'show_cat.php?catid='.$details['catid'];
    }
}
display_button($target, 'continue-shopping', 'Continue Shopping');
display_button('checkout.php', 'go-to-checkout', 'Go To Checkout');

do_html_footer();

