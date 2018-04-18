
<!--FLIGHT BOOKING CONFIRMED RESULT-->
<?php
$flightConfirms = $this->All->select_template("bookingRefID", $bookingOrderID, "flight_history_order");
if( $flightConfirms == TRUE ) {
?>
    <h1>Flight Confirmed Order</h1>
    <?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
        <ul class="room-types">
            <?php
            $xxx = 1;
            foreach( $flightConfirms AS $flightConfirm ) {
            ?>
            <li class="print">
             <div style="clear:both"></div>
                <div style="float:left"># <?php echo $xxx;?></div>
                <div style="float:right">
                    <span style="font-size:16px; font-weight:bold">
                        PNR: <span style="color:green"><?php echo $flightConfirm->flight_PNR; ?></span>
                    </span>
                    <span style="font-size:16px; font-weight:bold">
                        Booking ID: <span style="color:green">#<?php echo $bookingOrderID; ?></span>
                    </span>
                </div>
                <div style="clear:both"></div>
                <div style="background-color:#efefef; padding:10px; text-align: center">
                    <span style="font-size:16px; color:#1ba0e2"><b>Departure Details</b></span>
                </div>
                <!--DEPARTURE-->
                <?php
                if( strpos($flightConfirm->departureFlightName, '~') !== FALSE ) {
                    //indirect
                    $explodeCount = explode("~", $flightConfirm->departureFlightName);
                    for($xe=0; $xe<count($explodeCount); $xe++) {
                        $arrDepartureFlightName         = explode("~", $flightConfirm->departureFlightName);
                        $arrDepartureFlightCode         = explode("~", $flightConfirm->departureFlightCode);
                        $arrDepartureTimeTaken          = explode("~", $flightConfirm->departureTimeTaken);
                        $arrDepartureDateFrom           = explode("~", $flightConfirm->departureDateFrom);
                        $arrDepartureDateTo             = explode("~", $flightConfirm->departureDateTo);
                        $arrDepartureTimeFrom           = explode("~", $flightConfirm->departureTimeFrom);
                        $arrDepartureTimeTo             = explode("~", $flightConfirm->departureTimeTo);
                        $arrDepartureCityNameFrom       = explode("~", $flightConfirm->departureCityNameFrom);
                        $arrDepartureCityNameTo         = explode("~", $flightConfirm->departureCityNameTo);
                        $arrDepartureCityCodeFrom       = explode("~", $flightConfirm->departureCityCodeFrom);
                        $arrDepartureCityCodeTo         = explode("~", $flightConfirm->departureCityCodeTo);
                        $arrDepartureAirportNameFrom    = explode("~", $flightConfirm->departureAirportNameFrom);
                        $arrDepartureAirportNameTo      = explode("~", $flightConfirm->departureAirportNameTo);
                        $arrDepartureBaggage            = explode("~", $flightConfirm->departureBaggage);
                        $arrDepartureMeal               = explode("~", $flightConfirm->departureMeal);
                ?>
                        <div class="tab">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top">
                                        <div style="font-size:12px; text-align:center; vertical-align: top">
                                            <?php
                                            $imgReal = explode(" ", $arrDepartureFlightCode[$xe]);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:14px">
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
                                    <td colspan="2" style="text-align:left; width:50%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:14px">
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
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px" colspan="2">
                                        <div style="font-size:14px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
                                            (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Departure</h5>
                                            <?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:30%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Arrival</h5>
                                            <?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
                                            <?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                    <td style="text-align:left; width:25%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $arrDepartureBaggage[$xe]; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($arrDepartureMeal[$xe] == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Total Transfer</h5>
                                            <b>
                                                <?php
                                                $totalTf = count($explodeCount);
                                                echo $totalTf-1;
                                                ?>
                                            </b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Time taken</h5>
                                            <?php
                                            $arrDepartureTimeTaken[$xe] = str_replace("hours", "Hrs", strtolower($arrDepartureTimeTaken[$xe]));
                                            $arrDepartureTimeTaken[$xe] = str_replace("minutes", "Mins", strtolower($arrDepartureTimeTaken[$xe]));

                                            echo $arrDepartureTimeTaken[$xe]; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="days">
                                    <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="5">&nbsp;</th>
                                </tr>
                            </table>
                        </div>
                <?php
                    }
                }
                else if( strpos($flightConfirm->departureFlightName, '~') !== TRUE ) {
                    //direct
                ?>
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr>
                                <td width="10%" style="text-align:center; background-color:#efefef" valign="top">
                                    <div style="font-size:12px; text-align:center; vertical-align: top">
                                        <?php
                                        $imgReal = explode(" ", $flightConfirm->departureFlightCode);
                                        ?>
                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:14px">
                                        <h5>Departure Airport</h5>
                                        <?php
                                        $airportNameDeparture = str_replace("International", "Int'l", $flightConfirm->departureAirportNameFrom);
                                        $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $flightConfirm->departureAirportNameFrom);
                                        echo $airportNameDeparture;
                                        ?>
                                        (<?php echo $flightConfirm->departureCityCodeFrom; ?>)
                                        -
                                        <?php echo $flightConfirm->departureCityNameFrom; ?>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:50%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:14px">
                                        <h5>Arrival Airport</h5>
                                        <?php
                                        $airportName = str_replace("International", "Int'l", $flightConfirm->departureAirportNameTo);
                                        $airportName = str_replace("Airport", "", $airportName);
                                        echo $airportName; ?>
                                        (<?php echo $flightConfirm->departureCityCodeTo; ?>)
                                        -
                                        <?php echo $flightConfirm->departureCityNameTo; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                <td colspan="2" style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Flight details</h5>
                                        <?php echo str_replace("%20", " ", $flightConfirm->departureFlightName); ?>
                                        (<?php echo $flightConfirm->departureFlightCode; ?>)
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Departure</h5>
                                        <?php echo date("d M Y", strtotime($flightConfirm->departureDateFrom)); ?>
                                        <?php echo date("H:i", strtotime($flightConfirm->departureTimeFrom)); ?>
                                    </div>
                                </td>
                                <td style="text-align:left; width:30%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Arrival</h5>
                                        <?php echo date("d M Y", strtotime($flightConfirm->departureDateTo)); ?>
                                        <?php echo date("H:i", strtotime($flightConfirm->departureTimeTo)); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                <td style="text-align:left; width:25%; background-color:#efefef; padding-bottom:0px" width="20%">
                                    <div style="font-size:14px">
                                        <h5>Baggage Info</h5>
                                        <b><?php echo $flightConfirm->departureBaggage; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Meal Info</h5>
                                        <b><?php echo ($flightConfirm->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Total Transfer</h5>
                                        <b>0</b>
                                    </div>
                                </td>

                                <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:14px">
                                        <h5>Time taken</h5>
                                        <?php
                                        $timetaken = $flightConfirm->departureTimeTaken;
                                        $timetaken = str_replace("hours", "Hrs", strtolower($timetaken));
                                        $timetaken = str_replace("minutes", "Mins", strtolower($timetaken));
                                        echo $timetaken; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="days">
                                <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="5">&nbsp;</th>
                            </tr>
                        </table>
                    </div>
                <?php
                }
                ?>
                <!--END OF DEPARTURE-->
                <?php
                if( $flightConfirm->arrivalFlightName != "" && $flightConfirm->arrivalFlightCode != "" ) {
                ?>
                    <div style="background-color:#efefef; padding:10px; text-align: center">
                        <span style="font-size:16px; color:#1ba0e2"><b>Return Details</b></span>
                    </div>
                    <!--ARRIVAL-->
                    <?php
                    if( strpos($flightConfirm->arrivalFlightName, '~') !== FALSE ) {
                        //indirect
                        $explodeCountA = explode("~", $flightConfirm->arrivalFlightName);
                        for($xe=0; $xe<count($explodeCountA); $xe++) {
                            $arrArrivalFlightName       = explode("~", $flightConfirm->arrivalFlightName);
                            $arrArrivalFlightCode       = explode("~", $flightConfirm->arrivalFlightCode);
                            $arrArrivalTimeTaken        = explode("~", $flightConfirm->arrivalTimeTaken);
                            $arrArrivalDateFrom         = explode("~", $flightConfirm->arrivalDateFrom);
                            $arrArrivalDateTo           = explode("~", $flightConfirm->arrivalDateTo);
                            $arrArrivalTimeFrom         = explode("~", $flightConfirm->arrivalTimeFrom);
                            $arrArrivalTimeTo           = explode("~", $flightConfirm->arrivalTimeTo);
                            $arrArrivalCityNameFrom     = explode("~", $flightConfirm->arrivalCityNameFrom);
                            $arrArrivalCityNameTo       = explode("~", $flightConfirm->arrivalCityNameTo);
                            $arrArrivalCityCodeFrom     = explode("~", $flightConfirm->arrivalCityCodeFrom);
                            $arrArrivalCityCodeTo       = explode("~", $flightConfirm->arrivalCityCodeTo);
                            $arrArrivalAirportNameFrom  = explode("~", $flightConfirm->arrivalAirportNameFrom);
                            $arrArrivalAirportNameTo    = explode("~", $flightConfirm->arrivalAirportNameTo);
                            $arrArrivalBaggage          = explode("~", $flightConfirm->arrivalBaggage);
                            $arrArrivalMeal             = explode("~", $flightConfirm->arrivalMeal);
                    ?>
                            <div class="tab">
                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                    <tr>
                                        <td width="10%" style="text-align:center; background-color:#efefef" valign="top">
                                            <div style="font-size:12px; text-align:center">
                                                <?php
                                                $imgReal = explode(" ", $arrArrivalFlightCode[$xe]);
                                                ?>
                                                <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                            <div style="font-size:14px">
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
                                        <td colspan="2" style="text-align:left; width:50%; background-color:#efefef; padding-bottom: 0px">
                                            <div style="font-size:14px">
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
                                        <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                        <td colspan="2" style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Flight details</h5>
                                                <?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
                                                (<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                            </div>
                                        </td>

                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Departure</h5>
                                                <?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:30%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Arrival</h5>
                                                <?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
                                                <?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                        <td style="text-align:left; width:25%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Baggage Info</h5>
                                                <b><?php echo $arrArrivalBaggage[$xe]; ?></b>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Meal Info</h5>
                                                <b><?php echo ($arrArrivalMeal[$xe] == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Total Transfer</h5>
                                                <b>
                                                    <?php
                                                        $totalATf = count($explodeCountA);
                                                        echo $totalATf-1;
                                                    ?>
                                                </b>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:14px">
                                                <h5>Time taken</h5>
                                                <?php
                                                $timetaken = $arrArrivalTimeTaken[$xe];
                                                $timetaken = str_replace("hours", "Hrs", strtolower($timetaken));
                                                $timetaken = str_replace("minutes", "Mins", strtolower($timetaken));
                                                echo $timetaken; ?>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="days">
                                        <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="5">&nbsp;</th>
                                    </tr>
                                </table>
                            </div>
                    <?php
                        }
                    }
                    else if( strpos($flightConfirm->arrivalFlightName, '~') !== TRUE ) {
                        //direct
                    ?>
                        <div class="tab">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $flightConfirm->arrivalFlightCode);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:14px">
                                            <h5>Departure Airport</h5>
                                            <?php
                                            $airportNameArrival = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameFrom);
                                            $airportNameArrival = str_replace("Kuala Lumpur", "KL", $flightConfirm->arrivalAirportNameFrom);
                                            echo $airportNameArrival;
                                            ?>
                                            (<?php echo $flightConfirm->arrivalCityCodeFrom; ?>)
                                            -
                                            <?php echo $flightConfirm->arrivalCityNameFrom; ?>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:50%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:14px">
                                            <h5>Arrival Airport</h5>
                                            <?php
                                            $airportName = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameTo);
                                            $airportName = str_replace("Airport", "", $airportName);
                                            echo $airportName; ?>
                                            (<?php echo $flightConfirm->arrivalCityCodeTo; ?>)
                                            -
                                            <?php echo $flightConfirm->arrivalCityNameTo; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                    <td colspan="2" style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Flight details</h5>
                                            <?php echo str_replace("%20", " ", $flightConfirm->arrivalFlightName); ?>
                                            (<?php echo $flightConfirm->arrivalFlightCode; ?>)
                                        </div>
                                    </td>

                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Departure</h5>
                                            <?php echo date("d M Y", strtotime($flightConfirm->arrivalDateFrom)); ?>
                                            <?php echo date("H:i", strtotime($flightConfirm->arrivalTimeFrom)); ?>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:30%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Arrival</h5>
                                            <?php echo date("d M Y", strtotime($flightConfirm->arrivalDateTo)); ?>
                                            <?php echo date("H:i", strtotime($flightConfirm->arrivalTimeTo)); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align:center; background-color:#efefef" valign="top"></td>
                                    <td style="text-align:left; width:25%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Baggage Info</h5>
                                            <b><?php echo $flightConfirm->arrivalBaggage; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Meal Info</h5>
                                            <b><?php echo ($flightConfirm->arrivalMeal == "NO") ? "Not include" : "Include"; ?></b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Total Transfer</h5>
                                            <b>0</b>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:15%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:14px">
                                            <h5>Time taken</h5>
                                            <?php
                                            $timetaken = $flightConfirm->arrivalTimeTaken;
                                            $timetaken = str_replace("hours", "Hrs", strtolower($timetaken));
                                            $timetaken = str_replace("minutes", "Mins", strtolower($timetaken));
                                            echo $flightConfirm->arrivalTimeTaken; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="days">
                                    <th width="25%" style="text-align:left; background-color:#efefef; padding:10px" colspan="5">&nbsp;</th>
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
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:5px; font-size:12px; text-align:right">
                            <b>Pax Details Info</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>
                                <?php echo $flightConfirm->noofAdult; ?> Adult(s) &
                                <?php echo $flightConfirm->noofChild; ?> Child(s) &
                                <?php echo $flightConfirm->noofInfant; ?> Infant(s)
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>Departure Price</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>$ <?php echo number_format($flightConfirm->departureTotalPrice, 2); ?></b>
                        </td>
                    </tr>
                    <?php
                    if( $flightConfirm->arrivalFlightName != "" && $flightConfirm->departureFlightCode != "" ) {
                    ?>
                        <tr>
                            <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>Arrival Price</b>
                            </td>
                            <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                                <b>$ <?php echo number_format($flightConfirm->arrivalTotalPrice, 2); ?></b>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3" width="550px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>Total Price</b>
                        </td>
                        <td colspan="6" width="500px" style="background-color:rgb(255, 145, 38); color:white; padding:10px; font-size:12px; text-align:right">
                            <b>
                            $ <?php
                                $total_flight_grand += $flightConfirm->departureTotalPrice+$flightConfirm->arrivalTotalPrice;
                                echo number_format($flightConfirm->departureTotalPrice+$flightConfirm->arrivalTotalPrice, 2);
                            ?>
                            </b>
                        </td>
                    </tr>
                </table>
                <!--END OF PRICE AND OTHER INFOS-->
                <!--PASSENGER INFO DETAILS-->
                <div style="text-align:left">
                    <h1 style="border-bottom:none">Passenger details</h1>
                </div>
                <div class="tab">
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tr>
                            <th style="background-color:#e0f2f4; font-size:14px; text-align:left" valign="top">
                                Person
                            </th>
                            <th style="background-color:#e0f2f4; font-size:14px; text-align:left" valign="top">
                                Nationality
                            </th>
                            <th style="background-color:#e0f2f4; font-size:14px; text-align:left" valign="top">
                                Dob
                            </th>
                            <th style="background-color:#e0f2f4; font-size:14px; text-align:left" valign="top">
                                Passport
                            </th>
                            <th style="background-color:#e0f2f4; font-size:14px; text-align:left" valign="top">
                                Transaction Made
                            </th>
                        </tr>
                        <?php
                        $passengers = $this->All->select_template_with_where2_and_order(
                            "bookingOrderID", $bookingOrderID,
                            "passengerCartID", $xxx,
                            "passengerCartID", "ASC",
                            "flight_passenger_pnr_details"
                        );
                        if( $passengers == TRUE ) {
                            foreach( $passengers AS $passenger ) {
                                $passName = $passenger->passenger_surname.'/'.$passenger->passenger_givenname;
                        ?>
                        <tr>
                            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top; text-transform: UPPERCASE">
                                <?php echo $passenger->passengerTitle != "" ? $passName . $passenger->passengerTitle: $passName;?>
                                <br />
                                (TYPE: <?php echo $passenger->passengerType; ?>)
                            </td>
                            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                                <?php echo $passenger->passengerNationality; ?>
                            </td>
                            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                                <?php echo date("Y-F-d", strtotime($passenger->passengerDOB)); ?>
                            </td>
                            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                                Passport no.:<br /><b><?php echo $passenger->passengerPassportNo; ?>
                                </b><br /><br />
                                Issue date:<br /><b><?php echo $passenger->passengerPassportIssueDate; ?>
                                </b><br /><br />
                                Expiry date:<br /><b><?php echo $passenger->passengerPassportExpiryDate; ?></b>
                            </td>
                            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                                <?php echo date("Y-F-d", strtotime($passenger->created)); ?>
                                <br />
                                <?php echo date("H:i:sA", strtotime($passenger->created)); ?>
                            </td>
                        </tr>
                        <?php if($passenger->passenger_remarks != "") { ?>
                        <tr>
                            <td colspan="5" style="background-color:#eff0f1; font-size:12px; vertical-align: top">Remark:<br> <?php echo $passenger->passenger_remarks;?></td>
                        </tr>
                        <?php }
                            }
                        }
                        ?>
                    </table>
                </div>
                </li>
                <!--END OF PASSENGER DETAILS-->
            <?php
                $xxx++;
            }
            ?>
        </ul>

    <?php echo form_close(); ?>
<?php
}
?>
<!--END OF FLIGHT BOOKING CONFIRMED RESULT-->