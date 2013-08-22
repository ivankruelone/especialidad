<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devolucion extends CI_Controller {

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
       $data['menu'] = 'devolucion';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('catalogo_model');
		$data['sucx'] = $this->catalogo_model->busca_sucursal();
        $data['sale'] = $this->catalogo_model->busca_sucursal_dev();
        $data['entra'] =$this->catalogo_model->busca_sucursal_dev();
        $data['tipo'] =0;
       $this->load->model('devolucion_model');
       
       $data['titulo'] = "Devolucion de Productos";
       $data['contenido'] = "devolucion/devolucion_c_form";
       $data['tabla'] = $this->devolucion_model->control();
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

	public function detalle($id_cc)
	{
	   $data = array();
       $data['menu'] = 'devolucion';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('devolucion_model');
       $trae = $this->devolucion_model->trae_datos_c($id_cc);
       $row = $trae->row();
       $data['tit'] = "Folio.: $id_cc <br />Sale.:$row->salex  <br />Entra: $row->entrax";
       $data['id_cc'] = $id_cc;
       $data['titulo'] = "Devolucion de Productos";
       $data['contenido'] = "devolucion/devolucion_d_form";
       $data['tabla'] = $this->devolucion_model->detalle_d($id_cc);
       
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function insert_c()
	{
	$sale= $this->input->post('sale');
    $entra= $this->input->post('entra');
    $tipo= $this->input->post('tipo');
    $this->load->model('devolucion_model');
    $this->devolucion_model->create_member_c($sale,$entra,$tipo);
    redirect('devolucion/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
function insert_d()
	{
	$id_cc= $this->input->post('id_cc');
    $clave= $this->input->post('clave');
    $can= $this->input->post('can');
    $lote= $this->input->post('lote');
    $cad= $this->input->post('cad');
    $this->load->model('devolucion_model');
    $this->devolucion_model->create_member_d($id_cc,$clave,$can,$lote,$cad);
    redirect('devolucion/detalle'."/".$id_cc);
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c($id)
	{
	$this->load->model('devolucion_model');
    $this->devolucion_model->delete_member_c($id);
    redirect('devolucion/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_d($id,$id_cc)
	{
	$this->load->model('devolucion_model');
    $this->devolucion_model->delete_member_d($id);
    redirect('devolucion/detalle'."/".$id_cc);
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c($id,$concepto)
	{
	$this->load->model('devolucion_model');
    $this->devolucion_model->cierre_member_c($id,$concepto);
    redirect('devolucion/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico()
	{
	   $data = array();
       $data['menu'] = 'devolucion';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('devolucion_model');
       
       $data['titulo'] = "HISTORICO  DE DEVOLUCION DE ESPECIALIDAD";
       $data['contenido'] = "devolucion/devolucion_c";
       $data['tabla'] = $this->devolucion_model->control_historico();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle_historico($id_cc)
	{
	   $data = array();
       $data['menu'] = 'devolucion';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('devolucion_model');
       $trae = $this->devolucion_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $tit = "Sale.:  $row->sale - $row->salex   <br />Entra.:  $row->entra - $row->entrax   <br />  Folio: $id_cc";
       
       $data['titulo'] = "HISTORICO  DE DEVOLUCION DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['contenido'] = "devolucion/devolucion_c";
       $data['tabla'] = $this->devolucion_model->detalle_d_historico($id_cc,$tit);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_d($id_cc)
	{
		
            $this->load->model('devolucion_model');
            $trae = $this->devolucion_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"4\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"4\" align=\"center\">DEVOLUCION DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"4\">Sale.:  $row->sale - $row->salex   <br />Entra.:  $row->entra - $row->entrax</td>   
            </tr>
            
            <tr>
            <td colspan=\"4\" align=\"right\">  FOLIO DE DEVOLUCION: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"4\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            
            </table>";
            $data['detalle'] = $this->devolucion_model->imprime_detalle($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_e($id_cc)
	{
		
            $this->load->model('devolucion_model');
            $trae = $this->devolucion_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"center\">DEVOLUCION DE MERCANCIA</td>
            </tr>
            
            <tr>
            <td colspan=\"5\"> SUCURSAL.:  $row->suc - $row->sucx</td>   
            </tr>
            
            <tr>
            <td colspan=\"5\" align=\"right\">  FOLIO DE DEVOLUCION: $id_cc</td>
            </tr>
            
            <tr> 
            <td colspan=\"5\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            
            </table>";
            $data['detalle'] = $this->devolucion_model->imprime_detalle_e($id_cc);
            $this->load->view('impresiones/reporte', $data);
			
		}
//////////////////////////////////////////////////////  
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */