<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@ini_set("output_buffering", "Off");
@ini_set('implicit_flush', 1);
@ini_set('zlib.output_compression', 0);

require_once APPPATH.'libraries/XMLTransactionHander.class.php';

class Hotels2 extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function checkHotelItem($city_code='')
    {
        if($city_code == "")
            echo die('Nope!');

        $itemInformationReq="";
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';

        $itemInformationReq .= '<SearchItemRequest ItemType="hotel"><ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" /></SearchItemRequest>';
        $requestData .= $itemInformationReq;
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $parseResult            = simplexml_load_string($output);
        /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

        $array1 = json_decode(json_encode((array) $parseResult), 1);
        $array1 = array($parseResult->getName() => $array1);

        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
        //$array_output[]       = json_decode(json_encode($parseResult), true);

        $array = json_decode(json_encode((array) $parseResult), 1);
        $array = array($parseResult->getName() => $array);
        echo '<pre>';
        var_dump($array);
        var_dump($array1);
        die();
    }
    public function getGTAHotelItem()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            /* est time for looping city : 0.0003 s */
            $countryCode = trim($this->input->post('country_code'));

            $this->db->select('city_code, country_code');
            if ($countryCode !='-')
                $this->db->where_in('country_code', $countryCode);
            /*$this->db->join('tb_country', 'tb_country.country_code=tb_countrycity.country_code');
            $this->db->where('tb_country.done_proceed_item', 0);*/
            //$this->db->limit(30); // per 30 country in a go
            $this->db->where('done', 0);
            $this->db->order_by('city_id', 'asc');

            $qry = $this->db->get('tb_countrycity');

            $cityArr = array();
            if($qry->num_rows() > 0) {
                $time_start = microtime(true);
                foreach ($qry->result() as $data_city) {
                    # code...
                    $cityArr[] = $data_city->city_code;
                }
                $time_end = microtime(true);
                $time = $time_end - $time_start;

                echo 'Time for Looping City : '.$time.'<br>';
            } else if ($countryCode != '-') {
                $this->db->set('nodatacity', 1);
                $this->db->set('done_proceed_item', 1);
                $this->db->where('country_code', $countryCode);
                $this->db->update('country');

                $this->session->set_flashdata('nodata', 'No Data');
                redirect('static_data/Hotels2/getGTAHotelItem');
            }

            if(count($cityArr)) {
                $arrDataHotelItem = array();
                $arrDataHotelInformation = array();
                $array_output = array();
                $array_output_tag = array();
                $start = 0; $end = 10;
                $stillLoop = true;

                $time_start = microtime(true);
                foreach ($qry->result() as $data_city) {


                //while($stillLoop) {
                //for ($start; $start < $end; $start++) {
                //        if(empty($cityArr[$start])) {
                //            $stillLoop = false;
                //            break;
                //        }
                        $city_code = $data_city->city_code;
                        $countryCode = $data_city->country_code;

                        $itemInformationReq="";
                        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                        $requestData .= '<Request>';
                        $requestData .=     '<Source>';
                        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                        $requestData .=         '</RequestorPreferences>';
                        $requestData .=     '</Source>';
                        $requestData .=     '<RequestDetails>';

                        $itemInformationReq .= '<SearchItemRequest ItemType="hotel"><ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" /></SearchItemRequest>';
                        $requestData .= $itemInformationReq;
                        $requestData .=     '</RequestDetails>';
                        $requestData .= '</Request>';
                        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                        $output = curl_exec($ch);
                        $info = curl_getinfo($ch);

                        curl_close($ch);

                        $parseResult            = simplexml_load_string($output);
                        /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

                        $array1 = json_decode(json_encode((array) $parseResult), 1);
                        $array1 = array($parseResult->getName() => $array1);

                        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                        //$array_output[]       = json_decode(json_encode($parseResult), true);

                        $array = json_decode(json_encode((array) $parseResult), 1);
                        $array = array($parseResult->getName() => $array);

                        if(count($array1)) {
                            foreach ($array1 as $idxArr => $arrTag) {
                                if (!empty($arrTag['ResponseDetails'])) {
                                    if (!empty($arrTag['ResponseDetails']['SearchItemResponse'])) {
                                        if(!empty($arrTag['ResponseDetails']['SearchItemResponse']['ItemDetails']['ItemDetail'])) {
                                            $itemList = $arrTag['ResponseDetails']['SearchItemResponse']['ItemDetails']['ItemDetail'];
                                            $itemOutput = $array[$idxArr]['ResponseDetails']['SearchItemResponse']['ItemDetails']['ItemDetail'];

                                            if(isset($itemList[0])) {
                                                foreach ($itemList as $idx_item => $itemData) {
                                                    if ( $idx_item=='Item' && isset($itemData['Item']) && !empty($itemData['Item'])) {
                                                        $itemCode = $itemData['Item']['@attributes']['Code'];
                                                        $itemName = $itemOutput[$idx_item]['Item'];
                                                        $cityName = $itemOutput[$idx_item]['City'];

                                                        $locationText = "- ";

                                                        if (!empty($itemData['LocationDetails'])) {
                                                            if (!empty($itemData['LocationDetails']['Location']) && array_key_exists('0', $itemData['LocationDetails']['Location'])) {
                                                                foreach ($itemData['LocationDetails']['Location'] as $idx_loc=>$loc) {
                                                                    $locationText .= $itemOutput[$idx_item]['LocationDetails']['Location'][$idx_loc]." (".$loc['@attributes']['Code'].") - ";
                                                                }
                                                            } else if (!empty($itemData['LocationDetails']['Location'])) {
                                                                $locationText = $itemOutput[$idx_item]['LocationDetails']['Location']." (".$itemData['LocationDetails']['Location']['@attributes']['Code'].") - ";
                                                            } else {
                                                                $locationText = "- ";
                                                            }
                                                        }

                                                        $locationText = trim($locationText, "- ");

                                                        /*$arrDataHotelItem[] = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));*/
                                                        $arrDataHotelItem = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));

                                                        $this->db->insert('hotel_gta_item', $arrDataHotelItem);

                                                        //$arrDataHotelInformation[] = array(
                                                        $arrDataHotelInformation = array(
                                                            'city_code' => $city_code,
                                                            'city_content'=> $cityName,
                                                            'item_code'=> $itemCode,
                                                            'item_content'=> $itemName,

                                                            'location_text' => $locationText,
                                                            /*'star_rating' => $star_rating,
                                                            'website' => $website,
                                                            'category' => $category,
                                                            'telephone' => $phone,
                                                            'fax' => $fax,
                                                            'email_address' => $email,
                                                            'geo_latitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Latitude'],
                                                            'geo_longitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Longitude'],*/
                                                            'modified' => date('Y-m-d H:i:s'));

                                                        // $this->db->insert('hotel_gta_item_information', $arrDataHotelInformation);
                                                    }
                                                }
                                            } else {
                                                $itemCode = $itemList['Item']['@attributes']['Code'];
                                                $itemName = $itemOutput['Item'];
                                                $cityName = $itemOutput['City'];

                                                $locationText = "- ";

                                                if (!empty($itemList['LocationDetails'])) {
                                                    if (!empty($itemList['LocationDetails']['Location']) && array_key_exists('0', $itemList['LocationDetails']['Location'])) {
                                                        foreach ($itemList['LocationDetails']['Location'] as $idx_loc=>$loc) {
                                                            $locationText .= $itemOutput['LocationDetails']['Location'][$idx_loc]." (".$loc['@attributes']['Code'].") - ";
                                                        }
                                                    } else if (!empty($itemList['LocationDetails']['Location'])) {
                                                        $locationText = $itemOutput['LocationDetails']['Location']." (".$itemList['LocationDetails']['Location']['@attributes']['Code'].") - ";
                                                    } else {
                                                        $locationText = "- ";
                                                    }
                                                }

                                                $locationText = trim($locationText, "- ");

                                                /*$arrDataHotelItem[] = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));*/
                                                $arrDataHotelItem = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));

                                                $this->db->insert('hotel_gta_item', $arrDataHotelItem);

                                                //$arrDataHotelInformation[] = array(
                                                $arrDataHotelInformation = array(
                                                    'city_code' => $city_code,
                                                    'city_content'=> $cityName,
                                                    'item_code'=> $itemCode,
                                                    'item_content'=> $itemName,

                                                    'location_text' => $locationText,
                                                    /*'star_rating' => $star_rating,
                                                    'website' => $website,
                                                    'category' => $category,
                                                    'telephone' => $phone,
                                                    'fax' => $fax,
                                                    'email_address' => $email,
                                                    'geo_latitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Latitude'],
                                                    'geo_longitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Longitude'],*/
                                                    'modified' => date('Y-m-d H:i:s'));

                                                // $this->db->insert('hotel_gta_item_information', $arrDataHotelInformation);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    //}
                    //$end+= 10;
                    $this->db->set('done', 1);
                    $this->db->where('city_code', $city_code);
                    $this->db->update('tb_countrycity');

                }

                $time_end = microtime(true);
                $time = $time_end - $time_start;

                echo 'Time for Looping Output Array : '.$time.'<br>';

                if(count($arrDataHotelItem)) {
                    //$this->db->insert_batch('tb_hotel_gta_item', $arrDataHotelItem);
                    //$this->db->insert_batch('tb_hotel_gta_item_information', $arrDataHotelInformation);
                } else {
                    //$this->db->set('nodatacity', 1);
                    //$this->db->set('done_proceed_item', 1);
                    /*$this->db->where('country_code', $countryCode);
                    $this->db->update('tb_country');*/
                }
            } else {

                $this->db->set('done_proceed_item', 1);
                $this->db->set('nodatacity', 1);
                $this->db->where('country_code', $countryCode);
                $this->db->update('country');
            }


            redirect('static_data/Hotels2/getGTAHotelItem');
        } else {
            $data['showOffCountry1'] = '1';
            $data['actionurl'] = base_url().'static_data/Hotels2/getGTAHotelItem';
            $this->load->view('static_data/country_filter', $data);
        }
    }

    public function testGTACityItem($city_code='')
    {
        if($city_code == '') {
            die('no data');
        }
        $city_code = $city_code;

        $itemInformationReq="";
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';

        $itemInformationReq .= '<SearchItemRequest ItemType="hotel"><ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" /></SearchItemRequest>';
        $requestData .= $itemInformationReq;
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $parseResult            = simplexml_load_string($output);
        /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

        $array1 = json_decode(json_encode((array) $parseResult), 1);
        $array1 = array($parseResult->getName() => $array1);

        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
        //$array_output[]       = json_decode(json_encode($parseResult), true);

        $array = json_decode(json_encode((array) $parseResult), 1);
        $array = array($parseResult->getName() => $array);
        echo '<pre>';
        var_dump($array);
        var_dump($array1);
        die();
    }

    public function getGTAHotelItemInfo()
    {
        /*$item_code_arr = array('BAD'); //this one really no data?*/
        $time_start = microtime(true);
        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE id > 61152 order by id asc");

        if ($qry->num_rows()) {
            $nodataCityItemCode = "";
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {

            //foreach ($item_code_arr as $item_code) {
                /* est time for looping city : 0.0003 s */
                //$countryCode = 'PH';
                $city_code = $data_gta_item->city_code;
                $item_code = $data_gta_item->item_code;
                $itemInformationReq="";
                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';

                $itemInformationReq .= '<SearchItemInformationRequest ItemType="hotel">
                        <ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" />
                        <ItemCode>'.$item_code.'</ItemCode>
                    </SearchItemInformationRequest>
                    ';
                $requestData .= $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);

                $parseResult            = simplexml_load_string($output);
                /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

                $array1 = json_decode(json_encode((array) $parseResult), 1);
                $array1 = array($parseResult->getName() => $array1);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                //$array_output[]       = json_decode(json_encode($parseResult), true);

                $array = json_decode(json_encode((array) $parseResult), 1);
                $array = array($parseResult->getName() => $array);

                if(count($array1)) {
                    foreach ($array1 as $idxArr => $arrTag) {
                        if (!empty($arrTag['ResponseDetails'])) {
                            if (!empty($arrTag['ResponseDetails']['SearchItemInformationResponse'])) {
                                if(!empty($arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'])) {
                                    $itemList = $arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];
                                    $itemOutput = $array[$idxArr]['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];

                                    if (count($itemList)) {
                                        if (isset($itemList[0])) {
                                            foreach ($itemList as $idx_item => $itemData) {
                                                if (!empty($itemData['Item'])) {
                                                    $itemCode = $itemData['Item']['@attributes']['Code'];
                                                    $itemName = $itemOutput[$idx_item]['Item'];
                                                    $cityName = $itemOutput[$idx_item]['City'];
                                                    $locationText = "- ";

                                                    if (!empty($itemData['LocationDetails'])) {
                                                        if (!empty($itemData['LocationDetails']['Location']) && array_key_exists('0', $itemData['LocationDetails']['Location'])) {
                                                            foreach ($itemData['LocationDetails']['Location'] as $idx_loc=>$loc) {
                                                                $locationText .= $itemOutput[$idx_item]['LocationDetails']['Location'][$idx_loc]." (".$loc['@attributes']['Code'].") - ";
                                                            }
                                                        } else if (!empty($itemData['LocationDetails']['Location'])) {
                                                            $locationText = $itemOutput[$idx_item]['LocationDetails']['Location']." (".$itemData['LocationDetails']['Location']['@attributes']['Code'].") - ";
                                                        } else {
                                                            $locationText = "- ";
                                                        }
                                                    }

                                                    $locationText = trim($locationText, "- ");

                                                    /*$arrDataHotelItem = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));
                                                    $this->db->insert('tb_hotel_gta_item', $arrDataHotelItem);*/

                                                    //$arrDataHotelInformation[] = array(
                                                    $arrDataHotelInformation = array(
                                                        'city_code' => $city_code,
                                                        'city_content'=> $cityName,
                                                        'item_code'=> $itemCode,
                                                        'item_content'=> $itemName,

                                                        'location_text' => $locationText,
                                                        /*'star_rating' => $star_rating,
                                                        'website' => $website,
                                                        'category' => $category,
                                                        'telephone' => $phone,
                                                        'fax' => $fax,
                                                        'email_address' => $email,
                                                        'geo_latitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Latitude'],
                                                        'geo_longitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Longitude'],*/
                                                        'modified' => date('Y-m-d H:i:s'));

                                                    $this->db->insert('tb_hotel_gta_item_information', $arrDataHotelInformation);
                                                }


                                            }
                                        } else {

                                            $itemCode = $itemList['Item']['@attributes']['Code'];
                                            $itemName = $itemOutput['Item'];
                                            $cityName = $itemOutput['City'];
                                            $locationText = "- ";
                                            if (!empty($itemList['LocationDetails'])) {
                                                if (!empty($itemList['LocationDetails']['Location']) && array_key_exists('0', $itemList['LocationDetails']['Location'])) {
                                                    foreach ($itemList['LocationDetails']['Location'] as $idx_loc=>$loc) {
                                                        $locationText .= $itemOutput['LocationDetails']['Location'][$idx_loc]." (".$loc['@attributes']['Code'].") - ";
                                                    }
                                                } else if (!empty($itemList['LocationDetails']['Location'])) {
                                                    $locationText = $itemOutput['LocationDetails']['Location']." (".$itemList['LocationDetails']['Location']['@attributes']['Code'].") - ";
                                                } else {
                                                    $locationText = "- ";
                                                }
                                            }

                                            $locationText = trim($locationText, "- ");

                                            /*$arrDataHotelItem = array('city_code' => $city_code, 'city_name' => $cityName , 'country_code'=> $countryCode, 'item_code' => $itemCode, 'item_name' => $itemName, 'modified' => date('Y-m-d H:i:s'));
                                            $this->db->insert('tb_hotel_gta_item', $arrDataHotelItem);*/

                                            //$arrDataHotelInformation[] = array(
                                            $arrDataHotelInformation = array(
                                                'city_code' => $city_code,
                                                'city_content'=> $cityName,
                                                'item_code'=> $itemCode,
                                                'item_content'=> $itemName,

                                                'location_text' => $locationText,
                                                /*'star_rating' => $star_rating,
                                                'website' => $website,
                                                'category' => $category,
                                                'telephone' => $phone,
                                                'fax' => $fax,
                                                'email_address' => $email,
                                                'geo_latitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Latitude'],
                                                'geo_longitude' => $itemOutput[$idx_item]['HotelInformation']['GeoCodes']['Longitude'],*/
                                                'modified' => date('Y-m-d H:i:s'));

                                            $this->db->insert('hotel_gta_item_information', $arrDataHotelInformation);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /*$this->db->set('done', 1);
        $this->db->where('city_code', $city_code);
        $this->db->update('tb_countrycity');
        */

        $time_end = microtime(true);
        $time = $time_end - $time_start;

        echo 'Time for Looping Output Array : '.$time.'<br>';
    }

    public function getGTAHotelRoomType()
    {
        $time_start = microtime(true);

        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE sync_roomtype = 0 order by id asc");

        if ($qry->num_rows()) {
            $nodataCityItemCode = "";
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {
                        $nodata = 0;
                $city_code = $data_gta_item->city_code;
                $item_code = $data_gta_item->item_code;

                $totalData++;
                echo "$totalData. ";

                /* est time for looping city : 0.0003 s */
                $itemInformationReq="";
                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';

                $itemInformationReq .= '<SearchItemInformationRequest ItemType="hotel">
                        <ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" />
                        <ItemCode>'.$item_code.'</ItemCode>
                    </SearchItemInformationRequest>
                    ';
                $requestData .= $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);

                $parseResult            = simplexml_load_string($output);
                /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

                $array1 = json_decode(json_encode((array) $parseResult), 1);
                $array1 = array($parseResult->getName() => $array1);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                //$array_output[]       = json_decode(json_encode($parseResult), true);

                $array = json_decode(json_encode((array) $parseResult), 1);
                $array = array($parseResult->getName() => $array);
                echo 'Get in Process Item Code : '.$item_code.'; City : '.$city_code.'...<br>';
                if(count($array1)) {
                    foreach ($array1 as $idxArr => $arrTag) {
                        if (!empty($arrTag['ResponseDetails'])) {
                            if (!empty($arrTag['ResponseDetails']['SearchItemInformationResponse'])) {
                                if(!empty($arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'])) {
                                    $itemList = $arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];
                                    $itemOutput = $array[$idxArr]['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];

                                    if (count($itemList)) {
                                        if (isset($itemList[0])) {
                                            foreach ($itemList as $idx_item => $itemData) {
                                                if (!empty($itemData['Item'])) {
                                                    $itemCode = $itemData['Item']['@attributes']['Code'];
                                                    $itemName = $itemOutput[$idx_item]['Item'];
                                                    $cityName = $itemOutput[$idx_item]['City'];

                                                    $room_count = $itemData["RoomTypes"]["@attributes"]["RoomCount"];

                                                    /*
                                                    $this->db->set('room_count', $room_count);
                                                    $this->db->where('item_code', $itemCode);
                                                    $this->db->where('city_code', $city_code);
                                                    $this->db->update('tb_hotel_gta_item_information');
                                                    */
                                                    $room_types = $itemData['RoomTypes']['RoomType'];
                                                    $room_types_code = $itemOutput[$idx_item]['RoomTypes']['RoomType'];
                                                    echo 'Not supported Yet!';
                                                    die();
                                                    /*$hotel_facility =
                                                    $room_facilities
                                                    $room_facilities_information = */
                                                } else {
                                                    $nodata = 1;
                                                }
                                            }
                                        } else {
                                            if(isset($itemList['HotelInformation']['RoomTypes']['RoomType'])) {
                                                $itemCode = $itemList['Item']['@attributes']['Code'];
                                                $itemName = $itemOutput['Item'];
                                                $cityName = $itemOutput['City'];

                                                $RoomCount = isset($itemList['HotelInformation']['RoomTypes']['@attributes']['RoomCount']) ? $itemList['HotelInformation']['RoomTypes']['@attributes']['RoomCount'] : count($itemList['HotelInformation']['RoomTypes']['RoomType']);
                                                $roomTypeCodeArray = $itemList['HotelInformation']['RoomTypes']['RoomType'];
                                                $roomTypeArray = $itemOutput['HotelInformation']['RoomTypes']['RoomType'];

                                                echo $itemCode."-".$itemName."-".$cityName."-".$RoomCount;
                                                echo '<br>';

                                                if (count($roomTypeArray) != 0 && count($roomTypeArray) > 1) {
                                                    foreach ($roomTypeArray as $idx => $roomtype) {
                                                        $roomtypeCode = $roomTypeCodeArray[$idx]['@attributes']['Code'];
                                                        echo $roomtype."--". $roomtypeCode.'<br>';
                                                        $arrDataHotelInformation = array(
                                                            'city_code' => $city_code,
                                                            'item_code'=> $itemCode,
                                                            'content'=> $roomtype,
                                                            'code' => $roomtypeCode,
                                                            'modified' => date('Y-m-d H:i:s')
                                                        );

                                                        $this->db->insert('hotel_gta_item_information_room_type', $arrDataHotelInformation);
                                                    }
                                                } else {
                                                    $roomtype = $roomTypeArray;
                                                    $roomtypeCode = $roomTypeCodeArray['@attributes']['Code'];
                                                    echo $roomtype."--". $roomtypeCode.'<br>';

                                                    $arrDataHotelInformation = array(
                                                        'city_code' => $city_code,
                                                        'item_code'=> $itemCode,
                                                        'content'=> $roomtype,
                                                        'code' => $roomtypeCode,
                                                        'modified' => date('Y-m-d H:i:s')
                                                    );

                                                    $this->db->insert('hotel_gta_item_information_room_type', $arrDataHotelInformation);
                                                }



                                                $this->db->set('sync_roomtype', 1);
                                                $this->db->set('room_count', $RoomCount);
                                                $this->db->where('city_code', $city_code);
                                                $this->db->where('item_code', $itemCode);
                                                $this->db->update('hotel_gta_item');
                                            } else {
                                                /* no DATA */
                                                $nodata = 1;

                                            }
                                        }
                                    } else {
                                        $nodata = 1;
                                    }
                                } else {$nodata = 1;}
                            } else { $nodata = 1; }
                        } else { $nodata = 1; }

                        if($nodata == 1) {
                            $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";
                            //$dataUpdateSync[] = array('noitemdetailsdata' => 2, 'sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' =>  $data_gta_item->item_code);

                            $this->db->set('noitemdetailsdata', 11); // if 11 means no data in hotel room type
                            $this->db->set('sync_roomtype', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update("hotel_gta_item");
                        }
                        flush();
                        ob_flush();
                        echo 'Continuing..<br>';
                    }
                } else {
                    echo 'No Data<br>';
                    /* no DATA */
                    $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";
                    //$dataUpdateSync[] = array('noitemdetailsdata' => 2, 'sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' =>  $data_gta_item->item_code);

                    $this->db->set('noitemdetailsdata', 11); // if 11 means no data in hotel room type
                    $this->db->set('sync_roomtype', 1);
                    $this->db->set('modified', date("Y-m-d H:i:s"));
                    $this->db->where('city_code', $data_gta_item->city_code);
                    $this->db->where('item_code', $data_gta_item->item_code);
                    $this->db->update("hotel_gta_item");
                }
                flush();
                ob_flush();
            }
        }

        echo $nodataCityItemCode;
        $time_end = microtime(true);
        $time = $time_end - $time_start;

        echo 'Time for Looping Output Array : '.$time.'<br>';
    }

    public function getGTAHotelRoomFacilities()
    {
        $time_start = microtime(true);

        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE sync_roomfacl = 0 order by id asc");

        if ($qry->num_rows()) {
            $nodataCityItemCode = "";
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {
                $city_code = $data_gta_item->city_code;
                $item_code = $data_gta_item->item_code;

                $totalData++;
                echo "$totalData. ";

                /* est time for looping city : 0.0003 s */
                $itemInformationReq="";
                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';

                $itemInformationReq .= '<SearchItemInformationRequest ItemType="hotel">
                        <ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" />
                        <ItemCode>'.$item_code.'</ItemCode>
                    </SearchItemInformationRequest>
                    ';
                $requestData .= $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);

                $parseResult            = simplexml_load_string($output);
                /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

                $array1 = json_decode(json_encode((array) $parseResult), 1);
                $array1 = array($parseResult->getName() => $array1);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                //$array_output[]       = json_decode(json_encode($parseResult), true);

                $array = json_decode(json_encode((array) $parseResult), 1);
                $array = array($parseResult->getName() => $array);
                echo 'Get in Process Item Code : '.$item_code.'; City : '.$city_code.'...<br>';

                if(count($array1)) {
                    foreach ($array1 as $idxArr => $arrTag) {
                        $nodata = 0;
                        if (!empty($arrTag['ResponseDetails']))
                        {
                            if (!empty($arrTag['ResponseDetails']['SearchItemInformationResponse']))
                            {
                                if(!empty($arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']))
                                {
                                    $itemList = $arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];
                                    $itemOutput = $array[$idxArr]['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];

                                    if (count($itemList))
                                    {
                                        if (isset($itemList[0]))
                                        {
                                            foreach ($itemList as $idx_item => $itemData)
                                            {
                                                if (!empty($itemData['Item']))
                                                {
                                                    $itemCode = $itemData['Item']['@attributes']['Code'];
                                                    $itemName = $itemOutput[$idx_item]['Item'];
                                                    $cityName = $itemOutput[$idx_item]['City'];
                                                    echo 'Not supported Yet';die();
                                                    /*$hotel_facility =
                                                    $room_facilities
                                                    $room_facilities_information = */
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if(isset($itemList['HotelInformation']['RoomFacilities']['Facility'])) {
                                                $itemCode = $itemList['Item']['@attributes']['Code'];
                                                $itemName = $itemOutput['Item'];
                                                $cityName = $itemOutput['City'];

                                                $roomFacCodeArray = $itemList['HotelInformation']['RoomFacilities']['Facility'];
                                                $roomFacArray = $itemOutput['HotelInformation']['RoomFacilities']['Facility'];

                                                echo $itemCode."-".$itemName."-".$cityName;
                                                echo '<br>';

                                                if (count($roomFacArray) != 0 && count($roomFacArray) > 1) {
                                                    foreach ($roomFacArray as $idx => $roomfac) {
                                                        $roomfacCode = $roomFacCodeArray[$idx]['@attributes']['Code'];
                                                        echo $roomfac."--". $roomfacCode.'<br>';
                                                        $arrDataHotelInformation = array(
                                                            'city_code' => $city_code,
                                                            'item_code'=> $itemCode,
                                                            'content'=> $roomfac,
                                                            'code' => $roomfacCode,
                                                            'modified' => date('Y-m-d H:i:s')
                                                        );

                                                        $this->db->insert('hotel_gta_item_information_room_facility', $arrDataHotelInformation);
                                                    }
                                                } else {
                                                    $roomfac = $roomFacArray;
                                                    $roomfacCode = $roomFacCodeArray['@attributes']['Code'];
                                                    echo $roomfac."--". $roomfacCode.'<br>';

                                                    $arrDataHotelInformation = array(
                                                        'city_code' => $city_code,
                                                        'item_code'=> $itemCode,
                                                        'content'=> $roomfac,
                                                        'code' => $roomfacCode,
                                                        'modified' => date('Y-m-d H:i:s')
                                                    );
                                                    $this->db->insert('hotel_gta_item_information_room_facility', $arrDataHotelInformation);
                                                }
                                                $this->db->set('sync_roomfacl', 1);
                                                $this->db->where('city_code', $city_code);
                                                $this->db->where('item_code', $itemCode);
                                                $this->db->update('hotel_gta_item');
                                            } else {
                                                /* no DATA */
                                                $nodata = 1;
                                            }
                                        }
                                    } else {
                                        $nodata = 1;
                                    }
                                } else {
                                    $nodata = 1;
                                }
                            } else {
                                $nodata = 1;
                            }
                        } else {
                            $nodata = 1;
                        }

                        if($nodata == 1){
                            $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";
                            $this->db->set('noitemdetailsdata', 12); // if 11 means no data in hotel room facl
                            $this->db->set('sync_roomfacl', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update("hotel_gta_item");
                        }
                        flush();
                        ob_flush();
                        echo 'Continuing..<br>';
                    }
                } else {
                    echo 'No Data<br>';
                    /* no DATA */
                    $this->db->set('noitemdetailsdata', 12); // if 11 means no data in hotel room type
                    $this->db->set('sync_roomtype', 1);
                    $this->db->set('modified', date("Y-m-d H:i:s"));
                    $this->db->where('city_code', $data_gta_item->city_code);
                    $this->db->where('item_code', $data_gta_item->item_code);
                    $this->db->update("hotel_gta_item");
                }
                flush();
                ob_flush();
            }
        }

        echo $nodataCityItemCode;
        $time_end = microtime(true);
        $time = $time_end - $time_start;

        echo 'Time for Looping Output Array : '.$time.'<br>';
    }

    public function getGTAHotelFacilities()
    {
        $time_start = microtime(true);

        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE sync_facl = 0 order by id asc");

        if ($qry->num_rows()) {
            $nodataCityItemCode = "";
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {
                $nodata = 0;
                $city_code = $data_gta_item->city_code;
                $item_code = $data_gta_item->item_code;

                $totalData++;
                echo "$totalData. ";

                /* est time for looping city : 0.0003 s */
                $itemInformationReq="";
                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';

                $itemInformationReq .= '<SearchItemInformationRequest ItemType="hotel">
                        <ItemDestination DestinationType="city" DestinationCode="'.$city_code.'" />
                        <ItemCode>'.$item_code.'</ItemCode>
                    </SearchItemInformationRequest>
                    ';
                $requestData .= $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);

                $parseResult            = simplexml_load_string($output);
                /*$array_output_tag[]       = json_decode(json_encode($parseResult), true);*/

                if($parseResult) {
                    $array1 = json_decode(json_encode((array) $parseResult), 1);
                    $array1 = array($parseResult->getName() => $array1);

                    $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                    //$array_output[]       = json_decode(json_encode($parseResult), true);

                    $array = json_decode(json_encode((array) $parseResult), 1);
                    $array = array($parseResult->getName() => $array);
                }
                echo 'Get in Process Item Code : '.$item_code.'; City : '.$city_code.'...<br>';

                if($array1 && count($array1)) {
                    foreach ($array1 as $idxArr => $arrTag) {
                        if (!empty($arrTag['ResponseDetails'])) {
                            if (!empty($arrTag['ResponseDetails']['SearchItemInformationResponse'])) {
                                if(!empty($arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'])) {
                                    $itemList = $arrTag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];
                                    $itemOutput = $array[$idxArr]['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail'];

                                    if (count($itemList)) {
                                        if (isset($itemList[0])) {
                                            foreach ($itemList as $idx_item => $itemData) {
                                                if (!empty($itemData['Item'])) {
                                                    $itemCode = $itemData['Item']['@attributes']['Code'];
                                                    $itemName = $itemOutput[$idx_item]['Item'];
                                                    $cityName = $itemOutput[$idx_item]['City'];
                                                    echo 'Not supported Yet';die();
                                                    /*$hotel_facility =
                                                    $room_facilities
                                                    $room_facilities_information = */
                                                }
                                            }
                                        } else {
                                            if(isset($itemList['HotelInformation']['Facilities']['Facility'])) {
                                                $itemCode = $itemList['Item']['@attributes']['Code'];
                                                $itemName = $itemOutput['Item'];
                                                $cityName = $itemOutput['City'];

                                                $roomFacCodeArray = $itemList['HotelInformation']['Facilities']['Facility'];
                                                $roomFacArray = $itemOutput['HotelInformation']['Facilities']['Facility'];

                                                echo $itemCode."-".$itemName."-".$cityName;
                                                echo '<br>';

                                                if (count($roomFacArray) != 0 && count($roomFacArray) > 1) {
                                                    foreach ($roomFacArray as $idx => $roomfac) {
                                                        $roomfacCode = $roomFacCodeArray[$idx]['@attributes']['Code'];
                                                        echo $roomfac."--". $roomfacCode.'<br>';
                                                        $arrDataHotelInformation = array(
                                                            'city_code' => $city_code,
                                                            'item_code'=> $itemCode,
                                                            'content'=> $roomfac,
                                                            'code' => $roomfacCode,
                                                            'modified' => date('Y-m-d H:i:s')
                                                        );

                                                        $this->db->insert('hotel_gta_item_information_facility', $arrDataHotelInformation);
                                                    }
                                                } else {
                                                    $roomfac = $roomFacArray;
                                                    $roomfacCode = $roomFacCodeArray['@attributes']['Code'];
                                                    echo $roomfac."--". $roomfacCode.'<br>';

                                                    $arrDataHotelInformation = array(
                                                        'city_code' => $city_code,
                                                        'item_code'=> $itemCode,
                                                        'content'=> $roomfac,
                                                        'code' => $roomfacCode,
                                                        'modified' => date('Y-m-d H:i:s')
                                                    );


                                                    $this->db->insert('hotel_gta_item_information_facility', $arrDataHotelInformation);

                                                }

                                                $this->db->set('sync_facl', 1);
                                                $this->db->where('city_code', $city_code);
                                                $this->db->where('item_code', $itemCode);
                                                $this->db->update('hotel_gta_item');
                                            } else {
                                                /* no DATA */
                                                $nodata = 1;
                                            }
                                        }
                                    } else {
                                        $nodata = 1;
                                    }
                                } else { $nodata = 1;}
                            } else {$nodata = 1;}
                        } else {
                            $nodata = 1;
                            echo 'No Data<br>';
                        }
                        if($nodata == 1) {
                            $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";
                            //$dataUpdateSync[] = array('noitemdetailsdata' => 2, 'sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' =>  $data_gta_item->item_code);

                            $this->db->set('noitemdetailsdata', 13); // if 13 means no data in hotel facl
                            $this->db->set('sync_facl', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update("hotel_gta_item");
                        }
                        flush();
                        ob_flush();
                        echo 'Continuing..<br>';


                    }
                } else {
                    $this->db->set('noitemdetailsdata', 13); // if 13 means no data in hotel facl
                    $this->db->set('sync_facl', 1);
                    $this->db->set('modified', date("Y-m-d H:i:s"));
                    $this->db->where('city_code', $city_code);
                    $this->db->where('item_code', $item_code);
                    $this->db->update("hotel_gta_item");
                }
                flush();
                ob_flush();
            }
        }

        echo $nodataCityItemCode;
        $time_end = microtime(true);
        $time = $time_end - $time_start;

        echo 'Time for Looping Output Array : '.$time.'<br>';
    }

    public function getGTACities()
    {
        /* using xml header class */
        $dbhandle   = mysql_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD) or die("Unable to connect to MySQL");
        $selected   = mysql_select_db("ctcfitapp-testing", $dbhandle) or die("Could not select ctcfitapp");

        $time_start = microtime(true);
        $country_res = mysql_query("SELECT * FROM tb_country ORDER BY country_code ASC");
        $cityarr = array();
        while( $country_row = mysql_fetch_array($country_res, MYSQL_ASSOC) ) {

            //inputs
            $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
            $requestData .= '<Request>';
                $requestData .= '<Source>';
                    $requestData .= '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                    $requestData .= '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                        $requestData .= '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                    $requestData .= '</RequestorPreferences>';
                $requestData .= '</Source>';
                $requestData .= '<RequestDetails>';
                    $requestData .= '<SearchCityRequest CountryCode="'.$country_row["country_code"].'">';
                        $requestData .= '<CityName></CityName>';
                    $requestData .= '</SearchCityRequest>';
                $requestData .= '</RequestDetails>';
            $requestData .= '</Request>';
            //end of inputs

            /*--Execute Search Transaction--*/
            $requestURL = 'https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet';
            $XMLTransactionHander = new XMLTransactionHander;
            $responseDoc = $XMLTransactionHander->executeRequest( $requestURL, $requestData );
            $array_final_result = array();
            /*--End of execute search transaction--*/

            // Process Response XML Data
            if( $responseDoc != NULL ) {
                $responseElement = $responseDoc->documentElement;
                $xpath = new DOMXPath( $responseDoc );
                $errorsElements = $xpath->query( 'ResponseDetails/SearchCityResponse/Errors', $responseElement );
                if( $errorsElements->length > 0 ) {
                    echo '<p>Invalid Search Request</p>';
                }
                else {
                    $x = 0;
                    $searchCityReponseElements = $xpath->query( 'ResponseDetails/SearchCityResponse', $responseElement );
                    foreach( $searchCityReponseElements as $searchCityReponseElement ) {
                        $cityElements = $xpath->query( 'CityDetails/City ', $searchCityReponseElement );
                        foreach( $cityElements AS $cityElement ) {
                            foreach( $cityElement->attributes AS $attribute ) {
                                $array_final_result[$x]["attributes"][$attribute->name] = $attribute->value;
                            }
                            $array_final_result[$x]["Name"] = $cityElement->textContent;
                            $x++;
                        }
                    }

                    //array hold all country data
                    /*$array_city = array();
                    $city_res = mysql_query("SELECT * FROM hotel_list_city_gta ORDER BY city_code ASC");
                    while( $city_row = mysql_fetch_array($city_res, MYSQL_ASSOC) ) {
                        $array_city[] = $city_row["city_code"];
                    }*/
                    //end of array hold all country data

                    //insert and update into hotel_list_country_gta
                    /*for( $x=0; $x<sizeof($array_final_result); $x++ ) {
                        if( !in_array($array_final_result[$x]["attributes"]["Code"], $array_city) ) {
                            $insert_query = mysql_query(
                                "
                                    INSERT INTO hotel_list_city_gta (city_code, city_name, country_code, created, modified)
                                    VALUES ('".$array_final_result[$x]["attributes"]["Code"]."', '".$array_final_result[$x]["Name"]."',                                     '".$country_row["country_code"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')
                                "
                            );
                        }
                    }*/
                    //end of update into hotel_list_country_gta
                    $cityarr[] = $array_final_result;
                }
            }
            else {
                echo '<p>Invalid Search Request: '.$XMLTransactionHander->errno.'</p>';
            }
            // End of Process Response XML Data
        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo 'Time Taken : '.$time;

        //print result
        echo "<pre>";
        print_r($cityarr);
        echo "</pre>";
        //end of print result
    }
    public function getGTACountryCity($forceInsert=0)
    {
        /* est. 82 seconds for 21232 datas*/
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $arrInsert = array();
            $time_start = microtime(true);
            $this->db->select('country_code');
            $this->db->where('country_code', 'BV');
            $this->db->order_by('country_code', 'ASC');
            $qry = $this->db->get('tb_country');

            if ($qry->num_rows()) {
                $result = $qry->result();
                foreach($result as $ctr) {
                    //$countryCode = trim($this->input->post('country_code'));
                    $countryCode = $ctr->country_code;

                    $itemInformationReq="";
                    $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                    $requestData .= '<Request>';
                    $requestData .=     '<Source>';
                    $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                    $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                    $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                    $requestData .=         '</RequestorPreferences>';
                    $requestData .=     '</Source>';
                    $requestData .=     '<RequestDetails>';
                    $itemInformationReq .=         ' <SearchCityRequest CountryCode="'.$countryCode.'"></SearchCityRequest>';
                    $requestData .= $itemInformationReq;
                    $requestData .=     '</RequestDetails>';
                    $requestData .= '</Request>';
                    $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                    $output = curl_exec($ch);
                    $info = curl_getinfo($ch);

                    curl_close($ch);

                    $parseResult            = simplexml_load_string($output);
                    $array_output_tag       = json_decode(json_encode($parseResult), true);

                    $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                    $array_output       = json_decode(json_encode($parseResult), true);

                    if (!empty($array_output_tag['ResponseDetails'])) {
                        if (!empty($array_output_tag['ResponseDetails']['SearchCityResponse'])) {
                            if (!empty($array_output_tag['ResponseDetails']['SearchCityResponse']['CityDetails']['City']))
                            {

                                $listCity = $array_output_tag['ResponseDetails']['SearchCityResponse']['CityDetails']['City'];

                                $listCount = count($listCity);
                                if ($listCount > 0) {
                                    if($forceInsert == 1) {
                                        $this->db->query('DELETE from tb_countrycity where country_code="'.$countryCode.'"');
                                    }

                                    foreach ($listCity as $idx_city => $city_code) {
                                        if(!empty($city_code['@attributes']))
                                        /*echo $country_code['@attributes']['Code'] ." ". $array_output['ResponseDetails']['SearchCountryResponse']['CountryDetails']['Country'][$idx_country]."<br>";*/
                                        $arrInsert[] = array(
                                                'country_code' => $countryCode,
                                                'city_code' => $city_code['@attributes']['Code'],
                                                'city_name' => $array_output['ResponseDetails']['SearchCityResponse']['CityDetails']['City'][$idx_city],
                                                'modified' => date('Y-m-d H:i:s')
                                            );
                                    }
                                }
                            }
                        }
                    }
                }

                if (count($arrInsert)) {
                    $this->db->insert_batch('tb_countrycity', $arrInsert);

                    /*$this->db->set('done_proceed', 1);
                    $this->db->where('country_code', $countryCode);
                    $this->db->update('tb_country');
*/
                    //redirect('static_data/Hotelimage_4/getGTACountryCity');
                }
            }
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            echo "total time taken : ".$time;
        } else {
            $data['showOffCountry'] = 0;
            $data['actionurl'] = base_url().'static_data/Hotels2/getGTACountryCity';
            $this->load->view('static_data/country_filter', $data);
        }
    }
    public function getGTACountry($forceInsert = 0)
    {
        $itemInformationReq="";
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $itemInformationReq .=         ' <SearchCountryRequest ISO="true"></SearchCountryRequest>';
        $requestData .= $itemInformationReq;
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $parseResult            = simplexml_load_string($output);
        $array_output_tag       = json_decode(json_encode($parseResult), true);

        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
        $array_output       = json_decode(json_encode($parseResult), true);

        if (array_key_exists('ResponseDetails', $array_output_tag)) {
            if (array_key_exists('SearchCountryResponse', $array_output_tag['ResponseDetails'])) {
                $listCountry = $array_output_tag['ResponseDetails']['SearchCountryResponse']['CountryDetails']['Country'];

                $listCount = count($listCountry);
                if ($listCount > 0) {
                    if($forceInsert == 1) {
                        $this->db->query('DELETE from tb_country where 1');
                    }

                    $arrInsert = array();
                    foreach ($listCountry as $idx_country => $country_code) {
                        /*echo $country_code['@attributes']['Code'] ." ". $array_output['ResponseDetails']['SearchCountryResponse']['CountryDetails']['Country'][$idx_country]."<br>";*/
                        $arrInsert[] = array(
                                'country_code' => $country_code['@attributes']['Code'],
                                'country_name' => $array_output['ResponseDetails']['SearchCountryResponse']['CountryDetails']['Country'][$idx_country],
                                'modified' => date('Y-m-d H:i:s')
                            );
                    }

                    if (count($arrInsert)) {
                        $this->db->insert_batch('tb_country', $arrInsert);
                        echo 'Done. Inserting Data success';
                    }
                }
            }
        }
    }

    public function testImage()
    {
        $time_start = microtime(true);

         /* delete all image of hotel */
        $itemInformationReq = "";
        //$this->db->query("DELETE from hotel_gta_item_information_image_link WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';


        $itemInformationReq .=         '<SearchItemInformationRequest ItemType="hotel">';
        $itemInformationReq .=             '<ItemDestination DestinationType="city" DestinationCode="CHKT"/>';
        $itemInformationReq .=             '<ItemCode>HOM</ItemCode>';
        $itemInformationReq .=         '</SearchItemInformationRequest>';

        $requestData .=         $itemInformationReq;
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);
        /*$array_output = $this->All->XMLtoArray($output);
        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
        */
        $parseResult            = simplexml_load_string($output);
        $array_output_tag       = json_decode(json_encode($parseResult), true);
        /*
        echo '<pre>';
        var_dump($array_output_tag);*/
        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
        $array_output       = json_decode(json_encode($parseResult), true);

        echo '<pre>';
        var_dump($array_output);
        die();
    }

	public function checkHotelImage($item_code = '', $city_code = '')
	{
        if($item_code == "" || $city_code == "")
            echo die('Nope!');

		$time_start = microtime(true);
        $dataInsertImage = array();
        $qry = $this->db->distinct()->select('city_code, item_code')->from('hotel_gta_item')->where('item_code', $item_code)->where('city_code', $city_code)->order_by('id', 'asc')->get();

        $nodataCityItemCode = "";
        if ($qry->num_rows()) {
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;
            foreach ($qry->result() as $data_gta_item) {
                $totalData++;
                echo "$totalData. ";
                $dataUpdateSync = array();

                 /* delete all image of hotel */
                $itemInformationReq = "";

                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';


                $itemInformationReq .=         '<SearchItemInformationRequest ItemType="hotel">';
                $itemInformationReq .=             '<ItemDestination DestinationType="city" DestinationCode="'.$data_gta_item->city_code.'"/>';
                $itemInformationReq .=             '<ItemCode>'.$data_gta_item->item_code.'</ItemCode>';
                $itemInformationReq .=         '</SearchItemInformationRequest>';

                $requestData .=         $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);
                /*$array_output = $this->All->XMLtoArray($output);
                echo "<pre>";
                print_r($array_output);
                echo "</pre>";
                */
                $parseResult            = simplexml_load_string($output);
                $array_output_tag       = json_decode(json_encode($parseResult), true);

                echo '<pre>';
                var_dump($array_output_tag);
                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);

                echo '<pre>';
                var_dump($array_output);
                flush();
                ob_flush();

            }
        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "total time taken : ".$time;
        echo 'Done.<br>No Data for city & item code (separate data by ~): <br>'.$nodataCityItemCode;
	}

    public function getHotelImage()
    {
        $time_start = microtime(true);
        /* get max ID */
        /*$this->db->select_max('id');
        $qry = $this->db->get('tb_hotel_gta_item');
        if($qry->num_rows()) {
            $totalData = $qry->row()->id;
        }*/

        $dataInsertImage = array();

        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE sync_image = 0 order by id asc");

        if ($qry->num_rows()) {
            $nodataCityItemCode = "";
            $resQry = $qry->result();
            $totalData = 0;
            $procData = 0;
            foreach ($qry->result() as $data_gta_item) {
                $totalData++;
                echo "$totalData. ";
                $dataUpdateSync = array();

                 /* delete all image of hotel */
                $itemInformationReq = "";
                //$this->db->query("DELETE from hotel_gta_item_information_image_link WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

                $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
                $requestData .= '<Request>';
                $requestData .=     '<Source>';
                $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
                $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
                $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
                $requestData .=         '</RequestorPreferences>';
                $requestData .=     '</Source>';
                $requestData .=     '<RequestDetails>';


                $itemInformationReq .=         '<SearchItemInformationRequest ItemType="hotel">';
                $itemInformationReq .=             '<ItemDestination DestinationType="city" DestinationCode="'.$data_gta_item->city_code.'"/>';
                $itemInformationReq .=             '<ItemCode>'.$data_gta_item->item_code.'</ItemCode>';
                $itemInformationReq .=         '</SearchItemInformationRequest>';

                $requestData .=         $itemInformationReq;
                $requestData .=     '</RequestDetails>';
                $requestData .= '</Request>';
                $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);

                curl_close($ch);
                /*$array_output = $this->All->XMLtoArray($output);
                echo "<pre>";
                print_r($array_output);
                echo "</pre>";
                */
                $parseResult            = simplexml_load_string($output);
                $array_output_tag       = json_decode(json_encode($parseResult), true);

                //echo '<pre>';
                //var_dump($array_output_tag);
                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);

                //echo '<pre>';
                //var_dump($array_output);
                //die();
                if (
                    !empty($array_output['ResponseDetails']) && !empty($array_output['ResponseDetails']['SearchItemInformationResponse'])
                ) {
                    $arrResponse = $array_output['ResponseDetails']['SearchItemInformationResponse'];
                    $arrResponseTag = $array_output_tag['ResponseDetails']['SearchItemInformationResponse'];

                    if (!empty($array_output['ResponseDetails']['SearchItemInformationResponse']) && isset($array_output['ResponseDetails']['SearchItemInformationResponse'][0]))
                    {
                        echo 'Start Processing...<br>';
                        $totalArr = count($array_output['ResponseDetails']['SearchItemInformationResponse']);
                        /*$dataInsertImage = array();*/
                        for ($i = 0; $i < $totalArr; $i++) {

                            $itemtype = $arrResponse[$i]['@attributes']['ItemType'];
                            $itemDetails = $arrResponse[$i]['ItemDetails']['ItemDetail'];

                            $cityName = $itemDetails['City'];
                            $cityCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemName = $itemDetails['Item'];
                            $itemCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];

                            $hotelInformationArray = $itemDetails['HotelInformation'];
                            echo 'Item : '. $itemCode.'; City : '. $cityCode;
                            if (isset($hotelInformationArray['Links']) && !empty($hotelInformationArray['Links']))
                            {
                                $mapimagelink = "";
                                if(isset($hotelInformationArray['Links']['MapLinks'])) {
                                    $procData++;
                                    $mapimagelink = $hotelInformationArray['Links']['MapLinks']['MapPageLink'];
                                    $dataInsertImage = array(
                                        'type' => 'mapimage',
                                        'city_code' => $cityCode,
                                        'item_code' => $itemCode,
                                        'text' => null,
                                        'thumbnail' => null,
                                        'image' => $mapimagelink,
                                        'height' => null,
                                        'width' => null,
                                        'last_modified' => date("Y-m-d H:i:s")
                                    );

                                    $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                }
                                if (isset($hotelInformationArray['Links']['ImageLinks']['ImageLink']) && !empty($hotelInformationArray['Links']['ImageLinks']['ImageLink'])) {
                                    $imageLinkArr = $hotelInformationArray['Links']['ImageLinks']['ImageLink'];
                                    if (isset($imageLinkArr[0]) && !empty($imageLinkArr[0])) {
                                        $procData++;

                                        $totalImageLink = count($imageLinkArr);
                                        for ($j = 0; $j < $totalImageLink; $j++) {
                                            $imageWidth = $imageLinkArr[$j]['@attributes']['Width'];
                                            $imageHeight =  $imageLinkArr[$j]['@attributes']['Height'];
                                            $imageThumbnailLink = $imageLinkArr[$j]['ThumbNail'];
                                            $imageLink = $imageLinkArr[$j]['Image'];
                                            $imageText = $imageLinkArr[$j]['Text'];
                                            $dataInsertImage = array(
                                                'type' => 'image',
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'image' => $imageLink,
                                                'text' => $imageText,
                                                'thumbnail' => $imageThumbnailLink,
                                                'height' => $imageHeight,
                                                'width' => $imageWidth,
                                                'last_modified' => date("Y-m-d H:i:s")
                                                );

                                            $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                        }
                                        /* multipla image */
                                    } else {
                                        $procData++;

                                        /* only got 1 image */
                                        $imageWidth = $imageLinkArr['@attributes']['Width'];
                                        $imageHeight =  $imageLinkArr['@attributes']['Height'];
                                        $imageThumbnailLink = $imageLinkArr['ThumbNail'];
                                        $imageLink = $imageLinkArr['Image'];
                                        $imageText = $imageLinkArr['Text'];
                                        $dataInsertImage = array(
                                            'type' => 'image',
                                            'city_code' => $cityCode,
                                            'item_code' => $itemCode,
                                            'image' => $imageLink,
                                            'text' => $imageText,
                                            'thumbnail' => $imageThumbnailLink,
                                            'height' => $imageHeight,
                                            'width' => $imageWidth,
                                            'last_modified' => date("Y-m-d H:i:s")
                                            );

                                        $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                    }
                                }
                            }

                            if (isset($hotelInformationArray['GeoCodes']) && !empty($hotelInformationArray['GeoCodes'])) {
                                $geo_latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                                $geo_longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                            }

                            //$dataUpdateSync[] = array('sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' => $itemCode);
                            $this->db->set('sync_image', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update("hotel_gta_item");
                        }
                        echo 'Done : City '. $cityCode.'; Item '. $itemCode.'; Processed Data : '.$procData.'<br>';
                    } else {
                        echo 'Start Processing 2 ...<br>';
                        if (isset($arrResponse['ItemDetails']['ItemDetail'])) {

                            //$dataInsertImage = array();
                            /* only single data query */
                            $itemtype = $arrResponse['@attributes']['ItemType'];
                            $itemDetails = $arrResponse['ItemDetails']['ItemDetail'];

                            $cityName = $itemDetails['City'];
                            $cityCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemName = $itemDetails['Item'];
                            $itemCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];

                            /*$locationCode = $itemDetails['LOCATIONDETAILS']['LOCATION']['CODE'];*/
                            /*$locationName = $itemDetails['LocationDetails']['Location'];*/
                            echo '2. Item : '. $itemCode.'; City : '. $cityCode;

                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            if (isset($hotelInformationArray['Links']) && !empty($hotelInformationArray['Links'])) {
                                $mapimagelink = "";
                                if (isset($hotelInformationArray['Links']['MapLinks']) && !empty($hotelInformationArray['Links']['MapLinks'])) {
                                    $procData++;

                                    $mapimagelink = $hotelInformationArray['Links']['MapLinks']['MapPageLink'];
                                    $dataInsertImage = array(
                                        'type' => 'mapimage',
                                        'city_code' => $cityCode,
                                        'item_code' => $itemCode,
                                        'image' => $mapimagelink,
                                        'text' => null,
                                        'thumbnail' => null,
                                        'height' => null,
                                        'width' => null,
                                        'last_modified' => date("Y-m-d H:i:s")
                                    );

                                    $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                }
                                if (isset($hotelInformationArray['Links']['ImageLinks']) && !empty($hotelInformationArray['Links']['ImageLinks'])) {
                                    if ( isset($hotelInformationArray['Links']['ImageLinks']['ImageLink']) && !empty($hotelInformationArray['Links']['ImageLinks']['ImageLink']))
                                    {
                                        if (isset($hotelInformationArray['Links']['ImageLinks']['ImageLink'][0]) && !empty($hotelInformationArray['Links']['ImageLinks']['ImageLink'][0])) {
                                            $totalImageLink = count($hotelInformationArray['Links']['ImageLinks']['ImageLink']);
                                            for ($j = 0; $j < $totalImageLink; $j++) {

                                                $procData++;

                                                $imageWidth = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['@attributes']['Width'];
                                                $imageHeight =  $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['@attributes']['Height'];
                                                $imageThumbnailLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['ThumbNail'];
                                                $imageLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['Image'];
                                                $imageText = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['Text'];
                                                if(!isset($imageText)) {
                                                    echo '<pre>';
                                                    var_dump($hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]);
                                                }

                                                $dataInsertImage = array(
                                                    'type' => 'image',
                                                    'city_code' => $cityCode,
                                                    'item_code' => $itemCode,
                                                    'image' => $imageLink,
                                                    'text' => $imageText,
                                                    'thumbnail' => $imageThumbnailLink,
                                                    'height' => $imageHeight,
                                                    'width' => $imageWidth,
                                                    'last_modified' => date("Y-m-d H:i:s")
                                                );
                                                $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                            }
                                            /* multipla image */
                                        } else {
                                            $procData++;

                                            /* only got 1 image */
                                            $imageWidth = $hotelInformationArray['Links']['ImageLinks']['ImageLink']['@attributes']['Width'];
                                            $imageHeight =  $hotelInformationArray['Links']['ImageLinks']['ImageLink']['@attributes']['Height'];
                                            $imageThumbnailLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink']['ThumbNail'];
                                            $imageLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink']['Image'];
                                            $imageText = $hotelInformationArray['Links']['ImageLinks']['ImageLink']['Text'];

                                            $dataInsertImage = array(
                                                'type' => 'image',
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'image' => $imageLink,
                                                'text' => $imageText,
                                                'thumbnail' => $imageThumbnailLink,
                                                'height' => $imageHeight,
                                                'width' => $imageWidth,
                                                'last_modified' => date("Y-m-d H:i:s")
                                                );

                                            $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                        }
                                    }
                                }
                            }

                            if (isset($hotelInformationArray['GeoCodes']) && !empty($hotelInformationArray['GeoCodes'])) {
                                $geo_latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                                $geo_longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                            }

                            $this->db->set('noitemdetailsdata', 1); // if 2 means no data in hotel image
                            $this->db->set('sync_image', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update("hotel_gta_item");

                            echo 'Done : City '. $cityCode.'; Item '. $itemCode.'; ProcData : '. $procData.'<br>';

                            //$dataUpdateSync[] = array('noitemdetailsdata' => 1, 'sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' => $itemCode);
                        } else {
                            $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";
                            //$dataUpdateSync[] = array('noitemdetailsdata' => 2, 'sync_image' => 1, 'modified' => date("Y-m-d H:i:s"), 'item_code' =>  $data_gta_item->item_code);

                           $this->db->set('noitemdetailsdata', 2); // if 2 means no data in hotel image
                            $this->db->set('sync_image', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update("hotel_gta_item");
                            ;

                            echo 'Done : City '. $data_gta_item->city_code.'; Item '. $data_gta_item->item_code.'; Processed Data : '.$procData.'<br>';
                        }
                    }
                } else {

                    /* no DATA */
                    $nodataCityItemCode .= $data_gta_item->city_code."-".$data_gta_item->item_code."~";

                    $this->db->set('noitemdetailsdata', 1); // if 11 means no data in hotel room type
                    $this->db->set('sync_image', 1);
                    $this->db->set('modified', date("Y-m-d H:i:s"));
                    $this->db->where('city_code', $data_gta_item->city_code);
                    $this->db->where('item_code', $data_gta_item->item_code);
                    $this->db->update("hotel_gta_item");
                }
                /*echo '<pre>';
                var_dump($dataUpdateSync);
                echo '</pre>';*/

                flush();
                ob_flush();

            }
        }

        /*if(count($dataInsertImage)) {
            $this->db->insert_batch("tb_hotel_gta_item_information_image_link", $dataInsertImage);
        }*/

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "total time taken : ".$time;

        echo 'Done.<br>No Data for city & item code (separate data by ~): <br>'.$nodataCityItemCode;
    }
}
