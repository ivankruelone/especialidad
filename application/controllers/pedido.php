<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

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

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
	public function tabla_control()
	{
	   $data = array();
       $data['menu'] = 'pedido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('catalogo_model');
		$data['sucx'] = $this->catalogo_model->busca_sucursal();
           
       $this->load->model('pedido_model');
       
       $data['titulo'] = "Pedido de Productos de especialidad";
       $data['contenido'] = "pedido/pedido_c_form";
       $data['tabla'] = $this->pedido_model->control();
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

	public function detalle($id_cc)
	{
	   $data = array();
       $data['menu'] = 'pedido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       $trae = $this->pedido_model->trae_datos_c($id_cc);
       $row = $trae->row();
       $data['tit'] = "Folio.: $id_cc <br />Sucursal.:$row->suc - $row->sucx";
       $data['id_cc'] = $id_cc;
       $data['titulo'] = "pedido de Productos de especialidad";
       $data['contenido'] = "pedido/pedido_d_form";
       $data['tabla'] = $this->pedido_model->detalle_d($id_cc);
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function insert_c()
	{
	$suc= $this->input->post('suc');
    $tipo=0;  
	$this->load->model('pedido_model');
    $this->pedido_model->create_member_c($suc);
    redirect('pedido/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////
function busca_producto()
	{
	
    $clave=$this->input->post('clave');
    $this->load->model('catalogo_model');
    echo $this->catalogo_model->busca_produc($clave); 
       
    }
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////////////
function insert_d()
	{
	$id_cc= $this->input->post('id_cc');
    $codigo= $this->input->post('codigo');
    
    $can= $this->input->post('can');
    $this->load->model('pedido_model');
    $this->pedido_model->create_member_d($id_cc,$codigo,$can);
    redirect('pedido/detalle'."/".$id_cc);
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c($id)
	{
	$this->load->model('pedido_model');
    $this->pedido_model->delete_member_c($id);
    redirect('pedido/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_d($id,$id_cc)
	{
	$this->load->model('pedido_model');
    $this->pedido_model->delete_member_d($id);
    redirect('pedido/detalle'."/".$id_cc);
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c($id)
	{
	$this->load->model('pedido_model');
    $this->pedido_model->cierre_member_c($id);
    redirect('pedido/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico()
	{
	   $data = array();
       $data['menu'] = 'pedido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       
       $data['titulo'] = "HISTORICO  DE PEDIDOS DE ESPECIALIDAD";
       $data['contenido'] = "pedido/pedido_c";
       $data['tabla'] = $this->pedido_model->control_historico();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico_s()
	{
	   $data = array();
       $data['menu'] = 'pedido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       
       $data['titulo'] = "HISTORICO  DE PEDIDOS DE ESPECIALIDAD";
       $data['contenido'] = "pedido/pedido_c";
       $data['tabla'] = $this->pedido_model->control_historico_s();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle_historico($id_cc)
	{
	   $data = array();
       $data['menu'] = 'pedido';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('pedido_model');
       $trae = $this->pedido_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $tit = "Sucursal.:  $row->suc - $row->sucx   <br />  Folio: $id_cc";
       
       $data['titulo'] = "HISTORICO  DE PEDIDO DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['contenido'] = "pedido/pedido_c";
       $data['tabla'] = $this->pedido_model->detalle_d_historico($id_cc,$tit);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_d_s($id_cc)
	{
		
            $this->load->model('pedido_model');
            $trae = $this->pedido_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"center\">PEDIDO DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"5\"> SUCURSAL.:  $row->suc - $row->sucx</td>   
            </tr>
            
            <tr>
            <td colspan=\"4\" align=\"right\">  FOLIO DE PEDIDO: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"5\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            
            </table>";
            $data['detalle'] = $this->pedido_model->imprime_detalle_s($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
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
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"center\">PEDIDO DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"5\"> SUCURSAL.:  $row->suc - $row->sucx</td>   
            </tr>
            
            <tr>
            <td colspan=\"4\" align=\"right\">  FOLIO DE PEDIDO: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"5\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            
            </table>";
            $data['detalle'] = $this->pedido_model->imprime_detalle($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_e($id_cc)
	{
		
            $this->load->model('pedido_model');
            $trae = $this->pedido_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"center\">PEDIDO DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"5\"> SUCURSAL.:  $row->suc - $row->sucx</td>   
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"right\">  FOLIO DE PEDIDO: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"5\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            
            </table>";
            $data['detalle'] = $this->pedido_model->imprime_detalle_e($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////  
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */