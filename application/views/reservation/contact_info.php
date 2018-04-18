<br />
<div style="text-align:left">
	<h1 style="border-bottom:none">Contact Person Information</h1>
</div>
<div>
	<div class="tab">
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
					Person
				</th>
				<th style="background-color:#e0f2f4; padding:10px; font-size:14px; text-align:left">
					Contact
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
			$infos = $this->All->select_template_with_where_and_order(
				"bookOrderID", $bookingOrderID, "cp_fullname", "ASC", "contact_person_information"
			);
			if( $infos == TRUE ) {
				foreach( $infos AS $info ) {
					$cp_title 	   			 = $info->cp_title;
					$cp_fullname   			 = $info->cp_fullname;
					$cp_nric 	   			 = $info->cp_nric;
					$cp_contact_no 			 = $info->cp_contact_no;	
					$cp_email 	   			 = $info->cp_email;	
					$cp_nationality 		 = $info->cp_nationality;
					$cp_dob 	   			 = $info->cp_dob;
					$cp_passport_no			 = $info->cp_passport_no;
					$cp_passport_issue_date  = $info->cp_passport_issue_date;
					$cp_passport_expire_date = $info->cp_passport_expire_date;
					$cp_created 			 = $info->created;
				}
			?>
				<tr>
					<td style="background-color:#eff0f1; font-size:12px">
						<?php echo $cp_title; ?>. <?php echo $cp_fullname; ?><br />(NRIC: <?php echo $cp_nric; ?>)
					</td>
					<td style="background-color:#eff0f1; font-size:12px">
						<b>Contact no.:<br /><?php echo $cp_contact_no; ?></b>
						<br /><br />
						<b>Email address:<br /><?php echo $cp_email; ?></b>
					</td>
					<td style="background-color:#eff0f1; font-size:12px">
						<?php echo $cp_nationality; ?>
					</td>
					<td style="background-color:#eff0f1; font-size:12px">
						<?php echo date("Y-F-d", strtotime($cp_dob)); ?>
					</td>
					<td style="background-color:#eff0f1; font-size:12px">
						<div style="padding:10px">
							Passport no.:<br /><b><?php echo $cp_passport_no; ?></b><br /><br />
							Issue date:<br /><b><?php echo $cp_passport_issue_date; ?></b><br /><br />
							Expiry date:<br /><b><?php echo $cp_passport_expire_date; ?></b>
						</div>
					</td>
					<td style="background-color:#eff0f1; font-size:12px">
						<?php echo date("Y-F-d", strtotime($cp_created)); ?>
						<br />
						<?php echo date("H:i:sA", strtotime($cp_created)); ?>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
	</div>
</div>