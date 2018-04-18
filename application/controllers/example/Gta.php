<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gta extends CI_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function responseBooking()
    {
        //header('Content-Type: text/event-stream'); //indicates that server is aware of server sent events
        //header('Cache-Control: no-cache');//disable caching of response
        header('Content-Type: application/html');
    }

    function checkResponseRef()
    {
        /* https://rbs.gta-travel.com/rbsrsapi/RetrieveListenerServlet?TOKEN=REF_P_013_16618-574362-527485130772112 */
    }
}