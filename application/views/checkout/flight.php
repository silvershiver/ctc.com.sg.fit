<?php
$ctr_ad = 0;
if( $this->session->userdata('shoppingCartFlightCookie') == TRUE ) {
    if( count($this->session->userdata('shoppingCartFlightCookie')) > 0 ) {
?>
		<br><br>
        <h1>Confirmed Booking Order - Flight</h1>
        <div style="background-color:#eff0f1">
            <div style="float:left; padding:10px">
                <img src="<?php echo base_url(); ?>assets/info.png" width="30" height="30" />
            </div>
            <div style="float:left; padding:0px; width:65%; font-size:14px; margin-top:15px">
                <b>Note: Make sure all data provided are correct and passport validity is still active.</b>
            </div>
            <div style="clear:both"></div>

        </div>
        <br />

        <ul class="room-types">
            <?php
            $count_session_data = count($this->session->userdata('shoppingCartFlightCookie'));
            $arrayCart = $this->session->userdata('shoppingCartFlightCookie');
            for( $x=0; $x<$count_session_data; $x++ ) {
            ?>
                <div style="background-color:#efefef; padding:10px; text-align: center">
                    <span style="font-size:16px; color:#1ba0e2"><b>Departure Details</b></span>
                </div>
                <!--DEPARTURE-->
                <?php
                $ctr =0;
                $arrivalDate = "";
                if( strpos($arrayCart[$x]["departureFlightName"], '~') !== FALSE ) {
                    //indirect

                    $explodeCount = explode("~", $arrayCart[$x]["departureFlightName"]);
                    for($xe=0; $xe<count($explodeCount); $xe++) {
                        $ctr++;
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
                        $arrDepartureFareBasisCode      = explode("~", $arrayCart[$x]["departureFareBasisCode"]);
                ?>
                        <div class="tab">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr class="days">
                                    <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Departure Airport</h5>
                                            <?php
                                            $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
                                            $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrDepartureAirportNameFrom[$xe]);
                                            echo $airportNameDeparture;
                                            ?>
                                            (<?php echo $arrDepartureCityCodeFrom[$xe]; ?>)
                                            -
                                            <?php echo $arrDepartureCityNameFrom[$xe]; ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival Airport</h5>
                                            <?php
                                            $airportName = str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]);
                                            $airportName = str_replace("Airport", "", $airportName);
                                            echo $airportName; ?>
                                            (<?php echo $arrDepartureCityCodeTo[$xe]; ?>)
                                            -
                                            <?php echo $arrDepartureCityNameTo[$xe]; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
                                            (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Time taken</h5>
                                            <?php echo $arrDepartureTimeTaken[$xe]; ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Departure</h5>
                                            <?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival</h5>
                                            <?php $arrivalDate = date("Y-m-d", strtotime($arrDepartureDateTo[$xe])); ?>
                                            <?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $arrDepartureBaggage[$xe]; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Total Transfer</h5>
                                            <b>
                                                <?php
                                                $totalTf = count($explodeCount);
                                                echo $totalTf-1;
                                                ?>
                                            </b>
                                        </div>
                                    </td>
                                    <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                    $ctr++;
                    //direct
                ?>
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                    <div style="font-size:12px; text-align:center">
                                        <?php
                                        $imgReal = explode(" ", $arrayCart[$x]["departureFlightCode"]);
                                        ?>
                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />

                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Departure Airport</h5>
                                        <?php
                                        $airportNameDeparture = str_replace("International", "Int'l", $arrayCart[$x]["departureAirportNameFrom"]);
                                        $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrayCart[$x]["departureAirportNameFrom"]);
                                        echo $airportNameDeparture;
                                        ?>
                                        (<?php echo $arrayCart[$x]["departureCityCodeFrom"]; ?>)
                                        -
                                        <?php echo $arrayCart[$x]["departureCityNameFrom"]; ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival Airport</h5>
                                        <?php
                                        $airportName = str_replace("International", "Int'l", $arrayCart[$x]["departureAirportNameTo"]);
                                        $airportName = str_replace("Airport", "", $airportName);
                                        echo $airportName; ?>
                                        (<?php echo $arrayCart[$x]["departureCityCodeTo"]; ?>)
                                        -
                                        <?php echo $arrayCart[$x]["departureCityNameTo"]; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Flight details</h5>
                                        <?php echo str_replace("%20", " ", $arrayCart[$x]["departureFlightName"]); ?>
                                        (<?php echo $arrayCart[$x]["departureFlightCode"]; ?>)
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Time taken</h5>
                                        <?php echo $arrayCart[$x]["departureTimeTaken"]; ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Departure</h5>
                                        <?php echo date("d M Y", strtotime($arrayCart[$x]["departureDateFrom"])); ?>
                                        <?php echo date("H:i", strtotime($arrayCart[$x]["departureTimeFrom"])); ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival</h5>
                                        <?php $arrivalDate = date("Y-m-d", strtotime($arrayCart[$x]["departureDateTo"])); ?>

                                        <?php echo date("d M Y", strtotime($arrayCart[$x]["departureDateTo"])); ?>
                                        <?php echo date("H:i", strtotime($arrayCart[$x]["departureTimeTo"])); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Baggage Info</h5>
                                        <b><?php echo $arrayCart[$x]["departureBaggage"]; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Meal Info</h5>
                                        <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Total Transfer</h5>
                                        <b>0</b>
                                    </div>
                                </td>
                                <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                if( $arrayCart[$x]["arrivalFlightName"] != "" && $arrayCart[$x]["arrivalFlightCode"] != "" ) {
                ?>
                    <div style="background-color:#efefef; padding:10px; text-align: center">
                        <span style="font-size:16px; color:#1ba0e2"><b>Return Details</b></span>
                    </div>
                    <!--ARRIVAL-->
                    <?php
                    if( strpos($arrayCart[$x]["arrivalFlightName"], '~') !== FALSE ) {
                        //indirect
                        $explodeCountA = explode("~", $arrayCart[$x]["arrivalFlightName"]);
                        for($xe=0; $xe<count($explodeCountA); $xe++) {
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
                            $arrArrivalFareBasisCode      = explode("~", $arrayCart[$x]["arrivalFareBasisCode"]);
                    ?>
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr class="days">
                                        <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                            <div style="font-size:12px; text-align:center">
                                                <?php
                                                $imgReal = explode(" ", $arrArrivalFlightCode[$xe]);
                                                ?>
                                                <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                                <!-- <div class="view-rules" data-base="<?php echo $arrArrivalFareBasisCode[$xe];?>" data-mc="<?php echo $imgReal[0];?>" data-df="<?php echo $arrArrivalDateFrom[$xe];?>" data-oc="<?php echo $arrArrivalCityCodeFrom[$xe];?>" data-dc="<?php echo $arrArrivalCityCodeTo[$xe];?>">View Flight Rules Before flight(?)</div> -->
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                            <div style="font-size:15px">
                                                <h5>Departure Airport</h5>
                                                <?php
                                                $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
                                                $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrArrivalAirportNameFrom[$xe]);
                                                echo $airportNameArrival;
                                                ?>
                                                (<?php echo $arrArrivalCityCodeFrom[$xe]; ?>)
                                                -
                                                <?php echo $arrArrivalCityNameFrom[$xe]; ?>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival Airport</h5>
                                                <?php
                                                $airportName = str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]);
                                                $airportName = str_replace("Airport", "", $airportName);
                                                echo $airportName; ?>
                                                (<?php echo $arrArrivalCityCodeTo[$xe]; ?>)
                                                -
                                                <?php echo $arrArrivalCityNameTo[$xe]; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Flight details</h5>
                                                <?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
                                                (<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Time taken</h5>
                                                <?php echo $arrArrivalTimeTaken[$xe]; ?>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Departure</h5>
                                                <?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Arrival</h5>
                                                <?php $arrivalDate = date("Y-m-d", strtotime($arrArrivalDateTo[$xe])); ?>
                                                <?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Baggage Info</h5>
                                                <b><?php echo $arrArrivalBaggage[$xe]; ?></b>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Meal Info</h5>
                                                <b><?php echo ($arrayCart[$x]["departureMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
                                                <h5>Total Transfer</h5>
                                                <b>
                                                    <?php
                                                        $totalATf = count($explodeCountA);
                                                        echo $totalATf-1;
                                                    ?>
                                                </b>
                                            </div>
                                        </td>
                                        <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                                    <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $arrayCart[$x]["arrivalFlightCode"]);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                            <!-- <div class="view-rules" data-base="<?php echo $arrayCart[$x]["arrivalFareBasisCode"];?>" data-mc="<?php echo $imgReal[0];?>" data-df="<?php echo $arrayCart[$x]["arrivalDateFrom"];?>" data-oc="<?php echo $arrayCart[$x]["arrivalCityCodeFrom"];?>" data-dc="<?php echo $arrayCart[$x]["arrivalCityCodeTo"];?>">View Flight Fare Rules Before you flight (?)</div> -->
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Departure Airport</h5>
                                            <?php
                                            $airportNameArrival = str_replace("International", "Int'l", $arrayCart[$x]["arrivalAirportNameFrom"]);
                                            $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrayCart[$x]["arrivalAirportNameFrom"]);
                                            echo $airportNameArrival;
                                            ?>
                                            (<?php echo $arrayCart[$x]["arrivalCityCodeFrom"]; ?>)
                                            -
                                            <?php echo $arrayCart[$x]["arrivalCityNameFrom"]; ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival Airport</h5>
                                            <?php
                                            $airportName = str_replace("International", "Int'l", $arrayCart[$x]["arrivalAirportNameTo"]);
                                            $airportName = str_replace("Airport", "", $airportName);
                                            echo $airportName; ?>
                                            (<?php echo $arrayCart[$x]["arrivalCityCodeTo"]; ?>)
                                            -
                                            <?php echo $arrayCart[$x]["arrivalCityNameTo"]; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $arrayCart[$x]["arrivalFlightName"]); ?>
                                            (<?php echo $arrayCart[$x]["arrivalFlightCode"]; ?>)
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Time taken</h5>
                                            <?php echo $arrayCart[$x]["arrivalTimeTaken"]; ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Departure</h5>
                                            <?php echo date("d M Y", strtotime($arrayCart[$x]["arrivalDateFrom"])); ?>
                                            <?php echo date("H:i", strtotime($arrayCart[$x]["arrivalTimeFrom"])); ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival</h5>
                                            <?php $arrivalDate = date("Y-m-d", strtotime($arrayCart[$x]["arrivalDateTo"])); ?>
                                            <?php echo date("d M Y", strtotime($arrayCart[$x]["arrivalDateTo"])); ?>
                                            <?php echo date("H:i", strtotime($arrayCart[$x]["arrivalTimeTo"])); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $arrayCart[$x]["arrivalBaggage"]; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($arrayCart[$x]["arrivalMeal"] == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Total Transfer</h5>
                                            <b>0</b>
                                        </div>
                                    </td>
                                    <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>Pax Details Info</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>
                                <?php echo $arrayCart[$x]["noofAdult"]; ?> Adult(s) &
                                <?php echo $arrayCart[$x]["noofChild"]; ?> Child(s) &
                                <?php echo $arrayCart[$x]["noofInfant"]; ?> Infant(s)
                            </b>
                        </td>
                    </tr>
                    <?php
                    if (!$arrayCart[$x]['isReturnFlight'] || $arrayCart[$x]['isReturnFlight'] == "0") {
                    ?>
                        <tr>
                            <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>Departure Price</b>
                            </td>
                            <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>$<?php echo number_format($arrayCart[$x]["departureTotalPrice"], 2); ?></b>
                            </td>
                        </tr>
                        <?php
                        if( $arrayCart[$x]["arrivalFlightName"] != "" && $arrayCart[$x]["departureFlightCode"] != "" ) {
                        ?>
                            <tr>
                                <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>Arrival Price</b>
                                </td>
                                <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                    <b>$<?php echo number_format($arrayCart[$x]["arrivalTotalPrice"], 2); ?></b>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                        ?>
                    <tr>
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>Total Price</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>
                            $
                            <?php
                                $total_flight_grand += $arrayCart[$x]["departureTotalPrice"]+$arrayCart[$x]["arrivalTotalPrice"];
                                echo number_format($arrayCart[$x]["departureTotalPrice"]+$arrayCart[$x]["arrivalTotalPrice"], 2);
                            ?>
                            </b>
                        </td>
                    </tr>
                </table>
                <!--END OF PRICE AND OTHER INFOS-->
                <!--DATA PASSENGERS-->
                <div style="margin-top:10px">
                    <!--ADULT PASSENGER FORM-->
                    <?php
                    if( $arrayCart[$x]["noofAdult"] > 0 ) {
                        for($ad=0; $ad<$arrayCart[$x]["noofAdult"]; $ad++) {
                            $ctr_ad++;
                    ?>
                            <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                                <div class="form_div particular-form">
                                    <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                        <div style="float:left; width:35%">
                                            <span style="color:green"><b>Adult <?php echo $ad+1; ?> Passenger</b></span>
                                        </div>
                                        <div style="float:left; width: 60%">
                                            <input style="margin: 0 20px 0 0" type="radio" value="" class="text main-contact" name="contact_personalAdult" id="contact_personal_<?php echo $ctr_ad;?>" data-checkedid="<?php echo $ctr_ad;?>"/>
                                            <label for="contact_personal_<?php echo $ctr_ad;?>">Use as contact person for this purchase.</label>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>

                                    <div>
                                        <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                        <div>
                                            <select name="titleAdult[<?php echo $x+1; ?>][]" required style="width:210px; height:37px" id="titleAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                                <option value="">- Choose title -</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Ms">Ms</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                                <input type="text" name="givennameAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH" id="givennameAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                                <input type="text" name="surnameAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN" id="surnameAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                                <input type="text" name="passport_noAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div style="position: relative">
                                                <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                                <input type="text" name="dob_adult[<?php echo $x+1;?>][]" required class="datepickerdobadult" readonly>
                                                <!--
                                                <select name="dob_yearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $dobYear = 2005;
                                                    for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
                                                    ?>
                                                    <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="dob_monthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="dob_dayAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $dobDay = 31;
                                                    for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                    ?>
                                                    <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select> -->
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                                <select name="nationalityAdult[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                                <select name="passportIssueCountryAdult[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                                <select name="passport_expiryYearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $expiryYear = 2031;
                                                    for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_expiryMonthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_expiryDateAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $expiryDate = 31;
                                                    for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                                <select name="passport_issueYearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $issueYear = date("Y");
                                                    for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_issueMonthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_issueDayAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $issueDate = 31;
                                                    for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                        <textarea name="passengerRemarks_Adult[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $ctr_ad;?>"  onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')"></textarea>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <!--END OF ADULT PASSENGER FORM-->
                    <!--CHILD PASSENGER FORM-->
                    <?php
                    if( $arrayCart[$x]["noofChild"] > 0 ) {
                        for($ch=0; $ch<$arrayCart[$x]["noofChild"]; $ch++) {
                    ?>
                            <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                                <div class="form_div particular-form">
                                    <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                        <div style="float:left">
                                            <span style="color:green"><b>Child <?php echo $ch+1; ?> Passenger</b></span>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                        <div>
                                            <select name="titleChild[<?php echo $x+1; ?>][]" required style="width:210px; height:37px">
                                                <option value="">- Choose title -</option>
                                                <option value="MSTR">Master</option>
                                                <option value="Miss">Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                                <input type="text" name="givennameChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                                <input type="text" name="surnameChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN">
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                                <input type="text" name="passport_noChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div style="position: relative">
                                                <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                                <input type="text" name="dob_child[<?php echo $x+1;?>][]" required class="datepickerdobchild" readonly data-retdate="<?php echo $arrivalDate;?>">
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                                <select name="nationalityChild[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                                <select name="passport_issueCountryChild[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                                <select name="passport_expiryYearChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $expiryYear = 2031;
                                                    for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_expiryMonthChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_expiryDayChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $expiryDate = 31;
                                                    for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                                <select name="passport_issueYearChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $issueYear = date("Y");
                                                    for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_issueMonthChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_issueDayChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $issueDate = 31;
                                                    for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                        <textarea name="passengerRemarks_Child[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;"></textarea>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <!--END OF CHILD PASSENGER FORM-->
                    <!--INFANT PASSENGER FORM-->
                    <?php
                    if( $arrayCart[$x]["noofInfant"] > 0 ) {
                        for($in=0; $in<$arrayCart[$x]["noofInfant"]; $in++) {
                    ?>
                            <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                                <div class="form_div particular-form">
                                    <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                        <div style="float:left">
                                            <span style="color:green"><b>Infant <?php echo $in+1; ?> Passenger</b></span>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                        <div>
                                            <select name="titleInfant[<?php echo $x+1; ?>][]" required style="width:210px; height:37px">
                                                <option value="">- Choose title -</option>
                                                <option value="MSTR">Master</option>
                                                <option value="Miss">Miss</option>
                                            </select>
                                        </div>
                                    </div>

                                     <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                                <input type="text" name="givennameInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                                <input type="text" name="surnameInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN">
                                            </div>
                                        </div>


                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                                <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                                <input type="text" name="passport_noInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div style="position: relative">
                                                <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                                <input type="text" name="dob_infant[<?php echo $x+1;?>][]" required class="datepickerdobinfant" readonly data-retdate="<?php echo $arrivalDate;?>">
                                                <!-- <select name="dob_yearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    $dobYear = $currentYear - 2;
                                                    for( $xYear=$dobYear; $xYear<=$currentYear; $xYear++ ) {
                                                    ?>
                                                    <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="dob_monthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="dob_dayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $dobDay = 31;
                                                    for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                    ?>
                                                    <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select> -->
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                                <select name="nationalityInfant[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                                <select name="passport_issueCountryInfant[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                    <?php
                                                    $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                    foreach( $nationalities AS $nationality ) {
                                                        if( $nationality->nicename == "Singapore" ) {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        else {
                                                    ?>
                                                    <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                        <?php echo $nationality->nicename; ?>
                                                    </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                                <select name="passport_expiryYearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $expiryYear = 2031;
                                                    for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_expiryMonthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_expiryDayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $expiryDate = 31;
                                                    for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                    ?>
                                                    <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="float:left; width:50%">
                                            <div>
                                                <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                                <select name="passport_issueYearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Year -</option>
                                                    <?php
                                                    $issueYear = date("Y");
                                                    for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <select name="passport_issueMonthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Month -</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                                <select name="passport_issueDayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                    <option value="">- Day -</option>
                                                    <?php
                                                    $issueDate = 31;
                                                    for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                    ?>
                                                    <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                        <div>
                                            <ul class="info-li">
                                                <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                        <textarea name="passengerRemarks_Infant[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;"></textarea>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <!--END OF INFANT PASSENGER FORM-->
                    <div style="clear:both"></div>
                </div>
                <!--END OF DATA PASSENGERS-->
                <br />
            <?php
            }
            ?>
        </ul>
<?php
    }
}
else if( $this->session->userdata('normal_session_id') == TRUE ) {
    $flights_cart = $this->All->select_template(
        "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
    );
    if( $flights_cart == TRUE ) {
        echo '<h1>Confirmed Booking Order - Flight</h1>
        <div style="background-color:#eff0f1">
            <div style="float:left; padding:10px">
                <img src="'.base_url().'assets/info.png" width="30" height="30" />
            </div>
            <div style="float:left; padding:0px; width:65%; font-size:14px; margin-top:15px">
                <b>Note: Make sure all data provided are correct and passport validity is still active.</b>
            </div>
            <div style="clear:both"></div>
        </div><br><ul class="room-types">';
        $x = 0;
        foreach( $flights_cart AS $flight_cart ) {
?>

            <div style="background-color:#efefef; padding:10px; text-align: center">
                <span style="font-size:16px; color:#1ba0e2"><b>Departure Details</b></span>
                <div style="clear:both"></div>
            </div>
            <!--DEPARTURE-->
            <?php
            if( strpos($flight_cart->departureFlightName, '~') !== FALSE ) {
                //indirect
                $ctr = 0;
                $explodeCount = explode("~", $flight_cart->departureFlightName);
                for($xe=0; $xe<count($explodeCount); $xe++) {
                    $ctr++;
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
                    $arrDepartureFareBasisCode      = explode("~", $flight_cart->departureFareBasisCode);
            ?>
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                    <div style="font-size:12px; text-align:center">
                                        <?php
                                        $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);
                                        ?>
                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Departure Airport</h5>
                                        <?php
                                        $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
                                        $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrDepartureAirportNameFrom[$xe]);
                                        echo $airportNameDeparture;
                                        ?>
                                        (<?php echo $arrDepartureCityCodeFrom[$xe]; ?>)
                                        -
                                        <?php echo $arrDepartureCityNameFrom[$xe]; ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival Airport</h5>
                                        <?php
                                        $airportName = str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]);
                                        $airportName = str_replace("Airport", "", $airportName);
                                        echo $airportName; ?>
                                        (<?php echo $arrDepartureCityCodeTo[$xe]; ?>)
                                        -
                                        <?php echo $arrDepartureCityNameTo[$xe]; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Flight details</h5>
                                        <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
                                        (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Time taken</h5>
                                        <?php echo $arrDepartureTimeTaken[$xe]; ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Departure</h5>
                                        <?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
                                        <?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival</h5>
                                        <?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
                                        <?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Baggage Info</h5>
                                        <b><?php echo $arrDepartureBaggage[$xe]; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Meal Info</h5>
                                        <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Total Transfer</h5>
                                        <b>
                                            <?php
                                            $totalTf = count($explodeCount);
                                            echo $totalTf-1;
                                            ?>
                                        </b>
                                    </div>
                                </td>
                                <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                $ctr++;
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
                            <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                <div style="font-size:15px">
                                    <h5>Departure Airport</h5>
                                    <?php
                                    $airportNameDeparture = str_replace("International", "Int'l", $flight_cart->departureAirportNameFrom);
                                    $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $flight_cart->departureAirportNameFrom);
                                    echo $airportNameDeparture;
                                    ?>
                                    (<?php echo $flight_cart->departureCityCodeFrom; ?>)
                                    -
                                    <?php echo $flight_cart->departureCityNameFrom; ?>
                                </div>
                            </td>
                            <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                <div style="font-size:15px">
                                    <h5>Arrival Airport</h5>
                                    <?php
                                    $airportName = str_replace("International", "Int'l", $flight_cart->departureAirportNameTo);
                                    $airportName = str_replace("Airport", "", $airportName);
                                    echo $airportName; ?>
                                    (<?php echo $flight_cart->departureCityCodeTo; ?>)
                                    -
                                    <?php echo $flight_cart->departureCityNameTo; ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Flight details</h5>
                                    <?php echo str_replace("%20", " ", $flight_cart->departureFlightName); ?>
                                    (<?php echo $flight_cart->departureFlightCode; ?>)
                                </div>
                            </td>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Time taken</h5>
                                    <?php echo $flight_cart->departureTimeTaken; ?>
                                </div>
                            </td>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Departure</h5>
                                    <?php echo date("d M Y", strtotime($flight_cart->departureDateFrom)); ?>
                                    <?php echo date("H:i", strtotime($flight_cart->departureTimeFrom)); ?>
                                </div>
                            </td>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Arrival</h5>
                                    <?php echo date("d M Y", strtotime($flight_cart->departureDateTo)); ?>
                                    <?php echo date("H:i", strtotime($flight_cart->departureTimeTo)); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Baggage Info</h5>
                                    <b><?php echo $flight_cart->departureBaggage; ?></b>
                                </div>
                            </td>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Meal Info</h5>
                                    <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                </div>
                            </td>
                            <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                <div style="font-size:15px">
                                    <h5>Total Transfer</h5>
                                    <b>0</b>
                                </div>
                            </td>
                            <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
            if( $flight_cart->arrivalFlightName != "" && $flight_cart->arrivalFlightCode != "" ) {
            ?>
                <div style="background-color:#efefef; padding:10px; text-align: center">
                    <span style="font-size:16px; color:#1ba0e2"><b>Return Details</b></span>
                </div>
                <!--ARRIVAL-->
                <?php
                if( strpos($flight_cart->arrivalFlightName, '~') !== FALSE ) {
                    //indirect
                    $explodeCountA = explode("~", $aflight_cart->arrivalFlightName);
                    for($xe=0; $xe<count($explodeCountA); $xe++) {
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
                                    <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $arrArrivalFlightCode[$xe]);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Departure Airport</h5>
                                            <?php
                                            $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
                                            $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrArrivalAirportNameFrom[$xe]);
                                            echo $airportNameArrival;
                                            ?>
                                            (<?php echo $arrArrivalCityCodeFrom[$xe]; ?>)
                                            -
                                            <?php echo $arrArrivalCityNameFrom[$xe]; ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival Airport</h5>
                                            <?php
                                            $airportName = str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]);
                                            $airportName = str_replace("Airport", "", $airportName);
                                            echo $airportName; ?>
                                            (<?php echo $arrArrivalCityCodeTo[$xe]; ?>)
                                            -
                                            <?php echo $arrArrivalCityNameTo[$xe]; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
                                            (<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Time taken</h5>
                                            <?php echo $arrArrivalTimeTaken[$xe]; ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Departure</h5>
                                            <?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Arrival</h5>
                                            <?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $arrArrivalBaggage[$xe]; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($flight_cart->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <h5>Total Transfer</h5>
                                            <b>
                                                <?php
                                                    $totalATf = count($explodeCountA);
                                                    echo $totalATf-1;
                                                ?>
                                            </b>
                                        </div>
                                    </td>
                                    <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                                <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                    <div style="font-size:12px; text-align:center">
                                        <?php
                                        $imgReal = explode(" ", $flight_cart->arrivalFlightCode);
                                        ?>
                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Departure Airport</h5>
                                        <?php
                                        $airportNameArrival = str_replace("International", "Int'l", $flight_cart->arrivalAirportNameFrom);
                                        $airportNameArrival = str_replace("Kuala Lumpur", "KL", $flight_cart->arrivalAirportNameFrom);
                                        echo $airportNameArrival;
                                        ?>
                                        (<?php echo $flight_cart->arrivalCityCodeFrom; ?>)
                                        -
                                        <?php echo $flight_cart->arrivalCityNameFrom; ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival Airport</h5>
                                        <?php
                                        $airportName = str_replace("International", "Int'l", $flight_cart->arrivalAirportNameTo);
                                        $airportName = str_replace("Airport", "", $airportName);
                                        echo $airportName; ?>
                                        (<?php echo $flight_cart->arrivalCityCodeTo; ?>)
                                        -
                                        <?php echo $flight_cart->arrivalCityNameTo; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Flight details</h5>
                                        <?php echo str_replace("%20", " ", $flight_cart->arrivalFlightName); ?>
                                        (<?php echo $flight_cart->arrivalFlightCode; ?>)
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Time taken</h5>
                                        <?php echo $flight_cart->arrivalTimeTaken; ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Departure</h5>
                                        <?php echo date("d M Y", strtotime($flight_cart->arrivalDateFrom)); ?>
                                        <?php echo date("H:i", strtotime($flight_cart->arrivalTimeFrom)); ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Arrival</h5>
                                        <?php echo date("d M Y", strtotime($flight_cart->arrivalDateTo)); ?>
                                        <?php echo date("H:i", strtotime($flight_cart->arrivalTimeTo)); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Baggage Info</h5>
                                        <b><?php echo $flight_cart->arrivalBaggage; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Meal Info</h5>
                                        <b><?php echo ($flight_cart->arrivalMeal == "NO") ? "Not include" : "Include"; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
                                        <h5>Total Transfer</h5>
                                        <b>0</b>
                                    </div>
                                </td>
                                <td colspan="1" style="padding-bottom:0px">&nbsp;</td>
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
                    <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                        <b>Pax Details Info</b>
                    </td>
                    <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                        <b>
                            <?php echo $flight_cart->noofAdult; ?> Adult(s) &
                            <?php echo $flight_cart->noofChild; ?> Child(s) &
                            <?php echo $flight_cart->noofInfant; ?> Infant(s)
                        </b>
                    </td>
                </tr>
                <?php
                if (!$flight_cart->isReturnFlight || $flight_cart->isReturnFlight == "0") {
                ?>
                    <tr>
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>Departure Price</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>$<?php echo number_format($flight_cart->departureTotalPrice, 2); ?></b>
                        </td>
                    </tr>
                    <?php
                    if( $flight_cart->arrivalFlightName != "" && $flight_cart->departureFlightCode != "" ) {
                    ?>
                        <tr>
                            <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>Arrival Price</b>
                            </td>
                            <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>$<?php echo number_format($flight_cart->arrivalTotalPrice, 2); ?></b>
                            </td>
                        </tr>
                    <?php
                    }
                }
                    ?>
                <tr>
                    <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                        <b>Total Price</b>
                    </td>
                    <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                        <b>
                        $
                        <?php
                            $total_flight_grand += $flight_cart->departureTotalPrice+$flight_cart->arrivalTotalPrice;
                            echo number_format($flight_cart->departureTotalPrice+$flight_cart->arrivalTotalPrice, 2);
                        ?>
                        </b>
                    </td>
                </tr>
            </table>
            <!--END OF PRICE AND OTHER INFOS-->
            <!--DATA PASSENGERS-->
            <div style="margin-top:10px">
                <!--ADULT PASSENGER FORM-->
                <?php
                if( $flight_cart->noofAdult > 0 ) {
                    for($ad=0; $ad<$flight_cart->noofAdult; $ad++) {
                        $ctr_ad++;
                ?>
                        <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                            <div class="form_div particular-form">
                                <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div style="float:left; width:35%">
                                        <span style="color:green"><b>Adult <?php echo $ad+1; ?> Passenger</b></span>
                                    </div>
                                    <div style="float:left; width: 60%">
                                        <input style="margin: 0 20px 0 0" type="radio" value="" class="text main-contact" name="contact_personalAdult" id="contact_personal_<?php echo $ctr_ad;?>" data-checkedid="<?php echo $ctr_ad;?>"/>
                                        <label for="contact_personal_<?php echo $ctr_ad;?>">Use as contact person for this purchase.</label>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                    <div>
                                        <select name="titleAdult[<?php echo $x+1; ?>][]" required style="width:210px; height:37px" id="titleAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                            <option value="">- Choose title -</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Ms">Ms</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                            <input type="text" name="givennameAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH" id="givennameAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                            <input type="text" name="surnameAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN" id="surnameAdult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                            <input type="text" name="passport_noAdult[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                            <select name="dob_yearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $dobYear = 2005;
                                                for( $xYear=1920; $xYear<=$dobYear; $xYear++ ) {
                                                ?>
                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="dob_monthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="dob_dayAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $dobDay = 31;
                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                ?>
                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                            <select name="nationalityAdult[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                            <select name="passportIssueCountryAdult[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                            <select name="passport_expiryYearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $expiryYear = 2031;
                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                ?>
                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_expiryMonthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_expiryDateAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $expiryDate = 31;
                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                ?>
                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                            <select name="passport_issueYearAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $issueYear = date("Y");
                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                ?>
                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_issueMonthAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_issueDayAdult[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $issueDate = 31;
                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                ?>
                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                    <textarea name="passengerRemarks_Adult[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;" id="passengerRemarks_Adult_<?php echo $ctr_ad;?>" onchange="javascript:checkActiveCP('<?php echo $ctr_ad;?>')"></textarea>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <!--END OF ADULT PASSENGER FORM-->
                <!--CHILD PASSENGER FORM-->
                <?php
                if( $flight_cart->noofChild > 0 ) {
                    for($ch=0; $ch<$flight_cart->noofChild; $ch++) {
                ?>
                        <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                            <div class="form_div particular-form">
                                <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div style="float:left">
                                        <span style="color:green"><b>Child <?php echo $ch+1; ?> Passenger</b></span>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                    <div>
                                        <select name="titleChild[<?php echo $x+1; ?>][]" required style="width:210px; height:37px">
                                            <option value="">- Choose title -</option>
                                            <option value="MSTR">Master</option>
                                            <option value="Miss">Miss</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                            <input type="text" name="givennameChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                            <input type="text" name="surnameChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                            <input type="text" name="passport_noChild[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div class="childbod">
                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                            <select name="dob_yearChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkChildAge">
                                                <option value="">- Year -</option>
                                                <?php
                                                $currentYear = date("Y");
                                                $dobYear = $currentYear - 11;
                                                for( $xYear=$dobYear; $xYear<=$currentYear - 2; $xYear++ ) {
                                                ?>
                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="dob_monthChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkChildAge">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="dob_dayChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkChildAge">
                                                <option value="">- Day -</option>
                                                <?php
                                                $dobDay = 31;
                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                ?>
                                                    <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                            <select name="nationalityChild[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                            <select name="passport_issueCountryChild[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                            <select name="passport_expiryYearChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $expiryYear = 2031;
                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                ?>
                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_expiryMonthChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_expiryDayChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $expiryDate = 31;
                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                ?>
                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                            <select name="passport_issueYearChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $issueYear = date("Y");
                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                ?>
                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_issueMonthChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_issueDayChild[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $issueDate = 31;
                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                ?>
                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                    <textarea name="passengerRemarks_Child[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;"></textarea>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <!--END OF CHILD PASSENGER FORM-->
                <!--INFANT PASSENGER FORM-->
                <?php
                if( $flight_cart->noofInfant > 0 ) {
                    for($in=0; $in<$flight_cart->noofInfant; $in++) {
                ?>
                        <div class="tab_container" style="font-size:14px; float:left; width:47%; margin-right:10px">
                            <div class="form_div particular-form">
                                <div style="border-bottom: 1px dotted #ccc ; padding-bottom: 10px; margin-bottom: 10px;">
                                    <div style="float:left">
                                        <span style="color:green"><b>Infant <?php echo $in+1; ?> Passenger</b></span>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>

                                    <div style="margin-top:10px; margin-bottom:5px">Title</div>
                                    <div>
                                        <select name="titleInfant[<?php echo $x+1; ?>][]" required style="width:210px; height:37px">
                                            <option value="">- Choose title -</option>
                                            <option value="MSTR">Master</option>
                                            <option value="Miss">Miss</option>
                                        </select>
                                    </div>
                                </div>

                                 <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">First, Middle Name</div>
                                            <input type="text" name="givennameInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="GARYCHENGPOH">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Last/Family Name</div>
                                            <input type="text" name="surnameInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%" class="check_name upper" onkeypress="return onlyAlphabets(event,this);" placeholder="TAN">
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. If you have a middle name, add it after the first name. Enter your name with no space.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Name changes is not allowed once the ticket are issued.</li>
                                            <li class="circle" style="font-size: 1.3em !important">*. Please enter the passenger's name <b>EXACTLY</b> as shown on the <b>PASSPORTS</b> (otherwise there's a possibility to be rejected at check-in)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport No.</div>
                                            <input type="text" name="passport_noInfant[<?php echo $x+1; ?>][]" required style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px; width:75%"  onkeypress="return onlyAlphabetNumber(event,this);" maxlength="50" minlength="6">
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div class="infantbod">
                                            <div style="margin-top:10px; margin-bottom:5px">Date Of Birth</div>
                                            <select name="dob_yearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkInfantAge">
                                                <option value="">- Year -</option>
                                                <?php
                                                $currentYear = date("Y");
                                                $dobYear = $currentYear - 2;
                                                for( $xYear=$dobYear; $xYear<=$currentYear; $xYear++ ) {
                                                ?>
                                                <option value="<?php echo $xYear; ?>"><?php echo $xYear; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="dob_monthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkInfantAge">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="dob_dayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px" class="checkInfantAge">
                                                <option value="">- Day -</option>
                                                <?php
                                                $dobDay = 31;
                                                for( $xDay=1; $xDay<=$dobDay; $xDay++ ) {
                                                ?>
                                                <option value="<?php echo $xDay; ?>"><?php echo $xDay; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Nationality</div>
                                            <select name="nationalityInfant[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Country</div>
                                            <select name="passport_issueCountryInfant[<?php echo $x+1; ?>][]" required style="width:80%; height:37px">
                                                <?php
                                                $nationalities = $this->All->select_template_with_order("nicename", "ASC", "countries");
                                                foreach( $nationalities AS $nationality ) {
                                                    if( $nationality->nicename == "Singapore" ) {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>" SELECTED>
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                    else {
                                                ?>
                                                <option title="<?php echo $nationality->phonecode; ?>" value="<?php echo $nationality->nicename; ?>">
                                                    <?php echo $nationality->nicename; ?>
                                                </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Expiry Date</div>
                                            <select name="passport_expiryYearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $expiryYear = 2031;
                                                for( $expiryY=2014; $expiryY<=$expiryYear; $expiryY++ ) {
                                                ?>
                                                <option value="<?php echo $expiryY; ?>"><?php echo $expiryY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_expiryMonthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_expiryDayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $expiryDate = 31;
                                                for( $expiryD=1; $expiryD<=$expiryDate; $expiryD++ ) {
                                                ?>
                                                <option value="<?php echo $expiryD; ?>"><?php echo $expiryD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="float:left; width:50%">
                                        <div>
                                            <div style="margin-top:10px; margin-bottom:5px">Passport Issue Date</div>
                                            <select name="passport_issueYearInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Year -</option>
                                                <?php
                                                $issueYear = date("Y");
                                                for( $issueY=2001; $issueY<=$issueYear; $issueY++ ) {
                                                ?>
                                                <option value="<?php echo $issueY; ?>"><?php echo $issueY; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="passport_issueMonthInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Month -</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                            <select name="passport_issueDayInfant[<?php echo $x+1; ?>][]" required style="width:75px; height:37px">
                                                <option value="">- Day -</option>
                                                <?php
                                                $issueDate = 31;
                                                for( $issueD=1; $issueD<=$issueDate; $issueD++ ) {
                                                ?>
                                                <option value="<?php echo $issueD; ?>"><?php echo $issueD; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div>
                                        <ul class="info-li">
                                            <li class="circle" style="font-size: 1.3em !important">*. Please confirm your passport validity on your own. Some country require three / six months validity for entry.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div style="margin-top:40px; margin-bottom:5px">Passenger Remark</div>
                                    <textarea name="passengerRemarks_Infant[<?php echo $x+1;?>][]" class="form-control" rows="5" style="-webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius:0px;"></textarea>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <!--END OF INFANT PASSENGER FORM-->
                <div style="clear:both"></div>
            </div>
            <!--END OF DATA PASSENGERS-->
            <div style="border-bottom:2px solid black">&nbsp;</div>
            <br />
<?php
            $x++;
        }
        echo '</ul>';
    }
}
?>