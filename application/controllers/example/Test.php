<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/XMLTransactionHander.class.php';

class Test extends CI_Controller {

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
	
	public function start()
	{
		echo die("test");
	}
	
    public function index()
    {
        /* get max ID */
        $this->db->select_max('id');
        $qry = $this->db->get('hotel_gta_item');
        if($qry->num_rows()) {
            $totalData = $qry->row()->id;
        }

        $qry = $this->db->query("select distinct city_code, item_code FROM hotel_gta_item WHERE is_sync = 0 order by id asc LIMIT 100");

        if ($qry->num_rows()) {
            foreach ($qry->result() as $data_gta_item) {
                 /* delete all image of hotel */
                $itemInformationReq = "";
                $this->db->query("DELETE from hotel_gta_item_information_image_link WHERE city_code = '".$data_gta_item->city_code."' AND item_code = '".$data_gta_item->item_code."'");

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
                /*
                echo '<pre>';
                var_dump($array_output_tag);*/
                $parseResult            = simplexml_load_string($output, 'SimpleXMLElement', LIBXML_NOCDATA );
                $array_output       = json_decode(json_encode($parseResult), true);

                if (
                    array_key_exists('ResponseDetails', $array_output) &&
                    array_key_exists('SearchItemInformationResponse', $array_output['ResponseDetails'])
                ) {
                    $arrResponse = $array_output['ResponseDetails']['SearchItemInformationResponse'];
                    $arrResponseTag = $array_output_tag['ResponseDetails']['SearchItemInformationResponse'];

                    if (array_key_exists('0', $array_output['ResponseDetails']['SearchItemInformationResponse'])) {
                        $totalArr = count($array_output['ResponseDetails']['SearchItemInformationResponse']);
                        /*$dataInsertImage = array();*/
                        for ($i = 0; $i < $totalArr; $i++) {
                            $itemtype = $arrResponse[$i]['@attributes']['ItemType'];
                            $itemDetails = $arrResponse[$i]['ItemDetails']['ItemDetail'];

                            $cityName = $itemDetails['City'];
                            $cityCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['City']['@attributes']['Code'];

                            $itemName = $itemDetails['Item'];
                            $itemCode = $arrResponseTag[$i]['ItemDetails']['ItemDetail']['Item']['@attributes']['Code'];

                            /*$locationCode =$arrResponseTag[$i]['ItemDetails']['ItemDetail']['LocationDetails']['Location'][0]['@attributes']['Code'];*/
                            /*$locationName = $itemDetails['LocationDetails']['Location'];*/

                            $hotelInformationArray = $itemDetails['HotelInformation'];

                            if(array_key_exists('Links', $hotelInformationArray)) {
                                $mapimagelink = "";
                                if(array_key_exists('MapLinks', $hotelInformationArray['Links'])) {
                                    $mapimagelink = $hotelInformationArray['Links']['MapLinks']['MapPageLink'];
                                    $dataInsertImage = array(
                                        'type' => 'mapimage',
                                        'city_code' => $cityCode,
                                        'item_code' => $itemCode,
                                        'image' => $mapimagelink,
                                        'last_modified' => date("Y-m-d H:i:s")
                                    );
                                    $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                }
                                if(array_key_exists('ImageLink', $hotelInformationArray['Links']['ImageLinks'])) {
                                    $imageLinkArr = $hotelInformationArray['Links']['ImageLinks']['ImageLink'];
                                    if(array_key_exists('0', $imageLinkArr)) {
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
                                                'image' => $imageLink,
                                                'height' => $imageHeight,
                                                'width' => $imageWidth,
                                                'last_modified' => date("Y-m-d H:i:s")
                                                );

                                            $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                        }
                                        /* multipla image */
                                    } else {
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
                                            'image' => $imageLink,
                                            'height' => $imageHeight,
                                            'width' => $imageWidth,
                                            'last_modified' => date("Y-m-d H:i:s")
                                            );


                                        $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                    }
                                }
                            }

                            if(array_key_exists('GeoCodes', $hotelInformationArray)) {
                                $geo_latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                                $geo_longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                            }

                            $this->db->set('is_sync', 1);
                            $this->db->set('modified', date("Y-m-d H:i:s"));
                            $this->db->where('city_code', $cityCode);
                            $this->db->where('item_code', $itemCode);
                            $this->db->update("hotel_gta_item");

                        }
                    } else {
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

                        $hotelInformationArray = $itemDetails['HotelInformation'];


                        if(array_key_exists('Links', $hotelInformationArray)) {
                            $mapimagelink = "";
                            if(array_key_exists('MapLinks', $hotelInformationArray['Links'])) {
                                $mapimagelink = $hotelInformationArray['Links']['MapLinks']['MapPageLink'];
                                $dataInsertImage = array(
                                    'type' => 'mapimage',
                                    'city_code' => $cityCode,
                                    'item_code' => $itemCode,
                                    'image' => $mapimagelink,
                                    'last_modified' => date("Y-m-d H:i:s")
                                );

                                $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                            }
                            if(array_key_exists('ImageLink', $hotelInformationArray['Links']['ImageLinks'])) {
                                if(array_key_exists('0', $hotelInformationArray['Links']['ImageLinks']['ImageLink'])) {
                                    $totalImageLink = count($hotelInformationArray['Links']['ImageLinks']['ImageLink']);
                                    for ($j = 0; $j < $totalImageLink; $j++) {
                                        $imageWidth = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['@attributes']['Width'];
                                        $imageHeight =  $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['@attributes']['Height'];
                                        $imageThumbnailLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['ThumbNail'];
                                        $imageLink = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['Image'];
                                        $imageText = $hotelInformationArray['Links']['ImageLinks']['ImageLink'][$j]['Text'];

                                        $dataInsertImage = array(
                                        'type' => 'image',
                                        'city_code' => $cityCode,
                                        'item_code' => $itemCode,
                                        'image' => $imageLink,
                                        'text' => $imageText,
                                        'thumbnail' => $imageThumbnailLink,
                                        'image' => $imageLink,
                                        'height' => $imageHeight,
                                        'width' => $imageWidth,
                                        'last_modified' => date("Y-m-d H:i:s")
                                        );
                                        $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                    }
                                    /* multipla image */
                                } else {
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
                                        'image' => $imageLink,
                                        'height' => $imageHeight,
                                        'width' => $imageWidth,
                                        'last_modified' => date("Y-m-d H:i:s")
                                        );

                                    $this->db->insert("hotel_gta_item_information_image_link", $dataInsertImage);
                                }
                            }
                        }

                        if(array_key_exists('GeoCodes', $hotelInformationArray)) {
                            $geo_latitude = $hotelInformationArray['GeoCodes']['Latitude'];
                            $geo_longitude = $hotelInformationArray['GeoCodes']['Longitude'];
                        }

                        $this->db->set('is_sync', 1);
                        $this->db->set('modified', date("Y-m-d H:i:s"));
                        $this->db->where('city_code', $cityCode);
                        $this->db->where('item_code', $itemCode);
                        $this->db->update("hotel_gta_item");

                    }
                }

            }
        }


    }
}

