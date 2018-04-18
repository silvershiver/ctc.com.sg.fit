<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors','On');

class TestABCDE extends CI_Controller {

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

	public function sabreTerm1()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		testFd();
	}
	public function sabreTerm2()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		saberCommand2();
	}
	public function sabreTerm3()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		saberCommand3();
	}
	public function checkPD ()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');

		readPassengerData();
	}

	public function updatePD ()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');

		updatePassengerData();
	}

	public function readTrip ()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');

		readTripData();
	}

	public function testItinerary ($pnr = "")
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		if($pnr == "" && strlen($pnr) != 6) {
			echo 'please insert PNR in url';
		}
		else {
			readItinerary($pnr);
		}
	}

	public function test_voucher($bookref= '')
	{
		$this->load->view('voucher/test_final');
	}
	
	public function test_voucherABC($bookref= '')
	{
		$data['bookrefd'] = $bookref;
		$this->load->view('voucher/test_final', $data);
	}

	public function test_email_message()
	{
		$this->load->view('voucher/test_email_message');
	}

	public function testref()
	{
		$this->All->getStatusBooking('5a002137b2cb6');
	}
	public function testaddHotel($c = "")
	{
		if($c ==  "") $c = "5a13b3d6d3a82";
		$this->All->insert_addNewBooking($c);
	}
	public function testemail2()
	{
		$bookOrderID = $this->uri->segment(3);
		$checks = $this->All->select_template("id", 288, "payment_reference");

		if( $checks == TRUE ) {
			foreach( $checks AS $check ) {
				$tmStatus = $check->TM_Status;
			}

			if( $tmStatus == "YES" ) {
				if( $this->session->userdata('normal_session_id') == TRUE ) {
					die('a');
				}
				else {
					//send email
					$userEmailAddress    = $this->All->getEmailContactPurchaseInfo($bookOrderID);
					$data["bookRefID"]   = $bookOrderID;
					$data["dateCreated"] = date("Y F d");

					$html = $this->load->view('voucher/final', $data, true);

					$messageContent = $this->load->view('voucher/email_message', '', true);
					$pdfFilePath = "/var/www/html/ctctravel.org/fit/assets/final_pdf/".$bookOrderID.".pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->WriteHTML($html);
					$save_as = $this->m_pdf->pdf->Output($pdfFilePath, "F");
					$attachment = chunk_split(base64_encode($save_as));
			        $this->load->library('email');
			        $config = array(
						'charset'  => 'utf-8',
						'wordwrap' => TRUE,
						'mailtype' => 'html'
					);
					$this->email->initialize($config);
					$this->email->from('info@ctc.com.sg', 'CTC Travel');
					$this->email->to($userEmailAddress);
					//$this->email->bcc('sylvia.tan@ctc.com.sg, immanuel@pixely.sg, fandyfandry@gmail.com, cindy.yan@ctc.com.sg');
					$this->email->to('beto.thamrin@gmail.com');
					$this->email->bcc('fandyfandry@gmail.com');
					$this->email->subject('CTC Pax Statement');
					$this->email->message($messageContent);
					$this->email->attach($pdfFilePath);
					if(!$this->email->send()) {
						echo 'Pax Statement Failed to Send due to system error Please Contact Your Administrator';
						die();
					}
					//end of send email

				}
			}
			else {
				echo 'WOW';
			}
		}
	}
	public function testEmailSent()
	{
        $this->load->library('email');
        $config = array(
			'charset'  => 'utf-8',
			'wordwrap' => TRUE,
			'mailtype' => 'html'
		);
		$this->email->initialize($config);
		$this->email->from('xtidus64@gmail.com', 'CTC Travel');
		$this->email->to("enquiries@atlantaindonesia.com");
		$this->email->subject('CTC Pax Statement');
		$this->email->message('test content');
		$this->email->send();
	}

	public function test_abcde()
	{
		$bookOrderID = "59197ea6cc9f9";
		$data['bookRefID'] = $bookOrderID;
		$html = $this->load->view('voucher/final', $data, true);
		$messageContent = $this->load->view('voucher/email_message', '', true);
		$pdfFilePath = "/var/www/html/ctctravel.org/fit/assets/final_pdf/".$bookOrderID.".pdf";
		$this->load->library('m_pdf');
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output();
		//$this->load->view('voucher/abcde');
	}

	public function testrules()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		checkrules();
	}

	public function testBFM()
	{
		$file_datas  = require_once('/var/www/html/ctctravel.org/fit/webservices/abacus/SWSWebservices.class.php');
		$results 	 = search_flight(
			"SG", "BKK",
			"2017-07-20T00:00:00", 1, 0, 0,
			"Y"
		);
		$parseResult = simplexml_load_string($results);
		echo "<pre>";
		print_r($parseResult);
		echo "</pre>";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */