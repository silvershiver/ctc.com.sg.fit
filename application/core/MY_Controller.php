<?php
class MY_Controller extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        // Assuming that you have loaded all required library in autoload
        $result = $this->db->get('gta_settings');
        $app_conf = $result->result_array();
        foreach( $app_conf as $row )
        {
            defined("{$row['name']}") or define("{$row['name']}", $row['value']);
        }
    }
}