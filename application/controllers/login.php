<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        
    }
    
    function index($error = null)
    {
        $data['error'] = $error;
        $this->load->view('login/login', $data);
    }
	
	function validate_credentials()
	{		
		$this->load->model('miembros_model');
		$query = $this->miembros_model->validate();
		
		if($query->num_rows == 1) // if the user's credentials validated...
		{
			
            $row = $query->row();
            
            $data = array(
				'username' => $row->username,
				'is_logged_in' => true,
                'nivel' => $row->nivel,
                'nombre' => $row->nombre,
                'id' => $row->id,
                'tipo' => $row->tipo,
                'puesto' => $row->puesto,
                'email' => $row->email,
                'avatar' => $row->avatar
			);
			$this->session->set_userdata($data);
			redirect('welcome');
		}
		else // incorrect username or password
		{
			redirect('login/index/1');
		}
	}

	public function perfil()
	{
	   $data = array();
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('miembros_model');

    $data_c['extraheader'] = "
        <script type=\"text/javascript\" src=\"".base_url()."js/AjaxUpload.2.0.min.js\"></script>
        ";
       
       $data['titulo'] = "Perfil del Usuario";
       $data['contenido'] = "login/perfil";
       $data['query'] = $this->miembros_model->datos_usuario($this->session->userdata('id'));
       
		$this->load->view('header', $data_c);
		$this->load->view('main', $data);
	}
    
    public function submit_perfil()
    {
        $this->load->model('miembros_model');
        $this->miembros_model->update_usuario();
        redirect('welcome', 'refresh');
    }
    
    function upload_avatar()
    {
        $uploaddir = './img/avatar/';
        $file = basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $file;
        
        $config['image_library'] = 'gd2';
        $config['source_image']	= $uploadfile;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width']	 = 100;
        $config['height']	= 100;
        $config['master_dim'] = 'auto';
        
        
        
        
        
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->load->model('miembros_model');
        
            echo $this->miembros_model->update_avatar($file);
        } else {
          echo "error";
        }

    }

	
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}

}