/* documentation if you need to breakdown the $hotelInformationArray
$hotelAddress = "";
if (array_key_exists('ADDRESSLINE1', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelAddress .=  $hotelInformationArray['ADDRESSLINES']['ADDRESSLINE1'];
                }
                if (array_key_exists('ADDRESSLINE2', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelAddress .=  $hotelInformationArray['ADDRESSLINES']['ADDRESSLINE2'];
                }
                if (array_key_exists('ADDRESSLINE3', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelAddress .=  $hotelInformationArray['ADDRESSLINES']['ADDRESSLINE3'];
                }
                if (array_key_exists('ADDRESSLINE4', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelAddress .=  $hotelInformationArray['ADDRESSLINES']['ADDRESSLINE4'];
                }
                if (array_key_exists('ADDRESSLINE5', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelAddress .=  $hotelInformationArray['ADDRESSLINES']['ADDRESSLINE5'];
                }
                $hotelTelephone = "";
                if (array_key_exists('TELEPHONE', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelTelephone = $hotelInformationArray['ADDRESSLINES']['TELEPHONE'];
                }
                $hotelFax = "";
                if (array_key_exists('FAX', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelFax  = $hotelInformationArray['ADDRESSLINES']['TELEPHONE'];
                }
                $hotelWebsite = "";
                if (array_key_exists('WEBSITE', $hotelInformationArray['ADDRESSLINES'])) {
                    $hotelWebsite = $hotelInformationArray['ADDRESSLINES']['WEBSITE'];
                }
                $hotelRating = "";
                if (array_key_exists('STARRATING', $hotelInformationArray)) {
                    $hotelRating = $hotelInformationArray['STARRATING'];
                }
                $hotelCategory = "";
                if (array_key_exists('CATEGORY', $hotelInformationArray)) {
                    $hotelCategory = $hotelInformationArray['CATEGORY'];
                }

                $hotelAreaDetails = "";
                if (array_key_exists('AREADETAIL', $hotelInformationArray['AREADETAILS'])) {
                    [AREADETAIL] => Array
                    (
                        [0] => 75 kms to city centre
                        [1] => 75 kms to the nearest airport (beijing capital international airport)
                        [2] => 75 km to the nearest station (beijing railway station)
                        [3] => 60 minute walk to the nearest bus stop
                    )
                }

                [REPORTS] => Array
                (
                    [REPORT] => Array
                        (
                            [0] => Array
                                (
                                    [content] => The Great Wall Exit at Shuiguan, Badaling Highway, Beijing
Located in the Shuiguan Mountains amidst 8 square kilometers of private land, 1 hour drive away from Beijing International Capital Airport, 20 kilometers away from the main train station (Qing Long Qiao station) and 50 minutes' drive from Beijing city center, the property enjoys an easy access via the Badaling Expressway. 15 minutes' drive from Badaling private airport, available for Helicopters (20' minutes transfer from Beijing Capital Airport) and small aircrafts on the 800 metres long runway.
                                    [TYPE] => location
                                )

                            [1] => Array
                                (
                                    [content] => Spacious bedrooms are elegantly furnished and with modern facilities, with Mountain View or Great Wall. There is also large common area where the guests may enjoy various indoor activities.
                                    [TYPE] => rooms
                                )

                            [2] => Array
                                (
                                    [content] => We have introduced four food series of classic Beijing, Sichuan and Cantonese cuisines, entitled Peking Roast Duck, Spicy Sichuan Food, Nourishing Cantonese Food and Vegetarian Food. It's most enjoyable to taste the mixture of Chinese and Western culinary cultures in orthodox traditional Chinese food plus red and white wines from around the world in refined and modernistic surroundings.
Courtyard Restaurant serves a variety of Chinese cuisines. It can hold 150 people at dinner or function as a meeting hall. The restaurant has a bar and four private rooms respectively named Spring, Summer, Autumn and Winter, each having a private yard attached. The partitions in the restaurant can be dismantled when necessary to turn the restaurant into a greater hall.
Terrace Lounge: Open 24 hours a day for breakfast, lunch and dinner. It can accommodate up to 80 persons.
                                    [TYPE] => restaurant
                                )

                            [3] => Array
                                (
                                    [content] => The site has so beautiful landscape as natural environment. The mountains enclosing 3 valleys have dramatic topography and make splendor scenes, and the Great Wall that is boundary of this site is running on the steep mountains. Thus, architecture here is not an object to see but a place where people with different background meet and communicate to each other and nature. Given nature and artificial architecture make new landscape with people. This culturescape is new nature, new place and new life.
                                    [TYPE] => exterior
                                )

                            [4] => Array
                                (
                                    [content] => The Clubhouse is the center of the project. Easy access between the houses
Landscape is the extension of the clubhouse, having linear elements connecting the building and road. There are fountains, wood decks and parking lots, however some parts of the exterior are remained as they are. All the artificial elements are delicately attached to the existing landscape. The edge should be treated very specially.
                                    [TYPE] => lobby
                                )

                            [5] => Array
                                (
                                    [content] => Commune by the Great Wall is a private collection of contemporary architecture designed by 12 Asian architects. It was exhibited at the 2002 la Biennale di Venezia and awarded a special prize. Commune by the Great Wall was named “A New Architectural Wonder of China” by Business Week in 2005. (RS 08/07)
                                    [TYPE] => general
                                )

                        )

                )

                 [ROOMCATEGORIES] => Array
                                                        (
                                                            [ROOMCATEGORY] => Array
                                                                (
                                                                    [ID] => 001:COM
                                                                    [DESCRIPTION] => Standard
                                                                    [ROOMDESCRIPTION] => Spacious bedrooms are elegantly furnished and with modern facilities, with Mountain View or Great Wall. There is also large common area where the guests may enjoy various indoor activities.
                                                                )

                                                        )

                                                    [ROOMTYPES] => Array
                                                        (
                                                            [ROOMCOUNT] => 92
                                                            [ROOMTYPE] => Array
                                                                (
                                                                    [0] => Array
                                                                        (
                                                                            [content] => Single rooms
                                                                            [CODE] => SB
                                                                        )

                                                                    [1] => Array
                                                                        (
                                                                            [content] => Double rooms
                                                                            [CODE] => DB
                                                                        )

                                                                    [2] => Array
                                                                        (
                                                                            [content] => Twin rooms
                                                                            [CODE] => TB
                                                                        )

                                                                    [3] => Array
                                                                        (
                                                                            [content] => Non-smoking rooms
                                                                            [CODE] => NS
                                                                        )

                                                                )

                                                        )

                                                    [ROOMFACILITIES] => Array
                                                        (
                                                            [FACILITY] => Array
                                                                (
                                                                    [0] => Array
                                                                        (
                                                                            [content] => Connection for laptop
                                                                            [CODE] => *LT
                                                                        )

                                                                    [1] => Array
                                                                        (
                                                                            [content] => Air conditioning
                                                                            [CODE] => *AC
                                                                        )

                                                                    [2] => Array
                                                                        (
                                                                            [content] => Television
                                                                            [CODE] => *TV
                                                                        )

                                                                    [3] => Array
                                                                        (
                                                                            [content] => Satellite television
                                                                            [CODE] => *SV
                                                                        )

                                                                    [4] => Array
                                                                        (
                                                                            [content] => Hairdryer
                                                                            [CODE] => *HD
                                                                        )

                                                                    [5] => Array
                                                                        (
                                                                            [content] => Voltage 220v
                                                                            [CODE] => *VL
                                                                        )

                                                                )

                                                        )

                                                    [FACILITIES] => Array
                                                        (
                                                            [FACILITY] => Array
                                                                (
                                                                    [6] => Array
                                                                        (
                                                                            [content] => Medium sized lobby
                                                                            [CODE] => *LS
                                                                        )

                                                                    [7] => Array
                                                                        (
                                                                            [content] => Earliest check-in at 14:00
                                                                            [CODE] => *EC
                                                                        )

                                                                    [8] => Array
                                                                        (
                                                                            [content] => Porterage 24 hour
                                                                            [CODE] => *PT
                                                                        )

                                                                    [9] => Array
                                                                        (
                                                                            [content] => Room service 24 hour
                                                                            [CODE] => *RS
                                                                        )

                                                                    [10] => Array
                                                                        (
                                                                            [content] => 3 floors
                                                                            [CODE] => *FL
                                                                        )

                                                                    [11] => Array
                                                                        (
                                                                            [content] => Car parking (Payable to hotel, if applicable)
                                                                            [CODE] => *CP
                                                                        )

                                                                    [12] => Array
                                                                        (
                                                                            [content] => Gymnasium
                                                                            [CODE] => *GY
                                                                        )

                                                                    [13] => Array
                                                                        (
                                                                            [content] => Sauna
                                                                            [CODE] => *SA
                                                                        )

                                                                    [14] => Array
                                                                        (
                                                                            [content] => Beauty parlour
                                                                            [CODE] => *BP
                                                                        )

                                                                    [15] => Array
                                                                        (
                                                                            [content] => Baby sitting
                                                                            [CODE] => *BS
                                                                        )

                                                                )

                                                        )
*/

