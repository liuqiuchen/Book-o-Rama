<?php

function do_html_header($title = '')
{
    if (!$_SESSION['items']) {
        $_SESSION['items'] = '0';
    }
    if (!$_SESSION['total_price']) {
        $_SESSION['total_price'] = '0.00';
    }

    ?>
    <html>
    <head>
        <title><?php echo $title; ?></title>
        <style>
            h2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 22px;
                color: red;
                margin: 6px;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
            }

            li, td {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
            }

            hr {
                color: #FF0000;
                width = 70%;
                text-align = center;
            }

            a {
                color: #000000;
            }
        </style>
    </head>
    <body>
    <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td rowspan="2">
                <a href="index.php"><img src="images/Book-O-Rama.gif" alt="Bookorama" border="0" align="left"
                                         valign="bottom" height="55" width="325"></a>
            </td>
            <td align="right" valign="bottom">
                <?php
                if (isset($_SESSION['admin_user'])) {
                    display_button('logout.php', 'log-out', 'Log Out');
                } else {
                    display_button('show_cart.php', 'view_cart', 'View Your Shopping Cart');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                <?php
                if(isset($_SESSION['admin_user'])) {
                    echo "&nbsp;";
                } else {
                    echo "Total Price = $".number_format($_SESSION['total_price'], 2);
                }
                ?>
            </td>
        </tr>
    </table>
    <?php
    if($title) {
        do_html_heading($title);
    }
}

function do_html_footer() {
    ?>
    </body>
    </html>
    <?php
}

function do_html_heading($heading) {
    ?>
    <h2><?php echo $heading; ?></h2>
    <?php
}

function do_html_url($url, $name) {
    ?>
    <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br>
    <?php
}

function display_categories($cat_array) {
    if(!is_array($cat_array)) {
        echo '<p>No categories currently available.</p>';
        return;
    }
    echo '<ul>';
    foreach($cat_array as $row) {
        $url = 'show_cat.php?catid='.$row['catid'];
        $title = $row['catname'];
        echo '<li>';
        do_html_url($url, $title);
        echo '</li>';
    }
    echo '</ul>';
    echo '<hr/>';
}

function display_books($book_array) {
    if(!is_array($book_array)) {
        echo '<p>No books currently available in this category</p>';
    } else {
        // create table
        echo "<table width='100%' border='0'>";

        foreach($book_array as $row) {
            $url = 'show_book.php?isbn='.$row['isbn'];
            echo '<tr><td>';
            if(@file_exists('images/'.$row['isbn'].'.jpg')) {
                $title = "<img src='images/'".$row['isbn']."'.jpg' style='border: 1px solid black'/>";
                do_html_url($url, $title);
            } else {
                echo "&nbsp;";
            }
            echo '</td><td>';
            $title = $row['title'].'by'.$row['author'];
            do_html_url($url, $title);
            echo '</td></tr>';
        }
    }
}

function display_book_details($book) {
    // display all details about this book
    if(is_array($book)) {
       echo '<table><tr>';
       // display the picture if there is one
        if(@file_exists('images/'.$book['isbn'].'.jpg')) {
            $size = GetImageSize('images/'.$book['isbn'].'.jpg');
            if(($size[0] > 0) && ($size[1] > 0)) {
                echo "<td><img src='images/'".$book['isbn']."'.jpg' style='border: 1px solid black'/></td>";
            }
        }
        echo '<td><ul>';
        echo '<li><strong>Author: </strong>';
        echo $book['author'];
        echo '</li><li><strong>ISBN: </strong>';
        echo $book['isbn'];
        echo '</li><li><strong>Our Price: </strong>';
        echo number_format($book['price'], 2);
        echo '</li><li><strong>Description</strong>';
        echo $book['description'];
        echo '</li></ul></td></tr></table>';
    } else {
        echo '<p>The details of this book cannot be displayed at this time.</p>';
    }
    echo '<hr/>';
}

function display_checkout_form() {
    // display the form that asks for name and address
    ?>
    <br>
    <table border="0" width="100%" cellspacing="0">
        <form action="purchase.php" method="post">
            <tr>
                <th colspan="2" bgcolor="#cccccc">Your Details</th>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input type="text" name="address" value="" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td>City/Suburb</td>
                <td><input type="text" name="city" value="" maxlength="20" size="40"></td>
            </tr>
            <tr>
                <td>State/Province</td>
                <td><input type="text" name="state" value="" maxlength="20" size="40"></td>
            </tr>
            <tr>
                <td>Postal Code or Zip Code</td>
                <td><input type="text" name="zip" value="" maxlength="10" size="40"></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type="text" name="country" value="" maxlength="20" size="40"></td>
            </tr>
            <tr><th colspan="2" bgcolor="#cccccc">Shipping Address (leave blank if as above)</th></tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="ship_name" value="" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input type="text" name="ship_address" value="" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td>City/Suburb</td>
                <td><input type="text" name="ship_city" value="" maxlength="20" size="40"></td>
            </tr>
            <tr>
                <td>State/Province</td>
                <td><input type="text" name="ship_state" value="" maxlength="20" size="40"></td>
            </tr>
            <tr>
                <td>Postal Code or Zip Code</td>
                <td><input type="text" name="ship_zip" value="" maxlength="10" size="40"></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type="text" name="ship_country" value="" maxlength="20" size="40"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items.</strong></p>
                    <?php display_form_button('purchase', 'Purchase These Items') ?>
                </td>
            </tr>
        </form>
    </table>
    <hr>
    <?php
}

function display_shipping($shipping) {
    // display table row with shipping cost and total price including shipping
    ?>
    <table border="0" width="100%" cellspacing="0">
        <tr>
            <td align="left">Shipping</td>
            <td align="right"><?php echo number_format($shipping, 2); ?></td>
        </tr>
        <tr>
            <th bgcolor="#cccccc" align="left">Total including shipping</th>
            <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
        </tr>
    </table><br>
    <?php
}

function display_card_form($name) {
    // display form asking for credit card details
    ?>
    <table border="0" width="100%" cellspacing="0">
        <form action="process.php" method="post">
            <tr>
                <th colspan="2" bgcolor="#cccccc">Credit Card Details</th>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="card_type" id="">
                        <option value="VISA">VISA</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="American Express">American Express</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Number</td>
                <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
            </tr>
            <tr>
                <td>AMEX code (if required)</td>
                <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
            </tr>
            <tr>
                <td>Expiry Date</td>
                <td>Month
                    <select name="card_month" id="">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    Year
                    <select name="card_year" id="">
                        <?php
                        for($y = date('Y'); $y < date('Y') + 10;$y++) {
                            echo "<option value='".$y."'>".$y."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name on Card</td>
                <!-- 观察后续代码的$name -->
                <td><input type="text" name="card_name" value="<?php echo $name;?>" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
                        add or remove items.</strong></p>
                    <?php display_form_button('purchase', 'Purchase These Items'); ?>
                </td>
            </tr>
        </form>
    </table>
    <?php
}

function display_cart($cart, $change = true, $images=1) {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)
    echo "<table border='0' width='100%' cellspacing='0'>
<form action='show_cart.php' method='post'>
<tr>
    <th colspan='".(1 + $images)."' bgcolor='#cccccc'>Item</th>
    <th bgcolor='#cccccc'>Price</th>
    <th bgcolor='#cccccc'>Quantity</th>
    <th bgcolor='#cccccc'>Total</th>
</tr>";

    // display each item as a table row
    foreach($cart as $isbn => $qty) {
        $book = get_book_details($isbn);
        echo '<tr>';
        if($images == true) {

        }
    }
}

