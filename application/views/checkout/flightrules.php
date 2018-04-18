<?php
$file_datas = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');

$finalxml = array();
if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
    if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
        $count_session_data = count($this->session->userdata('shoppingCartFlightCookie'));
        $arrayCart = $this->session->userdata('shoppingCartFlightCookie');
        for( $x=0; $x<$count_session_data; $x++ ) {
            if( strpos($arrayCart[$x]["departureFlightName"], '~') !== FALSE ) {
                $explodeCount = explode("~", $arrayCart[$x]["departureFlightName"]);
                for($xe=0; $xe<count($explodeCount); $xe++) {
                    $arrDepartureFlightCode       = explode("~", $arrayCart[$x]["departureFlightCode"]);
                    $arrDepartureFareBasisCode      = explode("~", $arrayCart[$x]["departureFareBasisCode"]);
                    $arrDepartureCityCodeTo       = explode("~", $arrayCart[$x]["departureCityCodeTo"]);
                    $arrDepartureCityCodeFrom     = explode("~", $arrayCart[$x]["departureCityCodeFrom"]);
                    $arrDepartureDateFrom         = explode("~", $arrayCart[$x]["departureDateFrom"]);
                    $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);

                    $farebasecode = $arrDepartureFareBasisCode[$xe];
                    $datefrom = $arrDepartureDateFrom[$xe];
                    $destination_code = $arrDepartureCityCodeTo[$xe];
                    $origin_code = $arrDepartureCityCodeFrom[$xe];
                    $marketing_carrier = $imgReal[0];

                    $xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode);

                    $parseResult = simplexml_load_string($xml);
                    $finalxml[] = json_decode(json_encode($parseResult), true);
                }
            } else if( strpos($arrayCart[$x]["departureFlightName"], '~') !== TRUE ) {
                $imgReal = explode(" ", $arrayCart[$x]['departureFlightCode']);
                $farebasecode = $arrayCart[$x]['departureFareBasisCode'];
                $datefrom = $arrayCart[$x]['departureDateFrom'];
                $destination_code = $arrayCart[$x]['departureCityCodeTo'];
                $origin_code = $arrayCart[$x]['departureCityCodeFrom'];
                $marketing_carrier = $imgReal[0];

                $xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode);

                $parseResult = simplexml_load_string($xml);
                $finalxml[] = json_decode(json_encode($parseResult), true);
            }
        }
    }
} else {
     $flights_cart = $this->All->select_template(
        "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
    );
    if( $flights_cart == TRUE ) {
        $x = 0;
        foreach( $flights_cart AS $flight_cart ) {
            if( strpos($flight_cart->departureFlightName, '~') !== FALSE ) {
                //indirect
                $ctr = 0;
                $explodeCount = explode("~", $flight_cart->departureFlightName);
                for($xe=0; $xe<count($explodeCount); $xe++) {
                    $arrDepartureFlightCode       = explode("~", $flight_cart->departureFlightCode);
                    $arrDepartureFareBasisCode      = explode("~", $flight_cart->departureFareBasisCode);
                    $arrDepartureCityCodeTo       = explode("~", $flight_cart->departureCityCodeTo);
                    $arrDepartureCityCodeFrom     = explode("~", $flight_cart->departureCityCodeFrom);
                    $arrDepartureDateFrom         = explode("~", $flight_cart->departureDateFrom);
                    $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);

                    $farebasecode = $arrDepartureFareBasisCode[$xe];
                    $datefrom = $arrDepartureDateFrom[$xe];
                    $destination_code = $arrDepartureCityCodeTo[$xe];
                    $origin_code = $arrDepartureCityCodeFrom[$xe];
                    $marketing_carrier = $imgReal[0];

                    $xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode);

                    $parseResult = simplexml_load_string($xml);
                    $finalxml[] = json_decode(json_encode($parseResult), true);

                }
            } else if( strpos($flight_cart->departureFlightName, '~') !== TRUE ) {
                $imgReal = explode(" ", $flight_cart->departureFlightCode);
                $farebasecode = $flight_cart->departureFareBasisCode;
                $datefrom = $flight_cart->departureDateFrom;
                $destination_code = $flight_cart->departureCityCodeTo;
                $origin_code = $flight_cart->departureCityCodeFrom;
                $marketing_carrier = $imgReal[0];

                $xml = checkrules($datefrom, $destination_code, $marketing_carrier, $origin_code, $farebasecode);

                $parseResult = simplexml_load_string($xml);
                $finalxml[] = json_decode(json_encode($parseResult), true);
            }
        }
    }
}

echo '<pre>';
var_dump($finalxml);
die();















//$xml = checkrules($this->input->post('df'), $this->input->post('dc'), $this->input->post('mc'), $this->input->post('oc'), $this->input->post('fb'));

//$parseResult = simplexml_load_string($xml);
//$data['finalxml'] = json_decode(json_encode($parseResult), true);*/
/*if (count($finalxml['FareRuleInfo'])) {
    echo '<table style="width:100%">';

    if(count($finalxml['FareRuleInfo']['Header'])) {
        echo '<tr>';
        $idx = 0;

        foreach($finalxml['FareRuleInfo']['Header']['Line'] as $lineRule) {
            $idx++;
            echo '<td>'.$lineRule['Text'].'</td>';
            if($idx % 4 == 0) {
                echo '</tr><tr>';

            }
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '<table style="width:100%; text-align:left">';
    $idx = 1;
    foreach($finalxml['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
        echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
        $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
        $texting = str_replace('\r', '<br>', $texting);

        echo '<tr><td>'.nl2br($texting).'</td></tr>';
        $idx++;
    }

    /* uncomment this if prefering displaying routing info rather than rules
    echo '<tr><td>'.$finalxml['FareRuleInfo']['RoutingInfo']['Text'].'</td></tr>';
    echo '</table>';
} else {
    echo '<div style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
}*/
/*echo '</pre>';*/
?>