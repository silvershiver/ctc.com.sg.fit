<?php
    $total_hotel_grand  = 0;
    $total_flight_grand = 0;
    $total_cruise_grand = 0;
    $total_ltour_grand  = 0;
    $cruiseExtra        = 0;
    $cruiseCheck = 'YES'; $landtourCheck = 'YES';
    $flights_cart = false; $hotel_cart = false; $cruise_cart = false;
    if( $this->session->userdata('normal_session_id') == TRUE ) {
        $flights_cart = $this->All->select_template(
            "user_access_id", $this->session->userdata('normal_session_id'), "flight_cart"
        );
        $hotel_cart = $this->All->select_template(
            "user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
        );
    }
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if IE   ]>    <html class="ie" lang="en"> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>CTC Travel | Checkout Process</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css?id=<?php echo uniqid(); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css?id=<?php echo uniqid(); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/newtable.css?id=<?php echo uniqid(); ?>" type="text/css" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <style>.select_custom { width:100px; }</style>
    <style>

        .age_type { background: #f4f4f4; border: 1px solid #ddd; border-bottom: none; padding: 5px 10px; font-weight: bold; }
        .tab_container { border: 1px solid #ddd; padding: 0 10px 10px 10px; margin-bottom: 20px; }
        .form_div { margin: 20px 0 20px 0; }
        .traveller_info_form>div>div>div>div { width: 230px; float: left; font-weight: bold; }
    </style>
    <style>
        h5 { color: #F7941D !important; font-size: 14px; }
    </style>
    <style>
        input, textarea {
            padding: 5px 2px;
            color: #000000 !important; /* override */
        }
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
          opacity: 0.3;
        }
        ::-moz-placeholder { /* Firefox 19+ */
          opacity: 0.3;
        }
        :-ms-input-placeholder { /* IE 10+ */
          opacity: 0.3;
        }
        :-moz-placeholder { /* Firefox 18- */
          opacity: 0.3;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 30px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            height: 85%;
            overflow-y: scroll;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .datepickerdobadult, .datepickerdobchild, .datepickerdobinfant, .datepickerdobcp {
                border-radius: 0px !important;
                width: 75% !important;
        }
        .ui-datepicker-trigger {
            position: absolute;
            top: 31px;
            right: 50px;
        }
        .full-width-2 {
            display: block;width: 100%;margin: 0 0 2% 0; background: #FFFFFF;
        }
        input.upper { text-transform: uppercase; }
        .info-li {
            font-size: 8px;
            padding: 5px !important;
        }
        .circle {
            float: left;
            display: block;
            width: 100%;
            font-size: 1em;
            list-style: none;
            margin-left:20px;
            border: none !important;
            margin: 0 !important; padding: 0 !important;}

    </style>
    <script type="text/javascript">
        function onlyNumber (e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if (
                    (charCode >= 48 && charCode <= 57)  || charCode == 8 || charCode == 46
                    )
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }

        }
        function onlyAlphabetNumber(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ( (charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) ||
                    (charCode >= 48 && charCode <= 57)  || charCode == 8 || charCode == 46)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }

        }
        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 46)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }

        function onlyAlphabetsspace(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32 || charCode == 8 || charCode == 46)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
        }
    </script>
    <link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap-select.min.css" rel="stylesheet" type="text/css">

