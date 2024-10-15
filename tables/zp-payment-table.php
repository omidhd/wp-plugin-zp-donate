<?php
/*
 * require class file
 * create a const from table name
 * write cells for table
 * create new object from Zp_tables
 */
require_once ZP_PATHBASE .'/tables/table-class.php';
global $wpdb;
define('PAYMENT_DONATE_TABLE', $wpdb->prefix.'payment_donate_table');

$cells =
    '`id` INT NOT NULL AUTO_INCREMENT ,
    `user_id` INT(50) NOT NULL ,
    `v_amount` VARCHAR(300) NOT NULL ,
    `v_phone` VARCHAR(11) NOT NULL ,
    `v_name` VARCHAR(300) NOT NULL ,
    `v_subject` VARCHAR(300) NOT NULL ,
    `v_authority` TEXT NOT NULL ,
    `v_refid` TEXT NOT NULL ,
    `v_date` DATE NOT NULL ,
    `v_time` TIME NOT NULL ,
    `status` INT(1) NOT NULL ,
    PRIMARY KEY (`id`)';
$donate_tables = new Zp_tables(PAYMENT_DONATE_TABLE, $cells);
