<div class="tab" style="margin-bottom:-30px">
    <div class="not-print" style="margin-top:0px">
        <h1 style="border-bottom:none">Contact Person Information</h1>
    </div>
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <th style="background-color:#e0f2f4; font-size:14px; text-align:left">
                Person
            </th>
            <th style="background-color:#e0f2f4; font-size:14px; text-align:left">
                Contact
            </th>
            <th style="background-color:#e0f2f4; font-size:14px; text-align:left">
                Relationship
            </th>
            <th style="background-color:#e0f2f4; font-size:14px; text-align:left">
                Transaction Made
            </th>
        </tr>
        <?php
        $infos = $this->All->select_template_with_where_and_order(
            "bookOrderID", $bookingOrderID, "id", "ASC", "contact_person_information"
        );

        if( $infos == TRUE ) {
            foreach( $infos AS $info ) {
                $namearr = explode(" ", $info->cp_fullname);
                if(count($namearr) > 1) {
                    $passname = $namearr[1]."/".$namearr[0];
                } else {
                    $passname = $namearr[0];
                }

                $passname = $info->cp_title != "" ? $passname . $info->cp_title : $passname;
        ?>
        <tr>
            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top; text-transform: UPPERCASE">
                <?php echo $passname; ?>
            </td>
            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                <b>Contact no.:<br /><?php echo $info->cp_contact_no; ?></b>
                <br /><br />
                <b>Email address:<br /><?php echo $info->cp_email; ?></b>
            </td>
            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                <b><?php echo $info->category == 'main' ? 'Main Contact Person':$info->category; ?></b>

            </td>
            <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                <?php echo date("Y-F-d", strtotime($info->created)); ?>
                <br />
                <?php echo date("H:i:sA", strtotime($info->created)); ?>
            </td>
        </tr>
        <?php if($info->category == 'main' && $info->cp_remarks != "") { ?>
        <tr>
            <td colspan="4" style="background-color:#eff0f1; font-size:12px; vertical-align: top">Remark:<br><?php echo $info->cp_remarks;?></td>
        </tr>
        <?php
                }
            }
        } else {
                $infos = $this->All->select_template_with_where2_and_order(
                    "bookOrderID", $bookingOrderID, "type_adul_or_child", "", "traveler_fullname", "ASC", "cruise_traverlerInfo"
                );
                if( $infos == TRUE ) {
                    foreach( $infos AS $info ) {
                ?>
                <tr>
                    <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                        <?php echo $info->traveler_title; ?>. <?php echo $info->traveler_fullname; ?>
                    </td>
                    <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                        <b>Contact no.:<br /><?php echo $info->traveler_contact; ?></b>
                        <br /><br />
                        <b>Email address:<br /><?php echo $info->traveler_email; ?></b>
                    </td>
                    <b><?php echo $info->category == 'main' ? 'Main Contact Person':$info->category; ?></b>
                    <td style="background-color:#eff0f1; font-size:12px; vertical-align: top">
                        <?php echo date("Y-F-d", strtotime($info->created)); ?>
                        <br />
                        <?php echo date("H:i:sA", strtotime($info->created)); ?>
                    </td>
                </tr>
                <?php
                    }
                }
        }
        ?>
    </table>
</div>