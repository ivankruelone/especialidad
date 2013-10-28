<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surtido extends CI_Controller {

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

	public function tabla_control()
	{
	   $data = array();
       $data['menu'] = 'surtido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('surtido_model');
       
       $data['titulo'] = "Surtido de Productos de especialidad";
       $data['contenido'] = "surtido/surtido";
       $data['tabla'] = $this->surtido_model->control();
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
	public function detalle($id_cc)
	{
	   $data = array();
       $data['menu'] = 'surtido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       $trae = $this->pedido_model->trae_datos_c($id_cc);
       $row = $trae->row();
       $this->load->model('surtido_model');
       $data['tit'] = "Sucursal:  $row->suc - $row->sucx   <br />";
       $data['titulo'] = "SURTIDO DE PEDIDOS DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['contenido'] = "surtido/surtido_d_form";
       $data['tabla'] = $this->surtido_model->detalle_d($id_cc);
       $this->load->view('header');
	   $this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
///////////////////////////
function busca_lote()
	{
	$this->load->model('inventario_model');
    echo $this->inventario_model->busca_lotess($this->input->post('clave'),$this->input->post('id_cc'));
    }
/////////////////////////// 
function busca_can()
	{
	$this->load->model('inventario_model');
    echo $this->inventario_model->busca_cans($this->input->post('id_inv'),$this->input->post('can'));
    
    }
/////////////////////////// 
function busca_canped()
	{
	$this->load->model('pedido_model');
    echo $this->pedido_model->busca_canp($this->input->post('id_inv'),$this->input->post('can'),$this->input->post('id_cc'));
    }

//////////////////////////////////////////////////////
 function insert_d()
	{
	
    
    $id_cc= $this->input->post('id_cc');
    $clave= $this->input->post('clave');
    $id_inv= $this->input->post('id_inv');
    $can= $this->input->post('can');
    $this->load->model('surtido_model');
    $this->surtido_model->create_member_d($id_cc,$clave,$id_inv,$can);
    redirect('surtido/detalle'."/".$id_cc);
    
    }


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c($id)
	{
	$this->load->model('surtido_model');
    $this->surtido_model->delete_member_c($id);
    redirect('surtido/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_d($id,$id_cc)
	{
	$this->load->model('surtido_model');
    $this->surtido_model->delete_member_d($id);
    redirect('surtido/detalle'."/".$id_cc);
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c($id)
	{
	$this->load->model('surtido_model');
    $this->surtido_model->cierre_member_c($id);
    redirect('surtido/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico()
	{
	   $data = array();
       $data['menu'] = 'surtido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('surtido_model');
       
       $data['titulo'] = "HISTORICO  DE SURTIDO DE ESPECIALIDAD";
       $data['contenido'] = "pedido/pedido_c";
       $data['tabla'] = $this->surtido_model->control_historico();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle_historico($id_cc)
	{
	   $data = array();
       $data['menu'] = 'surtido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       $trae = $this->pedido_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $tit = "Sucursal.:  $row->suc - $row->sucx   <br />  Folio: $id_cc";
       $this->load->model('surtido_model');
       $data['titulo'] = "HISTORICO  DE SURTIDO DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['contenido'] = "surtido/surtido";
       $data['tabla'] = $this->surtido_model->detalle_d_historico($id_cc,$tit);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_d($id_cc)
	{
		
            $this->load->model('pedido_model');
            $trae = $this->pedido_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"8\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"8\" align=\"center\">PEDIDO DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"8\"> SUCURSAL.:  $row->suc - $row->sucx</td>   
            </tr>
            
            <tr>
            <td colspan=\"8\" align=\"right\">  FOLIO DE PEDIDO: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"8\">  FECHA DE CAPTURA : $row->fechasur</td>
            </tr>
            
            </table>";
            $this->load->model('surtido_model');
            $data['detalle'] = $this->surtido_model->imprime_detalle($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */