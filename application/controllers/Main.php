<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function index()
	{
		$data['title'] = "EASYGO | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('slider_search');
		$this->load->view('index');
		$this->load->view('footer');
	}
	
	public function login()
	{
		$data['title'] = "EASYGO | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('slider_search');
		$this->load->view('login');
		$this->load->view('footer');
	}
	
	public function hotels()
	{
		$data['title'] = "EASYGO - HOTELS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('hotels');
		$this->load->view('footer');
	}
	
	public function hotel_page()
	{
		$data['title'] = "EASYGO - HOTELS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('page/hotel');
		$this->load->view('footer');
	}
	
	public function flights()
	{
		$data['title'] = "EASYGO - FLIGHTS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('flights');
		$this->load->view('footer');
	}
	
	public function flight_page()
	{
		$data['title'] = "EASYGO - FLIGHTS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('page/flight');
		$this->load->view('footer');
	}
	
	public function flight_and_hotel()
	{
		$data['title'] = "EASYGO - FLIGHT AND HOTEL | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('flight_and_hotel');
		$this->load->view('footer');
	}
	
	public function flight_hotel_page()
	{
		$data['title'] = "EASYGO - FLIGHT AND HOTEL | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('page/flight_and_hotel');
		$this->load->view('footer');
	}
	
	public function cruise()
	{
		$data['title'] = "EASYGO - CRUISES | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('cruise');
		$this->load->view('footer');
	}
	
	public function cruise_page()
	{
		$data['title'] = "EASYGO - CRUISES | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('page/cruise');
		$this->load->view('footer');
	}
	
	public function land_tours()
	{
		$data['title'] = "EASYGO - LAND TOURS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('land_tours');
		$this->load->view('footer');
	}
	
	public function land_tours_results()
	{
		$data['title'] = "EASYGO - LAND TOURS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('results/land_tours');
		$this->load->view('footer');
	}
	
	public function hot_deals()
	{
		$data['title'] = "EASYGO - HOT DEALS | Travel the world your way";
		$this->load->view('header', $data);
		$this->load->view('hot_deals');
		$this->load->view('footer');
	}
}
