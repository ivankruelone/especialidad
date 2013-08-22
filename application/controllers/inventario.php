<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventario extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('login');
		}		
	}	

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

	public function tabla_control()
	{
	   $data = array();
       $data['menu'] = 'inventario';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('inventario_model');
       
       $data['titulo'] = "Inventario de Productos de Especialidad";
       $data['contenido'] = "inventario/inventario";
       $data['tabla'] = $this->inventario_model->control_c();
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
    public function detalle_d($clave)
	{
	   $data = array();
       $data['menu'] = 'inventario';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('inventario_model');
       
       $data['titulo'] = "Inventario de Productos de Especialidad ";
       $data['contenido'] = "inventario/inventario";
       $data['tabla'] = $this->inventario_model->detalle_d($clave);
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
    
	public function tabla_detalle()
	{
	   $data = array();
       $data['menu'] = 'inventario';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('inventario_model');
       
       $data['titulo'] = "Inventario de Productos de Especialidad";
       $data['contenido'] = "inventario/inventario";
       $data['tabla'] = $this->inventario_model->detalle();
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
   function imprime_d()
	{
		
            $this->load->model('inventario_model');
            
            $data['cabeza'] = "
            <table>
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"center\">INVENTARIO DE ALMACEN DE ESPECIALIDAD</td>
            </tr>
            </table>";
            $data['detalle'] = $this->inventario_model->imprime_detalle(); 
			$this->load->view('impresiones/reporte', $data);
			
		
		}
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
   function imprime_c()
	{
		
            $this->load->model('inventario_model');
            
            $data['cabeza'] = "
            <table>
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"center\">INVENTARIO DE ALMACEN DE ESPECIALIDAD</td>
            </tr>
            </table>";
            $data['detalle'] = $this->inventario_model->imprime_control(); 
			$this->load->view('impresiones/reporte', $data);
			
		
	}
///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
    
	public function tabla_inv_suc($suc)
	{
	   $data = array();
       $data['menu'] = 'inventario';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('inventario_model');
       $data['tit'] = 'AGREGA PRODUCTOS';
        $data['suc'] = $suc;
       $data['titulo'] = "Inventario de Productos de Especialidad";
       $data['contenido'] = "inventario/inv_form_alta";
       $data['tabla'] = $this->inventario_model->detalle_inv_suc($suc);
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
 function insert_d_inv()
	{
    $suc= $this->input->post('suc');
	$clave= $this->input->post('clave');
    $lote= $this->input->post('lote');
    $cad= $this->input->post('cad');
    $can= $this->input->post('can');
    $this->load->model('inventario_model');
    $this->inventario_model->create_member_d_inv($clave,$lote,$cad,$can,$suc);
    redirect('inventario/tabla_inv_suc'."/".$suc);
    
    }
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
 function borrar_inv($id,$suc)
	{
     $this->load->model('inventario_model');
    $this->inventario_model->delete_member_c($id);
    redirect('inventario/tabla_inv_suc'."/".$suc);
    }
///////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
   function imprime_d_suc($suc)
	{
		    $this->load->model('inventario_model');
            $this->load->model('catalogo_model');
            $sucx =$this->catalogo_model->busca_suc_unica($suc);
            echo  "
            <table border=\"1\">
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"center\">INVENTARIO $suc - $sucx</td>
            </tr>
            </table>";
            echo $this->inventario_model->detalle_inv_suc_imp($suc);
			
		
		}
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */