<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {

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
		$this->load->view('reservation_index');
	}
	
	public function getRecord()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$emailAddress  = $this->input->post("order_email_address");
			$bookingID 	   = $this->input->post("order_booking_reference");
			$checkEmails   = $this->All->select_template("email_address", $emailAddress, "user_access");
			if( $checkEmails == TRUE ) {
				foreach( $checkEmails AS $checkEmail ) {
					$userAccessID = $checkEmail->id;
				}
				$checkBookings = $this->All->select_template_w_2_conditions(
					"BookingOrderID", $bookingID,
					"user_access_id", $userAccessID,
					"confirmedBookOrder"
				);
				if( $checkBookings == TRUE ) {
					foreach( $checkBookings AS $checkBooking ) {
						$confirmedBookingID = $checkBooking->id;
					}
					//redirect
					redirect("reservation/index/".base64_encode(base64_encode(base64_encode($emailAddress)))."/".base64_encode(base64_encode(base64_encode($bookingID)))."/".base64_encode(base64_encode(base64_encode($confirmedBookingID))));
					//end of redirect
				}
				else {
					//session and redirect
					$this->session->set_flashdata(
						'wrongBookingIDReservation',
						'<article class="full-width">
							<div style="text-align:center; color:red; padding:15px; font-size:16px">
								Your booking reference ID not found. Please try again.
							</div>
						</article>'
					);
					redirect("reservation");
					//end of session and redirect
				}
			}
			else {
				//session and redirect
				$this->session->set_flashdata(
					'wrongEmailReservation',
					'<article class="full-width">
						<div style="text-align:center; color:red; padding:15px; font-size:16px">
							Your email address not found. Please try again.
						</div>
					</article>'
				);
				redirect("reservation");
				//end of session and redirect
			}
		}
		else {
			redirect("reservation");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */