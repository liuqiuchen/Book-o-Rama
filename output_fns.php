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





























