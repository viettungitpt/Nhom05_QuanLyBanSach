<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Author extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['controller'] = 'author';   
        $this->load->model('Mauthor');
        $this->checkAdmin($this->session->userdata('maQuanLy'));
    }
    
	public function index(){
		$this->data['id_active'] = $this->getParamUri(2,3);
        $this->data['txtsearch'] = $this->getParamString('txtsearch');
		$this->load->library('pagination');
		$config['per_page'] = 100;
		$this->data['page'] = $this->data['pageCurrent'] = $this->getParamUri(2,3);
		$offset = (($this->getParamUri(2,3) - 1) * $config['per_page']) > 0 ? (($this->getParamUri(2,3) - 1) * $config['per_page']) : 0;
		$data = $this->Mauthor->getAuthorDB($config['per_page'],$offset,$this->data['txtsearch']); 
		$config['base_url'] = base_url($this->uri->segment(1));
		$config['total_rows'] = $data['count'];
		$config['uri_segment'] = 2;
		$config['uri_segment_page'] = $this->getParamUri(2,3);
		$config['suffix'] = '.html';
		$this->pagination->initialize($config);
		$this->data['pageg'] = $this->data['page'] - 1 > 0 ? $this->data['page'] - 1 : 0;
		$this->data['data'] = $data;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('check-delete', 'Mục cần xóa', 'required');
		$this->data['action'] = 'index';
		$this->load->view('template/layout', $this->data);
	}
	
	public function delete(){
		$id = $this->getParamUri(3,1);
		$this->Mauthor->deleteTacGiaDb($id);
		redirect('tac-gia');
	}
	
	public function add(){
		$id = $this->getParamUri(3,1);
		$this->load->library('form_validation');
        $this->form_validation->set_rules('tenTacGia', 'Tên tác giả', 'required');
        if($this->form_validation->run() === TRUE)
        {
			$tenTacGia = $this->getParamString("tenTacGia");
            $run = $this->Mauthor->addTacGiaDb($tenTacGia);
            if($run == 200)
            {
                die('<meta charset="utf-8"><script>alert("Lưu thành công");window.location.href="'.$this->data['baseurl'].'tac-gia";</script>');
            }
        }
        $this->data['action'] = 'add';
        $this->load->view('template/layout', $this->data);
	}
	
	
	public function edit(){
		$id = $this->getParamUri(3,1);
		$this->load->library('form_validation');
        $this->form_validation->set_rules('tenTacGia', 'tenTacGia', 'required');
        $this->data['data'] = $this->Mauthor->getTacGiaInfo($id); 
        if($this->form_validation->run() === TRUE)
        {
			$tenTacGia = $this->getParamString("tenTacGia");
            $run = $this->Mauthor->updateTacGiaDb($tenTacGia,$id);
            if($run == 200)
            {
                die('<meta charset="utf-8"><script>alert("Lưu thành công");window.location.href="'.$this->data['baseurl'].'tac-gia";</script>');
            }
        }
        $this->data['action'] = 'edit';
        $this->load->view('template/layout', $this->data);
	}
}
