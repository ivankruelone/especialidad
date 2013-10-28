<?php
	class Surtido_model extends CI_Model {
    
    
    function control()
    {
       
       $this->db->select('a.*');
       $this->db->from('pedido_c a');
       $this->db->where('tipo',1);
       $query = $this->db->get();
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Folio</th>
        <th align=\"left\" colspan=\"2\">Sucursal</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('surtido/detalle/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('surtido/delete_c/'.$row->id, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar factura!', 'class' => 'encabezado'));
            $l3 = anchor('surtido/cierre_c/'.$row->id, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para cerrar factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->id."</td>
            <td align=\"center\">".$row->suc."</td>
            <td align=\"left\">".$row->sucx."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"left\">$l1</td>
            <td align=\"left\">$l2</td>
            <td align=\"left\">$l3</td>
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

   function detalle_d($id_cc)
    {
       $this->db->select('a.*,sum(a.cans)as cans,b.*');
       $this->db->from('especialidad.surtido_d a');
       $this->db->join('catalogo.cat_nuevo_general b', 'a.codigo=b.codigo');
       $this->db->where('a.id_ped',$id_cc);
       $this->db->group_by('a.clave');
       $this->db->order_by('a.id');
       $query = $this->db->get();
       //echo $this->db->last_query();
        $tabla= "
        <table>
        <thead>
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"right\">Lote</th>
        <th align=\"right\">Caducidad</th>
        <th align=\"right\">Surtido</th>
        <th align=\"right\"></th>
        </tr>
        </thead>
        <tbody>
        ";
        $totcan=0;
        $num=0;
        foreach($query->result() as $row)
        {
         
            
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."
            <br />".$row->marca_comercial." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            </tr>
            ";
        $totcan= $totcan + $row->cans;
        $num=$num+1;
        $tabla.=$this->detalle_dd($id_cc,$row->clave);
        }
        $tabla.="
        <tr>
            <td align=\"left\" colspan=\"4\">Productos= $num</td>
            <td align=\"right\">TOTAL</td>
            <td align=\"right\">".number_format($totcan,0)."</td>
        </tr>
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
  function detalle_dd($id_cc,$clave)
 {
       $this->db->select('a.*');
       $this->db->from('especialidad.surtido_d a');
       $this->db->where('a.id_ped',$id_cc);
       $this->db->where('a.clave',$clave);
       $this->db->order_by('a.id');
       $query1 = $this->db->get();
       if($query1->num_rows() > 0){
        $tabla="";
        foreach($query1->result() as $row1)
        {
         
            $l1 = anchor('surtido/delete_d/'.$row1->id.'/'.$id_cc, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar productos!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"right\" bgcolor=\"#E7ECC9\" colspan=\"4\">".$row1->lote."</td>
            <td align=\"right\" bgcolor=\"#E7ECC9\">".$row1->cad."</td>
            <td align=\"right\" bgcolor=\"#E7ECC9\">".$row1->cans."</td>
            <td align=\"right\">".$l1."</td>
            </tr>
            ";      
        }
        } 
 return $tabla;
 }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////insert y delete
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

function create_member_d($id_cc,$clave,$id_inv,$can)
	{
       $s="select *from inventario_d where id=$id_inv";
       
       $q= $this->db->query($s);
       if($q->num_rows()== 1){
       $r=$q->row();
        
       $sql1 = "SELECT * FROM surtido_d where id_ped= ? and clave= ? and lote= ? ";
       $query1 = $this->db->query($sql1,array($id_cc,$r->clave,$r->lote)); 
    //////////////////////////////////////////////inserta los datos en la base de datos
    if($query1->num_rows()==0){ 
        $new_member_insert_data = array(
			'id_ped' => $id_cc,
			'clave' => $r->clave,
			'lote' =>  str_replace(' ', '',strtoupper(trim($r->lote))),
            'cad' => $r->caducidad,
			'cans' => $can,
            'codigo'=>$r->codigo,
			'fecha'=> date('Y-m-d H:s:i'),
            'vta'=> 0,
            'lin'=> 1
            						
		);
		
		$insert = $this->db->insert('surtido_d', $new_member_insert_data);
		
	

}}
 return FALSE;
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_d($id)
{
        $this->db->delete('surtido_d', array('id' => $id));

} 
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c($id)
{
$data = array(
			'tipo' => 4,
			'fechacan'=> date('Y-m-d H:s:i')
		);
		$this->db->where('id', $id);
        $this->db->update('pedido_c', $data); 
}    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function cierre_member_c($id)
{
$this->__cierra_pedido_c($id);

$sql0 = "SELECT * FROM surtido_d where id_ped= ? and aplica='NO'";
        $query0 = $this->db->query($sql0,array($id));
        foreach($query0->result() as $row0)
        {
            $this->__actualiza_inventario_d($row0->clave,$row0->lote,$row0->cans);
            $this->__cierra_surtido_d($row0->id,$row0->clave);
        }
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
private function __cierra_pedido_c($id)
{
$data = array(
			'tipo' => 3,
			'fechasur'=> date('Y-m-d H:s:i')
		);
      $this->db->where('id', $id);
      $this->db->where('tipo', 1);
      $this->db->update('pedido_c', $data); 
}
//////////////////////////////////////////////////////////////////////////////////
private function __cierra_surtido_d($id_detalle,$clave)
{
 $sql = "SELECT * FROM catalogo.cat_nuevo_general_prv a where clagob= ? and preferencia='S' group by clagob";
        $query = $this->db->query($sql,array($clave));
        if($query->num_rows() > 0){
            $row= $query->row();
            
            $data = array(
			'vta' => $row->costo,
			'fecha'=> date('Y-m-d H:s:i'),
            'lin' => 1,
            'aplica' => 'SI'
		    );
		    
            $this->db->where('id', $id_detalle);
            $this->db->where('aplica', 'NO');
            $this->db->update('surtido_d', $data); 
            }
}    
//////////////////////////////////////////////////////////////////////////////////
private function __actualiza_inventario_d($clave,$lote,$cans)
{
$sql2 = "SELECT * FROM inventario_d where clave= ? and lote = ? ";
           $query2 = $this->db->query($sql2,array($clave,$lote));
           
           if($query2->num_rows()== 1){
           $row2= $query2->row();
           $existencia=$row2->cantidad; 
           
$data1 = array(
			'cantidad' => $existencia - $cans
			);
		    
            $this->db->where('clave', $clave);
            $this->db->where('lote', $lote);
            $this->db->update('inventario_d', $data1); 
            }
} 
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
    function control_historico()
    {
       
       $this->db->select('a.*');
       $this->db->from('pedido_c a');
        $this->db->where('tipo', 3);
       $this->db->order_by('fecha desc');
       $query = $this->db->get();
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th>Pedido</th>
        <th align=\"center\" colspan=\"2\">Sucursal</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('surtido/detalle_historico/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('surtido/imprime_d/'.$row->id, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->id."</td>
            <td align=\"center\">".$row->suc."</td>
            <td align=\"left\">".$row->sucx."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"left\">$l1</td>
            <td align=\"left\">$l2</td>
            
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

   function detalle_d_historico($id_cc,$tit)
    {
       
       $this->db->select('a.*,b.*');
       $this->db->from('especialidad.surtido_d a');
       $this->db->join('catalogo.cat_nuevo_general_clagob b', 'a.clave=b.clagob');
       $this->db->where('id_ped',$id_cc);
       $this->db->where('aplica','SI');
       $query = $this->db->get();
        
        $tabla= "
        <table>
        <thead>
        <tr>
        <th colspan=\"4\">$tit</th>
        </tr>
        
        <tr>
        <th>Clave</th>
        <th>Sustancia Activa</th>
        <th>Lote</th>
        <th>Caducidad</th>
        <th>Cantidad</th>
        
        </tr>
        
        
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"center\">".$row->lote."</td>
            <td align=\"center\">".$row->cad."</td>
            <td align=\"center\">".$row->cans."</td>
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function imprime_detalle($id)
    {
        $timporte=0;
        $importe=0;
        $tocan=0;
        $num=0;
        $sql = "SELECT a.*,b.* from surtido_d a
        left join catalogo.cat_nuevo_general b on a.codigo=b.codigo
        where a.id_ped= ? and a.aplica='SI'  order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla="
        <table>
        <thead>
        
        <tr>
        <th colspan=\"8\">______________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width=\"50\"><strong>Clave</strong></th>
        <th width=\"50\"><strong>Codigo</strong></th>
        <th width=\"200\"><strong>Sustancia Activa</strong></th>
        <th width=\"80\" align=\"center\"><strong>Lote</strong></th>
        <th width=\"80\" align=\"right\"><strong>Caducidad</strong></th>
        <th width=\"50\" align=\"right\"><strong>Piezas</strong></th>
        <th width=\"70\" align=\"right\"><strong>Precio</strong></th>
        <th width=\"80\" align=\"right\"><strong>Importe</strong></th>
        </tr>
        
        <tr>
        <th colspan=\"8\">__________________________________________________________________________________________________</th>
        </tr>
        
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {
             
            $importe=$row->cans*$row->vta;  
            $tabla.="
            <tr>
            <td width=\"50\" align=\"left\">".$row->clave."</td>
            <td width=\"50\" align=\"left\">".$row->codigo."</td>
            <td width=\"200\" align=\"left\">".trim($row->marca_comercial)." ".trim($row->gramaje)." ".trim($row->contenido)." ".trim($row->presenta)."</td>
            <td width=\"80\" align=\"center\">".$row->lote."</td>
            <td width=\"80\" align=\"right\">".$row->cad."</td>
            <td width=\"50\" align=\"right\">".$row->cans."</td>
            <td width=\"70\" align=\"right\">".number_format($row->vta,2)."</td>
            <td width=\"80\" align=\"right\">".number_format($importe,2)."</td>
            </tr>
            <tr>
            <td colspan=\"8\"></td>
            </tr>
            ";
        $tocan=$tocan+$row->cans;
        $timporte=$timporte+($row->cans*$row->vta);
        $num=$num+1;
        }
        
        $tabla.="
        </tbody>
        <tfoot>
        <tr>
        
        <td colspan=\"8\">_________________________________________________________________________________________________</td>
        </tr>
        
        <tr>
        <td colspan=\"5\" align=\"left\">Productos con diferente lote.: $num</td>
        <td width=\"50\" align=\"right\">".$tocan."</td>
        <td width=\"150\" align=\"right\">".number_format($timporte,2)."<br /><br /><br /><br /><br /></td>
        
        </tr>
        
         <tr>
        <td colspan=\"4\" width=\"330\"align=\"center\">ENVIADO<br /><br /><br /><br /></td>
        <td coslpan=\"4\" width=\"330\" align=\"center\">RECIBIDO<br /><br /><br /><br /></td>
        </tr>
        
        <tr>
        <td coslpan=\"4\" width=\"330\" align=\"center\">______________________________________<br /><br /><br /><br /></td>
        <td coslpan=\"4\" width=\"330\" align=\"center\">______________________________________<br /><br /><br /><br /></td>
        </tr>
        </tfoot>
        </table>";
        //$tabla.=$this->imprime_detalle_negados($id);
        //echo $tabla;
        //die();
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function imprime_detalle_negados($id)
    {
        $tocan=0;
        $num=0;
        $sql = "select * from pedido_d  
        where id_cc = ? and clave not in(select clave from surtido_d_idped_clave where id_ped = ?)";
        $query = $this->db->query($sql,array($id,$id));
        
        $tabla= "
        <table>
        <thead>
        <tr>
        <th colspan=\"6\" align=\"center\"><strong>PRODUCTOS NEGADOS</strong></th>
        </tr>
        <tr>
        <th colspan=\"6\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width=\"70\"><strong>Clave</strong></th>
        <th width=\"300\"><strong>Sustancia Activa</strong></th>
        <th width=\"80\" align=\"right\"><strong>Cantidad</strong></th>
        <th width=\"80\" align=\"center\"><strong></strong></th>
        <th width=\"80\" align=\"right\"><strong></strong></th>
        </tr>
        
        <tr>
        <th colspan=\"6\">__________________________________________________________________________________________</th>
        </tr>
        
        </thead>
        <tbody>
        ";
  
        $susa1=' ';
        $susa2=' ';
        foreach($query->result() as $row)
        {
            
        $sql2 = "SELECT * FROM catalogo.sec_generica where sec= ? ";
        $query2 = $this->db->query($sql2,array($row->clave));
        $row2= $query2->row();
        $susa1=$row2->susa;
         echo $susa1;
         die();
            $tabla.="
            <tr>
            <td width=\"70\" align=\"left\">".$row->clave."</td>
            <td width=\"300\" align=\"left\">".$susa1."</td>
            <td width=\"80\" align=\"right\">".$row->canp."</td>
            <td width=\"80\" align=\"center\"></td>
            <td width=\"80\" align=\"right\"></td>
            
            </tr>
            ";
        $tocan=$tocan+$row->canp;
        $num=$num+1;
        }
        
        $tabla.="
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"6\">__________________________________________________________________________________________</td>
        </tr>
        
        <tr>
        <td width=\"370\" align=\"left\">Productos Negados.: $num</td>
        <td width=\"80\" align=\"right\">".$tocan."</td>
        </tr>
        </tfoot>
        
        </table>";
        echo $tabla;
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
}