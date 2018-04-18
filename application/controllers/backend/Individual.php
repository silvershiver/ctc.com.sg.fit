<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Individual extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
		parent::__construct();
		$this->load->library('Spreadsheet_Excel_Reader');
		$this->load->model('bank');
    }
    
	public function cs()
	{	
		$this->load->view('backend/individual_cs');
	}
	
	public function gs()
	{
		$this->load->view('backend/individual_gs');
	}
	
	public function jpm()
	{
		$this->load->view('backend/individual_jpm');
	}
	
	public function pfm()
	{
		$this->load->view('backend/individual_pfm');
	}
	
	public function history()
	{
		$this->load->view('backend/individual_history');
	}
	
	public function master()
	{
		$this->load->view('backend/individual_master');
	}
	
	public function details()
	{
		$this->load->view('backend/portfolio_details');
	}
	
	public function overall()
	{
		$this->load->view('backend/portfolio_overall');
	}
	
	public function country_allocation()
	{
		$this->load->view('backend/list_acc_country');
	}
	
	public function country_allocation_details()
	{
		$this->load->view('backend/country_allocation');
	}
	
	public function print_format_one_pager()
	{
		$consolidated = $this->input->post('consolidated');
		$data['array_individual_id'] = $consolidated;
		$this->load->view('backend/print_one_pager', $data);
	}
	
	public function print_format_country_allocation()
	{
		$consolidated = $this->input->post('consolidated');
		$data['array_individual_id'] = $consolidated;
		$this->load->view('backend/print_country_allocation', $data);
	}
	
	public function consolidate_account()
	{
		$consolidated = $this->input->post('consolidated');
		if( $consolidated == "" ) {
			$this->session->set_flashdata(
				'no_checkbox_selection', 
				'<div style="color:red; font-weight:bold; margin-bottom:5px">Please choose and tick the checkbox(s) below.</div>'
			);
			redirect('backend/dashboard');
		}
		else {
			$data['array_individual_id'] = $consolidated;
			if( $this->input->post('dasboard_select') == "one_pager" ) {
				$this->load->view('backend/one_pager', $data);
			}
			else if( $this->input->post('dasboard_select') == "one_pager_live" ) {
				$this->load->view('backend/one_pager_live', $data);
			}
			else if( $this->input->post('dasboard_select') == "country_allocation" ) {
				$this->load->view('backend/country_allocation', $data);
			}
			else if( $this->input->post('dasboard_select') == "violation_list" ) {
				$this->load->view('backend/violation_list', $data);
			}
			else if( $this->input->post('dasboard_select') == "quarterly_summary" ) {
				$this->load->view('backend/quarterly_summary', $data);
			}
		}
	}
	
	public function consolidate_account_group()
	{
		$consolidated = $this->input->post('consolidated');
		if( $consolidated == "" ) {
			$this->session->set_flashdata(
				'no_checkbox_selection', 
				'<div style="color:red; font-weight:bold; margin-bottom:5px; margin-left:10px">
					Please choose and tick the checkbox(s) below.
				</div>'
			);
			redirect('backend/dashboard/group');
		}
		else {
			if( count($consolidated) > 1 ) {
				$this->session->set_flashdata(
					'more_than_one_record', 
					'<div style="color:red; font-weight:bold; margin-bottom:5px; margin-left:10px">
						Please choose only one group.
					</div>'
				);
				redirect('backend/dashboard/group');
			}
			else {
				$detail_res = mysql_query(
					"SELECT * FROM individual_portfolio WHERE user_group_id = ".$consolidated[0]." GROUP BY account_id"
				);
				while( $detail_row = mysql_fetch_array($detail_res, MYSQL_ASSOC) ) {
					$data_aa[] = $detail_row["id"];
				}
				$data['array_individual_id'] = $data_aa;
				if( $this->input->post('dasboard_select') == "one_pager" ) {
					$this->load->view('backend/one_pager', $data);
				}
				else if( $this->input->post('dasboard_select') == "country_allocation" ) {
					$this->load->view('backend/country_allocation', $data);
				}
				else if( $this->input->post('dasboard_select') == "violation_list" ) {
					$this->load->view('backend/violation_list', $data);
				}
				else if( $this->input->post('dasboard_select') == "quarterly_summary" ) {
					$this->load->view('backend/quarterly_summary', $data);
				}
			}
		}
	}
	
	public function cs_update()
	{
		if($this->input->post('submit_details')) {
			$id = $this->input->post('portfolio_id');
			$details['fund_closing_date'] = $this->input->post('fund_closing_date');
			$details['potential_value'] = $this->input->post('potential_value');
			$where = array( "id"=>$id);
			$this->bank->update_value($details, $where); 
			$this->session->set_flashdata('success_update', 'Record has been updated');
			$this->session->set_flashdata(
				'success_update_inside_cs', 
				'<br /><div style="color:green; font-weight:bold; margin-top:10px">Update operation OK.</div>'
			);
			redirect('backend/individual/cs');
		} 
		else {
			redirect('backend/individual/cs');
		}
	}
	
	public function reset_pfm()
	{
		$clear_pfm = $this->all->delete_empty_table('individual_mtm_tyd');
		$this->session->set_flashdata(
			'success_reset_pfm_value', 
			'<div style="color:green; font-weight:bold; margin-top:10px">PFM values has been reset.</div>'
		);
		redirect('backend/individual/pfm');
	}
	
	public function pfm_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$archivo  = $_FILES['pfm_file']['tmp_name'];
			$data     = new Spreadsheet_Excel_Reader($archivo);
			$filename = pathinfo($_FILES['pfm_file']['name'], PATHINFO_FILENAME);	
			$details  = array();
			$total_rows = $data->rowcount($sheet_index=0);	
			for($i=2; $i<=$total_rows; $i++) {
				if( $data->val($i, 'A') != "" ) {
					$check_res = mysql_query(
						"
							SELECT * FROM individual_mtm_tyd WHERE account_id = '".trim($data->val($i, 'A'))."'
							AND date_gain_loss = '".trim($data->val($i, 'B'))."'
						"
					);
					if( mysql_num_rows($check_res) > 0 ) {
						//update record
						$data_fields = array(
							'total_market_value' => trim(str_replace(",","",$data->val($i, 'C'))),
							'modified' 			 => date("Y-m-d H:i:s")
						);
						$update_record = $this->all->update_template_two(
							$data_fields,
							'account_id', trim($data->val($i, 'A')),
							'date_gain_loss', trim($data->val($i, 'B')),
							'individual_mtm_tyd'
						);
					}
					else {
						//insert record
						$data_fields = array(
							'account_id' 		 => trim($data->val($i, 'A')),
							'total_market_value' => trim(str_replace(",","",$data->val($i, 'C'))),
							'gain_loss_percent'  => '',
							'different_percent'  => '',
							'date_gain_loss' 	 => trim($data->val($i, 'B')),
							'created' 			 => date("Y-m-d H:i:s"),
							'modified' 			 => date("Y-m-d H:i:s"),
						);
						$insert_record = $this->all->insert_template($data_fields, 'individual_mtm_tyd');
					}
				}
			}
			$this->session->set_flashdata(
				'success_update_pfm_file', 
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/individual/pfm');
		}
		else {
			redirect('backend/individual/pfm');
		}
	}
	
	public function masterlist_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//get al ISIN number existed
			$array_isin = array();
			$res_isin = mysql_query("SELECT * FROM individual_portfolio WHERE isin != ''");
			while( $row_isin = mysql_fetch_array($res_isin, MYSQL_ASSOC) ) {
				$array_isin[] = $row_isin['isin'];
			}
			//end of et al ISIN number existed
			//get all description existed
			$array_dsc = array();
			$res_dsc = mysql_query(
				"
					SELECT * FROM individual_portfolio 
					WHERE asset_class IN ('alternative investment', 'alternative investments', 'Alternative Investment', 
					'Alternative Investments')
				"
			);
			while( $row_dsc = mysql_fetch_array($res_dsc, MYSQL_ASSOC) ) {
				$array_dsc[] = strtolower($row_dsc['description']);
			}
			//end of get all description existed
			$archivo 	  = $_FILES['masterlist_file']['tmp_name'];
			$data    	  = new Spreadsheet_Excel_Reader($archivo);
			$filename 	  = pathinfo($_FILES['masterlist_file']['name'], PATHINFO_FILENAME);	
			$details 	  = array();
			$total_rows = $data->rowcount($sheet_index=0);	
			for($i=4; $i<=$total_rows; $i++) {
				if( in_array(trim($data->val($i,'I')), $array_isin) ) {
					//third party fund
					if( $data->val($i, 'AB') == "" ) {
						$third_party_fund = 0;
					}
					else {
						$third_party_fund = $data->val($i, 'AB');
					}
					//min lot
					if( trim($data->val($i, 'AC')) != "" || trim($data->val($i, 'AC')) != " #N/A Field Not Applicable " ) {
						$min_lot = str_replace(",",  "", trim($data->val($i, 'AC')));
						$min_lot = str_replace("* ", "", trim($data->val($i, 'AC')));
					}
					else {
						$min_lot = "";
					}
					//end of min lot
					//fx rate record
					if( trim($data->val($i, 'AL')) != "" || trim($data->val($i, 'AL')) != "#N/A Invalid Security" ) {
						$fx_rate = str_replace(",",  "", trim($data->val($i, 'AL')));
						$fx_rate = str_replace("* ", "", trim($data->val($i, 'AL')));
					}
					else {
						$fx_rate = "1.00";
					}
					//end of fx rate record
					//update record if ISIN same
					$details['asset_class'] 		  = $data->val($i, 'B');
					$details['description']	 		  = $data->val($i, 'C');
					$details['ticker']		 	      = $data->val($i, 'D');
					$details['region']		 		  = $data->val($i, 'E');
					$details['country'] 			  = $data->val($i, 'F');		
					$details['category'] 			  = $data->val($i, 'G');
					$details['fi_category']		 	  = $data->val($i, 'H');
					$details['isin']		 		  = $data->val($i, 'I');
					$details['sector'] 				  = $data->val($i, 'J');
					$details['core_or_non_core'] 	  = $data->val($i, 'K');
					$details['closing_price_live'] 	  = str_replace("* ", "", trim($data->val($i, 'L')));	
					$details['fx'] 					  = $data->val($i, 'M');
					$details['currency']			  = $data->val($i, 'N');
					$details['grade'] 				  = $data->val($i, 'O');
					$details['issuer'] 				  = $data->val($i, 'Q');
					$details['stated_maturity_date']  = $data->val($i, 'R');
					if( $data->val($i, 'S') != "#N/A N/A" || $data->val($i, 'S') != "-" || $data->val($i, 'S') != "#N/A Field Not Applicable" ) {
						$details['yield_to_maturiry'] = $data->val($i, 'S');
					}
					else {
						$details['yield_to_maturiry'] = "";
					}
					$details['bond_duration'] 		  = $data->val($i, 'T');
					$details['coupon'] 				  = $data->val($i, 'U');		
					$details['company_sp_rating'] 	  = $data->val($i, 'V');
					$details['company_moody_rating']  = $data->val($i, 'W');
					$details['company_fitch_rating']  = $data->val($i, 'X');
					$details['issuer_sp_rating'] 	  = $data->val($i, 'Y');
					$details['issuer_moody_rating']   = $data->val($i, 'Z');
					$details['issuer_fitch_rating']   = $data->val($i, 'AA');
					$details['third_party_fund'] 	  = $third_party_fund;
					$details['third_party_fund_sub']  = $third_party_fund_sub;
					$details['min_lot']  			  = $min_lot;
					$details['fx_rate']				  = str_replace("* ", "", trim($data->val($i, 'M')));
					$details['initial_commitment'] 	  = $data->val($i, 'AD');
					$details['net_contribution'] 	  = $data->val($i, 'AE');
					$details['fund_closing_date'] 	  = $data->val($i, 'AF');
					$details['year_since_investment'] = $data->val($i, 'AG');
					$details['potential_value'] 	  = $data->val($i, 'AH');
					$details['modified'] 			  = date("Y-m-d H:i:s");
					$where = array("isin" => $details['isin']);
					$this->bank->update_value($details, $where);
					$this->bank->update_value_split($details, $where);
					/*Insert into individual MTM YTD*/
					/*End of insert into individual MTM YTD*/
				}
				else {
					//third party fund
					if( $data->val($i, 'AB') == "" ) {
						$third_party_fund = 0;
					}
					else {
						$third_party_fund = $data->val($i, 'AB');
					}
					//min lot
					if( trim($data->val($i, 'AC')) != "" || trim($data->val($i, 'AC')) != " #N/A Field Not Applicable " ) {
						$min_lot = str_replace(",",  "", trim($data->val($i, 'AC')));
						$min_lot = str_replace("* ", "", trim($data->val($i, 'AC')));
					}
					else {
						$min_lot = "";
					}
					//end of min lot
					//fx rate record
					if( trim($data->val($i, 'AL')) != "" || trim($data->val($i, 'AL')) != "#N/A Invalid Security" ) {
						$fx_rate = str_replace(",",  "", trim($data->val($i, 'AL')));
						$fx_rate = str_replace("* ", "", trim($data->val($i, 'AL')));
					}
					else {
						$fx_rate = "1";
					}
					//end of fx rate record
					if( strtolower($data->val($i,'B')) == "alternative investment" ) {
						if( $data->val($i,'I') != NULL ) {
							if( in_array(trim($data->val($i,'I')), $array_isin) ) {
								//third party fund
								if( $data->val($i, 'AB') == "" ) {
									$third_party_fund = 0;
								}
								else {
									$third_party_fund = $data->val($i, 'AB');
								}
								//min lot
								if( trim($data->val($i, 'AC')) != "" || trim($data->val($i, 'AC')) != " #N/A Field Not Applicable " ) {
									$min_lot = str_replace(",",  "", trim($data->val($i, 'AC')));
									$min_lot = str_replace("* ", "", trim($data->val($i, 'AC')));
								}
								else {
									$min_lot = "";
								}
								//end of min lot
								//fx rate record
								if( trim($data->val($i, 'AL')) != "" || trim($data->val($i, 'AL')) != "#N/A Invalid Security" ) {
									$fx_rate = str_replace(",",  "", trim($data->val($i, 'AL')));
									$fx_rate = str_replace("* ", "", trim($data->val($i, 'AL')));
								}
								else {
									$fx_rate = "1";
								}
								//end of fx rate record
								//update record if ISIN same
								$details['asset_class'] 		  = $data->val($i,'B');
								$details['description']	 		  = $data->val($i, 'C');
								$details['ticker']		 	      = $data->val($i, 'D');
								$details['region']		 		  = $data->val($i, 'E');
								$details['country'] 			  = $data->val($i, 'F');		
								$details['category'] 			  = $data->val($i, 'G');
								$details['fi_category']		 	  = $data->val($i, 'H');
								$details['isin']		 		  = $data->val($i, 'I');
								$details['sector'] 				  = $data->val($i, 'J');
								$details['core_or_non_core'] 	  = $data->val($i, 'K');
								//$details['closing_price'] 		  = $data->val($i, 'L');
								$details['closing_price_live'] 	  = str_replace("* ", "", trim($data->val($i, 'L')));
								$details['fx'] 					  = $data->val($i, 'M');
								$details['currency']			  = $data->val($i, 'N');
								$details['grade'] 				  = $data->val($i, 'O');
								$details['issuer'] 				  = $data->val($i, 'Q');
								$details['stated_maturity_date']  = $data->val($i, 'R');
								if( $data->val($i, 'S') != "#N/A N/A" || $data->val($i, 'S') != "-" || $data->val($i, 'S') != "#N/A Field Not Applicable" ) {
									$details['yield_to_maturiry'] = $data->val($i, 'S');
								}
								else {
									$details['yield_to_maturiry'] = "";
								}
								$details['bond_duration'] 		  = $data->val($i, 'T');
								$details['coupon'] 				  = $data->val($i, 'U');		
								$details['company_sp_rating'] 	  = $data->val($i, 'V');
								$details['company_moody_rating']  = $data->val($i, 'W');
								$details['company_fitch_rating']  = $data->val($i, 'X');
								$details['issuer_sp_rating'] 	  = $data->val($i, 'Y');
								$details['issuer_moody_rating']   = $data->val($i, 'Z');
								$details['issuer_fitch_rating']   = $data->val($i, 'AA');
								$details['third_party_fund'] 	  = $third_party_fund;
								$details['min_lot']  			  = $min_lot;
								$details['fx_rate']				  = str_replace("* ", "", trim($data->val($i, 'M')));	
								$details['initial_commitment'] 	  = $data->val($i, 'AD');
								$details['net_contribution'] 	  = $data->val($i, 'AE');
								$details['fund_closing_date'] 	  = $data->val($i, 'AF');
								$details['year_since_investment'] = $data->val($i, 'AG');
								$details['potential_value'] 	  = $data->val($i, 'AH');
								$details['modified'] 			  = date("Y-m-d H:i:s");
								$where = array("isin" => $details['isin']);
								$this->bank->update_value($details, $where);
								$this->bank->update_value_split($details, $where);
								/*Insert into individual MTM YTD*/
								/*End of insert into individual MTM YTD*/
							}
						}
						else {
							if( in_array(strtolower(trim($data->val($i,'C'))), $array_dsc) ) {
								//third party fund
								if( $data->val($i, 'AB') == "" ) {
									$third_party_fund = 0;
								}
								else {
									$third_party_fund = $data->val($i, 'AB');
								}
								//min lot
								if( trim($data->val($i, 'AC')) != "" || trim($data->val($i, 'AC')) != " #N/A Field Not Applicable " ) {
									$min_lot = str_replace(",",  "", trim($data->val($i, 'AC')));
									$min_lot = str_replace("* ", "", trim($data->val($i, 'AC')));
								}
								else {
									$min_lot = "";
								}
								//end of min lot
								//fx rate record
								if( trim($data->val($i, 'AL')) != "" || trim($data->val($i, 'AL')) != "#N/A Invalid Security" ) {
									$fx_rate = str_replace(",",  "", trim($data->val($i, 'AL')));
									$fx_rate = str_replace("* ", "", trim($data->val($i, 'AL')));
								}
								else {
									$fx_rate = "1";
								}
								//end of fx rate record
								//update alternative record
								$details['asset_class'] 		  = $data->val($i,'B');
								$details['description']	 		  = $data->val($i, 'C');
								$details['ticker']		 	      = $data->val($i, 'D');
								$details['region']		 		  = $data->val($i, 'E');
								$details['country'] 			  = $data->val($i, 'F');		
								$details['category'] 			  = $data->val($i, 'G');
								$details['fi_category']		 	  = $data->val($i, 'H');
								$details['isin']		 		  = $data->val($i, 'I');
								$details['sector'] 				  = $data->val($i, 'J');
								$details['core_or_non_core'] 	  = $data->val($i, 'K');
								//$details['closing_price'] 		  = $data->val($i, 'L');
								$details['closing_price_live'] 	  = str_replace("* ", "", trim($data->val($i, 'L')));	
								$details['fx'] 					  = $data->val($i, 'M');
								$details['currency']			  = $data->val($i, 'N');
								$details['grade'] 				  = $data->val($i, 'O');
								$details['issuer'] 				  = $data->val($i, 'Q');
								$details['stated_maturity_date']  = $data->val($i, 'R');
								if( $data->val($i, 'S') != "#N/A N/A" || $data->val($i, 'S') != "-" || $data->val($i, 'S') != "#N/A Field Not Applicable" ) {
									$details['yield_to_maturiry'] = $data->val($i, 'S');
								}
								else {
									$details['yield_to_maturiry'] = "";
								}
								$details['bond_duration'] 		  = $data->val($i, 'T');
								$details['coupon'] 				  = $data->val($i, 'U');		
								$details['company_sp_rating'] 	  = $data->val($i, 'V');
								$details['company_moody_rating']  = $data->val($i, 'W');
								$details['company_fitch_rating']  = $data->val($i, 'X');
								$details['issuer_sp_rating'] 	  = $data->val($i, 'Y');
								$details['issuer_moody_rating']   = $data->val($i, 'Z');
								$details['issuer_fitch_rating']   = $data->val($i, 'AA');
								$details['third_party_fund'] 	  = $third_party_fund;
								$details['min_lot']  			  = $min_lot;
								$details['fx_rate']				  = str_replace("* ", "", trim($data->val($i, 'M')));		
								$details['initial_commitment'] 	  = $data->val($i, 'AD');
								$details['net_contribution'] 	  = $data->val($i, 'AE');
								$details['fund_closing_date'] 	  = $data->val($i, 'AF');
								$details['year_since_investment'] = $data->val($i, 'AG');
								$details['potential_value'] 	  = $data->val($i, 'AH');
								$details['modified'] 			  = date("Y-m-d H:i:s");
								$where = array("description" => $data->val($i, 'C'));
								$this->bank->update_value($details, $where);
								$this->bank->update_value_split($details, $where);
								//update end of alternative record
							}
						}
					}
				}
			}
			$config['upload_path']   = './assets/uploads/master_list/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['overwrite']	 = TRUE;
			$this->load->library('upload', $config);
			$this->upload->do_upload('masterlist_file');
			$data = $this->upload->data();
			//insert into history_upload
			$data_fields = array(
				'file_name' => $data['file_name'],
				'file_type' => $data['file_type'],
				'status' 	=> 1,
				'created' 	=> date("Y-m-d H:i:s"),
				'modified'  => date("Y-m-d H:i:s")
			);
			$insert_history = $this->all->insert_template($data_fields, 'history_upload');
			//end of insert into history_upload
			$this->session->set_flashdata(
				'success_update_masterlist', 
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/individual/master');
		}
		else {
			redirect('backend/individual/master');
		}
	}
	
	public function jpm_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//get al ISIN number existed
			$array_isin = array();
			$res_isin = mysql_query("SELECT * FROM individual_portfolio WHERE bank_type = 'JPM'");
			while( $row_isin = mysql_fetch_array($res_isin, MYSQL_ASSOC) ) {
				$array_isin[] = $row_isin['isin'];
			}
			//end of et al ISIN number existed
			//get description alternative investments
			$array_desc = array();
			$res_desc = mysql_query(
				"SELECT * FROM individual_portfolio WHERE bank_type = 'JPM' AND asset_class IN('Alternative Investments')"
			);
			while( $row_desc = mysql_fetch_array($res_desc, MYSQL_ASSOC) ) {
				$array_desc[] = $row_desc['description'];
			}
			//end of get description alternative investments
			$files = $_FILES;
			$cpt   = count($_FILES['jpm_file']['name']);
			for( $v=0; $v<$cpt; $v++ )
			{
				$archivo 	  = $_FILES['jpm_file']['tmp_name'][$v];
				$data    	  = new Spreadsheet_Excel_Reader($archivo);
				$total_sheets = $data->countSheets();
				$filename 	  = pathinfo($_FILES['jpm_file']['name'][$v], PATHINFO_FILENAME);	
				$details 	  = array();
				$arr_name = explode("_", $filename);
				$get_bank_name    = $arr_name[0];
				$get_initial_name = $arr_name[1];
				$get_full_date	  = $arr_name[2];
				$date_acc  = substr($get_full_date, 0, 2);
				$month_acc = substr($get_full_date, 2, 2);
				$year_acc  = '20'.substr($get_full_date, 4, 2);
				$portfolio_date = $year_acc.'-'.$month_acc.'-'.$date_acc;
				//get account number
				$accnumbers = $this->all->select_template_w_2_conditions(
					'bank_type', $get_bank_name, 'initial_name', $get_initial_name, 'user_initial'
				);
				if( $accnumbers == TRUE ) {
					foreach( $accnumbers AS $accnumber ) {
						$get_account_name     = $accnumber->account_name;
						$get_account_number   = $accnumber->account_id;
						$get_mandate_group_id = $accnumber->mandate_group_id;
					}
					//remove existing JPM account
					$remove_old_record = $this->all->delete_template('account_id', $get_account_number, 'individual_portfolio');
					//end of remove existing JPM account
					for($i=1; $i < $total_sheets; $i++) {
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "cash" ) {	 
							$total_rows = $data->rowcount($sheet_index=$i);	
							for($a=5; $a<=$total_rows; $a++) {
								if( $data->val($a, 'B', $i) != NULL ) {
									$detailsA['bank_type'] 	  = $get_bank_name;
									$detailsA['account_id']   = $get_account_number;
									$detailsA['account_name'] = $get_account_name;
									$detailsA['asset_class']  = "Cash";
									$detailsA['description']  = $data->val($a, 'B', $i).' - '.$data->val($a, 'C', $i);
									$detailsA['currency']     = $data->val($a, 'C', $i);
									$detailsA['qty'] 	      = $data->val($a, 'D', $i);
									$detailsA['market_value'] = str_replace(',', '.', str_replace(',', '', $data->val($a, 'E', $i)));
									$detailsA['portfolio_date']	  = $portfolio_date;
									$detailsA['mandate_group_id'] = $get_mandate_group_id;
									$detailsA['created'] 	  = date("Y-m-d H:i:s");
									$detailsA['modified'] 	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsA);
								}
							}		 
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "short term (fixed income)" ) {		 
							$total_rows = $data->rowcount($sheet_index=$i);
							for($b=5; $b<=$total_rows; $b++) {
								if( $data->val($b, 'B', $i) != NULL ) {
									$detailsB['bank_type']        = $get_bank_name;
									$detailsB['account_id']       = $get_account_number;
									$detailsB['account_name']     = $get_account_name;
									$detailsB['asset_class']  	  = "Fixed Income";
									$detailsB['isin']		      = $data->val($b, 'B', $i);
									$detailsB['description']	  = $data->val($b, 'C', $i);
									$detailsB['currency'] 	      = $data->val($b, 'F', $i);
									$detailsB['qty'] 		      = $data->val($b, 'G', $i);
									$detailsB['closing_price'] 	  = $data->val($b, 'H', $i);
									$detailsB['current_cost']     = str_replace(',', '.', str_replace(',', '', $data->val($b, 'K', $i)))-str_replace(',', '.', str_replace(',', '', $data->val($b, 'M', $i)));
									$detailsB['market_value']     = str_replace(',', '.', str_replace(',', '', $data->val($b, 'K', $i)));
									$detailsB['unit_cost'] 	  	  = $data->val($b, 'J', $i);
									$detailsB['accrued_interest'] = str_replace(',', '.', str_replace(',', '', $data->val($b, 'L', $i)));
									$detailsB['unrealised_gain_loss']   = $data->val($b, 'M', $i);
									$detailsB['asset_class_percentage'] = $data->val($b, 'N', $i);
									$detailsB['portfolio_date']	= $portfolio_date;
									$detailsB['mandate_group_id'] = $get_mandate_group_id;
									$detailsB['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsB['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsB);
								}
							}
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "fixed income" ) {
							$total_rows = $data->rowcount($sheet_index=$i);				 
							for($c=5; $c<=$total_rows; $c++) {
								if( $data->val($c, 'B', $i) != NULL ) {
									$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($c, 'K', $i)));
									$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($c, 'L', $i)));
									$detailsC['bank_type']        = $get_bank_name;
									$detailsC['account_id']       = $get_account_number;
									$detailsC['account_name']     = $get_account_name;
									$detailsC['asset_class']  	  = "Fixed Income";
									$detailsC['isin']		      = $data->val($c, 'B', $i);
									$detailsC['description']	  = $data->val($c, 'C', $i);
									$detailsC['currency'] 	      = $data->val($c, 'F', $i);
									$detailsC['qty'] 		      = $data->val($c, 'G', $i);
									$detailsC['closing_price'] 	  = $data->val($c, 'H', $i);
									$detailsC['current_cost']     = str_replace(',', '.', str_replace(',', '', $data->val($c, 'K', $i)))-str_replace(',', '.', str_replace(',', '', $data->val($c, 'M', $i)));
									$detailsC['market_value']     = $mkt_val+$acc_int;
									$detailsC['unit_cost'] 	  	  = $data->val($c, 'J', $i);
									$detailsC['accrued_interest'] = $acc_int;
									$detailsC['unrealised_gain_loss']   = $data->val($c, 'M', $i);
									$detailsC['asset_class_percentage'] = $data->val($c, 'N', $i);
									$detailsC['portfolio_date']	= $portfolio_date;
									$detailsC['mandate_group_id'] = $get_mandate_group_id;
									$detailsC['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsC['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsC);
								}
							}
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "equity" ) {
							$total_rows = $data->rowcount($sheet_index=$i);			 
							for($d=5; $d<=$total_rows; $d++) {
								if( $data->val($d, 'B', $i) != NULL ) {
									$detailsD['bank_type']     = $get_bank_name;
									$detailsD['account_id']    = $get_account_number;
									$detailsD['account_name']  = $get_account_name;
									$detailsD['asset_class']   = "Equity";
									$detailsD['isin']		   = $data->val($d, 'B', $i);
									$detailsD['description']   = $data->val($d, 'C', $i);
									$detailsD['ticker']	 	   = $data->val($d, 'E', $i);
									$detailsD['currency'] 	   = $data->val($d, 'F', $i);
									$detailsD['qty'] 		   = $data->val($d, 'G', $i);
									$detailsD['closing_price'] = $data->val($d, 'H', $i);
									$detailsD['unit_cost'] 	   = $data->val($d, 'J', $i);
									$detailsD['current_cost']  = str_replace(',', '.', str_replace(',', '', $data->val($d, 'K', $i)))-str_replace(',', '.', str_replace(',', '', $data->val($d, 'L', $i)));
									$detailsD['market_value']  = str_replace(',', '.', str_replace(',', '', $data->val($d, 'K', $i)));
									$detailsD['unrealised_gain_loss']   = $data->val($d, 'L', $i);	
									$detailsD['asset_class_percentage'] = $data->val($d, 'M', $i);
									$detailsD['portfolio_date']	= $portfolio_date;
									$detailsD['mandate_group_id'] = $get_mandate_group_id;
									$detailsD['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsD['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsD);
								}
							}
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "derivative" ) {
							$total_rows = $data->rowcount($sheet_index=$i);
							for($e=5; $e<=$total_rows; $e++) {
								if( $data->val($e, 'B', $i) != NULL ) {
									$detailsE['bank_type']     	  = $get_bank_name ;
									$detailsE['account_id']    	  = $get_account_number;
									$detailsE['account_name']  	  = $get_account_name;
									$detailsE['asset_class']  	  = "Alternative Investment";
									$detailsE['category']  		  = "FX Forward";
									$detailsE['isin']		  	  = $data->val($e, 'C', $i);
									$detailsE['description']	  = $data->val($e, 'D', $i);
									$detailsE['currency']	  	  = $data->val($e, 'E', $i);
									$detailsE['qty']	 		  = $data->val($e, 'G', $i);
									$detailsE['closing_price'] 	  = $data->val($e, 'H', $i);
									$detailsE['unit_cost']	  	  = $data->val($e, 'J', $i);
									$detailsE['current_cost']     = str_replace(',', '.', str_replace(',', '', $data->val($e, 'K', $i)))-str_replace(',', '.', str_replace(',', '', $data->val($e, 'M', $i)));
									$detailsE['market_value']  	  = str_replace(',', '.', str_replace(',', '', $data->val($e, 'K', $i)));
									$detailsE['accrued_interest'] = $data->val($e, 'L', $i);
									$detailsE['unrealised_gain_loss']   = $data->val($e, 'M', $i);	
									$detailsE['asset_class_percentage'] = $data->val($e, 'N', $i);
									$detailsE['portfolio_date']	= $portfolio_date;
									$detailsE['mandate_group_id'] = $get_mandate_group_id;
									$detailsE['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsE['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsE);
								}
							}
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "miscellaneous" ) {
							$total_rows = $data->rowcount($sheet_index=$i);					 
							for($f=5; $f<=$total_rows; $f++) {
								if( $data->val($f, 'C', $i) != NULL ) {
									$detailsF['bank_type'] 	   = $get_bank_name;
									$detailsF['account_id']    = $get_account_number;
									$detailsF['account_name']  = $get_account_name;
									$detailsF['asset_class']   = "Alternative Investment";
									$detailsF['isin']		   = $data->val($f, 'A', $i);
									$detailsF['description']   = $data->val($f, 'C', $i);
									$detailsF['currency']	   = $data->val($f, 'D', $i);
									$detailsF['qty']	 	   = $data->val($f, 'E', $i);
									$detailsF['closing_price'] = $data->val($f, 'F', $i);
									$detailsF['unit_cost']	   = $data->val($f, 'H', $i);
									$detailsF['current_cost']  = str_replace(',', '.', str_replace(',', '', $data->val($f, 'I', $i)))-str_replace(',', '.', str_replace(',', '', $data->val($f, 'J', $i)));
									$detailsF['market_value']  = str_replace(',', '.', str_replace(',', '', $data->val($f, 'I', $i)));
									$detailsF['unrealised_gain_loss']   = $data->val($f, 'J', $i);
									$detailsF['asset_class_percentage'] = $data->val($f, 'K', $i);
									$detailsF['portfolio_date']	= $portfolio_date;
									$detailsF['mandate_group_id'] = $get_mandate_group_id;
									$detailsF['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsF['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsF);
								}
							}						 
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "private equity" ) {
							$total_rows = $data->rowcount($sheet_index=$i);					 
							for($g=5; $g<=$total_rows; $g++) {
								if( $data->val($g, 'B', $i) != NULL ) {
									$detailsG['bank_type'] 	 		= $get_bank_name;
									$detailsG['account_id']   		= $get_account_number;
									$detailsG['account_name'] 		= $get_account_name;
									$detailsG['asset_class']  		= "Alternative Investment";
									$detailsG['description']	  	= $data->val($g, 'B', $i);
									$detailsG['currency']	  		= $data->val($g, 'C', $i);
									$detailsG['initial_commitment']	= $data->val($g, 'D', $i);
									$detailsG['net_contribution']	= $data->val($g, 'E', $i);
									$detailsG['net_contribution_base'] = $data->val($g, 'E', $i);
									$detailsG['total_distribution'] = $data->val($g, 'F', $i);
									$detailsG['market_value']  		= str_replace(',', '.', str_replace(',', '', $data->val($g, 'G', $i)));
									$detailsG['asset_class_percentage'] = $data->val($g, 'H', $i);
									$detailsG['portfolio_date']	= $portfolio_date;
									$detailsG['mandate_group_id'] = $get_mandate_group_id;
									$detailsG['created'] 	 	        = date("Y-m-d H:i:s");
									$detailsG['modified'] 	 		    = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsG);
								}
							}						 
						}
						$details['asset_class'] = $data->boundsheets[$i]['name'];
						if( strtolower($details['asset_class']) == "forex" ) {
							$total_rows = $data->rowcount($sheet_index=$i);
							for($h=5; $h<=$total_rows; $h++) {
								if( $data->val($h, 'B', $i) != NULL ) {
									$detailsFOREX['bank_type'] 	  = $get_bank_name;
									$detailsFOREX['account_id']   = $get_account_number;
									$detailsFOREX['account_name'] = $get_account_name;
									$detailsFOREX['asset_class']  = "Alternative Investment";
									$detailsFOREX['description']  = "Buy ".$data->val($h, 'D', $i)." sell ".$data->val($h, 'F', $i)."";
									$detailsFOREX['category']     = "Forex";
									$detailsFOREX['currency']	  = "USD";
									$detailsFOREX['market_value'] = str_replace(',', '.', str_replace(',', '', $data->val($h, 'J', $i)));
									$detailsFOREX['unrealised_gain_loss'] = str_replace(',', '.', str_replace(',', '', $data->val($h, 'J', $i)));
									$detailsFOREX['buy_currency']     = $data->val($h, 'D', $i);
									$detailsFOREX['sell_currency']    = $data->val($h, 'F', $i);
									$detailsFOREX['buy_quantity']     = str_replace(',', '.', str_replace(',', '', $data->val($h, 'E', $i)));
									$detailsFOREX['sell_quantity']    = str_replace(',', '.', str_replace(',', '', $data->val($h, 'G', $i)));
									$detailsFOREX['settlement_date']  = $data->val($h, 'C', $i);
									$detailsFOREX['purchase_fx_rate'] = $data->val($h, 'H', $i);
									$detailsFOREX['current_forward_rate'] = $data->val($h, 'I', $i);
									$detailsFOREX['trade_date']     	  = $data->val($h, 'B', $i);
									$detailsFOREX['portfolio_date']		  = $portfolio_date;
									$detailsFOREX['mandate_group_id'] = $get_mandate_group_id;
									$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
									$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsFOREX);
								}
							}						 
						}
					}
					$config['upload_path']   = './assets/uploads/jpm/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['overwrite']	 = TRUE;
					$this->load->library('upload', $config);
					$this->upload->do_upload('jpm_file');
					$data = $this->upload->data();
					//insert into history_upload
					$data_fields = array(
						'file_name' => $data['file_name'],
						'file_type' => $data['file_type'],
						'status' 	=> 1,
						'created' 	=> date("Y-m-d H:i:s"),
						'modified'  => date("Y-m-d H:i:s")
					);
					$insert_history = $this->all->insert_template($data_fields, 'history_upload');
					//end of insert into history_upload
				}
			}
			$this->session->set_flashdata(
				'success_update_jpm', 
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/individual/jpm');
			
		}
		else {
			redirect('backend/individual/jpm');
		}
	}
	
	public function gs_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//get al ISIN number existed
			$array_isin = array();
			$res_isin = mysql_query("SELECT * FROM individual_portfolio WHERE bank_type = 'GS'");
			while( $row_isin = mysql_fetch_array($res_isin, MYSQL_ASSOC) ) {
				$array_isin[] = $row_isin['isin'];
			}
			//end of et al ISIN number existed
			//get description alternative investments
			$array_desc = array();
			$res_desc = mysql_query("SELECT * FROM individual_portfolio WHERE bank_type = 'GS' AND asset_class = 'Alternative Investments'");
			while( $row_desc = mysql_fetch_array($res_desc, MYSQL_ASSOC) ) {
				$array_desc[] = $row_desc['description'];
			}
			//end of get description alternative investments
			$files = $_FILES;
			$cpt   = count($_FILES['gold_sach_file']['name']);
			for( $v=0; $v<$cpt; $v++ )
			{
				$archivo  = $_FILES['gold_sach_file']['tmp_name'][$v];
				$data 	  = new Spreadsheet_Excel_Reader($archivo);
				$filename = pathinfo($_FILES['gold_sach_file']['name'][$v], PATHINFO_FILENAME);
				$arr_name = explode("_", $filename);
				$get_bank_name    = $arr_name[0];
				$get_initial_name = $arr_name[1];
				$get_full_date	  = $arr_name[2];
				$date_acc  = substr($get_full_date, 0, 2);
				$month_acc = substr($get_full_date, 2, 2);
				$year_acc  = '20'.substr($get_full_date, 4, 2);
				$portfolio_date = $year_acc.'-'.$month_acc.'-'.$date_acc;
				//get account number
				$accnumbers = $this->all->select_template_w_2_conditions(
					'bank_type', $get_bank_name, 'initial_name', $get_initial_name, 'user_initial'
				);
				if( $accnumbers == TRUE ) {
					foreach( $accnumbers AS $accnumber ) {
						$get_account_name     = $accnumber->account_name;
						$get_account_number   = $accnumber->account_id;
						$get_mandate_group_id = $accnumber->mandate_group_id;
					}
					//remove existing NIDO account
					$remove_old_record = $this->all->delete_template('account_id', $get_account_number, 'individual_portfolio');
					//end of remove existing NIDO account
					$total_rows = $data->rowcount($sheet_index=0);
					$details = array();
					for($i = 10; $i<=$total_rows; $i++) {
						//if cash asset class
						if( $data->val($i,'A') == 'Cash, Deposits & Money Market Funds' ) {
							$details['bank_type'] 				  = $get_bank_name;
							$details['account_id'] 				  = $get_account_number;
							$details['account_name'] 			  = $get_account_name;						
							$details['asset_class'] 	 		  = $data->val($i,'A');
							$details['description']	 			  = $data->val($i, 'B');
							$details['sector']	 			      = '';
							$details['ticker']		 			  = $data->val($i, 'C');
							$details['qty'] 					  = $data->val($i, 'E');
							$details['unit_cost'] 				  = $data->val($i, 'F');
							$details['closing_price'] 			  = $data->val($i, 'G');
							$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
							$details['current_cost'] 			  = $data->val($i, 'I');
							$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['asset_class_percentage'] 	  = $data->val($i, 'K');
							$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
							$details['gain_loss_percentage_base'] = $data->val($i, 'M');
							$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
							$details['currency'] 				  = $data->val($i, 'O');
							$details['isin'] 					  = $data->val($i, 'P');
							$details['location_exp'] 			  = $data->val($i, 'V');
							$details['exp_region'] 				  = $data->val($i, 'W');
							$details['portfolio_date']			  = $portfolio_date;
							$details['mandate_group_id']		  = $get_mandate_group_id;
							$details['created'] 				  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
						//main asset class
						if( $data->val($i,'A') == 'Fixed Income' || $data->val($i,'A') == 'Other Investments' || 
							$data->val($i,'A') == 'Public Equity' ) 
						{
							$mixedStr  = trim($data->val($i, 'B'));
							$searchStr = "Currency Forward";
							if( strpos($mixedStr, $searchStr) === false ) {
								$currency_modify = $data->val($i, 'O');
						    }
						    else {
						      	$currency_modify = "USD";
						    }
							$details['bank_type'] 				  = $get_bank_name;
							$details['account_id'] 				  = $get_account_number;
							$details['account_name'] 			  = $get_account_name;						
							$details['asset_class'] 	 		  = $data->val($i,'A');
							$details['description']	 			  = $data->val($i, 'B');
							$details['sector']	 			      = '';
							$details['ticker']		 			  = $data->val($i, 'C');
							$details['qty'] 					  = $data->val($i, 'E');
							$details['unit_cost'] 				  = $data->val($i, 'F');
							$details['closing_price'] 			  = $data->val($i, 'G');
							$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
							$details['current_cost'] 			  = $data->val($i, 'I');
							$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['asset_class_percentage'] 	  = $data->val($i, 'K');
							$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
							$details['gain_loss_percentage_base'] = $data->val($i, 'M');
							$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
							$details['currency'] 				  = $currency_modify;
							$details['isin'] 					  = $data->val($i, 'P');
							$details['location_exp'] 			  = $data->val($i, 'V');
							$details['exp_region'] 				  = $data->val($i, 'W');
							$details['portfolio_date']			  = $portfolio_date;
							$details['mandate_group_id']		  = $get_mandate_group_id;
							$details['created'] 				  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
						//forex category
						if( strtolower($data->val($i,'A')) == "primary investments - currency forwards" ) {
							for($y = $i+2; $y<=$total_rows; $y++) {
								if( $data->val($y,'A') != "" ) {
									if( trim($data->val($y,'A')) == "TOTAL" ) {
										break;
									}
									if( !preg_match('/vs/',trim($data->val($y,'A'))) ) {
										$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
										$detailsFOREX['account_id']   		  = $get_account_number;
										$detailsFOREX['account_name'] 		  = $get_account_name;
										$detailsFOREX['asset_class']  		  = "Alternative Investment";
										$detailsFOREX['description']	 	  = "Buy ".$data->val($y,'A')." sell ".$data->val($y,'C')."";
										$detailsFOREX['category']    		  = "Forex";
										$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($y, 'G')));
										$detailsFOREX['unrealised_gain_loss'] = $data->val($y,'H');
										$detailsFOREX['buy_currency']     	  = $data->val($y,'A');
										$detailsFOREX['sell_currency']     	  = $data->val($y,'C');
										$detailsFOREX['buy_quantity']     	  = $data->val($y,'B');
										$detailsFOREX['sell_quantity']     	  = $data->val($y,'D');
										$detailsFOREX['settlement_date']      = $data->val($y,'K');
										$detailsFOREX['purchase_fx_rate']     = $data->val($y,'F');
										$detailsFOREX['current_forward_rate'] = $data->val($y,'E');
										$detailsFOREX['trade_date']     	  = $data->val($y,'J');
										$detailsFOREX['portfolio_date']		  = $portfolio_date;
										$detailsFOREX['mandate_group_id']	  = $get_mandate_group_id;
										$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
										$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
										$this->bank->insert_client($detailsFOREX);
									}
								}
							}
						}
						//Non Marketable Investments
						if( $data->val($i,'A') == 'Non Marketable Investments' ) {
							for($xx = $i+1; $xx<=$total_rows; $xx++) {
								if( $data->val($xx,'A') != "" ) {
									if( $data->val($xx,'A') == "Priced Alternative Investments" || trim($data->val($xx,'A')) == "(v) Please be advised that since the price for this security is currently unavailable, we have substituted the price with the cost of the security to you, which may not reflect the current value of the security. Accordingly, the price is for informational purposes only and should not be relied upon." || $data->val($xx,'A') == "Non-Priced Alternative Investments" ) {
										break;
									}
									$detailsA['bank_type'] 				  	  = $get_bank_name;
									$detailsA['account_id'] 				  = $get_account_number;
									$detailsA['account_name'] 			  	  = $get_account_name;						
									$detailsA['asset_class'] 	 		  	  = 'Alternative Investments';
									$detailsA['description']	 			  = $data->val($xx, 'A');
									$detailsA['market_value']	 		  	  = str_replace(',', '.', str_replace(',', '', $data->val($xx, 'E')));
									$detailsA['market_value_base']	 	  	  = $data->val($xx, 'D');
									$detailsA['currency'] 				  	  = $data->val($xx, 'C');
									$detailsA['net_contribution'] 		  	  = $data->val($xx, 'G');
									$detailsA['net_contribution_base'] 	  	  = $data->val($xx, 'F');
									$detailsA['gain_loss'] 	  			  	  = $data->val($xx, 'H');
									$detailsA['contrib_as_of_month_end'] 	  = $data->val($xx, 'J');
									$detailsA['contrib_as_of_month_end_base'] = $data->val($xx, 'I');
									$detailsA['total_distribution'] 		  = $data->val($xx, 'M');
									$detailsA['portfolio_date']		  		  = $portfolio_date;
									$detailsA['mandate_group_id']		  	  = $get_mandate_group_id;
									$detailsA['created'] 				  	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsA);
								}
							}
						}
						//alternative investment
						if( $data->val($i,'A') == 'Priced Alternative Investments' || trim($data->val($i, 'A')) == 'Non-Priced Alternative Investments' ) {
							for($x = $i+1; $x<=$total_rows; $x++) {
								if( $data->val($x,'A') != "" ) {
									if( trim($data->val($x,'A')) == "TOTAL" || trim($data->val($x, 'A')) == "(a) The figures for this partnership may vary due to transfer or assignment." ) {
										break;
									}
									$detailsA['bank_type'] 				  	  = $get_bank_name;
									$detailsA['account_id'] 				  = $get_account_number;
									$detailsA['account_name'] 			  	  = $get_account_name;						
									$detailsA['asset_class'] 	 		  	  = 'Alternative Investments';
									$detailsA['description']	 			  = $data->val($x, 'A');
									$detailsA['market_value']	 		  	  = str_replace(',', '.', str_replace(',', '', $data->val($x, 'F')));
									$detailsA['market_value_base']	 	  	  = $data->val($x, 'E');
									$detailsA['mkt_val_percentage'] 		  = $data->val($x, 'C');
									$detailsA['currency'] 				  	  = $data->val($x, 'D');
									$detailsA['net_contribution'] 		  	  = $data->val($x, 'H');
									$detailsA['net_contribution_base'] 	  	  = $data->val($x, 'G');
									$detailsA['gain_loss'] 	  			  	  = $data->val($x, 'I');
									$detailsA['contrib_as_of_month_end'] 	  = $data->val($x, 'K');
									$detailsA['contrib_as_of_month_end_base'] = $data->val($x, 'J');
									$detailsA['contrib_as_of_month_end'] 	  = $data->val($x, 'M');
									$detailsA['contrib_as_of_month_end_base'] = $data->val($x, 'L');
									$detailsA['total_distribution'] 		  = $data->val($x, 'N');
									$detailsA['portfolio_date']		  		  = $portfolio_date;
									$detailsA['mandate_group_id']		  	  = $get_mandate_group_id;
									$detailsA['created'] 				  	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsA);
								}
							}
						}
						//divident only description have
						if( $data->val($i,'B') == 'Dividends Earned But Not Yet Paid' ) {
							$details['bank_type'] 				  = $get_bank_name;
							$details['account_id'] 				  = $get_account_number;
							$details['account_name'] 			  = $get_account_name;						
							$details['asset_class'] 	 		  = 'Cash, Deposits & Money Market Funds';
							$details['description']	 			  = $data->val($i, 'B');
							$details['sector']	 			      = '';
							$details['ticker']		 			  = $data->val($i, 'C');
							$details['qty'] 					  = $data->val($i, 'E');
							$details['unit_cost'] 				  = $data->val($i, 'F');
							$details['closing_price'] 			  = $data->val($i, 'G');
							$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
							$details['current_cost'] 			  = $data->val($i, 'I');
							$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['asset_class_percentage'] 	  = $data->val($i, 'K');
							$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
							$details['gain_loss_percentage_base'] = $data->val($i, 'M');
							$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
							$details['currency'] 				  = $data->val($i, 'O');
							$details['isin'] 					  = $data->val($i, 'P');
							$details['location_exp'] 			  = $data->val($i, 'V');
							$details['exp_region'] 				  = $data->val($i, 'W');
							$details['portfolio_date']		  	  = $portfolio_date;
							$details['mandate_group_id']		  = $get_mandate_group_id;
							$details['created'] 				  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
					}
				}
			}
			$this->session->set_flashdata(
				'success_update_gs', 
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/individual/gs');
			
			/*
			//SINGLLE GS UPLOAD FILE
			$archivo  = $_FILES['gold_sach_file']['tmp_name'];
			$data 	  = new Spreadsheet_Excel_Reader($archivo);
			$filename = pathinfo($_FILES['gold_sach_file']['name'], PATHINFO_FILENAME);
			$arr_name = explode("_", $filename);
			$get_bank_name    = $arr_name[0];
			$get_initial_name = $arr_name[1];
			$get_full_date	  = $arr_name[2];
			//get account number
			$accnumbers = $this->all->select_template_w_2_conditions(
				'bank_type', $get_bank_name, 'initial_name', $get_initial_name, 'user_initial'
			);
			if( $accnumbers == TRUE ) {
				foreach( $accnumbers AS $accnumber ) {
					$get_account_name   = $accnumber->account_name;
					$get_account_number = $accnumber->account_id;
				}
				//remove existing NIDO account
				$remove_old_record = $this->all->delete_template('account_id', $get_account_number, 'individual_portfolio');
				//end of remove existing NIDO account
				$total_rows = $data->rowcount($sheet_index=0);
				$details = array();
				for($i = 10; $i<=$total_rows; $i++) {
					//if cash asset class
					if( $data->val($i,'A') == 'Cash, Deposits & Money Market Funds' ) {
						$details['bank_type'] 				  = $get_bank_name;
						$details['account_id'] 				  = $get_account_number;
						$details['account_name'] 			  = $get_account_name;						
						$details['asset_class'] 	 		  = $data->val($i,'A');
						$details['description']	 			  = $data->val($i, 'B');
						$details['sector']	 			      = '';
						$details['ticker']		 			  = $data->val($i, 'C');
						$details['qty'] 					  = $data->val($i, 'E');
						$details['unit_cost'] 				  = $data->val($i, 'F');
						$details['closing_price'] 			  = $data->val($i, 'G');
						$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
						$details['current_cost'] 			  = $data->val($i, 'I');
						$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
						$details['asset_class_percentage'] 	  = $data->val($i, 'K');
						$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
						$details['gain_loss_percentage_base'] = $data->val($i, 'M');
						$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
						$details['currency'] 				  = $data->val($i, 'O');
						$details['isin'] 					  = $data->val($i, 'P');
						$details['location_exp'] 			  = $data->val($i, 'V');
						$details['exp_region'] 				  = $data->val($i, 'W');
						$details['created'] 				  = date("Y-m-d H:i:s");
						$this->bank->insert_client($details);
					}
					//main asset class
					if( $data->val($i,'A') == 'Fixed Income' || $data->val($i,'A') == 'Other Investments' || 
						$data->val($i,'A') == 'Public Equity' ) 
					{
						$mixedStr  = trim($data->val($i, 'B'));
						$searchStr = "Currency Forward";
						if( strpos($mixedStr, $searchStr) === false ) {
							$currency_modify = $data->val($i, 'O');
					    }
					    else {
					      	$currency_modify = "USD";
					    }
						$details['bank_type'] 				  = $get_bank_name;
						$details['account_id'] 				  = $get_account_number;
						$details['account_name'] 			  = $get_account_name;						
						$details['asset_class'] 	 		  = $data->val($i,'A');
						$details['description']	 			  = $data->val($i, 'B');
						$details['sector']	 			      = '';
						$details['ticker']		 			  = $data->val($i, 'C');
						$details['qty'] 					  = $data->val($i, 'E');
						$details['unit_cost'] 				  = $data->val($i, 'F');
						$details['closing_price'] 			  = $data->val($i, 'G');
						$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
						$details['current_cost'] 			  = $data->val($i, 'I');
						$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
						$details['asset_class_percentage'] 	  = $data->val($i, 'K');
						$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
						$details['gain_loss_percentage_base'] = $data->val($i, 'M');
						$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
						$details['currency'] 				  = $currency_modify;
						$details['isin'] 					  = $data->val($i, 'P');
						$details['location_exp'] 			  = $data->val($i, 'V');
						$details['exp_region'] 				  = $data->val($i, 'W');
						$details['created'] 				  = date("Y-m-d H:i:s");
						$this->bank->insert_client($details);
					}
					//forex category
					if( strtolower($data->val($i,'A')) == "primary investments - currency forwards" ) {
						for($y = $i+2; $y<=$total_rows; $y++) {
							if( $data->val($y,'A') != "" ) {
								if( trim($data->val($y,'A')) == "TOTAL" ) {
									break;
								}
								if( !preg_match('/vs/',trim($data->val($y,'A'))) ) {
									$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
									$detailsFOREX['account_id']   		  = $get_account_number;
									$detailsFOREX['account_name'] 		  = $get_account_name;
									$detailsFOREX['asset_class']  		  = "Alternative Investment";
									$detailsFOREX['description']	 	  = "Buy ".$data->val($y,'A')." sell ".$data->val($y,'C')."";
									$detailsFOREX['category']    		  = "Forex";
									$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($y, 'G')));
									$detailsFOREX['unrealised_gain_loss'] = $data->val($y,'H');
									$detailsFOREX['buy_currency']     	  = $data->val($y,'A');
									$detailsFOREX['sell_currency']     	  = $data->val($y,'C');
									$detailsFOREX['buy_quantity']     	  = $data->val($y,'B');
									$detailsFOREX['sell_quantity']     	  = $data->val($y,'D');
									$detailsFOREX['settlement_date']      = $data->val($y,'K');
									$detailsFOREX['purchase_fx_rate']     = $data->val($y,'F');
									$detailsFOREX['current_forward_rate'] = $data->val($y,'E');
									$detailsFOREX['trade_date']     	  = $data->val($y,'J');
									$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
									$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsFOREX);
								}
							}
						}
					}
					//alternative investment
					if( $data->val($i,'A') == 'Priced Alternative Investments' ) {
						for($x = $i+1; $x<=$total_rows; $x++) {
							if( $data->val($x,'A') != "" ) {
								if( $data->val($x,'A') == "TOTAL" ) {
									break;
								}
								$detailsA['bank_type'] 				  	  = $get_bank_name;
								$detailsA['account_id'] 				  = $get_account_number;
								$detailsA['account_name'] 			  	  = $get_account_name;						
								$detailsA['asset_class'] 	 		  	  = 'Alternative Investments';
								$detailsA['description']	 			  = $data->val($x, 'A');
								$detailsA['market_value']	 		  	  = str_replace(',', '.', str_replace(',', '', $data->val($x, 'F')));
								$detailsA['market_value_base']	 	  	  = $data->val($x, 'E');
								$detailsA['mkt_val_percentage'] 		  = $data->val($x, 'C');
								$detailsA['currency'] 				  	  = $data->val($x, 'D');
								$detailsA['net_contribution'] 		  	  = $data->val($x, 'H');
								$detailsA['net_contribution_base'] 	  	  = $data->val($x, 'G');
								$detailsA['gain_loss'] 	  			  	  = $data->val($x, 'I');
								$detailsA['contrib_as_of_month_end'] 	  = $data->val($x, 'K');
								$detailsA['contrib_as_of_month_end_base'] = $data->val($x, 'J');
								$detailsA['contrib_as_of_month_end'] 	  = $data->val($x, 'M');
								$detailsA['contrib_as_of_month_end_base'] = $data->val($x, 'L');
								$detailsA['total_distribution'] 		  = $data->val($x, 'N');
								$detailsA['created'] 				  	  = date("Y-m-d H:i:s");
								$this->bank->insert_client($detailsA);
							}
						}
					}
					//divident only description have
					if( $data->val($i,'B') == 'Dividends Earned But Not Yet Paid' ) {
						$details['bank_type'] 				  = $get_bank_name;
						$details['account_id'] 				  = $get_account_number;
						$details['account_name'] 			  = $get_account_name;						
						$details['asset_class'] 	 		  = 'Cash, Deposits & Money Market Funds';
						$details['description']	 			  = $data->val($i, 'B');
						$details['sector']	 			      = '';
						$details['ticker']		 			  = $data->val($i, 'C');
						$details['qty'] 					  = $data->val($i, 'E');
						$details['unit_cost'] 				  = $data->val($i, 'F');
						$details['closing_price'] 			  = $data->val($i, 'G');
						$details['gain_loss_percentage'] 	  = $data->val($i, 'H');
						$details['current_cost'] 			  = $data->val($i, 'I');
						$details['market_value']	 		  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
						$details['asset_class_percentage'] 	  = $data->val($i, 'K');
						$details['unrealised_gain_loss'] 	  = $data->val($i, 'L');
						$details['gain_loss_percentage_base'] = $data->val($i, 'M');
						$details['mkt_val_percentage'] 		  = $data->val($i, 'N');
						$details['currency'] 				  = $data->val($i, 'O');
						$details['isin'] 					  = $data->val($i, 'P');
						$details['location_exp'] 			  = $data->val($i, 'V');
						$details['exp_region'] 				  = $data->val($i, 'W');
						$details['created'] 				  = date("Y-m-d H:i:s");
						$this->bank->insert_client($details);
					}
				}
				$config['upload_path']   = './assets/uploads/gs/';
				$config['allowed_types'] = 'xls|xlsx';
				$config['overwrite']	 = TRUE;
				$this->load->library('upload', $config);
				$this->upload->do_upload('gold_sach_file');
				$data = $this->upload->data();
				//insert into history_upload
				$data_fields = array(
					'file_name' => $data['file_name'],
					'file_type' => $data['file_type'],
					'status' 	=> 1,
					'created' 	=> date("Y-m-d H:i:s"),
					'modified'  => date("Y-m-d H:i:s")
				);
				$insert_history = $this->all->insert_template($data_fields, 'history_upload');
				//end of insert into history_upload
				$this->session->set_flashdata(
					'success_update_gs', 
					'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
				);
				redirect('backend/individual/gs');
			}
			else {
				$this->session->set_flashdata(
					'error_initial_found', 
					'<div style="color:red; font-weight:bold; margin-top:10px">
						Unknown account name. Initial name has not registered. Please upload withe the correct initial name.
					</div>'
				);
				redirect('backend/individual/gs');
			}
			*/
			
			
			
		}
		else {
			redirect("backend/individual/gs");
		}
	}
	
	public function cs_process()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//get al ISIN number existed
			$array_isin = array();
			$res_isin = mysql_query("SELECT * FROM individual_portfolio WHERE bank_type = 'CS'");
			while( $row_isin = mysql_fetch_array($res_isin, MYSQL_ASSOC) ) {
				$array_isin[] = $row_isin['isin'];
			}
			//end of et al ISIN number existed
			$files = $_FILES;
			$cpt   = count($_FILES['credit_suisse_file']['name']);
			for( $v=0; $v<$cpt; $v++ )
			{
				$archivo  = $_FILES['credit_suisse_file']['tmp_name'][$v];
				$data 	  = new Spreadsheet_Excel_Reader($archivo);
				$filename = pathinfo($_FILES['credit_suisse_file']['name'][$v], PATHINFO_FILENAME);
				$arr_name = explode("_", $filename);
				$get_bank_name    = $arr_name[0];
				$get_initial_name = $arr_name[1];
				$get_full_date	  = $arr_name[2];
				$date_acc  = substr($get_full_date, 0, 2);
				$month_acc = substr($get_full_date, 2, 2);
				$year_acc  = '20'.substr($get_full_date, 4, 2);
				$portfolio_date = $year_acc.'-'.$month_acc.'-'.$date_acc;
				//get account number
				$accnumbers = $this->all->select_template_w_2_conditions(
					'bank_type', $get_bank_name, 'initial_name', $get_initial_name, 'user_initial'
				);
				if( $accnumbers == TRUE ) {
					foreach( $accnumbers AS $accnumber ) {
						$get_account_name     = $accnumber->account_name;
						$get_account_number   = $accnumber->account_id;
						$get_mandate_group_id = $accnumber->mandate_group_id;
					}
					//remove existing account
					$remove_old_record = $this->all->delete_template('account_id', $get_account_number, 'individual_portfolio');
					//end of remove existing account
					$total_rows = $data->rowcount($sheet_index=0);
					$details = array();
					for($i = 2; $i<=$total_rows; $i++) {
						if( trim($data->val($i, 'Q')) == $get_account_number ) {
							$hz = str_replace(",","",$data->val($i, 'H'));
							$iz = str_replace(",","",$data->val($i, 'I'));
							//rename asset class name
							if( strtolower($data->val($i, 'A')) == "shares and similar investments" ) {
								$asset_class_name = "Public Equity";
								$category_product = NULL;
							}
							else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
								$asset_class_name = "Other Investments";
								$category_product = "Forex";
							}
							else if( strtolower($data->val($i, 'A')) == "fixed income investments" ) {
								$asset_class_name = "Fixed income";
								$category_product = NULL;
							}
							else if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
								$asset_class_name = "Cash, Deposits & Money Market Funds";
								$category_product = NULL;
							}
							else if( strtolower($data->val($i, 'A')) == "alternative investments" ) {
								$asset_class_name = "Alternative investments";
								$category_product = NULL;
							}
							//end of rename asset class name
							if( strtolower($data->val($i, 'A')) == "alternative investments" || 
								strtolower($data->val($i, 'A')) == "other investments" || 
								strtolower($data->val($i, 'A')) == "shares and similar investments" ) {
								if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
									$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
									$details['bank_type']     		 	  = $get_bank_name;
									$details['account_id']    		 	  = $get_account_number;
									$details['account_name']  		 	  = $get_account_name;
									$details['asset_class']   		 	  = $asset_class_name;
									$details['description']	  		 	  = $data->val($i, 'B');
									$details['category']	  		 	  = $category_product;
									$details['isin']		  		 	  = $data->val($i, 'C');
									$details['currency']      		 	  = $data->val($i, 'D');
									$details['qty'] 		  		 	  = $data->val($i, 'E');
									$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
									$details['closing_price'] 	     	  = $data->val($i, 'G');
									$details['market_value'] 		 	  = $mkt_val+$acc_int;
									$details['accrued_interest'] 	      = $acc_int;
									$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
									$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
									$details['initial_commitment'] 		  = $details['current_cost'];
									$details['net_contribution']   		  = $details['current_cost'];
									$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
									$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
									$details['portfolio_date']			  = $portfolio_date;
									$details['mandate_group_id']		  = $get_mandate_group_id;
									$details['created'] 	  	     	  = date("Y-m-d H:i:s");
									$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($details);
								}
								else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
									//for settlement date
									$var_settlement_date 	 = $data->val($i, 'B');
									$explode_settlement_date = explode("Value Date", $var_settlement_date);
									//end for settlement date
									//for sell quantity
									$columnE    = str_replace(',', '.', str_replace(',', '', $data->val($i, 'E')));
									$varColumnF = trim($data->val($i, 'F'));
									$explodeF   = explode(" ", $varColumnF);
									$columnF    = $explodeF[1];
									//end of for sell quantity
									//for current forward rate
									$varColumnG 		  = trim($data->val($i, 'G'));
									$explodeG   		  = explode(" ", $varColumnG);
									$current_forward_rate = $explodeG[1];
									//end of for current forward rate
									//for sell and buy currency
									$var_buy_currency 	  = $data->val($i, 'M');
									$explode_buy_currency = explode("/", $var_buy_currency);
									if( trim($explode_buy_currency[0]) == "EUR" ) {
										$buy_currency  = $explode_buy_currency[1];
										$sell_currency = $explode_buy_currency[0];
										$sell_quantity = $columnE/$columnF;
									}
									else {
										$buy_currency  = $explode_buy_currency[0];
										$sell_currency = $explode_buy_currency[1];
										$sell_quantity = $columnE*$columnF;
									}
									//end of for sell and buy currency
									$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
									$detailsFOREX['account_id']   		  = $get_account_number;
									$detailsFOREX['account_name'] 		  = $get_account_name;
									$detailsFOREX['asset_class']  		  = "Other Investments";
									//$detailsFOREX['description']	 	  = $data->val($i, 'B');
									//"Buy ".$data->val($y,'A')." sell ".$data->val($y,'C')."";
									$detailsFOREX['description']	 	  = "Buy ".trim($buy_currency)." sell ".trim($sell_currency)."";
									$detailsFOREX['category']    		  = "Forex";
									$detailsFOREX['currency']      		  = "USD";
									$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$detailsFOREX['unrealised_gain_loss'] = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$detailsFOREX['buy_currency']     	  = trim($buy_currency);
									$detailsFOREX['sell_currency']     	  = trim($sell_currency);
									$detailsFOREX['buy_quantity']     	  = $data->val($i, 'E');
									$detailsFOREX['sell_quantity']     	  = $sell_quantity;
									$detailsFOREX['settlement_date']      = trim($explode_settlement_date[1]);
									$detailsFOREX['purchase_fx_rate']     = $columnF;
									$detailsFOREX['current_forward_rate'] = $current_forward_rate;
									$detailsFOREX['trade_date']     	  = "";
									$detailsFOREX['portfolio_date']		  = $portfolio_date;
									$detailsFOREX['mandate_group_id']	  = $get_mandate_group_id;
									$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
									$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsFOREX);
								}
								else {
									//ISIN Hardcoded: LU0329592538
									//FI: 41%
									//PE: 59%
									$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
									$details['bank_type']     		 	  = $get_bank_name;
									$details['account_id']    		 	  = $get_account_number;
									$details['account_name']  		 	  = $get_account_name;
									$details['asset_class']   		 	  = $asset_class_name;
									$details['description']	  		 	  = $data->val($i, 'B');
									$details['category']	  		 	  = $category_product;
									$details['isin']		  		 	  = $data->val($i, 'C');
									$details['currency']      		 	  = $data->val($i, 'D');
									$details['qty'] 		  		 	  = $data->val($i, 'E');
									$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
									$details['closing_price'] 	     	  = $data->val($i, 'G');
									$details['market_value'] 		 	  = $mkt_val+$acc_int;
									$details['accrued_interest'] 	      = $acc_int;
									$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
									$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
									$details['initial_commitment'] 		  = $details['current_cost'];
									$details['net_contribution']   		  = $details['current_cost'];
									$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
									$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
									$details['portfolio_date']		  	  = $portfolio_date;
									$details['mandate_group_id']	  	  = $get_mandate_group_id;
									$details['created'] 	  	     	  = date("Y-m-d H:i:s");
									$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($details);
								}
							}
							else {
								if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
									$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
									$details['bank_type']     		 	  = $get_bank_name;
									$details['account_id']    		 	  = $get_account_number;
									$details['account_name']  		 	  = $get_account_name;
									$details['asset_class']   		 	  = $asset_class_name;
									$details['description']	  		 	  = $data->val($i, 'B');
									$details['category']	  		 	  = $category_product;
									$details['isin']		  		 	  = $data->val($i, 'C');
									$details['currency']      		 	  = $data->val($i, 'D');
									$details['qty'] 		  		 	  = $data->val($i, 'E');
									$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
									$details['closing_price'] 	     	  = $data->val($i, 'G');
									$details['market_value'] 		 	  = $mkt_val+$acc_int;
									$details['accrued_interest'] 	      = $acc_int;
									$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
									$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
									$details['initial_commitment'] 		  = $details['current_cost'];
									$details['net_contribution']   		  = $details['current_cost'];
									$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
									$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
									$details['portfolio_date']		  	  = $portfolio_date;
									$details['mandate_group_id']	  	  = $get_mandate_group_id;
									$details['created'] 	  	     	  = date("Y-m-d H:i:s");
									$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($details);
								}
								else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
									//for settlement date
									$var_settlement_date 	 = $data->val($i, 'B');
									$explode_settlement_date = explode("Value Date", $var_settlement_date);
									//end for settlement date
									//for sell quantity
									$columnE    = str_replace(',', '.', str_replace(',', '', $data->val($i, 'E')));
									$varColumnF = trim($data->val($i, 'F'));
									$explodeF   = explode(" ", $varColumnF);
									$columnF    = $explodeF[1];
									//end of for sell quantity
									//for current forward rate
									$varColumnG 		  = trim($data->val($i, 'G'));
									$explodeG   		  = explode(" ", $varColumnG);
									$current_forward_rate = $explodeG[1];
									//end of for current forward rate
									//for sell and buy currency
									$var_buy_currency 	  = $data->val($i, 'M');
									$explode_buy_currency = explode("/", $var_buy_currency);
									if( trim($explode_buy_currency[0]) == "EUR" ) {
										$buy_currency  = $explode_buy_currency[1];
										$sell_currency = $explode_buy_currency[0];
										$sell_quantity = $columnE/$columnF;
									}
									else {
										$buy_currency  = $explode_buy_currency[0];
										$sell_currency = $explode_buy_currency[1];
										$sell_quantity = $columnE*$columnF;
									}
									//end of for sell and buy currency
									$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
									$detailsFOREX['account_id']   		  = $get_account_number;
									$detailsFOREX['account_name'] 		  = $get_account_name;
									$detailsFOREX['asset_class']  		  = "Other Investments";
									//$detailsFOREX['description']	 	  = $data->val($i, 'B');
									$detailsFOREX['description']	 	  = "Buy ".trim($buy_currency)." sell ".trim($sell_currency)."";
									$detailsFOREX['category']    		  = "Forex";
									$detailsFOREX['currency']      		  = "USD";
									$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$detailsFOREX['unrealised_gain_loss'] = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$detailsFOREX['buy_currency']     	  = trim($buy_currency);
									$detailsFOREX['sell_currency']     	  = trim($sell_currency);
									$detailsFOREX['buy_quantity']     	  = $data->val($i, 'E');
									$detailsFOREX['sell_quantity']     	  = $sell_quantity;
									$detailsFOREX['settlement_date']      = trim($explode_settlement_date[1]);
									$detailsFOREX['purchase_fx_rate']     = $columnF;
									$detailsFOREX['current_forward_rate'] = $current_forward_rate;
									$detailsFOREX['trade_date']     	  = "";
									$detailsFOREX['portfolio_date']		  = $portfolio_date;
									$detailsFOREX['mandate_group_id']	  = $get_mandate_group_id;
									$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
									$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
									$this->bank->insert_client($detailsFOREX);
								}
								else {
									$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
									$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
									$details['bank_type']     		 	  = $get_bank_name;
									$details['account_id']    		 	  = $get_account_number;
									$details['account_name']  		 	  = $get_account_name;
									$details['asset_class']   		 	  = $asset_class_name;
									$details['description']	  		 	  = $data->val($i, 'B');
									$details['category']	  		 	  = $category_product;
									$details['isin']		  		 	  = $data->val($i, 'C');
									$details['currency']      		 	  = $data->val($i, 'D');
									$details['qty'] 		  		 	  = $data->val($i, 'E');
									$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
									$details['closing_price'] 	     	  = $data->val($i, 'G');
									$details['market_value'] 		 	  = $mkt_val+$acc_int;
									$details['accrued_interest'] 	      = $acc_int;
									$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
									$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
									$details['initial_commitment'] 		  = $details['current_cost'];
									$details['net_contribution']   		  = $details['current_cost'];
									$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
									$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
									$details['portfolio_date']		  	  = $portfolio_date;
									$details['mandate_group_id']	  	  = $get_mandate_group_id;
									$details['created'] 	  	     	  = date("Y-m-d H:i:s");
									$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
									$this->bank->insert_client($details);
								}
							}
						}
					}	
				}
			}
			$this->session->set_flashdata(
				'success_update_cs', 
				'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
			);
			redirect('backend/individual/cs');
			
			/*
			//SINGLLE CS UPLOAD FILE
			$archivo  = $_FILES['credit_suisse_file']['tmp_name'];
			$data 	  = new Spreadsheet_Excel_Reader($archivo);
			$filename = pathinfo($_FILES['credit_suisse_file']['name'], PATHINFO_FILENAME);
			$arr_name = explode("_", $filename);
			$get_bank_name    = $arr_name[0];
			$get_initial_name = $arr_name[1];
			$get_full_date	  = $arr_name[2];
			//get account number
			$accnumbers = $this->all->select_template_w_2_conditions(
				'bank_type', $get_bank_name, 'initial_name', $get_initial_name, 'user_initial'
			);
			if( $accnumbers == TRUE ) {
				foreach( $accnumbers AS $accnumber ) {
					$get_account_name   = $accnumber->account_name;
					$get_account_number = $accnumber->account_id;
				}
				//remove existing account
				$remove_old_record = $this->all->delete_template('account_id', $get_account_number, 'individual_portfolio');
				//end of remove existing account
				$total_rows = $data->rowcount($sheet_index=0);
				$details = array();
				for($i = 2; $i<=$total_rows; $i++) {
					$hz = str_replace(",","",$data->val($i, 'H'));
					$iz = str_replace(",","",$data->val($i, 'I'));
					//rename asset class name
					if( strtolower($data->val($i, 'A')) == "shares and similar investments" ) {
						$asset_class_name = "Public Equity";
						$category_product = NULL;
					}
					else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
						$asset_class_name = "Other Investments";
						$category_product = "Forex";
					}
					else if( strtolower($data->val($i, 'A')) == "fixed income investments" ) {
						$asset_class_name = "Fixed income";
						$category_product = NULL;
					}
					else if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
						$asset_class_name = "Cash, Deposits & Money Market Funds";
						$category_product = NULL;
					}
					else if( strtolower($data->val($i, 'A')) == "alternative investments" ) {
						$asset_class_name = "Alternative investments";
						$category_product = NULL;
					}
					//end of rename asset class name
					if( strtolower($data->val($i, 'A')) == "alternative investments" || 
						strtolower($data->val($i, 'A')) == "other investments" || 
						strtolower($data->val($i, 'A')) == "shares and similar investments" ) {
						if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
							$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
							$details['bank_type']     		 	  = $get_bank_name;
							$details['account_id']    		 	  = $get_account_number;
							$details['account_name']  		 	  = $get_account_name;
							$details['asset_class']   		 	  = $asset_class_name;
							$details['description']	  		 	  = $data->val($i, 'B');
							$details['category']	  		 	  = $category_product;
							$details['isin']		  		 	  = $data->val($i, 'C');
							$details['currency']      		 	  = $data->val($i, 'D');
							$details['qty'] 		  		 	  = $data->val($i, 'E');
							$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
							$details['closing_price'] 	     	  = $data->val($i, 'G');
							$details['market_value'] 		 	  = $mkt_val+$acc_int;
							$details['accrued_interest'] 	      = $acc_int;
							$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
							$details['initial_commitment'] 		  = $details['current_cost'];
							$details['net_contribution']   		  = $details['current_cost'];
							$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
							$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
							$details['created'] 	  	     	  = date("Y-m-d H:i:s");
							$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
						else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
							//for settlement date
							$var_settlement_date 	 = $data->val($i, 'B');
							$explode_settlement_date = explode("Value Date", $var_settlement_date);
							//end for settlement date
							//for sell quantity
							$columnE    = str_replace(',', '.', str_replace(',', '', $data->val($i, 'E')));
							$varColumnF = trim($data->val($i, 'F'));
							$explodeF   = explode(" ", $varColumnF);
							$columnF    = $explodeF[1];
							//end of for sell quantity
							//for current forward rate
							$varColumnG 		  = trim($data->val($i, 'G'));
							$explodeG   		  = explode(" ", $varColumnG);
							$current_forward_rate = $explodeG[1];
							//end of for current forward rate
							//for sell and buy currency
							$var_buy_currency 	  = $data->val($i, 'M');
							$explode_buy_currency = explode("/", $var_buy_currency);
							if( trim($explode_buy_currency[0]) == "EUR" ) {
								$buy_currency  = $explode_buy_currency[1];
								$sell_currency = $explode_buy_currency[0];
								$sell_quantity = $columnE/$columnF;
							}
							else {
								$buy_currency  = $explode_buy_currency[0];
								$sell_currency = $explode_buy_currency[1];
								$sell_quantity = $columnE*$columnF;
							}
							//end of for sell and buy currency
							$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
							$detailsFOREX['account_id']   		  = $get_account_number;
							$detailsFOREX['account_name'] 		  = $get_account_name;
							$detailsFOREX['asset_class']  		  = "Other Investments";
							//$detailsFOREX['description']	 	  = $data->val($i, 'B');
							//"Buy ".$data->val($y,'A')." sell ".$data->val($y,'C')."";
							$detailsFOREX['description']	 	  = "Buy ".trim($buy_currency)." sell ".trim($sell_currency)."";
							$detailsFOREX['category']    		  = "Forex";
							$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$detailsFOREX['unrealised_gain_loss'] = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$detailsFOREX['buy_currency']     	  = trim($buy_currency);
							$detailsFOREX['sell_currency']     	  = trim($sell_currency);
							$detailsFOREX['buy_quantity']     	  = $data->val($i, 'E');
							$detailsFOREX['sell_quantity']     	  = $sell_quantity;
							$detailsFOREX['settlement_date']      = trim($explode_settlement_date[1]);
							$detailsFOREX['purchase_fx_rate']     = $columnF;
							$detailsFOREX['current_forward_rate'] = $current_forward_rate;
							$detailsFOREX['trade_date']     	  = "";
							$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
							$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
							$this->bank->insert_client($detailsFOREX);
						}
						else {
							//ISIN Hardcoded: LU0329592538
							//FI: 41%
							//PE: 59%
							$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
							$details['bank_type']     		 	  = $get_bank_name;
							$details['account_id']    		 	  = $get_account_number;
							$details['account_name']  		 	  = $get_account_name;
							$details['asset_class']   		 	  = $asset_class_name;
							$details['description']	  		 	  = $data->val($i, 'B');
							$details['category']	  		 	  = $category_product;
							$details['isin']		  		 	  = $data->val($i, 'C');
							$details['currency']      		 	  = $data->val($i, 'D');
							$details['qty'] 		  		 	  = $data->val($i, 'E');
							$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
							$details['closing_price'] 	     	  = $data->val($i, 'G');
							$details['market_value'] 		 	  = $mkt_val+$acc_int;
							$details['accrued_interest'] 	      = $acc_int;
							$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
							$details['initial_commitment'] 		  = $details['current_cost'];
							$details['net_contribution']   		  = $details['current_cost'];
							$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
							$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
							$details['created'] 	  	     	  = date("Y-m-d H:i:s");
							$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
					}
					else {
						if( strtolower($data->val($i, 'A')) == "cash and cash investments" ) {
							$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
							$details['bank_type']     		 	  = $get_bank_name;
							$details['account_id']    		 	  = $get_account_number;
							$details['account_name']  		 	  = $get_account_name;
							$details['asset_class']   		 	  = $asset_class_name;
							$details['description']	  		 	  = $data->val($i, 'B');
							$details['category']	  		 	  = $category_product;
							$details['isin']		  		 	  = $data->val($i, 'C');
							$details['currency']      		 	  = $data->val($i, 'D');
							$details['qty'] 		  		 	  = $data->val($i, 'E');
							$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
							$details['closing_price'] 	     	  = $data->val($i, 'G');
							$details['market_value'] 		 	  = $mkt_val+$acc_int;
							$details['accrued_interest'] 	      = $acc_int;
							$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
							$details['initial_commitment'] 		  = $details['current_cost'];
							$details['net_contribution']   		  = $details['current_cost'];
							$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
							$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
							$details['created'] 	  	     	  = date("Y-m-d H:i:s");
							$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
						else if( strtolower($data->val($i, 'A')) == "foreign exchange and precious metal transactions" ) {
							//for settlement date
							$var_settlement_date 	 = $data->val($i, 'B');
							$explode_settlement_date = explode("Value Date", $var_settlement_date);
							//end for settlement date
							//for sell quantity
							$columnE    = str_replace(',', '.', str_replace(',', '', $data->val($i, 'E')));
							$varColumnF = trim($data->val($i, 'F'));
							$explodeF   = explode(" ", $varColumnF);
							$columnF    = $explodeF[1];
							//end of for sell quantity
							//for current forward rate
							$varColumnG 		  = trim($data->val($i, 'G'));
							$explodeG   		  = explode(" ", $varColumnG);
							$current_forward_rate = $explodeG[1];
							//end of for current forward rate
							//for sell and buy currency
							$var_buy_currency 	  = $data->val($i, 'M');
							$explode_buy_currency = explode("/", $var_buy_currency);
							if( trim($explode_buy_currency[0]) == "EUR" ) {
								$buy_currency  = $explode_buy_currency[1];
								$sell_currency = $explode_buy_currency[0];
								$sell_quantity = $columnE/$columnF;
							}
							else {
								$buy_currency  = $explode_buy_currency[0];
								$sell_currency = $explode_buy_currency[1];
								$sell_quantity = $columnE*$columnF;
							}
							//end of for sell and buy currency
							$detailsFOREX['bank_type'] 	  		  = $get_bank_name;
							$detailsFOREX['account_id']   		  = $get_account_number;
							$detailsFOREX['account_name'] 		  = $get_account_name;
							$detailsFOREX['asset_class']  		  = "Other Investments";
							//$detailsFOREX['description']	 	  = $data->val($i, 'B');
							$detailsFOREX['description']	 	  = "Buy ".trim($buy_currency)." sell ".trim($sell_currency)."";
							$detailsFOREX['category']    		  = "Forex";
							$detailsFOREX['market_value']         = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$detailsFOREX['unrealised_gain_loss'] = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$detailsFOREX['buy_currency']     	  = trim($buy_currency);
							$detailsFOREX['sell_currency']     	  = trim($sell_currency);
							$detailsFOREX['buy_quantity']     	  = $data->val($i, 'E');
							$detailsFOREX['sell_quantity']     	  = $sell_quantity;
							$detailsFOREX['settlement_date']      = trim($explode_settlement_date[1]);
							$detailsFOREX['purchase_fx_rate']     = $columnF;
							$detailsFOREX['current_forward_rate'] = $current_forward_rate;
							$detailsFOREX['trade_date']     	  = "";
							$detailsFOREX['created']     		  = date("Y-m-d H:i:s");
							$detailsFOREX['modified']     		  = date("Y-m-d H:i:s");
							$this->bank->insert_client($detailsFOREX);
						}
						else {
							$mkt_val = str_replace(',', '.', str_replace(',', '', $data->val($i, 'H')));
							$acc_int = str_replace(',', '.', str_replace(',', '', $data->val($i, 'I')));
							$details['bank_type']     		 	  = $get_bank_name;
							$details['account_id']    		 	  = $get_account_number;
							$details['account_name']  		 	  = $get_account_name;
							$details['asset_class']   		 	  = $asset_class_name;
							$details['description']	  		 	  = $data->val($i, 'B');
							$details['category']	  		 	  = $category_product;
							$details['isin']		  		 	  = $data->val($i, 'C');
							$details['currency']      		 	  = $data->val($i, 'D');
							$details['qty'] 		  		 	  = $data->val($i, 'E');
							$details['unit_cost'] 	  		 	  = str_replace("%","",$data->val($i, 'F'));
							$details['closing_price'] 	     	  = $data->val($i, 'G');
							$details['market_value'] 		 	  = $mkt_val+$acc_int;
							$details['accrued_interest'] 	      = $acc_int;
							$details['unrealised_gain_loss'] 	  = str_replace(',', '.', str_replace(',', '', $data->val($i, 'J')));
							$details['current_cost'] 	   		  = $details['market_value']-$details['unrealised_gain_loss'];
							$details['initial_commitment'] 		  = $details['current_cost'];
							$details['net_contribution']   		  = $details['current_cost'];
							$details['gain_loss'] 		   		  = $details['market_value']-$details['current_cost'];
							$details['gain_loss_percentage_base'] = $details['gain_loss']/$details['current_cost']*100;
							$details['created'] 	  	     	  = date("Y-m-d H:i:s");
							$details['modified'] 	  	     	  = date("Y-m-d H:i:s");
							$this->bank->insert_client($details);
						}
					}
				}
				$config['upload_path']   = './assets/uploads/cs/';
				$config['allowed_types'] = 'xls|xlsx';
				$config['overwrite']	 = TRUE;
				$this->load->library('upload', $config);
				$this->upload->do_upload('credit_suisse_file');
				$data = $this->upload->data();
				//insert into history_upload
				$data_fields = array(
					'file_name' => $data['file_name'],
					'file_type' => $data['file_type'],
					'status' 	=> 1,
					'created' 	=> date("Y-m-d H:i:s"),
					'modified'  => date("Y-m-d H:i:s")
				);
				$insert_history = $this->all->insert_template($data_fields, 'history_upload');
				//end of insert into history_upload
				$this->session->set_flashdata(
					'success_update_cs', 
					'<div style="color:green; font-weight:bold; margin-top:10px">File has been uploaded successfully.</div>'
				);
				redirect('backend/individual/cs');
			}
			else {
				$this->session->set_flashdata(
					'error_initial_found', 
					'<div style="color:red; font-weight:bold; margin-top:10px">
						Unknown account name. Initial name has not registered. Please upload withe the correct initial name.
					</div>'
				);
				redirect('backend/individual/cs');
			}
			*/
			
			
			
		}
		else {
			redirect("backend/individual/cs");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */