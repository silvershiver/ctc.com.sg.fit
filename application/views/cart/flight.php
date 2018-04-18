<section id="flight_cart" class="tab-content">
    <article>
    	<h1>Flight - Cart List</h1>
		<?php echo $this->session->flashdata('empty_cart');?>
	    <?php
	    if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
	        if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
	    ?>
                <ul class="room-types">
                    <?php
                    $count_session_data = count($this->session->userdata('shoppingCartFlightCookie'));
                    $arrayCart = $this->session->userdata('shoppingCartFlightCookie');
                    for( $x=0; $x<$count_session_data; $x++ ) {
                    ?>
                    <li>
                        <div style="background-color:#efefef; padding:10px; text-align: center">
                            <span style="font-size:16px; color:#1ba0e2"><b>Departure Details</b></span>
                        </div>
                        <!--DEPARTURE-->
                        <?php
                        if( strpos($arrayCart[$x]["departureFlightName"], '~') !== FALSE ) {
                            //indirect
                            $explodeCount = explode("~", $arrayCart[$x]["departureFlightName"]);
                            for($xe=0; $xe<count($explodeCount); $xe++) {
                                $arrDepartureFlightName         = explode("~", $arrayCart[$x]["departureFlightName"]);
                                $arrDepartureFlightCode         = explode("~", $arrayCart[$x]["departureFlightCode"]);
                                $arrDepartureTimeTaken          = explode("~", $arrayCart[$x]["departureTimeTaken"]);
                                $arrDepartureDateFrom           = explode("~", $arrayCart[$x]["departureDateFrom"]);
                                $arrDepartureDateTo             = explode("~", $arrayCart[$x]["departureDateTo"]);
                                $arrDepartureTimeFrom           = explode("~", $arrayCart[$x]["departureTimeFrom"]);
                                $arrDepartureTimeTo             = explode("~", $arrayCart[$x]["departureTimeTo"]);
                                $arrDepartureCityNameFrom       = explode("~", $arrayCart[$x]["departureCityNameFrom"]);
                                $arrDepartureCityNameTo         = explode("~", $arrayCart[$x]["departureCityNameTo"]);
                                $arrDepartureCityCodeFrom       = explode("~", $arrayCart[$x]["departureCityCodeFrom"]);
                                $arrDepartureCityCodeTo         = explode("~", $arrayCart[$x]["departureCityCodeTo"]);
                                $arrDepartureAirportNameFrom    = explode("~", $arrayCart[$x]["departureAirportNameFrom"]);
                                $arrDepartureAirportNameTo      = explode("~", $arrayCart[$x]["departureAirportNameTo"]);
                                $arrDepartureBaggage            = explode("~", $arrayCart[$x]["departureBaggage"]);
                                $arrDepartureMeal               = explode("~", $arrayCart[$x]["departureMeal"]);
                        ?>
                                <div class="tab">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr class="days">
                                            <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                                <div style="font-size:12px; text-align:center">
                                                    <?php
                                                    $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);
                                                    ?>
                                                    <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Flight details</h5>
                                                    <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
                                                    (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Time taken</h5>
                                                    <?php echo $arrDepartureTimeTaken[$xe]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure date</h5>
                                                    <?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
                                                    <?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival date</h5>
                                                    <?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
                                                    <?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Baggage Info</h5>
                                                    <b><?php echo $arrDepartureBaggage[$xe]; ?></b>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Meal Info</h5>
                                                    <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure Airport</h5>
                                                    <?php
                                                    $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
                                                    $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrDepartureAirportNameFrom[$xe]);
                                                    echo $airportNameDeparture;
                                                    ?>
                                                    <br />
                                                    (<?php echo $arrDepartureCityCodeFrom[$xe]; ?>)
                                                    -
                                                    <?php echo $arrDepartureCityNameFrom[$xe]; ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival Airport</h5>
                                                    <?php echo str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]); ?>
                                                    <br />
                                                    (<?php echo $arrDepartureCityCodeTo[$xe]; ?>)
                                                    -
                                                    <?php echo $arrDepartureCityNameTo[$xe]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="days">
                                            <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                        </tr>
                                    </table>
                                </div>
                        <?php
                            }
                        }
                        else if( strpos($arrayCart[$x]["departureFlightName"], '~') !== TRUE ) {
                            //direct
                        ?>
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr class="days">
                                        <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                            <div style="font-size:12px; text-align:center">
                                                <?php
                                                $imgReal = explode(" ", $arrayCart[$x]["departureFlightCode"]);
                                                ?>
                                                <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Flight details</h5>
                                                <?php echo str_replace("%20", " ", $arrayCart[$x]["departureFlightName"]); ?>
                                                (<?php echo $arrayCart[$x]["departureFlightCode"]; ?>)
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Time taken</h5>
                                                <?php echo $arrayCart[$x]["departureTimeTaken"]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure date</h5>
                                                <?php echo date("d M Y", strtotime($arrayCart[$x]["departureDateFrom"])); ?>
                                                <?php echo date("H:i", strtotime($arrayCart[$x]["departureTimeFrom"])); ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival date</h5>
                                                <?php echo date("d M Y", strtotime($arrayCart[$x]["departureDateTo"])); ?>
                                                <?php echo date("H:i", strtotime($arrayCart[$x]["departureTimeTo"])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Baggage Info</h5>
                                                <b><?php echo $arrayCart[$x]["departureBaggage"]; ?></b>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Meal Info</h5>
                                                <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure Airport</h5>
                                                <?php
                                                $airportNameDeparture = str_replace("International", "Int'l", $arrayCart[$x]["departureAirportNameFrom"]);
                                                $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrayCart[$x]["departureAirportNameFrom"]);
                                                echo $airportNameDeparture;
                                                ?>
                                                <br />
                                                (<?php echo $arrayCart[$x]["departureCityCodeFrom"]; ?>)
                                                -
                                                <?php echo $arrayCart[$x]["departureCityNameFrom"]; ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival Airport</h5>
                                                <?php echo str_replace("International", "Int'l", $arrayCart[$x]["departureAirportNameTo"]); ?>
                                                <br />
                                                (<?php echo $arrayCart[$x]["departureCityCodeTo"]; ?>)
                                                -
                                                <?php echo $arrayCart[$x]["departureCityNameTo"]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                        <?php
                        }
                        ?>
                        <!--END OF DEPARTURE-->

                        <?php
                        if( $arrayCart[$x]["arrivalFlightName"] != "" && $arrayCart[$x]["departureFlightCode"] != "" ) {
                        ?>
                            <div style="background-color:#efefef; padding:10px; text-align: center">
                                <span style="font-size:16px; color:#1ba0e2"><b>Return Details</b></span>
                            </div>
                            <!--ARRIVAL-->
                            <?php
                            if( strpos($arrayCart[$x]["arrivalFlightName"], '~') !== FALSE ) {
                                //indirect
                                $explodeCount = explode("~", $arrayCart[$x]["arrivalFlightName"]);
                                for($xe=0; $xe<count($explodeCount); $xe++) {
                                    $arrArrivalFlightName       = explode("~", $arrayCart[$x]["arrivalFlightName"]);
                                    $arrArrivalFlightCode       = explode("~", $arrayCart[$x]["arrivalFlightCode"]);
                                    $arrArrivalTimeTaken        = explode("~", $arrayCart[$x]["arrivalTimeTaken"]);
                                    $arrArrivalDateFrom         = explode("~", $arrayCart[$x]["arrivalDateFrom"]);
                                    $arrArrivalDateTo           = explode("~", $arrayCart[$x]["arrivalDateTo"]);
                                    $arrArrivalTimeFrom         = explode("~", $arrayCart[$x]["arrivalTimeFrom"]);
                                    $arrArrivalTimeTo           = explode("~", $arrayCart[$x]["arrivalTimeTo"]);
                                    $arrArrivalCityNameFrom     = explode("~", $arrayCart[$x]["arrivalCityNameFrom"]);
                                    $arrArrivalCityNameTo       = explode("~", $arrayCart[$x]["arrivalCityNameTo"]);
                                    $arrArrivalCityCodeFrom     = explode("~", $arrayCart[$x]["arrivalCityCodeFrom"]);
                                    $arrArrivalCityCodeTo       = explode("~", $arrayCart[$x]["arrivalCityCodeTo"]);
                                    $arrArrivalAirportNameFrom  = explode("~", $arrayCart[$x]["arrivalAirportNameFrom"]);
                                    $arrArrivalAirportNameTo    = explode("~", $arrayCart[$x]["arrivalAirportNameTo"]);
                                    $arrArrivalBaggage          = explode("~", $arrayCart[$x]["arrivalBaggage"]);
                                    $arrArrivalMeal             = explode("~", $arrayCart[$x]["arrivalMeal"]);
                            ?>
                                    <div class="tab">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr class="days">
                                                <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                                    <div style="font-size:12px; text-align:center">
                                                        <?php
                                                        $imgReal = explode(" ", $arrArrivalFlightCode[$xe]);
                                                        ?>
                                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Flight details</h5>
                                                        <?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
                                                        (<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                                    </div>
                                                </td>
                                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Time taken</h5>
                                                        <?php echo $arrArrivalTimeTaken[$xe]; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Departure date</h5>
                                                        <?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
                                                        <?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Arrival date</h5>
                                                        <?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
                                                        <?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Baggage Info</h5>
                                                        <b><?php echo $arrArrivalBaggage[$xe]; ?></b>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Meal Info</h5>
                                                        <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Departure Airport</h5>
                                                        <?php
                                                        $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
                                                        $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrArrivalAirportNameFrom[$xe]);
                                                        echo $airportNameArrival;
                                                        ?>
                                                        <br />
                                                        (<?php echo $arrArrivalCityCodeFrom[$xe]; ?>)
                                                        -
                                                        <?php echo $arrArrivalCityNameFrom[$xe]; ?>
                                                    </div>
                                                </td>
                                                <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                    <div style="font-size:15px">
                                                        <h5>Arrival Airport</h5>
                                                        <?php echo str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]); ?>
                                                        <br />
                                                        (<?php echo $arrArrivalCityCodeTo[$xe]; ?>)
                                                        -
                                                        <?php echo $arrArrivalCityNameTo[$xe]; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="days">
                                                <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                            </tr>
                                        </table>
                                    </div>
                            <?php
                                }
                            }
                            else if( strpos($arrayCart[$x]["arrivalFlightName"], '~') !== TRUE ) {
                                //direct
                            ?>
                                <div class="tab">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr class="days">
                                            <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                                <div style="font-size:12px; text-align:center">
                                                    <?php
                                                    $imgReal = explode(" ", $arrayCart[$x]["arrivalFlightCode"]);
                                                    ?>
                                                    <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Flight details</h5>
                                                    <?php echo str_replace("%20", " ", $arrayCart[$x]["arrivalFlightName"]); ?>
                                                    (<?php echo $arrayCart[$x]["arrivalFlightCode"]; ?>)
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Time taken</h5>
                                                    <?php echo $arrayCart[$x]["arrivalTimeTaken"]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure date</h5>
                                                    <?php echo date("d M Y", strtotime($arrayCart[$x]["arrivalDateFrom"])); ?>
                                                    <?php echo date("H:i", strtotime($arrayCart[$x]["arrivalTimeFrom"])); ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival date</h5>
                                                    <?php echo date("d M Y", strtotime($arrayCart[$x]["arrivalDateTo"])); ?>
                                                    <?php echo date("H:i", strtotime($arrayCart[$x]["arrivalTimeTo"])); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Baggage Info</h5>
                                                    <b><?php echo $arrayCart[$x]["arrivalBaggage"]; ?></b>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Meal Info</h5>
                                                    <b><?php echo ($arrayCart[$x]["arrivalMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure Airport</h5>
                                                    <?php
                                                    $airportNameArrival = str_replace("International", "Int'l", $arrayCart[$x]["arrivalAirportNameFrom"]);
                                                    $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrayCart[$x]["arrivalAirportNameFrom"]);
                                                    echo $airportNameArrival;
                                                    ?>
                                                    <br />
                                                    (<?php echo $arrayCart[$x]["arrivalCityCodeFrom"]; ?>)
                                                    -
                                                    <?php echo $arrayCart[$x]["arrivalCityNameFrom"]; ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival Airport</h5>
                                                    <?php echo str_replace("International", "Int'l", $arrayCart[$x]["arrivalAirportNameTo"]); ?>
                                                    <br />
                                                    (<?php echo $arrayCart[$x]["arrivalCityCodeTo"]; ?>)
                                                    -
                                                    <?php echo $arrayCart[$x]["arrivalCityNameTo"]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="days">
                                            <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                        </tr>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                            <!--END OF ARRIVAL-->
                        <?php
                        }
                        ?>
                        <!--PRICE AND OTHER INFOS-->
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>Pax Details Info</b>
                                </td>
                                <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>
                                        <?php echo $arrayCart[$x]["noofAdult"]; ?> Adult(s) &
                                        <?php echo $arrayCart[$x]["noofChild"]; ?> Child(s) &
                                        <?php echo $arrayCart[$x]["noofInfant"]; ?> Infant(s)
                                    </b>
                                </td>
                            </tr>
                            <?php if ($arrayCart[$x]['isReturnFlight'] && $arrayCart[$x]['isReturnFlight'] == 1) {

                            } else {
                            ?>
                                <tr>
                                    <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                        <b>Departure Price</b>
                                    </td>
                                    <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                        <b>$ <?php echo number_format($arrayCart[$x]["departureTotalPrice"], 2); ?></b>
                                    </td>
                                </tr>
                                <?php
                                if( $arrayCart[$x]["arrivalFlightName"] != "" && $arrayCart[$x]["departureFlightCode"] != "" ) {
                                ?>
                                    <tr>
                                        <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <b>Arrival Price</b>
                                        </td>
                                        <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                            <b>$ <?php echo number_format($arrayCart[$x]["arrivalTotalPrice"], 2); ?></b>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>

                            <tr>
                                <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>Total Price</b>
                                </td>
                                <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>
                                    $
                                    <?php
                                        $atp = 0; $dtp = 0;
                                        if($arrayCart[$x]["departureTotalPrice"] != 0 || $arrayCart[$x]["departureTotalPrice"] != "") {
                                            $total_flight_grand += $arrayCart[$x]["departureTotalPrice"];
                                            $dtp = $arrayCart[$x]["departureTotalPrice"];
                                        }
                                        if($arrayCart[$x]["arrivalTotalPrice"] != 0 || $arrayCart[$x]["arrivalTotalPrice"] != "") {
                                            $total_flight_grand += $arrayCart[$x]["arrivalTotalPrice"];
                                            $atp = $arrayCart[$x]["arrivalTotalPrice"];
                                        }
                                        echo number_format($dtp+$atp, 2);
                                    ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <div style="text-align:center; margin-top:5px">
                            <a href="<?php echo base_url(); ?>cart/remove_flight_cart_session/<?php echo $x; ?>" class="gradient-button" title="Remove" style="position:static">
                                Remove from cart
                            </a>
                        </div>
                        <!--END OF PRICE AND OTHER INFOS-->
                        <div style="border-bottom:2px solid black">&nbsp;</div>
                        <br />
                        </li>
                    <?php
                    }
                    ?>
                </ul>
        <?php
            }
            else {
	    ?>
		    	<ul class="room-types">
                    <article class="full-width">
    					<div style="text-align:center; color:red; font-size:16px">
    						No flight item found on your cart.11
    					</div>
    				</article>
                </ul>
	    <?php
            }
        }
        else if( $this->session->userdata('normal_session_id') == TRUE ) {
            $flights_cart = $this->All->select_template(
                "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
            );
            if( $flights_cart == TRUE ) {
                echo '<ul class="room-types">';
                foreach( $flights_cart AS $flight_cart ) {
        ?>
                <li>
                    <div style="background-color:#efefef; padding:10px; text-align: center">
                        <span style="font-size:16px; color:#1ba0e2"><b>Departure Details</b></span>
                    </div>
                    <!--DEPARTURE-->
                    <?php
                    if( strpos($flight_cart->departureFlightName, '~') !== FALSE )
                    {
                        //indirect
                        $explodeCount = explode("~", $flight_cart->departureFlightName);
                        for($xe=0; $xe<count($explodeCount); $xe++)
                        {
                            $arrDepartureFlightName         = explode("~", $flight_cart->departureFlightName);
                            $arrDepartureFlightCode         = explode("~", $flight_cart->departureFlightCode);
                            $arrDepartureTimeTaken          = explode("~", $flight_cart->departureTimeTaken);
                            $arrDepartureDateFrom           = explode("~", $flight_cart->departureDateFrom);
                            $arrDepartureDateTo             = explode("~", $flight_cart->departureDateTo);
                            $arrDepartureTimeFrom           = explode("~", $flight_cart->departureTimeFrom);
                            $arrDepartureTimeTo             = explode("~", $flight_cart->departureTimeTo);
                            $arrDepartureCityNameFrom       = explode("~", $flight_cart->departureCityNameFrom);
                            $arrDepartureCityNameTo         = explode("~", $flight_cart->departureCityNameTo);
                            $arrDepartureCityCodeFrom       = explode("~", $flight_cart->departureCityCodeFrom);
                            $arrDepartureCityCodeTo         = explode("~", $flight_cart->departureCityCodeTo);
                            $arrDepartureAirportNameFrom    = explode("~", $flight_cart->departureAirportNameFrom);
                            $arrDepartureAirportNameTo      = explode("~", $flight_cart->departureAirportNameTo);
                            $arrDepartureBaggage            = explode("~", $flight_cart->departureBaggage);
                            $arrDepartureMeal               = explode("~", $flight_cart->departureMeal);
                    ?>
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr class="days">
                                        <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                            <div style="font-size:12px; text-align:center">
                                                <?php
                                                $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);
                                                ?>
                                                <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Flight details</h5>
                                                <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
                                                (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Time taken</h5>
                                                <?php echo $arrDepartureTimeTaken[$xe]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure date</h5>
                                                <?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival date</h5>
                                                <?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Baggage Info</h5>
                                                <b><?php echo $arrDepartureBaggage[$xe]; ?></b>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Meal Info</h5>
                                                <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure Airport</h5>
                                                <?php
                                                $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
                                                $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrDepartureAirportNameFrom[$xe]);
                                                echo $airportNameDeparture;
                                                ?>
                                                <br />
                                                (<?php echo $arrDepartureCityCodeFrom[$xe]; ?>)
                                                -
                                                <?php echo $arrDepartureCityNameFrom[$xe]; ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival Airport</h5>
                                                <?php echo str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]); ?>
                                                <br />
                                                (<?php echo $arrDepartureCityCodeTo[$xe]; ?>)
                                                -
                                                <?php echo $arrDepartureCityNameTo[$xe]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                    <?php
                        }
                    }
                    else if( strpos($flight_cart->departureFlightName, '~') !== TRUE ) {
                        //direct
                    ?>
                        <div class="tab">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr class="days">
                                    <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $flight_cart->departureFlightCode);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $flight_cart->departureFlightName); ?>
                                            (<?php echo $flight_cart->departureFlightCode; ?>)
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Time taken</h5>
                                            <?php echo $flight_cart->departureTimeTaken; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Departure date</h5>
                                            <?php echo date("d M Y", strtotime($flight_cart->departureDateFrom)); ?>
                                            <?php echo date("H:i", strtotime($flight_cart->departureTimeFrom)); ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival date</h5>
                                            <?php echo date("d M Y", strtotime($flight_cart->departureDateTo)); ?>
                                            <?php echo date("H:i", strtotime($flight_cart->departureTimeTo)); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $flight_cart->departureBaggage; ?></b>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Departure Airport</h5>
                                            <?php
                                            $airportNameDeparture = str_replace("International", "Int'l", $flight_cart->departureAirportNameFrom);
                                            $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $flight_cart->departureAirportNameFrom);
                                            echo $airportNameDeparture;
                                            ?>
                                            <br />
                                            (<?php echo $flight_cart->departureCityCodeFrom; ?>)
                                            -
                                            <?php echo $flight_cart->departureCityNameFrom; ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival Airport</h5>
                                            <?php echo str_replace("International", "Int'l", $flight_cart->departureAirportNameTo); ?>
                                            <br />
                                            (<?php echo $flight_cart->departureCityCodeTo; ?>)
                                            -
                                            <?php echo $flight_cart->departureCityNameTo; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="days">
                                    <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                    <?php
                    }
                    ?>

                    <!--END OF DEPARTURE-->
                    <?php
                    if( $flight_cart->arrivalFlightName != "" && $flight_cart->departureFlightCode != "" ) {
                    ?>
                        <div style="background-color:#efefef; padding:10px; text-align: center">
                            <span style="font-size:16px; color:#1ba0e2"><b>Return Details</b></span>
                        </div>
                        <!--ARRIVAL-->
                        <?php
                        if( strpos($flight_cart->arrivalFlightName, '~') !== FALSE ) {
                            //indirect
                            $explodeCount = explode("~", $flight_cart->arrivalFlightName);
                            for($xe=0; $xe<count($explodeCount); $xe++) {
                                $arrArrivalFlightName       = explode("~", $flight_cart->arrivalFlightName);
                                $arrArrivalFlightCode       = explode("~", $flight_cart->arrivalFlightCode);
                                $arrArrivalTimeTaken        = explode("~", $flight_cart->arrivalTimeTaken);
                                $arrArrivalDateFrom         = explode("~", $flight_cart->arrivalDateFrom);
                                $arrArrivalDateTo           = explode("~", $flight_cart->arrivalDateTo);
                                $arrArrivalTimeFrom         = explode("~", $flight_cart->arrivalTimeFrom);
                                $arrArrivalTimeTo           = explode("~", $flight_cart->arrivalTimeTo);
                                $arrArrivalCityNameFrom     = explode("~", $flight_cart->arrivalCityNameFrom);
                                $arrArrivalCityNameTo       = explode("~", $flight_cart->arrivalCityNameTo);
                                $arrArrivalCityCodeFrom     = explode("~", $flight_cart->arrivalCityCodeFrom);
                                $arrArrivalCityCodeTo       = explode("~", $flight_cart->arrivalCityCodeTo);
                                $arrArrivalAirportNameFrom  = explode("~", $flight_cart->arrivalAirportNameFrom);
                                $arrArrivalAirportNameTo    = explode("~", $flight_cart->arrivalAirportNameTo);
                                $arrArrivalBaggage          = explode("~", $flight_cart->arrivalBaggage);
                                $arrArrivalMeal             = explode("~", $flight_cart->arrivalMeal);
                        ?>
                                <div class="tab">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr class="days">
                                            <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                                <div style="font-size:12px; text-align:center">
                                                    <?php
                                                    $imgReal = explode(" ", $arrArrivalFlightCode[$xe]);
                                                    ?>
                                                    <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Flight details</h5>
                                                    <?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
                                                    (<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Time taken</h5>
                                                    <?php echo $arrArrivalTimeTaken[$xe]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure date</h5>
                                                    <?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
                                                    <?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival date</h5>
                                                    <?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
                                                    <?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Baggage Info</h5>
                                                    <b><?php echo $arrArrivalBaggage[$xe]; ?></b>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Meal Info</h5>
                                                    <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Departure Airport</h5>
                                                    <?php
                                                    $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
                                                    $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrArrivalAirportNameFrom[$xe]);
                                                    echo $airportNameArrival;
                                                    ?>
                                                    <br />
                                                    (<?php echo $arrArrivalCityCodeFrom[$xe]; ?>)
                                                    -
                                                    <?php echo $arrArrivalCityNameFrom[$xe]; ?>
                                                </div>
                                            </td>
                                            <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                                <div style="font-size:15px">
                                                    <h5>Arrival Airport</h5>
                                                    <?php echo str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]); ?>
                                                    <br />
                                                    (<?php echo $arrArrivalCityCodeTo[$xe]; ?>)
                                                    -
                                                    <?php echo $arrArrivalCityNameTo[$xe]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="days">
                                            <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                        </tr>
                                    </table>
                                </div>
                        <?php
                            }
                        }
                        else if( strpos($flight_cart->arrivalFlightName, '~') !== TRUE ) {
                            //direct
                        ?>
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr class="days">
                                        <th width="25%" style="text-align:center; background-color:#efefef; vertical-align: top" rowspan="5">
                                            <div style="font-size:12px; text-align:center">
                                                <?php
                                                $imgReal = explode(" ", $flight_cart->arrivalFlightCode);
                                                ?>
                                                <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Flight details</h5>
                                                <?php echo str_replace("%20", " ", $flight_cart->arrivalFlightName); ?>
                                                (<?php echo $flight_cart->arrivalFlightCode; ?>)
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Time taken</h5>
                                                <?php echo $flight_cart->arrivalTimeTaken; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure date</h5>
                                                <?php echo date("d M Y", strtotime($flight_cart->arrivalDateFrom)); ?>
                                                <?php echo date("H:i", strtotime($flight_cart->arrivalTimeFrom)); ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival date</h5>
                                                <?php echo date("d M Y", strtotime($flight_cart->arrivalDateTo)); ?>
                                                <?php echo date("H:i", strtotime($flight_cart->arrivalTimeTo)); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Baggage Info</h5>
                                                <b><?php echo $flight_cart->arrivalBaggage; ?></b>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Meal Info</h5>
                                                <b><?php echo ($flight_cart->arrivalMeal == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:35%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure Airport</h5>
                                                <?php
                                                $airportNameArrival = str_replace("International", "Int'l", $flight_cart->arrivalAirportNameFrom);
                                                $airportNameArrival = str_replace("Kuala Lumpur", "KL", $flight_cart->arrivalAirportNameFrom);
                                                echo $airportNameArrival;
                                                ?>
                                                <br />
                                                (<?php echo $flight_cart->arrivalCityCodeFrom; ?>)
                                                -
                                                <?php echo $flight_cart->arrivalCityNameFrom; ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; background-color:#efefef; width:250px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival Airport</h5>
                                                <?php echo str_replace("International", "Int'l", $flight_cart->arrivalAirportNameTo); ?>
                                                <br />
                                                (<?php echo $flight_cart->arrivalCityCodeTo; ?>)
                                                -
                                                <?php echo $flight_cart->arrivalCityNameTo; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="4">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                        <?php
                        }
                        ?>
                        <!--END OF ARRIVAL-->
                    <?php
                    }
                    ?>
                    <!--PRICE AND OTHER INFOS-->
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>Pax Details Info</b>
                            </td>
                            <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>
                                    <?php echo $flight_cart->noofAdult; ?> Adult(s) &
                                    <?php echo $flight_cart->noofChild; ?> Child(s) &
                                    <?php echo $flight_cart->noofInfant; ?> Infant(s)
                                </b>
                            </td>
                        </tr>
                        <?php if ($flight_cart->isReturnFlight && $flight_cart->isReturnFlight == 1) {

                        } else {
                        ?>
                            <tr>
                                <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>Departure Price</b>
                                </td>
                                <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>$ <?php echo number_format($flight_cart->departureTotalPrice, 2); ?></b>
                                </td>
                            </tr>
                            <?php
                            if( $flight_cart->arrivalFlightName != "" && $flight_cart->departureFlightCode != "" ) {
                            ?>
                                <tr>
                                    <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                        <b>Arrival Price</b>
                                    </td>
                                    <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                        <b>$ <?php echo number_format($flight_cart->arrivalTotalPrice, 2); ?></b>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>

                        <tr>
                            <td colspan="2" width="200px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>Total Price</b>
                            </td>
                            <td colspan="5" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>
                                $
                                <?php
                                    $atp = 0; $dtp = 0;
                                    if($flight_cart->departureTotalPrice != 0 || $flight_cart->departureTotalPrice != "") {
                                        $total_flight_grand += $flight_cart->departureTotalPrice;
                                        $dtp = $flight_cart->departureTotalPrice;
                                    }
                                    if($flight_cart->arrivalTotalPrice != 0 || $flight_cart->arrivalTotalPrice != "") {
                                        $total_flight_grand += $flight_cart->arrivalTotalPrice;
                                        $atp = $flight_cart->arrivalTotalPrice;
                                    }
                                    echo number_format($dtp+$atp, 2);
                                    /*$total_flight_grand += $flight_cart->departureTotalPrice+$flight_cart->arrivalTotalPrice;
                                    echo number_format($flight_cart->departureTotalPrice+$flight_cart->arrivalTotalPrice, 2);*/
                                ?>
                                </b>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align:center; margin-top:5px">
                        <a href="<?php echo base_url(); ?>cart/remove_flight_cart_session/fid/<?php echo base64_encode(base64_encode(base64_encode($flight_cart->id))); ?>" class="gradient-button" title="Remove" style="position:static">
                            Remove from cart
                        </a>
                    </div>
                    <!--END OF PRICE AND OTHER INFOS-->
                    <div style="border-bottom:2px solid black">&nbsp;</div>
                    <br />
                </li>
        <?php
                }
                echo '</ul>';
            }
            else {
	    ?>
            <ul class="room-types">
		    	<article class="full-width">
	                <div style="text-align:center; color:red; font-size:16px">
	                    No flight item found on your cart.
	                </div>
	            </article>
            </ul>
	    <?php
            }
        }
        else {
        ?>
            <ul class="room-types">
                <article class="full-width">
                    <div style="text-align:center; color:red; font-size:16px">
                        No flight item found on your cart.
                    </div>
                </article>
            </ul>
        <?php
        }
        ?>
    </article>
</section>