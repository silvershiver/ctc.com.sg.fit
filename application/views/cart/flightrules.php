<?php
$hiddenClass = "";
if($print == 1){
    $hiddenClass = "hidden";
?>
<!doctype html>
<html>
<head>

<style>h5 { color: #F7941D !important; font-size: 14px }</style>
<link href="<?php echo base_url(); ?>assets/bootstrap/bootstrap-select.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css" media="screen,projection,print" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/prettyPhoto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/newtable.css" type="text/css" />

<style>
    html {
        padding: 0; margin: 0 font-size: 12px;
    }
    body {background: #ffffff; font-size: 12px;}
    a,
    a:visited               {text-decoration: underline; }
    pre,
    blockquote      {border: 1px solid #999; page-break-inside: avoid; }

    @media print {
        .go-print2 {display: none; visibility: hidden;}
    }
</style>
</head>
<body class="printableArea">
    <button type="button" class="go-print2" style="float:right">Print this page</button>
<?php
}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    var print = '<?php echo $print;?>';
    if(print == '1') {
    } else {
        $( function() {
            $( "#accordion" ).accordion({header:'h3', active: false, collapsible: true, autoHeight: true});
            $( ".accordion2" ).accordion({header:'h4', active: false, collapsible: true, autoHeight: true});
        } );
    }
</script>
<style>
.ui-icon-triangle-1-s {
    top: 0; right:0; left: 0;
}
.ui-accordion-content {
    height: 250px;
    max-height: 400px;
}

.empty{
    min-height: 100px !important;
    max-height: 100px !important;
}
</style>
<?php if($print == 1){
    $backgroundHeader = "; padding: 5px"?>
<div style="margin: 0; padding:20px">
<?php } else { ?>
<div id="accordion" style="margin: 20px 0">
<?php }
    foreach($finalxml as $dataFlightRules) {
        /* loop as accordion */
        echo '<h3 style="text-align:left '.$backgroundHeader.'">'.$dataFlightRules['FlightName'].' '. $dataFlightRules['FlightCode'].'</h3>';
        echo '<div class="accordion2">';/*
        echo '<pre>';
        var_dump($dataFlightRules['rules']);*/
        if (array_key_exists('adult', $dataFlightRules['rules'])) {
            echo '<h4>Applied Rules for Adult</h4>';
            echo '<div>';


                if (array_key_exists('0', $dataFlightRules['rules']['adult'])){
                    foreach($dataFlightRules['rules']['adult'] as $rulesadult) {

                        if(count($rulesadult['FareRuleInfo']['Header'])) {
                            echo '<table style="width:100%">';
                            echo '<tr>';
                            $idx = 0;

                            foreach($rulesadult['FareRuleInfo']['Header']['Line'] as $lineRule) {
                                $idx++;
                                echo '<td>'.$lineRule['Text'].'</td>';
                                if($idx % 4 == 0) {
                                    echo '</tr><tr>';

                                }
                            }
                            echo '</tr>';
                            echo '</table>';

                            echo '<table style="width:100%; text-align:left">';
                            $idx = 1;
                            foreach($rulesadult['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                                echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                                $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                                $texting = str_replace('\r', '<br>', $texting);

                                echo '<tr><td>'.nl2br($texting).'</td></tr>';
                                $idx++;
                            }
                            echo '</table>';
                        } else {
                            echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                        }
                    }

                } else {
                    if(count($dataFlightRules['rules']['adult']['FareRuleInfo']['Header'])) {
                        echo '<table style="width:100%">';
                        echo '<tr>';
                        $idx = 0;

                        foreach($dataFlightRules['rules']['adult']['FareRuleInfo']['Header']['Line'] as $lineRule) {
                            $idx++;
                            echo '<td>'.$lineRule['Text'].'</td>';
                            if($idx % 4 == 0) {
                                echo '</tr><tr>';

                            }
                        }
                        echo '</tr>';
                        echo '</table>';

                        echo '<table style="width:100%; text-align:left">';
                        $idx = 1;
                        foreach($dataFlightRules['rules']['adult']['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                            echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                            $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                            $texting = str_replace('\r', '<br>', $texting);

                            echo '<tr><td>'.nl2br($texting).'</td></tr>';
                            $idx++;
                        }
                        echo '</table>';
                    } else {
                        echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                    }
                }




            /* uncomment this if prefering displaying routing info rather than rules
            echo '<tr><td>'.$dataFlightRules['FareRuleInfo']['RoutingInfo']['Text'].'</td></tr>';
            */

            echo '</div>';
        }

        /* child */
        if (array_key_exists('child', $dataFlightRules['rules'])) {
            echo '<h4>Applied Rules for Children</h4>';
            echo '<div>';


                if (array_key_exists('0', $dataFlightRules['rules']['child'])){
                    foreach($dataFlightRules['rules']['child'] as $ruleschild) {

                        if(count($ruleschild['FareRuleInfo']['Header'])) {
                            echo '<table style="width:100%">';
                            echo '<tr>';
                            $idx = 0;

                            foreach($ruleschild['FareRuleInfo']['Header']['Line'] as $lineRule) {
                                $idx++;
                                echo '<td>'.$lineRule['Text'].'</td>';
                                if($idx % 4 == 0) {
                                    echo '</tr><tr>';

                                }
                            }
                            echo '</tr>';
                            echo '</table>';

                            echo '<table style="width:100%; text-align:left">';
                            $idx = 1;
                            foreach($ruleschild['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                                echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                                $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                                $texting = str_replace('\r', '<br>', $texting);

                                echo '<tr><td>'.nl2br($texting).'</td></tr>';
                                $idx++;
                            }
                            echo '</table>';
                        } else {
                            echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                        }
                    }

                } else {
                    if(count($dataFlightRules['rules']['child']['FareRuleInfo']['Header'])) {
                        echo '<table style="width:100%">';
                        echo '<tr>';
                        $idx = 0;

                        foreach($dataFlightRules['rules']['child']['FareRuleInfo']['Header']['Line'] as $lineRule) {
                            $idx++;
                            echo '<td>'.$lineRule['Text'].'</td>';
                            if($idx % 4 == 0) {
                                echo '</tr><tr>';

                            }
                        }
                        echo '</tr>';
                        echo '</table>';

                        echo '<table style="width:100%; text-align:left">';
                        $idx = 1;
                        foreach($dataFlightRules['rules']['child']['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                            echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                            $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                            $texting = str_replace('\r', '<br>', $texting);

                            echo '<tr><td>'.nl2br($texting).'</td></tr>';
                            $idx++;
                        }
                        echo '</table>';
                    } else {
                        echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                    }
                }




            /* uncomment this if prefering displaying routing info rather than rules
            echo '<tr><td>'.$dataFlightRules['FareRuleInfo']['RoutingInfo']['Text'].'</td></tr>';
            */

            echo '</div>';
        }
        /* infant */
        if (array_key_exists('infant', $dataFlightRules['rules'])) {
            echo '<h4>Applied Rules for Infant</h4>';
            echo '<div>';


                if (array_key_exists('0', $dataFlightRules['rules']['infant'])){
                    foreach($dataFlightRules['rules']['infant'] as $rulesinfant) {

                        if(count($rulesinfant['FareRuleInfo']['Header'])) {
                            echo '<table style="width:100%">';
                            echo '<tr>';
                            $idx = 0;

                            foreach($rulesinfant['FareRuleInfo']['Header']['Line'] as $lineRule) {
                                $idx++;
                                echo '<td>'.$lineRule['Text'].'</td>';
                                if($idx % 4 == 0) {
                                    echo '</tr><tr>';

                                }
                            }
                            echo '</tr>';
                            echo '</table>';

                            echo '<table style="width:100%; text-align:left">';
                            $idx = 1;
                            foreach($rulesinfant['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                                echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                                $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                                $texting = str_replace('\r', '<br>', $texting);

                                echo '<tr><td>'.nl2br($texting).'</td></tr>';
                                $idx++;
                            }
                            echo '</table>';
                        } else {
                            echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                        }
                    }

                } else {
                    if(count($dataFlightRules['rules']['infant']['FareRuleInfo']['Header'])) {
                        echo '<table style="width:100%">';
                        echo '<tr>';
                        $idx = 0;

                        foreach($dataFlightRules['rules']['infant']['FareRuleInfo']['Header']['Line'] as $lineRule) {
                            $idx++;
                            echo '<td>'.$lineRule['Text'].'</td>';
                            if($idx % 4 == 0) {
                                echo '</tr><tr>';

                            }
                        }
                        echo '</tr>';
                        echo '</table>';

                        echo '<table style="width:100%; text-align:left">';
                        $idx = 1;
                        foreach($dataFlightRules['rules']['infant']['FareRuleInfo']['Rules']['Paragraph'] as $ruleParagraph) {
                            echo '<tr><th>'.$idx.'. '.$ruleParagraph['@attributes']['Title'].'</th></tr>';
                            $texting = str_replace('\n', '<br>', $ruleParagraph['Text']);
                            $texting = str_replace('\r', '<br>', $texting);

                            echo '<tr><td>'.nl2br($texting).'</td></tr>';
                            $idx++;
                        }
                        echo '</table>';
                    } else {
                        echo '<div class="empty" style="font-weight:bold; font-size: 18px; margin:5px; padding: 15px; color:#FF0000">There is no applied rules return by the system</div>';
                    }
                }




            /* uncomment this if prefering displaying routing info rather than rules
            echo '<tr><td>'.$dataFlightRules['FareRuleInfo']['RoutingInfo']['Text'].'</td></tr>';
            */

            echo '</div>';
        }
        echo '</div>';

    }
    echo '</div>';
?>
</div>
<?php if($print == 1){ ?>

<script>
$(function() {
    $('.go-print2').on('click', function() {
        var w = window.open("<?php echo base_url()?>cart/flightrules/1", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=200,width=640,height=480");
        /*w.focus();*/
        setTimeout(function () { w.print(); }, 1);
        /**/
        $(w).load(function () {
            w.close();
        });
    });
});
</script>
</body>
</html>
<?php } ?>