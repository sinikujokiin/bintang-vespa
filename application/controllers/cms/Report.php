<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('General_Model');
		cekLogin();
	}

	public function index()
	{
		$data = [
			'title' => 'Laporan'
		];
		if ($this->input->get('search')) {
		}
			$data['data'] = $this->getData(); 

		$this->template->load('templates/cms', 'cms/reports',$data, FALSE);
	}


	private function getData()
	{
		$m = $this->input->get('m');
		$y = $this->input->get('y');
		$where =['transactions.status' => 'Finished', 'transactions.deleted_at' => null];
		if ($m) $where['MONTH(service_date)'] = $m;
		if ($y) $where['YEAR(service_date)'] = $y;

		$dataTrans = $this->db->select('transactions.*, customers.name as customer, workshops.name as workshop, vespa.name as vespa')
				->join('customers', 'customers.id = transactions.customer_id')
				->join('workshops', 'workshops.id = transactions.workshop_id')
				->join('vespa', 'vespa.id = transactions.vespa_id')->where($where)->order_by('transaction_code', 'DESC')->get('transactions')->result_array();
		foreach ($dataTrans as $key => $value) {
				$detailTrans = $this->db->select('detail_transaction.*, spareparts.name')->join('spareparts', 'spareparts.id = detail_transaction.sparepart_id')->get_where('detail_transaction', ['transaction_id' => $value['id']])->result_array();
				$dataTrans[$key]['detail'] = $detailTrans;
		}

		return $dataTrans;

	}

	function cetak()
	{
		$dataReport = $this->getData();
		$months = [
		  '1' => 'January',
		  '2' => 'February',
		  '3' => 'Maret',
		  '4' => 'April',
		  '5' => 'Mei',
		  '6' => 'Juni',
		  '7' => 'Juli',
		  '8' => 'Agustus',
		  '9' => 'September',
		  '10' => 'Oktober',
		  '11' => 'November',
		  '12' => 'Desember',
		];
		$this->load->library('Pdf');
		$m = $this->input->get('m');
		$y = $this->input->get('y');
		$month = '' ;
        $year = '' ;
        if ($m) $month = 'Bulan '.$months[$m];
        if ($y) $year = 'Tahun '.$y;
		$data = [
			'title' => $m || $y ? 'Laporan '.$month.' '.$year : 'Laporan Keseluruhan',
			'data' => $dataReport,
			'web' => $this->db->get('setting')->row()
		];

		$html = $this->load->view('templates/report', $data, true);
		$pdf = $this->pdf->createPDF($html, $data['title'], FALSE, 'A4', 'landscape');
		echo  $pdf;
	}

}

/* End of file Report.php */
/* Location: ./application/controllers/cms/Report.php */ ?>