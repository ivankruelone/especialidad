<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compra_c extends CI_Controller {

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

///////////////////////////////////////////////////////////  
///////////////////////////////////////////////////////////
	public function tabla_orden()
	{
	   $data = array();
       $data['menu'] = 'compra';
       $this->load->model('catalogo_model');
       $data['almacen'] = $this->catalogo_model->busca_almacen();
       $data['prv'] = $this->catalogo_model->busca_prv();
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE ESPECIALIDAD";
       $data['contenido'] = "compra_c/orden_c_form";
       $data['tabla'] = $this->compra_model->orden();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
 ///////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function insert_c_orden()
	{
	$prv= $this->input->post('prv');
    $cia= $this->input->post('cia');
    $almacen= $this->input->post('almacen');
    $tipo=0;  
    
	$this->load->model('compra_model');
    $this->compra_model->create_member_c_orden($prv,$tipo,$cia,$almacen);
    redirect('compra_c/tabla_orden');
    
    }
 //////////////////////////////////////////////////////
 //////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c_orden($id)
	{
	$this->load->model('compra_model');
    $this->compra_model->delete_member_c_orden($id);
    redirect('compra_c/tabla_orden');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c_orden($id)
	{
	$this->load->model('compra_model');
    $this->compra_model->cierre_member_c_orden($id);
    redirect('compra_c/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
	public function tabla_orden_his()
	{
	   $data = array();
       $data['menu'] = 'compra';
         $this->load->model('compra_model');
       $data['titulo'] = " ORDEN DE COMPRA";
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->ctl_orden_his();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
//////////////////////////////////////////////////////    
////////////////////////////////////////////////////// 
   function imprime_d_his($id_cc)
	{
		
            $this->load->model('compra_model');
            $this->load->model('catalogo_model');
            $trae = $this->catalogo_model->busca_orden($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            <tr>
            <td colspan=\"6\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"6\" align=\"center\"><strong>FAVOR DE ANEXAR ESTA ORDEN EN SU FACTURA</strong></td>
            </tr>
            <tr>
            <td colspan=\"6\" align=\"center\"><strong>ORDEN DE COMPRA</strong></td>
            </tr>
            <tr>
            <td colspan=\"6\" align=\"center\"><strong>CONTROL DE ESPECIALIDAD</strong><br /><br /></td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"><strong>ORDEN DE COMPRA..: $id_cc</strong></td>
            <td colspan=\"2\" align=\"left\"></td>
            <td colspan=\"2\" align=\"left\"><strong>CONSIGNAR PEDIDO A</strong></td>
            </tr>
             <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">$row->prv $row->razo</td>
            <td colspan=\"2\" align=\"left\">$row->razof</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">$row->dire</td>
            <td colspan=\"2\" align=\"left\">$row->diref</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\"></td>
            <td colspan=\"2\" align=\"left\">$row->colf</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">C.P $row->cp</td>
            <td colspan=\"2\" align=\"left\">C.P $row->cpf</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">$row->pobla</td>
            <td colspan=\"2\" align=\"left\">$row->poblaf</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">R.F.C $row->rfc</td>
            <td colspan=\"2\" align=\"left\">R.F.C $row->rfcf</td>
            </tr>
            <tr>
            <td colspan=\"2\" align=\"center\"></td>
            <td colspan=\"2\" align=\"left\">Tel. $row->tel</td>
            </tr>
            </table>
            ";
            $data['detalle'] = $this->compra_model->imprime_detalle_orden($id_cc);
            $this->load->view('impresiones/reporte_orden', $data);
			
		
		}   
//////////////////////////////////////////////////////    
//////////////////////////////////////////////////////    
//////////////////////////////////////////////////////    
	public function detalle_orden($id_cc)
	{
	   $data = array();
       $data['menu'] = 'compra';
         $this->load->model('compra_model');
       $trae = $this->compra_model->trae_datos_c_orden($id_cc);
       $row = $trae->row();
       $data['titulo'] = " ORDEN DE COMPRA PROVEEDOR:  $row->prv - $row->corto <br />IMPORTE ".number_format($row->importe,2);
       $data['id_cc'] =$id_cc;
       $data['prv'] =$row->corto;
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->detalle_d_orden($id_cc);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
 ///////////////////////////    
 /////////////////////////// 
  function actualiza_cansur()
    {
        $data = array('canp' => $this->input->post('valor'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('especialidad.orden_d', $data);
    }
///////////////////////////////////////////////////////////
	public function tabla_pendiente()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE ESPECIALIDAD";
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->pendiente();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
     
	public function tabla_control()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('catalogo_model');
       $data['almacen'] = $this->catalogo_model->busca_almacen();
       
       $this->load->model('compra_model');
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE ESPECIALIDAD";
       $data['contenido'] = "compra_c/compra_c_form";
       $data['tabla'] = $this->compra_model->control();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function insert_c()
	{
	$folio= $this->input->post('folio');
    $factura= $this->input->post('factura');
    $cia= $this->input->post('cia');
    $almacen= $this->input->post('almacen');
    $tipo=0;  
	$this->load->model('compra_model');
    $this->compra_model->create_member_c($folio,$tipo,$cia,$factura,$almacen);
    redirect('compra_c/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle($id_cc)
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
      
       
       $this->load->model('compra_model');
       $trae = $this->compra_model->trae_datos_c($id_cc);
       $row = $trae->row();
       $data['tit'] = "PROVEEDOR:  $row->prv - $row->prvx   <br />  FACTURA: $row->factura";
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['orden'] =$row->orden;
       $data['contenido'] = "compra_c/compra_d_form";
       $data['tabla'] = $this->compra_model->detalle_d($id_cc);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
 ///////////////////////////    
 /////////////////////////// 
 function insert_d()
	{
	$id_cc= $this->input->post('id_cc');
    $almacen= $this->input->post('almacen');
    $orden= $this->input->post('orden');
    $codigo= $this->input->post('codigo');
    $lote= $this->input->post('lote');
    $cad= $this->input->post('cad');
    $can= $this->input->post('can');
    $canr= $this->input->post('canr');
    $costo= $this->input->post('costo');
    $this->load->model('compra_model');
    $this->compra_model->create_member_d($id_cc,$orden,$codigo,$lote,$cad,$can,$canr,$almacen,$costo);
    redirect('compra_c/detalle'."/".$id_cc."/".$almacen);
    
    }


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c($id)
	{
	$this->load->model('compra_model');
    $this->compra_model->delete_member_c($id);
    redirect('compra_c/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_d($id,$id_cc)
	{
	$this->load->model('compra_model');
    $this->compra_model->delete_member_d($id);
    redirect('compra_c/detalle'."/".$id_cc);
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c($id, $orden,$almacen)
	{
	$this->load->model('compra_model');
    $this->compra_model->cierre_member_c($id, $orden,$almacen);
    redirect('compra_c/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "HISTORICO  DE COMPRA DE ESPECIALIDAD";
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->control_historico();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle_historico($id_cc)
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       $trae = $this->compra_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $tit = "PROVEEDOR:  $row->prv - $row->prvx   <br />  FACTURA: $row->factura";
       
       $data['titulo'] = "HISTORICO  DE COMPRA DE ESPECIALIDAD";
       $data['id_cc'] =$id_cc;
       $data['orden'] =$row->orden;
       $data['contenido'] = "compra_c/compra_d";
       $data['tabla'] = $this->compra_model->detalle_d_historico($id_cc,$tit);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_d($id_cc)
	{
		
            $this->load->model('compra_model');
            $trae = $this->compra_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            <tr>
            <td colspan=\"7\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"7\" align=\"center\">FACTURA DE ALMACEN DE PRODUCTOS DE ESPECIALIDAD</td>
            </tr>
            <tr>
            <td colspan=\"7\"> PROVEEDOR:  $row->prv - $row->prvx</td>   
            </tr>
            <tr>
            <td colspan=\"7\">  FACTURA: $row->factura</td>
            </tr>
            <tr>
            <td colspan=\"7\"> ORDEN DE COMPRA:  $row->orden</td>
            </tr>
            <tr>
            <td colspan=\"7\"><strong align=\"right\">ORDEN DE CXP:  $row->foliocxp</strong></td>
            </tr>
            <tr> 
            <td colspan=\"7\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            </table>
            
            ";
            $data['detalle'] = $this->compra_model->imprime_detalle($id_cc); 
            $this->load->view('impresiones/reporte_hor', $data);
			
		
		}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
     
     
	public function periodo_reporte()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE ESPECIALIDAD";
       $data['contenido'] = "compra_c/compra_c_form_periodo_reporte";
       $data['tabla'] = $this->compra_model->control();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}



//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
   function imprime_concentrado()
	{
		
            $this->load->model('compra_model');
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"center\">FACTURA DE ALMACEN DE PRODUCTOS DE ESPECIALIDAD</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"left\">Fecha de Entrada.:".$this->input->post('fecha')."</td>
            </tr>
            </table>
            
            ";
            $data['detalle'] = $this->compra_model->imprime_control($this->input->post('fecha')); 
			$this->load->view('impresiones/reporte', $data);
			
		
		}

//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////   
}