</head>
<body>
    <?php require_once(APPPATH."views/master-frontend/header.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/login-form.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/signup-form.php"); ?>
    <?php require_once(APPPATH."views/master-frontend/forgotpassword-form.php"); ?>
    <div class="main" role="main">
        <div class="wrap clearfix">
            <div class="content clearfix">
                <!--BREADCUMBS-->
                <nav role="navigation" class="breadcrumbs clearfix">
                    <ul class="crumbs">
                        <li><a href="#" title="">You are here:</a></li>
                        <li><a href="<?php echo base_url(); ?>" title="">Home</a></li>
                        <li><a href="<?php echo current_url(); ?>" title="">Checkout</a></li>
                    </ul>
                </nav>
                <!--END OF BREADCUMBS-->
                <section class="full-width">
                    <?php echo $this->session->flashdata('updated_cart');?>
                    <?php echo $this->session->flashdata('error_checkout');?>

                    <section id="hotels_cart" class="tab-content" style="width:100%">
                        <article>
                            <?php echo form_open_multipart('payment/final_proceed',
                                array(
                                    'id' => 'booking_particular_form',
                                    'name' => 'booking_particular_form',
                                    'onsubmit' => "$('#divLoading2').show()"
                                    )
                                );

                                if( $this->session->userdata('normal_session_id') == TRUE ) {
                                    $cruiseCheck   = $this->Others->check_cruiseCart($this->session->userdata('normal_session_id'));
                                    $landtourCheck = $this->Others->check_landtourCart($this->session->userdata('normal_session_id'));
                                    $hotelCheck    = $this->Others->check_hotelCart($this->session->userdata('normal_session_id'));
                                    $flightCheck   = $this->Others->check_flightCart($this->session->userdata('normal_session_id'));
                                }
                                else {
                                    $cruiseCheck   = $this->Others->check_cruiseCart("NONE");
                                    $landtourCheck = $this->Others->check_landtourCart("NONE");
                                    $hotelCheck    = $this->Others->check_hotelCart("NONE");
                                    $flightCheck   = $this->Others->check_flightCart("NONE");
                                }
                                ?>
                                <?php require_once(APPPATH."views/checkout/cruise.php"); ?>
                                <!--<br /><br /><br />-->
                                <?php require_once(APPPATH."views/checkout/landtour.php"); ?>
                                <?php require_once(APPPATH."views/checkout/hotel.php"); ?>
                                <?php require_once(APPPATH."views/checkout/flight.php"); ?>
                                <?php require_once(APPPATH."views/checkout/contact_person.php"); ?>
                                <!--GRAND TOTAL LIST-->
                                <?php
                                if( $this->session->userdata('shoppingCartCruiseCookie') == TRUE || $cruiseCheck == "YES" ||
                                    $this->session->userdata('shoppingCartLandtourCookie') == TRUE || $landtourCheck == "YES" ||
                                    $this->session->userdata('shoppingCartCookie') == TRUE || $hotelCheck == "YES" ||
                                    $this->session->userdata('shoppingCartFlightCookie') == TRUE || $flightCheck == "YES" ) {
                                ?>
                                    <div>
                                        <div style="float:right">
                                            <input type="checkbox" name="agreecheck" id="agreecheck" required />
                                            &nbsp;
                                            <span style="font-size:13px; color:rgb(255, 145, 38)">
                                                <label for="agreecheck"><b>
                                                    I acknowledge that I have read and agree to the
                                                    <a id="myBtn" style="text-decoration:underline; color:rgb(255, 145, 38); cursor:pointer">
                                                        Terms and Conditions.
                                                    </a></b>
                                                </label>
                                                    <!--TERMS & CONDITIONS MODAL-->
                                                    <div id="myModal" class="modal">
                                                        <div class="modal-content">
                                                            <span class="close" id="close_modal" style="margin-top:-20px">&times;</span>
                                                            <object width="100%" height="550" type="application/pdf" data="<?php echo base_url(); ?>assets/t&c/BOOKING TERMS AND CONDITIONS (14 March 2017).pdf?#zoom=85&scrollbar=0&toolbar=0&navpanes=0" id="pdf_content">
                                                                <p>PDF cannot be displayed.</p>
                                                            </object>
                                                        </div>
                                                    </div>
                                                    <!--END OF TERMS & CONDITIONS MODAL-->
                                            </span>
                                        </div>
                                        <div style="clear:both">&nbsp;</div>
                                        <div style="float:right; text-align:right">
                                            <span style="font-size:13px; color:rgb(255, 145, 38)">
                                                <b>
                                                    Full payment is required upon booking. Payment made does not constitute confirmation of the booking.<br />Our Sales Consultant will contact you for your booking confirmation
                                                </b>
                                            </span>
                                        </div>
                                        <div style="clear:both">&nbsp;</div>
                                    </div>
                                    <div id="grandtotal" style="position: fixed; right:0; top:50%; background: #CCCCCC; z-index: 999; padding:20px; opacity: 0.5" onmouseover="$(this).css('opacity', '1');" onmouseleave="$(this).css('opacity', '0.5');">
                                        <!--TOTAL GRAND-->
                                        <h1 style="text-align:center; margin:0px">Grand Total List</h1>
                                        <div>
                                            <div style="text-align:center">
                                                <div style="font-size:16px; margin-bottom:10px">
                                                    You have
                                                </div>
                                                <div class="timer" style="height: 40px; padding-top:5px">15:00</div>
                                                <div style="font-size:16px; margin-top:10px; margin-bottom:10px">
                                                    to complete this transaction
                                                </div>
                                                <div id="monitor"></div>
                                            </div>
                                            <div style="float:right">
                                                <?php
                                                $totalGrandAll = $total_hotel_grand+$total_cruise_grand+$totalGrandPrice+$total_flight_grand;
                                                $totalGrandAll = ceil($totalGrandAll);
                                                ?>
                                                <input type="hidden" name="hidden_grandTotalPrice" value="<?php echo $totalGrandAll; ?>" />
                                                <button type="submit" class="gradient-button submit-payment" style="border:none; opacity: 1 !important">
                                                    Payment
                                                </button>
                                            </div>
                                            <div style="float:right; margin-right:15px; font-size:20px">
                                                <b style="color:green">
                                                    Total Price: $<?php echo number_format($totalGrandAll, 2); ?>
                                                </b>
                                            </div>
                                            <div style="clear:both">&nbsp;</div>
                                        </div>
                                        <!--END OF TOTAL GRAND-->
                                    </div>
                                <?php
                                }
                                else {
                                ?>
                                    <div style="text-align:center; margin-top:-20px">
                                        <span style="font-size:16px; color:red"><b>No item found in your shopping cart</b></span>
                                        <br /><br />
                                        <a href="<?php echo base_url(); ?>" class="gradient-button" style="border:none">
                                            Back to home
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <!--END OF GRAND TOTAL LIST-->
                            <?php echo form_close(); ?>
                        </article>
                    </section>
                </section>
            </div>
        </div>
    </div>
    <!--LOADING GIF-->
    <div id="divLoading" style="display:none; margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
        <p style="position:absolute; color:white; top:45%; left:45%; padding:0px">
            Checking again price and availability from system.. Please Wait...
            <br />
            <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
        </p>
    </div>

    <div id="divLoading2" style="display:none; margin:0px; padding:0px; position:fixed; right:0px; top:0px; width:100%; height:100%; background-color: rgb(102, 102, 102); z-index:30001; opacity:0.8;">
        <p style="position:absolute; color:white; top:45%; left:45%; padding:0px" class="loading-content">
            Processing your request.. Please Wait..
            <br />
            <img src="<?php echo base_url(); ?>assets/progress_bar/ajax-loader.gif" style="margin-top:5px">
        </p>
    </div>

    <!--END OF LOADING GIF-->
    <?php require_once(APPPATH."views/master-frontend/footer.php"); ?>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.jquery-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sequence.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/selectnav.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts-no-uniform.js"></script>
    <!-- timer -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/countdown/css/jquery.countdown.css?<?php echo uniqid(); ?>">
    <script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.plugin.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.countdown.js"></script>

    <script type="text/javascript">
        function customRange(input) {
            var maxdate = $(input).data('retdate');

            if(maxdate !== undefined) {
                var ndate = new Date(maxdate);
                var year = ndate.getFullYear() - 2;
                var month = ndate.getMonth() - 1;
                var day = ndate.getDate();
                var newdt = new Date(year, month, day);

                return { maxDate: newdt };
            }
        }

        function customRange2(input) {
            var maxdate = $(input).data('retdate');

            if(maxdate !== undefined) {
                var ndate = new Date(maxdate);
                var year = ndate.getFullYear();
                var month = ndate.getMonth() - 3;
                var day = ndate.getDate() - 1;
                var newdt = new Date(year, month, day);

                return { maxDate: newdt };
            }
        }

        $(document).ready(function(){
            $( ".datepickerdobadult" ).datepicker({ minDate: "-99Y", maxDate: "-12Y", changeMonth: true, changeYear: true,
                "dateFormat" : 'yy-mm-dd', yearRange : "-100:+0",
                showOn: "button",
                buttonImage: '<?php echo base_url();?>assets/images/ico/calendar.png',
                buttonImageOnly: true,
                buttonText: "Select date" }
              );
            $( ".datepickerdobchild" ).datepicker({ minDate: "-12Y +1D", maxDate: "-2Y -1D", changeMonth: true, changeYear: true, "dateFormat" : 'yy-mm-dd', yearRange : "-100:+0",
                showOn: "button",
                /*beforeShow: customRange,*/
                buttonImage: '<?php echo base_url();?>assets/images/ico/calendar.png',
                buttonImageOnly: true,
                buttonText: "Select date" });
            $( ".datepickerdobinfant" ).datepicker({ minDate: "-2Y +1D", maxDate: "-3M",changeMonth: true, changeYear: true, "dateFormat" : 'yy-mm-dd', yearRange : "-100:+0",
                showOn: "button",
                /*beforeShow: customRange2,*/
                buttonImage: '<?php echo base_url();?>assets/images/ico/calendar.png',
                buttonImageOnly: true,
                buttonText: "Select date" });
            $( ".datepickerdobcp" ).datepicker({ minDate: "-99Y", maxDate: "-12Y", changeMonth: true, changeYear: true, "dateFormat" : 'yy-mm-dd', yearRange : "-100:+0",
                showOn: "button",
                buttonImage: '<?php echo base_url();?>assets/images/ico/calendar.png',
                buttonImageOnly: true,
                buttonText: "Select date" });

            $('.submit-payment').click(function(){
                /*$('.timer').countdown('pause');*/
                var msg = "";
                var ctr = 1;
                $( ".datepickerdobadult" ).each(function() {
                    if( $(this).val() == "") {
                        msg += "Date of birth for data adult #"+ctr +" is required\n";
                    }
                    ctr++;
                });
                var ctr = 1;
                $( ".datepickerdobchild" ).each(function() {
                    if( $(this).val() == "") {
                        msg += "Date of birth for data child #"+ctr +" is required\n";
                    }
                    ctr++;
                });

                var ctr = 1;
                $( ".datepickerdobinfant" ).each(function() {
                    if( $(this).val() == "") {
                        msg += "Date of birth for data infant #"+ctr +" is required\n";
                    }
                    ctr++;
                });

                $( ".datepickerdobcp" ).each(function() {
                    if( $(this).val() == "") {
                        msg += "Date of birth for data Contact Person is required\n";
                    }
                });

                if(!$('#agreecheck').is(':checked')) {
                    msg += "Please Check the agreement box";
                }

                if(msg != "") {
                    alert(msg);
                    return false;
                } else {
                    return true;
                }
            });
            /*--COUNTDOWN TIMER--*/
            timeoutsecond = 15 * 60; // 15 min
            var shortly = new Date();
            shortly.setSeconds(shortly.getSeconds() + timeoutsecond);
            $('.timer').countdown({until: shortly, onExpiry: liftOff, onTick: watchCountdown});
            $('.timer').countdown('option', {until: shortly});
            function liftOff() {
                $('#divLoading').show();
                var r = confirm("Do you still want to continue?");
                if (r == true) {
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '<?php echo base_url(); ?>checkout/checkPrice/check',
                        success: function(data)
                        {
                            $('#divLoading').hide();
                            if(data.error == false && data.pricechange == true) {
                                /* refresh price */
                                location.href = '<?php echo base_url(); ?>checkout';
                            }
                            else if (data.error == false && data.message == "") {
                                /* extend time */
                                var shortly = new Date();
                                shortly.setSeconds(shortly.getSeconds() + timeoutsecond);
                                $('.timer').countdown('option', {until: shortly});
                            }
                            else {
                                /* empty cart because there is 'no' response from user */
                                //location.href = '<?php echo base_url();?>cart/emptyCart';
                            }
                        }
                    });
                }
                else {
                    $('#divLoading').hide();
                    location.href = '<?php echo base_url();?>cart/emptyCart';
                }
            }
            function watchCountdown(periods) { }
            /*--END OF COUNTDOWN TIMER--*/
            $('#btnFPSubmit').click(function() {
                if( $("#email_fp").val() == "" ) {
                    var msg = "<span style='color:red'>Please enter your email address.</span>";
                    $("#forgot_password_ajax_msg").html(msg);
                    return false;
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>forgot_password/do_submission',
                        data: {
                            email: $("#email_fp").val()
                        },
                        success: function(data)
                        {
                            if( data == 0 ) {
                                var msg = "<span style='color:red'>This email address has never registered before. Please try another email address.</span>";
                                $("#forgot_password_ajax_msg").html(msg);
                                return false;
                            }
                            else if( data == 1 ) {
                                var msg = "<span style='color:yellow'>An email has been sent to you in order to retrieve your password.</span>";
                                $("#email_form_fp").hide();
                                $("#btn_form_fp").hide();
                                $("#forgot_password_ajax_msg").html(msg);
                                return false;
                            }
                        }
                    });
                    return false;
                }
            });
            $('#btnLogin').click(function() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>login/do_login_process',
                    data: {
                        email: $("#login_email").val(),
                        password: $("#login_password").val(),
                        remember_me: $('#login_checkbox:checked').val()
                    },
                    success: function(data)
                    {
                        if( data == 0 ) {
                            var msg = "<span style='color:red'>Invalid login account. Please try again.</span>";
                            $("#login_ajax_msg").html(msg);
                            return false;
                        }
                        else if( data == 1 ) {
                            var msg = "<span style='color:yellow'>Login successfully.</span>";
                            $("#login_ajax_msg").html(msg);
                            window.location = '<?php echo current_url(); ?>';
                            return false;
                        }
                    }
                });
                return false;
            });
            /*--TOGGLE REQUEST--*/
            <?php
            if( $this->session->userdata('normal_session_id') == TRUE ) {
                $cartHotelLists = $this->All->select_template(
                    "user_access_id", $this->session->userdata('normal_session_id'), "hotel_cart"
                );
                if($cartHotelLists) {
                    foreach( $cartHotelLists AS $cartHotelList ) {
            ?>
                $("a#specialRequestLink<?php echo $cartHotelList->id; ?>").click(function(){
                    $("#contentSpecialRequest<?php echo $cartHotelList->id; ?>").toggle();
                });
            <?php
                    }
                }
            }
            else {
                $arrayHotel = $this->session->userdata('shoppingCartCookie');
                $arrayHotelCount = count($arrayHotel);

                for($js=0; $js<$arrayHotelCount; $js++) {
                    $ctr = 1;
                    foreach($arrayHotel[$js]['hotel_room'] as $hotelroom) {
            ?>
                        $("a#specialRequestLink_<?php echo $js; ?>_<?php echo $ctr;?>").click(function(){
                            $("#contentSpecialRequest_<?php echo $js; ?>_<?php echo $ctr;?>").toggle();
                        });
            <?php
                        $ctr++;
                    }
                }
            }
            ?>
            /*--END OF TOGGLE REQUEST--*/
        });
    </script>
    <script type="text/javascript">

        function checkActiveCP(chk_id)
        {
            if(chk_id !== undefined)
                if($('#contact_personal_'+chk_id).prop('checked') == true) {
                    $('#contact_personal_'+chk_id).trigger('click');
                } else {
                    /* do nothing */
                }
        }

        $(document).ready(function(){

            $('.main-contact').on('click', function() {
                var chk_id = $(this).data('checkedid');

                var titleAd = $('#titleAdult_'+chk_id).val(),
                    fname = $('#givennameAdult_'+chk_id).val() + " " + $('#surnameAdult_'+chk_id).val(),
                    remark = $('#passengerRemarks_Adult_'+chk_id).val();
                $('#titleCP').val(titleAd);
                $('#nameCP').val(fname);
                $('#remarksCP').val(remark);
            });

            <?php
            $jsChildAge = date("Y")-12;
            if( $this->session->userdata('normal_session_id') == TRUE ) {
                $countCart = $this->All->getCountCart($this->session->userdata('normal_session_id'));
                if( $countCart > 0 ) {
                    $cartCruiseLists = $this->All->select_template(
                        "user_access_id", $this->session->userdata('normal_session_id'), "cruise_cart"
                    );
                    foreach( $cartCruiseLists AS $cartCruiseList ) {
                        $cruiseJSTitleID = $cartCruiseList->cruiseTitleID;
                        $age_restrict = $this->All->getChildAgeValueOnly($cruiseJSTitleID);
                        if( $age_restrict == 0 ) { $jsage = date("Y"); }
                        else { $jsage = date("Y")-$age_restrict; }
            ?>
            $("#datepickerChild<?php echo $cartCruiseList->id; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '<?php echo $jsChildAge; ?>:<?php echo date("Y")-1; ?>'
            });
            $("#datepickerAdult<?php echo $cartCruiseList->id; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '1930:<?php echo $jsage; ?>'
            });
            $("#issuePassportAdultDatepicker<?php echo $cartCruiseList->id; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2001:2016'
            });
            $("#expiryPassportAdultDatepicker<?php echo $cartCruiseList->id; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2014:2031'
            });
            <?php
                    }
                }
            }
            else {
                $arrayCruiseAge = $this->session->userdata('shoppingCartCruiseCookie');
                $arrayCruiseAgeCount = count($arrayCruiseAge);
                for($a=0; $a<$arrayCruiseAgeCount; $a++) {
                    $cruiseJSTitleID = $arrayCruiseAge[$a]["cruiseTitleID"];
                    $age_restrict = $this->All->getChildAgeValueOnly($cruiseJSTitleID);
                    if( $age_restrict == 0 ) { $jsage = date("Y"); }
                    else { $jsage = date("Y")-$age_restrict; }
                    $noofAdult = $arrayCruiseAge[$a]["noofAdult"];
                    for( $ad=1; $ad<=$noofAdult; $ad++ ) {
            ?>
            $("#datepickerAdult<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ad; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '1930:<?php echo $jsage; ?>'
            });
            $("#issuePassportAdultDatepicker<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ad; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2001:2016'
            });
            $("#expiryPassportAdultDatepicker<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ad; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2014:2031'
            });
            <?php
                    }
                    $noofChild = $arrayCruiseAge[$a]["noofChild"];
                    for( $ac=1; $ac<=$noofChild; $ac++ ) {
            ?>
            $("#datepickerChild<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ac; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '<?php echo $jsChildAge; ?>:<?php echo date("Y")-1; ?>'
            });
            $("#issuePassportChildDatepicker<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ac; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2001:2016'
            });
            $("#expiryPassportChildDatepicker<?php echo $arrayCruiseAge[$a]["uniqueID"]; ?><?php echo $ac; ?>").datepicker({
                changeMonth: true, changeYear: true,
                dateFormat: "yy-mm-dd", yearRange: '2014:2031'
            });
            <?php
                    }
                }
            }
            ?>
            /*--FOR HOTEL--*/
            $("#dobHotel").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                yearRange: '1930:2000'
            });
            $("#issueDatePassport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                yearRange: '2010:2022'
            });
            $("#expiryDatePassport").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                yearRange: '2010:2022'
            });
            /*--END OF FOR HOTEL--*/
        });
    </script>
    <script type="text/javascript">
        var modal   = document.getElementById('myModal');
        var btn     = document.getElementById("myBtn");
        var span    = document.getElementById("close_modal");
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>