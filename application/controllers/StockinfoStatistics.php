<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockinfoStatistics extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function MonthLoan(){		
		$Month = $this->input->get('Month');
		$this->load->model('Statistics_model', 'StatisticsData');
		$StatisticsData = $this->StatisticsData->Month();
		echo json_encode($StatisticsData);
	}

	public function ArticleLoan(){
		//$Month = $this->input->get('Month');
		$this->load->model('Statistics_model', 'StatisticsData');
		$ArticleLoan = $this->StatisticsData->ArticleLoan();
		echo json_encode($ArticleLoan);
	}

	public function TypeLoan(){
		//$Month = $this->input->get('Month');
		$this->load->model('Statistics_model', 'StatisticsData');
		$TypeLoan = $this->StatisticsData->TypeLoan();
		echo json_encode($TypeLoan);
	}
	
}