<?php
$flightConfirms = $this->All->select_template(
	"flight_confirmedBookOrder_ID", $confirmBookingID, "flight_history_order"
);
if( $flightConfirms == TRUE ) {
?>
	<div style="text-align:left">
		<h1>Flight Order Details</h1>
	</div>
	<?php echo form_open_multipart('', array('class' => 'form-horizontal')); ?>
		<ul class="room-types">
            <?php
            $xxx = 1;
            foreach( $flightConfirms AS $flightConfirm ) {
            ?>
            <li>
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
	                                        <div style="font-size:16px; color:black">
												<b>Departure Airport</b>
											</div>
											<div style="font-size:12px">
	                                            <?php
	                                            $airportNameDeparture = str_replace("International", "Int'l", $arrDepartureAirportNameFrom[$xe]);
	                                            $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $arrDepartureAirportNameFrom[$xe]);
	                                            echo $airportNameDeparture;
	                                            ?>
	                                            (<?php echo $arrDepartureCityCodeFrom[$xe]; ?>)
	                                            -
	                                            <?php echo $arrDepartureCityNameFrom[$xe]; ?>
											</div>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Arrival Airport</b>
											</div>
											<div style="font-size:12px">
	                                            <?php
	                                            $airportName = str_replace("International", "Int'l", $arrDepartureAirportNameTo[$xe]);
	                                            $airportName = str_replace("Airport", "", $airportName);
	                                            echo $airportName; ?>
	                                            (<?php echo $arrDepartureCityCodeTo[$xe]; ?>)
	                                            -
	                                            <?php echo $arrDepartureCityNameTo[$xe]; ?>
											</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Flight details</b>
											</div>
                                            <div style="font-size:12px">
	                                            <?php echo str_replace("%20", " ", $arrDepartureFlightName[$xe]); ?>
	                                            (<?php echo $arrDepartureFlightCode[$xe]; ?>)
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Time taken</b>
											</div>
                                            <div style="font-size:12px">
                                            	<?php echo $arrDepartureTimeTaken[$xe]; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Departure</b>
											</div>
                                            <div style="font-size:12px">
                                            	<?php echo date("d M Y", strtotime($arrDepartureDateFrom[$xe])); ?>
												<?php echo date("H:i", strtotime($arrDepartureTimeFrom[$xe])); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <div style="font-size:16px; color:black">
												<b>Arrival</b>
											</div>
											<div style="font-size:12px">
                                            	<?php echo date("d M Y", strtotime($arrDepartureDateTo[$xe])); ?>
												<?php echo date("H:i", strtotime($arrDepartureTimeTo[$xe])); ?>
											</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
                                            <div style="font-size:16px; color:black">
												<b>Baggage Info</b>
											</div>
											<div style="font-size:12px">
                                            	<b><?php echo $arrDepartureBaggage[$xe]; ?></b>
											</div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Meal Info</b>
											</div>
                                            <div style="font-size:12px">
                                            	<b><?php echo ($arrDepartureMeal[$xe] == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px" colspan="2">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Total Transfer</b>
											</div>
                                            <div style="font-size:12px">
	                                            <b>
	                                                <?php
	                                                $totalTf = count($explodeCount);
	                                                echo $totalTf-1;
	                                                ?>
	                                            </b>
                                            </div>
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
                else if( strpos($flightConfirm->departureFlightName, '~') !== TRUE ) {
                    //direct
                ?>
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr class="days">
                                <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                    <div style="font-size:12px; text-align:center">
                                        <?php
                                        $imgReal = explode(" ", $flightConfirm->departureFlightCode);
                                        ?>
                                        <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Departure Airport</b>
										</div>
                                        <div style="font-size:12px">
	                                        <?php
	                                        $airportNameDeparture = str_replace("International", "Int'l", $flightConfirm->departureAirportNameFrom);
	                                        $airportNameDeparture = str_replace("Kuala Lumpur", "KL", $flightConfirm->departureAirportNameFrom);
	                                        echo $airportNameDeparture;
	                                        ?>
	                                        (<?php echo $flightConfirm->departureCityCodeFrom; ?>)
	                                        -
	                                        <?php echo $flightConfirm->departureCityNameFrom; ?>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Arrival Airport</b>
										</div>
                                        <div style="font-size:12px">
	                                        <?php
	                                        $airportName = str_replace("International", "Int'l", $flightConfirm->departureAirportNameTo);
	                                        $airportName = str_replace("Airport", "", $airportName);
	                                        echo $airportName; ?>
	                                        (<?php echo $flightConfirm->departureCityCodeTo; ?>)
	                                        -
	                                        <?php echo $flightConfirm->departureCityNameTo; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Flight details</b>
										</div>
                                        <div style="font-size:12px">
                                        	<?php echo str_replace("%20", " ", $flightConfirm->departureFlightName); ?>
											(<?php echo $flightConfirm->departureFlightCode; ?>)
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Time taken</b>
										</div>
										<div style="font-size:12px">
                                        	<?php echo $flightConfirm->departureTimeTaken; ?>
                                       	</div>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Departure</b>
										</div>
                                        <div style="font-size:12px">
                                        	<?php echo date("d M Y", strtotime($flightConfirm->departureDateFrom)); ?>
											<?php echo date("H:i", strtotime($flightConfirm->departureTimeFrom)); ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Arrival</b>
										</div>
										<div style="font-size:12px">
                                        	<?php echo date("d M Y", strtotime($flightConfirm->departureDateTo)); ?>
											<?php echo date("H:i", strtotime($flightConfirm->departureTimeTo)); ?>
										</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Baggage Info</b>
										</div>
                                        <div style="font-size:12px">
                                        	<b><?php echo $flightConfirm->departureBaggage; ?></b>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Meal Info</b>
										</div>
										<div style="font-size:12px">
                                        	<b><?php echo ($flightConfirm->departureMeal == "NO") ? "Not include" : "Include"; ?></b>
										</div>
                                    </div>
                                </td>
                                <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px" colspan="2">
                                    <div style="font-size:15px">
	                                    <div style="font-size:16px; color:black">
											<b>Total Transfer</b>
										</div>
                                        <div style="font-size:12px">
                                        	<b>0</b>
                                        </div>
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
	                                            <div style="font-size:16px; color:black">
													<b>Departure Airport</b>
												</div>
                                                <div style="font-size:12px">
	                                                <?php
	                                                $airportNameArrival = str_replace("International", "Int'l", $arrArrivalAirportNameFrom[$xe]);
	                                                $airportNameArrival = str_replace("Kuala Lumpur", "KL", $arrArrivalAirportNameFrom[$xe]);
	                                                echo $airportNameArrival;
	                                                ?>
	                                                (<?php echo $arrArrivalCityCodeFrom[$xe]; ?>)
	                                                -
	                                                <?php echo $arrArrivalCityNameFrom[$xe]; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Arrival Airport</b>
												</div>
                                                <div style="font-size:12px">
	                                                <?php
	                                                $airportName = str_replace("International", "Int'l", $arrArrivalAirportNameTo[$xe]);
	                                                $airportName = str_replace("Airport", "", $airportName);
	                                                echo $airportName; ?>
	                                                (<?php echo $arrArrivalCityCodeTo[$xe]; ?>)
	                                                -
	                                                <?php echo $arrArrivalCityNameTo[$xe]; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Flight details</b>
												</div>
                                                <div style="font-size:12px">
                                                	<?php echo str_replace("%20", " ", $arrArrivalFlightName[$xe]); ?>
													(<?php echo $arrArrivalFlightCode[$xe]; ?>)
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Time taken</b>
												</div>
                                                <div style="font-size:12px">
                                                	<?php echo $arrArrivalTimeTaken[$xe]; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Departure</b>
												</div>
                                                <div style="font-size:12px">
                                               	 	<?php echo date("d M Y", strtotime($arrArrivalDateFrom[$xe])); ?>
											   	 	<?php echo date("H:i", strtotime($arrArrivalTimeFrom[$xe])); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Arrival</b>
												</div>
                                                <div style="font-size:12px">
                                                	<?php echo date("d M Y", strtotime($arrArrivalDateTo[$xe])); ?>
													<?php echo date("H:i", strtotime($arrArrivalTimeTo[$xe])); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Baggage Info</b>
												</div>
                                                <div style="font-size:12px">
                                                	<b><?php echo $arrArrivalBaggage[$xe]; ?> kg</b>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Meal Info</b>
												</div>
                                                <div style="font-size:12px">
                                                	<b><?php echo ($arrArrivalMeal[$xe] == "NO") ? "Not include" : "Include"; ?></b>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px" colspan="2">
                                            <div style="font-size:15px">
	                                            <div style="font-size:16px; color:black">
													<b>Total Transfer</b>
												</div>
                                                <div style="font-size:12px">
	                                                <b>
	                                                    <?php
	                                                        $totalATf = count($explodeCountA);
	                                                        echo $totalATf-1;
	                                                    ?>
	                                                </b>
                                                </div>
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
                    else if( strpos($flightConfirm->arrivalFlightName, '~') !== TRUE ) {
                        //direct
                    ?>
                        <div class="tab">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr class="days">
                                    <th width="25%" style="text-align:center; background-color:#efefef" rowspan="5">
                                        <div style="font-size:12px; text-align:center">
                                            <?php
                                            $imgReal = explode(" ", $flightConfirm->arrivalFlightCode);
                                            ?>
                                            <img src="<?php echo base_url()."assets/airlines_image/".$imgReal[0].".gif"; ?>" alt="" width="122" height="40" />
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Departure Airport</b>
											</div>
											<div style="font-size:12px">
	                                            <?php
	                                            $airportNameArrival = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameFrom);
	                                            $airportNameArrival = str_replace("Kuala Lumpur", "KL", $flightConfirm->arrivalAirportNameFrom);
	                                            echo $airportNameArrival;
	                                            ?>
	                                            (<?php echo $flightConfirm->arrivalCityCodeFrom; ?>)
	                                            -
	                                            <?php echo $flightConfirm->arrivalCityNameFrom; ?>
											</div>
                                        </div>
                                    </td>
                                    <td colspan="2" style="text-align:left; width:40%; background-color:#efefef; padding-bottom: 0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Arrival Airport</b>
											</div>
                                            <div style="font-size:12px">
	                                            <?php
	                                            $airportName = str_replace("International", "Int'l", $flightConfirm->arrivalAirportNameTo);
	                                            $airportName = str_replace("Airport", "", $airportName);
	                                            echo $airportName; ?>
	                                            (<?php echo $flightConfirm->arrivalCityCodeTo; ?>)
	                                            -
	                                            <?php echo $flightConfirm->arrivalCityNameTo; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; width:200px; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Flight details</b>
											</div>
                                            <div style="font-size:12px">
                                            	<?php echo str_replace("%20", " ", $flightConfirm->arrivalFlightName); ?>
												(<?php echo $flightConfirm->arrivalFlightCode; ?>)
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Time taken</b>
											</div>
											<div style="font-size:12px">
                                            	<?php echo $flightConfirm->arrivalTimeTaken; ?>
											</div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Departure</b>
											</div>
                                            <div style="font-size:12px">
                                            	<?php echo date("d M Y", strtotime($flightConfirm->arrivalDateFrom)); ?>
												<?php echo date("H:i", strtotime($flightConfirm->arrivalTimeFrom)); ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Arrival</b>
											</div>
                                            <div style="font-size:12px">
                                            	<?php echo date("d M Y", strtotime($flightConfirm->arrivalDateTo)); ?>
												<?php echo date("H:i", strtotime($flightConfirm->arrivalTimeTo)); ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Baggage Info</b>
											</div>
                                            <div style="font-size:12px">
                                            	<b><?php echo $flightConfirm->arrivalBaggage; ?> kg</b>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Meal Info</b>
											</div>
                                            <div style="font-size:12px">
                                            	<b><?php echo ($flightConfirm->arrivalMeal == "NO") ? "Not include" : "Include"; ?></b>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:left; width:20%; background-color:#efefef; padding-bottom:0px" colspan="2">
                                        <div style="font-size:15px">
	                                        <div style="font-size:16px; color:black">
												<b>Total Transfer</b>
											</div>
                                            <div style="font-size:12px">
                                            	<b>0</b>
                                            </div>
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
                            <b>$<?php echo number_format($flightConfirm->departureTotalPrice, 2); ?></b>
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
                                <b>$<?php echo number_format($flightConfirm->arrivalTotalPrice, 2); ?></b>
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
                            $
                            <?php
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
                    <br />
                    <h1 style="border-bottom:none">Passenger details</h1>
                </div>
                <div>
                    <div class="tab">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                            <tr>
                                <th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
                                    Person
                                </th>
                                <th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
                                    Nationality
                                </th>
                                <th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
                                    Dob
                                </th>
                                <th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
                                    Passport
                                </th>
                                <th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
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
                            ?>
                            <tr>
                                <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                                    <?php echo $passenger->passengerTitle; ?>. <?php echo $passenger->passengerName; ?>
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
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
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