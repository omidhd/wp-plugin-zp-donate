<?php
/*
 * a class for create Tables
 * create a object and use two args for it
 * arg one: table name
 * arg two: table items
 * notice: $cells is a string
 * such as follow example:
 * $cells =
    '`id` INT NOT NULL AUTO_INCREMENT ,
    `branch_id` INT NULL ,
    `user_id` INT(50) NOT NULL ,
    `status` VARCHAR(10) NOT NULL,
    `rand_code` BIGINT NOT NULL,
    `b_modify_date` DATETIME NULL ,
    PRIMARY KEY (`id`)';
    $uppay_tables = new Uppay_tables('table_one', $cells);
 */
class Zp_tables
{
    public $table;
    public $cells = [];

    // Get table name and all cells for create table in databse
    public function __construct($table, $cells)
    {
        $this->table = $table;
        $this->cells = explode(",", $cells);

        add_action('init', array(&$this, 'uppay_create_table'));
    }

    // Create table in database
    public function uppay_create_table()
    {
        global $wpdb;
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        $table_name = $wpdb->prefix.$this->table;
        if($wpdb->get_var("SHOW TABLES LIKE '.$table_name.' ") != $table_name) {

            $create_table = " CREATE TABLE {$table_name} (
                ". implode(",", $this->cells) ."
                ) ENGINE = InnoDB COLLATE = utf8_general_ci ";
            dbDelta($create_table);
        }
    }

    // Create Select command for get result from database
    static public function select_get_results($cell, $table, $condition ='')
    {
        global $wpdb;
        $Select = $wpdb->get_results("SELECT {$cell} FROM {$table} ".$condition);
        return $Select;
    }

    // Create Delete command to clear the data on tables
    static public function delete($table, $condition)
    {
        global $wpdb;
        $Delete = $wpdb->query("DELETE FROM {$table} ".$condition);
        return $Delete;
    }

    // if was an error in SQL syntax display it
    static public function last_error()
    {
        global $wpdb;
        if($wpdb->last_error){
            var_dump($wpdb->last_error);
        }
    }
}