<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('My_model');
        //Do your magic here
    }


    function page($data){
        $this->load->view("layouts/main",$data);
        /*  if($this->session->has_userdata('sessbni_nip')){
              $this->load->view("layouts/main",$data);
          }else{
              redirect("Login");
          }*/

    }
    function errorpage(){
        $this->load->view('errors/html/error_404');
    }

    function viewdata($data,$key){
        if($key=="Z!681>*hDoyTeQtP(i=i>DA[N-"){
            $this->load->view("viewdata",$data);
        }else{
            $this->load->view('errors/html/error_404');
        }

    }
    function viewnodata($data,$key){
        if($key=="Z!681>*hDoyTeQtP(i=i>DA[N-"){
            $this->load->view("viewnodata",$data);
        }else{
            $this->load->view('errors/html/error_404');
        }

    }

    function viewdatauser($data,$token){
        $where=array();
        $where['token']=$token;
        $validuser=$this->getTabelArray($where,"tb_ao");

        if($token==$validuser[0]['token']){
            $this->load->view("viewdata",$data);
        }else{
            $this->load->view('errors/html/error_404');
        }
    }

    function viewnodatauser($data,$token){
        $where=array();
        $where['token']=$token;
        $validuser=$this->getTabelArray($where,"tb_ao");
        if($token==$validuser[0]['token']){
            $this->load->view("viewnodata",$data);
        }else{
            $this->load->view('errors/html/error_404');
        }
    }

    function cekpost(){
        if(isset($_POST) && count($_POST)>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function addtabel($tabel,$params){
        return $this->My_model->add($tabel,$params);
    }

    public function getAllTabel($tabel){
        return $this->My_model->get_all_tabel($tabel);
    }

    public function getTabel($where,$tabel){
        return $this->My_model->get_tabel($where,$tabel);
    }

    public function getTabelArray($where,$tabel){
        return $this->My_model->get_tabel_array($where,$tabel);
    }

    public function updatetabel($where,$tabel,$params){
        return $this->My_model->update($where,$tabel,$params);
    }

    public function execSQL($sql){
        return $this->My_model->execSQL($sql);
    }

    public function execSQLRow($sql){
        return $this->My_model->execSQLRow($sql);
    }

    public function delete_tabel($where,$tabel){
        return $this->My_model->delete_tabel($where,$tabel);
    }


    public function uploadFilesRename($name,$file,$path,$ext){
        $config['upload_path']          = $path;
        $config['allowed_types']        = $ext;
        $config['file_name']            = $name;
        $config['max_size']             = 2000;
        //$config['max_width']            = 650;
        //$config['max_height']           = 650;
//        $config['max_filename']         = 0;
        $config['file_ext_tolower']     = TRUE;
        $config['remove_spaces']        = TRUE;
        $config['detect_mime']        	= TRUE;
        $config['mod_mime_fix']        	= TRUE;
        $config['overwrite']     		= TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload($file)){
            $data=array();
            $error = array('error' => $this->upload->display_errors());
            $data['success']=0;
            $data['error']=$error;
            // print_r($error);
            //$name = "default.png";
            return $data;
        }else{
            // $data = array('upload_data' => $this->upload->data());
            // print_r($data);
            $data=array();
            $image_data = $this->upload->data();
            $data['success']=1;
            $data['data']=$image_data;
            $name = $image_data['file_name'];

            return $data;
        }
    }

    public function uploadFilesRenameSlider($name,$file,$path,$ext){
        $config['upload_path']          = $path;
        $config['allowed_types']        = $ext;
        $config['file_name']            = $name;
        $config['max_size']             = 10000;
        $config['max_width']            = 1920;
        $config['max_height']           = 728;
//        $config['max_filename']         = 0;
        $config['file_ext_tolower']     = TRUE;
        $config['remove_spaces']        = TRUE;
        $config['detect_mime']        	= TRUE;
        $config['mod_mime_fix']        	= TRUE;
        $config['overwrite']     		= TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(!$this->upload->do_upload($file)){
            $data=array();
            $error = array('error' => $this->upload->display_errors());
            $data['success']=0;
            $data['error']=$error;
            // print_r($error);
            //$name = "default.png";
            return $data;
        }else{
            // $data = array('upload_data' => $this->upload->data());
            // print_r($data);
            $data=array();
            $image_data = $this->upload->data();
            $data['success']=1;
            $data['data']=$image_data;
            $name = $image_data['file_name'];

            return $data;
        }
    }

    public function formatTanggal($tanggal){
        $formattanggal=str_replace("/","-",$tanggal);
        $buattanggal=date_create($formattanggal);
        $tanggal=date_format($buattanggal,"Y-m-d");
        return $tanggal;
    }

    public function kalkulasitanggal($tanggal){
        $createdate=date_create($tanggal);
        $days=date_format($createdate,"D");
        if($days=='sat'){
            date_add($createdate,date_interval_create_from_date_string("2 days"));
            return date_format($createdate,"Y-m-d");
        }else if($days=='sun'){
            date_add($createdate,date_interval_create_from_date_string("1 days"));
            return date_format($createdate,"Y-m-d");
        }
    }

    function indonesian_date ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
        if (trim ($timestamp) == '')
        {
            $timestamp = time ();
        }
        elseif (!ctype_digit ($timestamp))
        {
            $timestamp = strtotime ($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

    function formatwaktu($waktu){
        return date("H:i", strtotime($waktu));
    }
}

/* End of file Controllername.php */


?>
