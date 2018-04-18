<?php 
	/*
	1- period type
    2- stateroom ID
    3- pax count
	*/
	if( $this->input->post("hidden_period_type") == "LOW" ) {
		$array_posts = $this->input->post("stateroom");
		$count_stateroom = count($this->input->post("stateroom"));
		if( $count_stateroom > 0 ) {
			foreach($array_posts AS $key => $value) {
				$getPrices = $this->All->select_template_w_5_conditions(
					"SHIP_ID", $this->input->post("hidden_ship_id"), "BRAND_ID", $this->input->post("hidden_brand_id"), 
					"PERIOD_TYPE", "LOW", "NIGHTS_NO", $this->input->post("hidden_nights_no"),
					"STATEROOM_ID", $key,
					"cruise_prices"
				);
				if( $getPrices == TRUE ) {
					$data_fields = array(
						"ATT_SINGLE"  => $value[1],
						"ATT_1"    	  => $value[2],
						"ATT_2_ADULT" => $value[3],
						"ATT_2_CHILD" => $value[4],
						"ATT_3_ADULT" => $value[5],
						"ATT_3_CHILD" => $value[6],
						"ATT_4_ADULT" => $value[7],
						"ATT_4_CHILD" => $value[8],
						"MODIFIED" 	  => date("Y-m-d H:i:s")
					);
					$updatePrice = $this->All->update_template_five(
						$data_fields, 
						"SHIP_ID", trim($this->input->post("hidden_ship_id")), 
						"BRAND_ID", trim($this->input->post("hidden_brand_id")), 
						"PERIOD_TYPE", "LOW", 
						"NIGHTS_NO", trim($this->input->post("hidden_nights_no")), 
						"STATEROOM_ID", $key, 
						"cruise_prices"
					);
				}
				else {
					$data_fields = array(
						"SHIP_ID" 	   => trim($this->input->post("hidden_ship_id")),
						"BRAND_ID" 	   => trim($this->input->post("hidden_brand_id")),
						"STATEROOM_ID" => $key,
						"PERIOD_TYPE"  => trim($this->input->post("hidden_period_type")),
						"NIGHTS_NO"	   => trim($this->input->post("hidden_nights_no")),
						"ATT_SINGLE"   => $value[1],
						"ATT_1"    	   => $value[2],
						"ATT_2_ADULT"  => $value[3],
						"ATT_2_CHILD"  => $value[4],
						"ATT_3_ADULT"  => $value[5],
						"ATT_3_CHILD"  => $value[6],
						"ATT_4_ADULT"  => $value[7],
						"ATT_4_CHILD"  => $value[8],
						"CREATED"  	   => date("Y-m-d H:i:s"),
						"MODIFIED" 	   => date("Y-m-d H:i:s")
					);
					$insertPrice = $this->All->insert_template($data_fields, "cruise_prices");
				}
			}
			if( $this->input->post("hidden_redirect") != ""  ) {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_overview/'.$this->input->post("hidden_cruisetitleID"));
			}
			else {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_add_new_prices');
			}
		}
	}
	else if( $this->input->post("hidden_period_type") == "SHOULDER" ) {
		$array_posts = $this->input->post("stateroom");
		$count_stateroom = count($this->input->post("stateroom"));
		if( $count_stateroom > 0 ) {
			foreach($array_posts AS $key => $value) {
				$getPrices = $this->All->select_template_w_5_conditions(
					"SHIP_ID", $this->input->post("hidden_ship_id"), 
					"BRAND_ID", $this->input->post("hidden_brand_id"), 
					"PERIOD_TYPE", "SHOULDER", 
					"NIGHTS_NO", $this->input->post("hidden_nights_no"),
					"STATEROOM_ID", $key,
					"cruise_prices"
				);
				if( $getPrices == TRUE ) {
					$data_fields = array(
						"ATT_SINGLE"  => $value[1],
						"ATT_1"    	  => $value[2],
						"ATT_2_ADULT" => $value[3],
						"ATT_2_CHILD" => $value[4],
						"ATT_3_ADULT" => $value[5],
						"ATT_3_CHILD" => $value[6],
						"ATT_4_ADULT" => $value[7],
						"ATT_4_CHILD" => $value[8],
						"MODIFIED" => date("Y-m-d H:i:s")
					);
					$updatePrice = $this->All->update_template_five(
						$data_fields, 
						"SHIP_ID", trim($this->input->post("hidden_ship_id")), 
						"BRAND_ID", trim($this->input->post("hidden_brand_id")), 
						"PERIOD_TYPE", "SHOULDER", 
						"NIGHTS_NO", trim($this->input->post("hidden_nights_no")), 
						"STATEROOM_ID", $key, 
						"cruise_prices"
					);
				}
				else {
					$data_fields = array(
						"SHIP_ID" 	   => trim($this->input->post("hidden_ship_id")),
						"BRAND_ID" 	   => trim($this->input->post("hidden_brand_id")),
						"STATEROOM_ID" => $key,
						"PERIOD_TYPE"  => trim($this->input->post("hidden_period_type")),
						"NIGHTS_NO"	   => trim($this->input->post("hidden_nights_no")),
						"ATT_SINGLE"   => $value[1],
						"ATT_1"    	   => $value[2],
						"ATT_2_ADULT"  => $value[3],
						"ATT_2_CHILD"  => $value[4],
						"ATT_3_ADULT"  => $value[5],
						"ATT_3_CHILD"  => $value[6],
						"ATT_4_ADULT"  => $value[7],
						"ATT_4_CHILD"  => $value[8],
						"CREATED"  	   => date("Y-m-d H:i:s"),
						"MODIFIED" 	   => date("Y-m-d H:i:s")
					);
					$insertPrice = $this->All->insert_template($data_fields, "cruise_prices");
				}	
			}
			if( $this->input->post("hidden_redirect") != ""  ) {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_overview/'.$this->input->post("hidden_cruisetitleID"));
			}
			else {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_add_new_prices');
			}
		}
	}
	else if( $this->input->post("hidden_period_type") == "PEAK" ) {
		$array_posts = $this->input->post("stateroom");
		$count_stateroom = count($this->input->post("stateroom"));
		if( $count_stateroom > 0 ) {
			foreach($array_posts AS $key => $value) {
				$getPrices = $this->All->select_template_w_5_conditions(
					"SHIP_ID", $this->input->post("hidden_ship_id"), 
					"BRAND_ID", $this->input->post("hidden_brand_id"), 
					"PERIOD_TYPE", "PEAK", 
					"NIGHTS_NO", $this->input->post("hidden_nights_no"),
					"STATEROOM_ID", $key,
					"cruise_prices"
				);
				if( $getPrices == TRUE ) {
					$data_fields = array(
						"ATT_SINGLE"  => $value[1],
						"ATT_1"    	  => $value[2],
						"ATT_2_ADULT" => $value[3],
						"ATT_2_CHILD" => $value[4],
						"ATT_3_ADULT" => $value[5],
						"ATT_3_CHILD" => $value[6],
						"ATT_4_ADULT" => $value[7],
						"ATT_4_CHILD" => $value[8],
						"MODIFIED"    => date("Y-m-d H:i:s")
					);
					$updatePrice = $this->All->update_template_five(
						$data_fields, 
						"SHIP_ID", trim($this->input->post("hidden_ship_id")), 
						"BRAND_ID", trim($this->input->post("hidden_brand_id")), 
						"PERIOD_TYPE", "PEAK", 
						"NIGHTS_NO", trim($this->input->post("hidden_nights_no")), 
						"STATEROOM_ID", $key, 
						"cruise_prices"
					);
				}
				else {
					$data_fields = array(
						"SHIP_ID" 	   => trim($this->input->post("hidden_ship_id")),
						"BRAND_ID" 	   => trim($this->input->post("hidden_brand_id")),
						"STATEROOM_ID" => $key,
						"PERIOD_TYPE"  => trim($this->input->post("hidden_period_type")),
						"NIGHTS_NO"	   => trim($this->input->post("hidden_nights_no")),
						"ATT_SINGLE"   => $value[1],
						"ATT_1"    	   => $value[2],
						"ATT_2_ADULT"  => $value[3],
						"ATT_2_CHILD"  => $value[4],
						"ATT_3_ADULT"  => $value[5],
						"ATT_3_CHILD"  => $value[6],
						"ATT_4_ADULT"  => $value[7],
						"ATT_4_CHILD"  => $value[8],
						"CREATED"  	   => date("Y-m-d H:i:s"),
						"MODIFIED" 	   => date("Y-m-d H:i:s")
					);
					$insertPrice = $this->All->insert_template($data_fields, "cruise_prices");
				}
			}
			if( $this->input->post("hidden_redirect") != ""  ) {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_overview/'.$this->input->post("hidden_cruisetitleID"));
			}
			else {
				$this->session->set_flashdata(
					'sessionLOWPrice',
					'<div class="alert alert-success alert-bordered">
						<button type="button" class="close" data-dismiss="alert">
							<span>&times;</span><span class="sr-only">Close</span>
						</button>
						<span class="text-semibold">Well done!</span> 
						Price has been added.
					</div>'
				);
				redirect('backend/product/cruise_add_new_prices');
			}
		}
	}
	
?>
