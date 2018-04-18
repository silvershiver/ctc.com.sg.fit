<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@ini_set("output_buffering", "Off");
@ini_set('implicit_flush', 1);
@ini_set('zlib.output_compression', 0);

require_once APPPATH.'libraries/XMLTransactionHander.class.php';
class Location2 extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function getListLocation()
	{
		$requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
		$requestData .= '<Request>';
		$requestData .= 	'<Source>';
		$requestData .= 		'<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
		$requestData .= 		'<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
		$requestData .= 			'<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
		$requestData .= 		'</RequestorPreferences>';
		$requestData .= 	'</Source>';
		$requestData .= 	'<RequestDetails>';
		$requestData .= 		'<SearchFacilityRequest FacilityType="hotel">';
		$requestData .= 			'<FacilityName></FacilityName>';
		$requestData .= 			'<FacilityCode></FacilityCode>';
		$requestData .= 		'</SearchFacilityRequest>';
		$requestData .= 	'</RequestDetails>';
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
		echo "</pre>";*/

        $parseResult            = simplexml_load_string($output);
        $array_output_tag       = json_decode(json_encode($parseResult), true);

        echo "<pre>";
        print_r($array_output_tag);
        echo "</pre>";

        /*
        echo '<pre>';
        var_dump($array_output_tag);*/
        $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
        $array_output       = json_decode(json_encode($parseResult), true);

        echo "<pre>";
        print_r($array_output);
        echo "</pre>";
	}

    public function updateAreaDetails()
    {
        $table_gta_item = 'hotel_gta_item';
        $qry = $this->db->query("select distinct city_code, item_code FROM ".$table_gta_item." WHERE sync_area_detail = 0 order by id asc");

        if ($qry->num_rows()) {

            $table_gta_area_detail = "hotel_gta_item_information_area_details";

            $nodataCityItemCode = "";
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {
                 /* delete all image of hotel */
                $itemInformationReq = "";
                $this->db->query("DELETE from $table_gta_area_detail WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

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

                $parseResult            = simplexml_load_string($output);
                $array_output_tag       = json_decode(json_encode($parseResult), true);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);


                if (!empty($array_output_tag['ResponseDetails']) && !empty($array_output_tag['ResponseDetails']['SearchItemInformationResponse'])) {
                    $arrResponse = $array_output['ResponseDetails']['SearchItemInformationResponse'];
                    $arrResponseTag = $array_output_tag['ResponseDetails']['SearchItemInformationResponse'];

                    if (isset($array_output['ResponseDetails']['SearchItemInformationResponse']) && !empty($array_output['ResponseDetails']['SearchItemInformationResponse'][0])) {
                        $totalArr = count($array_output['ResponseDetails']['SearchItemInformationResponse']);
                        /*$dataInsertImage = array();*/

                        for ($i = 0; $i < $totalArr; $i++) {
                            $procData++;
                            $cityCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemName = $itemDetails['Item'];
                            $itemCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];
                            $itemDetails = $arrResponse[$i]['ItemDetails']['ItemDetail'];
                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            if (isset($hotelInformationArray['AreaDetails'])) {
                                if (!isset($hotelInformationArray['AreaDetails']['AreaDetail']) || empty($hotelInformationArray['AreaDetails']['AreaDetail'])) {
                                    $nodataCityItemCode .= "# ". $itemCode.'-'.$cityCode.'~';
                                } else {
                                    if (is_array($hotelInformationArray['AreaDetails']['AreaDetail'])) {
                                        foreach($hotelInformationArray['AreaDetails']['AreaDetail'] as $areadetail) {
                                            $dataInsertAreaDetails = array(
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'content' => $areadetail,
                                                'modified' => date("Y-m-d H:i:s")
                                            );

                                           $this->db->insert($table_gta_area_detail, $dataInsertAreaDetails);
                                        }
                                    } else {
                                         $dataInsertAreaDetails = array(
                                            'city_code' => $cityCode,
                                            'item_code' => $itemCode,
                                            'content' => $hotelInformationArray['AreaDetails']['AreaDetail'],
                                            'modified' => date("Y-m-d H:i:s")
                                        );

                                        $this->db->insert($table_gta_area_detail, $dataInsertAreaDetails);
                                    }
                                }
                            }
                            $this->db->set('sync_area_detail', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;
                        }
                        echo '; Proccessed Data : '. $procData.'<br>';

                    } else {
                        $procData++;
                        if (isset($arrResponse['ItemDetails']['ItemDetail'])) {
                            //$dataInsertImage = array();
                            /* only single data query */
                            $cityCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];
                            $itemDetails = $arrResponse['ItemDetails']['ItemDetail'];

                            $hotelInformationArray = $itemDetails['HotelInformation'];
                            if (isset($hotelInformationArray['AreaDetails'])) {
                                if (!isset($hotelInformationArray['AreaDetails']) || empty($hotelInformationArray['AreaDetails']['AreaDetail'])) {
                                    $nodataCityItemCode .= "//". $itemCode.'-'.$cityCode.'<br>';
                                } else {
                                    if (is_array($hotelInformationArray['AreaDetails']['AreaDetail'])) {
                                        foreach ($hotelInformationArray['AreaDetails']['AreaDetail'] as $areadetail) {
                                            $dataInsertAreaDetails = array(
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'content' => $areadetail,
                                                'modified' => date("Y-m-d H:i:s")
                                            );
                                            //var_dump($dataInsertAreaDetails);
                                            $this->db->insert($table_gta_area_detail, $dataInsertAreaDetails);
                                        }
                                    } else {
                                         $dataInsertAreaDetails = array(
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'content' => $hotelInformationArray['AreaDetails']['AreaDetail'],
                                                'modified' => date("Y-m-d H:i:s")
                                            );
                                         //var_dump($dataInsertAreaDetails);
                                        $this->db->insert($table_gta_area_detail, $dataInsertAreaDetails);
                                    }

                                }
                            }

                            $this->db->set('noitemdetailsdata', 1);
                            $this->db->set('sync_area_detail', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);

                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;
                        } else {
                            $this->db->set('noitemdetailsdata', 3); // if 2 means no data in area details
                            $this->db->set('sync_area_detail', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update($table_gta_item);

                            echo 'Done Process. City : '.$data_gta_item->city_code. '; Item : '. $data_gta_item->item_code;
                        }
                    }
                    echo '; Proccessed Data : '. $procData.'<br>';
                }
                flush();
                ob_flush();
            }
        }
        echo 'Done.<br>No Data for city & item code (separate data by ~): <br>'.$nodataCityItemCode;
    }

    public function updateHotelReports()
    {
        $table_gta_item = 'hotel_gta_item';
        $qry = $this->db->query("select distinct city_code, item_code FROM ".$table_gta_item." WHERE sync_hotel_reports = 0 order by id asc");

        if ($qry->num_rows()) {
            $table_gta_report = 'hotel_gta_item_information_report';
            $nodataCityItemCode = "";
            $procData = 0;

            foreach ($qry->result() as $data_gta_item) {
                 /* delete all image of hotel */
                $itemInformationReq = "";
                $this->db->query("DELETE from $table_gta_report WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

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

                $parseResult            = simplexml_load_string($output);
                $array_output_tag       = json_decode(json_encode($parseResult), true);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);
echo '<pre>';
var_dump($array_output);
var_dump($array_output_tag);
die();
                if (!empty($array_output_tag['ResponseDetails']) && !empty($array_output_tag['ResponseDetails']['SearchItemInformationResponse'])) {

                    $arrResponse = $array_output['ResponseDetails']['SearchItemInformationResponse'];
                    $arrResponseTag = $array_output_tag['ResponseDetails']['SearchItemInformationResponse'];

                    if (isset($array_output['ResponseDetails']['SearchItemInformationResponse']) && !empty($array_output['ResponseDetails']['SearchItemInformationResponse'][0])) {

                        $totalArr = count($array_output['ResponseDetails']['SearchItemInformationResponse']);

                        /*$dataInsertImage = array();*/
                        for ($i = 0; $i < $totalArr; $i++) {
                            $procData++;

                            $cityCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemName = $itemDetails['Item'];
                            $itemCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];
                            $itemDetails = $arrResponse[$i]['ItemDetails']['ItemDetail'];

                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            if (isset($hotelInformationArray['Reports'])) {
                                if (!isset($hotelInformationArray['Reports']['Report'])) {
                                    $nodataCityItemCode .= $itemCode.'-'.$cityCode.'~';
                                } else {
                                    if(is_array($hotelInformationArray['Reports']['Report'])) {
                                        foreach($hotelInformationArray['Reports']['Report'] as $idx=>$report) {
                                            $dataInsertReports = array(
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'content' => $report,
                                                'type' => $arrResponseTag[$i]['ItemDetails']['ItemDetail']['HotelInformation']['Reports']['Report'][$idx]['@attributes']['Type'],
                                                'modified' => date("Y-m-d H:i:s")
                                            );
                                            $this->db->insert($table_gta_report, $dataInsertReports);
                                        }
                                    } else {
                                        $dataInsertReports = array(
                                            'city_code' => $cityCode,
                                            'item_code' => $itemCode,
                                            'content' => $hotelInformationArray['Reports']['Report'],
                                            'type' => $arrResponseTag[$i]['ItemDetails']['ItemDetail']['HotelInformation']['Reports']['Report'][$idx]['@attributes']['Type'],
                                            'modified' => date("Y-m-d H:i:s")
                                        );

                                        $this->db->insert($table_gta_report, $dataInsertReports);
                                    }

                                }
                            }

                            $this->db->set('sync_hotel_reports', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;
                        }
                        echo '; Proccessed Data : '. $procData.'<br>';

                    } else {
                        $procData++;
                        if (isset($arrResponse['ItemDetails']['ItemDetail']) && !empty($arrResponse['ItemDetails']['ItemDetail'])) {
                            //$dataInsertImage = array();
                            /* only single data query */
                            $cityCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];
                            $itemDetails = $arrResponse['ItemDetails']['ItemDetail'];

                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            $nodataCityItemCode = "";
                            if (isset($hotelInformationArray['Reports'])) {
                                if (!isset($hotelInformationArray['Reports']['Report']) || empty($hotelInformationArray['Reports']['Report']))
                                {
                                    $nodataCityItemCode .= $itemCode.'-'.$cityCode.'~';
                                } else {
                                    if(is_array($hotelInformationArray['Reports']['Report'])) {
                                        foreach($hotelInformationArray['Reports']['Report'] as $idx=>$report) {
                                            $dataInsertReports = array(
                                                'city_code' => $cityCode,
                                                'item_code' => $itemCode,
                                                'content' => $report,
                                                'type' => $arrResponseTag['ItemDetails']['ItemDetail']['HotelInformation']['Reports']['Report'][$idx]['@attributes']['Type'],
                                                'modified' => date("Y-m-d H:i:s")
                                            );

                                            //var_dump($dataInsertReports);
                                            $this->db->insert($table_gta_report, $dataInsertReports);
                                        }
                                    } else {
                                        $dataInsertReports = array(
                                            'city_code' => $cityCode,
                                            'item_code' => $itemCode,
                                            'content' => $hotelInformationArray['Reports']['Report'],
                                            'type' => $arrResponseTag['ItemDetails']['ItemDetail']['HotelInformation']['Reports']['Report']['@attributes']['Type'],
                                            'modified' => date("Y-m-d H:i:s")
                                        );
                                        //var_dump($dataInsertReports);

                                        $this->db->insert($table_gta_report, $dataInsertReports);
                                    }

                                }
                            }

                            $this->db->set('noitemdetailsdata', 1);
                            $this->db->set('sync_hotel_reports', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;
                        } else {

                            $this->db->set('noitemdetailsdata', 4); // if 4 means no data in hotel reports
                            $this->db->set('sync_hotel_reports', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$data_gta_item->city_code. '; Item : '. $data_gta_item->item_code;
                        }
                    }
                    echo '; Proccessed Data : '. $procData.'<br>';
                }

                flush();
                ob_flush();
            }
        }
        echo 'Done.<br>No Data for city & item code (separate data by ~): <br>'.$nodataCityItemCode;
    }

    public function updateLocationInformation()
    {
        $table_gta_item = "hotel_gta_item";
        $qry = $this->db->query("select distinct city_code, item_code FROM ".$table_gta_item." WHERE sync_location = 0 order by id asc");

        if ($qry->num_rows()) {
            $procData = 0;
            $table_gta_information = "hotel_gta_item_information";
            $nodataCityItemCode = "";
            foreach ($qry->result() as $data_gta_item) {
                 /* delete all image of hotel */
                $itemInformationReq = "";
                //$this->db->query("DELETE from $table_gta_information WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

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

                $parseResult            = simplexml_load_string($output);
                $array_output_tag       = json_decode(json_encode($parseResult), true);

                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);

                if (!empty($array_output_tag['ResponseDetails']) && !empty($array_output_tag['ResponseDetails']['SearchItemInformationResponse'])) {

                    $arrResponse = $array_output['ResponseDetails']['SearchItemInformationResponse'];
                    $arrResponseTag = $array_output_tag['ResponseDetails']['SearchItemInformationResponse'];

                    if (isset($array_output['ResponseDetails']['SearchItemInformationResponse'][0])) {
                        $totalArr = count($array_output['ResponseDetails']['SearchItemInformationResponse']);
                        /*$dataInsertImage = array();*/
                        for ($i = 0; $i < $totalArr; $i++) {
                            $procData++;
                            $cityCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];

                            $itemtype = $arrResponse[$i]['@attributes']['ItemType'];
                            $itemDetails = $arrResponse[$i]['ItemDetails']['ItemDetail'];
                            $itemContent = $itemDetails['Item'];
                            $cityContent = $itemDetails['City'];

                            $locationName = null;
                            if ( !isset($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location']) || empty($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location'])) {
                                $nodataCityItemCode .= $itemCode.'-'.$cityCode.'~';
                            } else {
                                if (is_array($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location']) && isset($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location'][0])) {
                                    $locationName = "";
                                    foreach ($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location'] as $location) {
                                            /*$locationName = $itemDetails['LocationDetails']['Location'];*/
                                            $locationName .= $itemDetails['LocationDetails']['Location'][$idxL];
                                            if(array_key_exists('Code', $location['@attributes'])) {
                                                $locationName .= ' ('.$location['@attributes']['Code'].'), ';
                                            }
                                    }
                                    /*$locationName .= ' ('.$arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'].')';*/
                                } else {
                                    $locationName = $itemDetails['LocationDetails']['Location'];
                                    if (isset($arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'])) {
                                        $locationName .= ' ('.$arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'].')';
                                    }
                                }
                            }

                            $hotelInformationArray = $itemDetails['HotelInformation'];
                            $addressLineArray = $hotelInformationArray['AddressLines'];

                            $addressLine1 = NULL;
                            $addressLine2 = NULL;
                            $addressLine3 = NULL;
                            $addressLine4 = NULL;
                            $addressLine5 = NULL;

                            if (isset($addressLineArray['AddressLine1'])) {
                                $addressLine1 = $addressLineArray['AddressLine1'];
                            }

                            if (isset($addressLineArray['AddressLine2'])) {
                                $addressLine2 = $addressLineArray['AddressLine2'];
                            }

                            if (isset($addressLineArray['AddressLine3'])) {
                                $addressLine3 = $addressLineArray['AddressLine3'];
                            }

                            if (isset($addressLineArray['AddressLine4'])) {
                                $addressLine4 = $addressLineArray['AddressLine4'];
                            }

                            if (isset($addressLineArray['AddressLine5'])) {
                                $addressLine5 = $addressLineArray['AddressLine5'];
                            }

                            $telephone = NULL; $fax = NULL; $web = NULL; $star_rating = NULL;
                            $category = NULL; $geo_latitude = NULL; $geo_longitude = NULL; $email_address = NULL;
                            $latitude = NULL; $longitude = NULL;

                            if (isset($addressLineArray['Telephone'])) {
                                $telephone = $addressLineArray['Telephone'];
                            }
                            if (isset($addressLineArray['Fax'])) {
                                $fax = $addressLineArray['Fax'];
                            }

                            if(isset($addressLineArray['EmailAddress'])) {
                                $email_address = $addressLineArray['EmailAddress'];
                            }
                            if (isset($addressLineArray['WebSite'])) {
                                $web = $addressLineArray['WebSite'];
                            }
                            if (isset($hotelInformationArray['StarRating'])) {
                                $star_rating = $hotelInformationArray['StarRating'];
                            }
                            if (isset($hotelInformationArray['Category'])) {
                                $category = $hotelInformationArray['Category'];
                            }
                            if (isset($hotelInformationArray['GeoCodes'])) {
                                $latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                                $longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                            }

                            $dataInsertItemInformation = array(
                                /*'city_code' => $cityCode,*/
                                'item_code' => $itemCode,
                                'item_content' => $itemContent,
                                'city_content' => $cityContent,
                                'location_text' => $locationName,
                                'AddressLine1' => $addressLine1,
                                'AddressLine2' => $addressLine2,
                                'AddressLine3' => $addressLine3,
                                'AddressLine4' => $addressLine4,
                                'AddressLine5' => $addressLine5,
                                'telephone' => $telephone,
                                'email_address' => $email_address,
                                'fax' => $fax,
                                'website' => $web,
                                'star_rating' => $star_rating,
                                'category' => $category,
                                'geo_latitude' => $latitude,
                                'geo_longitude' => $longitude,
                                'created' => date("Y-m-d H:i:s"),
                                'modified' => date("Y-m-d H:i:s")
                            );

                            //var_dump($dataInsertItemInformation);
                            //$this->db->insert($table_gta_information, $dataInsertItemInformation);
                            $this->db->where('city_code', $cityCode);
                            $this->db->update($table_gta_information, $dataInsertItemInformation, 'item_code');

                            $this->db->set('sync_location', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);

                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;

                        }

                        echo '; Proccessed Data : '. $procData.'<br>';
                    } else {
                        $procData++;
                        if (isset($arrResponse['ItemDetails']['ItemDetail'])) {
                            /* only single data query */
                            $itemtype = $arrResponse['@attributes']['ItemType'];
                            $itemDetails = $arrResponse['ItemDetails']['ItemDetail'];

                            $cityContent = $itemDetails['City'];
                            $cityCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemContent = $itemDetails['Item'];
                            $itemCode = $array_output_tag['ResponseDetails']['SearchItemInformationResponse']['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];

                            $locationName = null;
                            if (!isset($arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']) || empty($arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location'])) {
                                $nodataCityItemCode .= $itemCode.'-'.$cityCode.'~';
                            } else {
                                if(is_array($arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']) && array_key_exists('0', $arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location'])) {
                                foreach($arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location'] as $idxL => $location) {
                                        /*$arrLoc = array_unique($itemDetails['LocationDetails']['Location']);*/
                                        /*var_dump($arrLoc);*/

                                        $locationName .= $itemDetails['LocationDetails']['Location'][$idxL];
                                        if(array_key_exists('Code', $location['@attributes'])) {
                                            $locationName .= ' ('.$location['@attributes']['Code'].'), ';
                                        }
                                }
                                /*$locationName .= ' ('.$arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'].')';*/
                                } else {
                                    $locationName = $itemDetails['LocationDetails']['Location'];
                                    if (isset($arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'])) {
                                        $locationName .= ' ('.$arrResponseTag['ItemDetails']['ItemDetail']['LocationDetails']['Location']['@attributes']['Code'].')';
                                    }
                                }
                            }

                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            $addressLineArray = $hotelInformationArray['AddressLines'];

                            $addressLine1 = NULL;
                            $addressLine2 = NULL;
                            $addressLine3 = NULL;
                            $addressLine4 = NULL;
                            $addressLine5 = NULL;
                            $email_address = NULL;

                            if(isset($addressLineArray['AddressLine1'])) {
                                $addressLine1 = $addressLineArray['AddressLine1'];
                            }

                            if(isset($addressLineArray['AddressLine2'])) {
                                $addressLine2 = $addressLineArray['AddressLine2'];
                            }

                            if(isset($addressLineArray['AddressLine3'])) {
                                $addressLine3 = $addressLineArray['AddressLine3'];
                            }

                            if(isset($addressLineArray['AddressLine4'])) {
                                $addressLine4 = $addressLineArray['AddressLine4'];
                            }

                            if(isset($addressLineArray['AddressLine5'])) {
                                $addressLine5 = $addressLineArray['AddressLine5'];
                            }

                            $telephone = NULL; $fax = NULL; $web = NULL; $star_rating = NULL;
                            $category = NULL; $latitude = NULL; $longitude = NULL;

                            if(isset($addressLineArray['Telephone'])) {
                                $telephone = $addressLineArray['Telephone'];
                            }
                            if(isset($addressLineArray['EmailAddress'])) {
                                $email_address = $addressLineArray['EmailAddress'];
                            }
                            if(isset($addressLineArray['Fax'])) {
                                $fax = $addressLineArray['Fax'];
                            }
                            if(isset($addressLineArray['WebSite'])) {
                                $web = $addressLineArray['WebSite'];
                            }
                            if(isset($hotelInformationArray['StarRating'])) {
                                $star_rating = $hotelInformationArray['StarRating'];
                            }
                            if(isset($hotelInformationArray['Category'])) {
                                $category = $hotelInformationArray['Category'];
                            }
                            if(isset($hotelInformationArray['GeoCodes'])) {
                                $latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                                $longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                            }


                            $dataInsertItemInformation = array(
                                /*'city_code' => $cityCode,*/
                                /*'item_code' => $itemCode,*/
                                'item_content' => $itemContent,
                                'city_content' => $cityContent,
                                'location_text' => $locationName,
                                'AddressLine1' => $addressLine1,
                                'AddressLine2' => $addressLine2,
                                'AddressLine3' => $addressLine3,
                                'AddressLine4' => $addressLine4,
                                'AddressLine5' => $addressLine5,
                                'telephone' => $telephone,
                                'email_address' => $email_address,
                                'fax' => $fax,
                                'website' => $web,
                                'star_rating' => $star_rating,
                                'category' => $category,
                                'geo_latitude' => $latitude,
                                'geo_longitude' => $longitude,
                                'created' => date("Y-m-d H:i:s"),
                                'modified' => date("Y-m-d H:i:s")
                            );

                            //var_dump($dataInsertItemInformation);
                            /*$this->db->insert($table_gta_information, $dataInsertItemInformation);*/
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_information, $dataInsertItemInformation);

                            $this->db->set('noitemdetailsdata', 1);
                            $this->db->set('sync_location', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$cityCode. '; Item : '. $itemCode;
                        } else {
                            $this->db->set('noitemdetailsdata', 5); // if 5 means no data in hotel location
                            $this->db->set('sync_location', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $data_gta_item->city_code);
                            $this->db->where('item_code', $data_gta_item->item_code);
                            $this->db->update($table_gta_item);
                            echo 'Done Process. City : '.$data_gta_item->city_code. '; Item : '. $data_gta_item->item_code;
                        }

                    }
                    echo '; Proccessed Data : '. $procData.'<br>';
                }

                flush();
                ob_flush();
            }
        }

        echo 'Done.<br>No Data for city & item code (separate data by ~): <br>'.$nodataCityItemCode;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */