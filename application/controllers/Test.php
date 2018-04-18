<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

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
	public function test_voucher()
	{
		$this->load->view('voucher/test_final');
	}
	
	public function test_email_message()
	{
		$this->load->view('voucher/test_email_message');
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
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */