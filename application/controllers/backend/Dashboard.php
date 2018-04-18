<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	public function index()
	{
		if($this->session->userdata('user_session_id') == TRUE) {


			if($this->session->userdata('user_session_access_dashboard') == '1')
			{
				$this->load->view('backend/dashboard');
			}
			else
			{
				$this->load->view('backend/permission_denied');
			}
		}
		else {
			redirect("backend/");
		}
	}

	public function viewVoucher()
	{
		/*
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('voucher/viewVoucher');
		}
		else {
			redirect("backend/");
		}
		*/
		if($this->session->userdata('user_session_id') == TRUE) {
			$this->load->view('backend/dashboard_view');
		}
		else {
			redirect("backend/");
		}
	}

	public function deleteVoucher()
	{
		$bookingOrderID = $this->uri->segment(4);
		if( $bookingOrderID != "" || $bookingOrderID != NULL ) {
			$delete1  = $this->All->delete_template("BookingOrderID", 	$bookingOrderID, 	"confirmedBookOrder");
			$delete2  = $this->All->delete_template("bookOrderID", 		$bookingOrderID, 	"contact_person_information");
			$delete3  = $this->All->delete_template("bookOrderID", 		$bookingOrderID, 	"cruise_traverlerInfo");
			$delete4  = $this->All->delete_template("bookingRefID", 	$bookingOrderID, 	"hotel_historyOder");
			$delete5  = $this->All->delete_template("bookingID", 		$bookingOrderID, 	"hotel_paxName");
			$delete6  = $this->All->delete_template("bookOrderID", 		$bookingOrderID, 	"hotel_payment_reference");
			$delete7  = $this->All->delete_template("bookOrderID", 		$bookingOrderID, 	"landtour_history_order");
			$delete8  = $this->All->delete_template("bookingID", 		$bookingOrderID, 	"landtour_paxname");
			$delete9  = $this->All->delete_template("bookingID", 		$bookingOrderID, 	"landtour_paxname_ticket");
			$delete10 = $this->All->delete_template("bookOrderID", 		$bookingOrderID, 	"payment_reference");
			$delete11 = $this->All->delete_template("bookingRefID", 	$bookingOrderID, 	"flight_history_order");
			$delete11 = $this->All->delete_template("bookingOrderID", 	$bookingOrderID, 	"flight_passenger_pnr_details");
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */