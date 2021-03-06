<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Mauthor extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        
    }
	
	public function getAuthorDB($number,$offset,$txtsearch)
    {
        $limit = $offset ? intval($offset) : '0';
        $sql = "SELECT * FROM tacgia WHERE 1=1 ";
		if( !in_array($txtsearch,array('',null)) ){
			$sql .= ' AND tenTacGia LIKE "%'.$txtsearch.'%" '; 
		}
		
        $sql_limit = " ORDER BY maTacGia DESC LIMIT ".$limit.",".$number."";
        $data = $this->db->query($sql.$sql_limit)->result_object();
        $count = $this->db->query($sql)->num_rows();
        $array = array();
        $array['count'] = $count;
        $array['data'] = $data;
        return $array;
    }
	
	public function deleteTacGiaDb($id){
		$this->db->query('DELETE FROM tacgia WHERE maTacGia = '.$id);
		$this->db->query('DELETE FROM sanpham WHERE id_MaTacGia = '.$id);
	}
	
	public function addTacGiaDb($tenTacGia)
    {
        $arr = array(
                'tenTacGia' => $tenTacGia
            );
        $this->db->insert('tacgia', $arr);
        return 200;
    }
	
	public function getTacGiaInfo($id){
		return $this->db->query('SELECT * FROM tacgia WHERE maTacGia = '.$id)->row_object();
	}
	
	public function updateTacGiaDb($tenTacGia,$id){
		$arr = array(
			'tenTacGia' => $tenTacGia
			);
		$this->db->update('tacgia',$arr,'maTacGia = '.$id);
		return 200;
	}
	/////////////////////////////////////////////////////////////////////
	
	
	
	
	
	
	
	
	
	
    public function getUserDB($number,$offset,$txtsearch)
    {
        $limit = $offset ? intval($offset) : '0';
        $sql = "SELECT * FROM nguoidung WHERE 1=1 ";
        if( !in_array($txtsearch,array('',null)) ){
            $sql .= "AND ( tendangnhap LIKE '%".$txtsearch."%' OR hoten LIKE '%".$txtsearch."%' OR sodienthoai LIKE '%".$txtsearch."%' ) ";
        }
        $sql_limit = " ORDER BY maNguoiDung DESC LIMIT ".$limit.",".$number."";
        $data = $this->db->query($sql.$sql_limit)->result_object();
        $count = $this->db->query($sql)->num_rows();
        $array = array();
        $array['count'] = $count;
        $array['data'] = $data;
        return $array;
    }
    
	
	////////////////////
	
	public function getUserid($id)
    {
        return $this->db->query('SELECT * FROM nguoiquanly WHERE maQuanLy = '.$id)->row_object();
    }
	
   
    
   
    
    public function deleteAcc($id)
    {
        //die("DELETE FROM user WHERE id IN ('" . (is_array($id) ? implode("','", $id) : $id) . "')");
        $run = $this->db->query("DELETE FROM user WHERE id IN ('" . (is_array($id) ? implode("','", $id) : $id) . "')");
        if ($this->db->affected_rows() > 0)
        {
            return 200;  
        }
        return 201;
    }
    
    
    
    public function editUserDb($id,$email,$fullname,$mobile,$address,$active,$expired,$pword,$pword2)
    {
		$arr = array(
                'email' => $email,
                'fullname' => $fullname,
                'mobile' => $mobile,
                'address' => $address,
                'active' => $active,
				
            );
		 if(!in_array($expired, array(null, '', '0'))){  
			$exp = time() + $expired*86400; 
			$arr['expired'] = $exp;
		 }
		 
        

        if(!in_array($pword, array(null, '', '0')) && ( $pword == $pword2 ) )
        {
            $username = $this->db->query('SELECT username FROM user WHERE id = '.$id)->row_object()->username;
            $arr['password'] = $pword = md5(md5($username).md5($pass_new));
        }
        $this->db->update('user', $arr, 'id = '.$id);
        return 200;
    }

    
    public function updateInfo($id)
    {
        $p = $this->getParamString('pword');
        $r_p = $this->getParamString('repword');
        if($p != $r_p)
        {
            return 203;
        }
        $data = array(
                    "fullname"      => $this->getParamString('fullname'),
                    "email"         => $this->getParamString('email'),
                    "mobile"        => $this->getParamString('mobile'),
                );
                
        if(!in_array($this->getParamString('pword'), array(null, '', '0')))
        {
            $salt           = $this->generateCode(5);
            $encode_pass    = md5($p);
            $encode_salt    = md5($encode_pass.$salt);
            $data['salt']   = $salt;
            $data['password']  = $encode_salt;
            
        }
        try{$this->db->update('user', $data, "id = '".$id."'"); return 200;} catch(exception $e) {}
    }
    
    public function getData($id)
    {
        $sql = "SELECT username,fullname,email,mobile,img,level,active,coin,subscriber,start_subscriber,end_subscriber,total_amount,codeConfirm FROM user WHERE id = '".$id."'";
        return $this->db->query($sql)->row_object();  
    }
    
    public function getUserExport()
    {
        return $this->db->query('SELECT username,fullname,email,mobile,DATE_FORMAT(created,"%H:%i:%s %d/%m/%Y") AS time FROM user ORDER BY id ASC LIMIT 4000')->result_object();
    }
    
    public function updateProfileDb($hoTen,$soDienThoai,$diaChi){
        $data = array ( 'hoTen' => $hoTen, 'soDienThoai' => $soDienThoai, 'diaChi' => $diaChi );
        $this->db->update('nguoiquanly', $data, "maQuanLy = '".$this->session->userdata('maQuanLy')."'");
		$this->session->set_userdata(array( 'hoTen' => $hoTen));
        return 200;
    }
    
    public function updateChangepwDb($pword,$pword1,$pword2){
       $query = $this->db->query('SELECT * FROM nguoiquanly WHERE maQuanLy = '.$this->session->userdata('maQuanLy').' AND matKhau = "'.$pword.'"');
        if ($query->num_rows() > 0)
        {
            if( $pword1 == $pword2 ){
                $data = array ('matKhau' => $pword1);
                $this->db->update('nguoiquanly', $data, "maQuanLy = '".$this->session->userdata('maQuanLy')."'");
                return 200;
            }else{
                return 201;
            }
        }else{
            return 201;
        }
    }
}