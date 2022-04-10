<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Online_Shoping";
    $connect = new PDO("mysql:host=$host;databsename=$dbname;charset=utf8", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $create_database = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8";
    $connect->exec($create_database);

    $table_name = "item";
    $create_table = "CREATE TABLE IF NOT EXISTS $table_name(
                    item_id int not null unique AUTO_INCREMENT,
                    item_image varchar(255) not null,
                    item_title varchar(255) not null,
                    item_description varchar(255) not null,
                    item_qty int not null,
                    item_cost int not null,
                    item_price int not null,
                    item_cat TEXT not null,
                    item_discount int not null,
                    primary key(item_id));";
    $connect->exec("use $dbname");
    $connect->exec($create_table);

    $new_table_name = "item_cat";
    $create_new_table = "CREATE TABLE IF NOT EXISTS $new_table_name(
                    cat_id int not null unique AUTO_INCREMENT,
                    cat_name varchar(255) not null,
                    cat_slug varchar(255) not null,
                    primary key(cat_id));";
    $connect->exec($create_new_table);

    $create_new_table_checkout = "CREATE TABLE IF NOT EXISTS checkout(
                                    chk_id int not null unique AUTO_INCREMENT,
                                    chk_item int not null unique,
                                    chk_ref varchar(255),
                                    chk_timing datetime,
                                    primary key(chk_id)
                                    );";
    $connect->exec($create_new_table_checkout);

    $create_table_orders = "CREATE TABLE IF NOT EXISTS orders(
                            order_id int not null unique AUTO_INCREMENT,
                            order_name varchar(255) not null,
                            order_email varchar(255) not null,
                            order_contact varchar(255) not null,
                            order_state varchar(255) not null,
                            order_delivery_address varchar(255) not null,
                            order_checkout_ref int not null,
                            order_total int not null,
                            primary key(order_id));";
    $connect->exec($create_table_orders);
?>