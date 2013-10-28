<?php
	class Inventario_model extends CI_Model {
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
    
    function control_c()
    {
        
        $this->db->select('a.*,sum(a.cantidad)as cantidad,b.*');
        $this->db->from('inventario_d a');
        $this->db->join('catalogo.cat_nuevo_general_clagob b' , 'a.clave=b.clagob', "left");
        $this->db->where('a.cantidad<>0','',false);
        $this->db->group_by('a.clave');
        $this->db->order_by('a.clave');
        $query = $this->db->get();
        
        
        $l0 = anchor('inventario/imprime_c', '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" />Imprime Inventario</a>', array('title' => 'Haz Click aqui para imprimir inventario!', 'class' => 'encabezado'));
        $tabla= "
        <table>
        <thead>
        
        <tr>
        <th align=\"right\" colspan=\"4\" >$l0</th>
        </tr>
        
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"right\">Cantidad</th>
        </tr>
        
        
        </thead>
        <tbody>";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('inventario/detalle_d/'.$row->clave, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            
            $tabla.="
            <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
        <td align=\"right\">$row->cantidad</td>
        <td align=\"right\">$l1</td>
        </tr>
            ";
        }
        $tabla.="
        </table>
        </tbody>";
        
        return $tabla;
        
        
    }
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////    
    function detalle_d($clave)
    {
        
        $this->db->select('a.*,b.*');
        $this->db->from('inventario_d a');
        $this->db->join('catalogo.cat_nuevo_general_clagob b' , 'a.clave=b.clagob', "left");
        $this->db->where('a.clave' , $clave);
         $this->db->where('a.cantidad<>0','',false);
        $query = $this->db->get();
        
        
        $num=0;
        $tocan=0;
        $tabla= "
        <table>
        <thead>
        
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"center\">Lote</th>
        <th align=\"center\">Caducidad</th>
        <th align=\"right\">Cantidad </th>
        </tr>
        
        </thead>
        <tbody>";
        
        foreach($query->result() as $row)
        {
            ////campos
            
        $tabla.="
        <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
        <td align=\"center\">$row->lote</td>
        <td align=\"center\">$row->caducidad</td>
        <td align=\"right\">$row->cantidad</td>
        </tr>
            ";
        $num=$num+1;
        $tocan=$tocan+$row->cantidad;
        }
        $tabla.="
        <tr>
        <td align=\"left\"colspan=\"4\">Lotes.: $num</td>
        <td align=\"right\">$tocan</td>
        </tr>
        
        
        </tbody>
        </table>";
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
    function detalle()
    {
        
        $this->db->select('a.*,b.*');
        $this->db->from('inventario_d a');
        $this->db->join('catalogo.cat_nuevo_general_clagob b' , 'a.clave=b.clagob' , "left");
         $this->db->where('a.cantidad<>0','',false);
         
        $this->db->order_by('clave');
        
        
        $query = $this->db->get();
        
        $l0 = anchor('inventario/imprime_d', '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" />Imprime Inventario</a>', array('title' => 'Haz Click aqui para imprimir inventario!', 'class' => 'encabezado'));
        $num=0;
        $tocan=0;
        $tabla= "
        <table>
        <thead>
        <tr>
        <th align=\"right\" colspan=\"4\" >$l0</th>
        </tr>
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"center\">Lote</th>
        <th align=\"center\">Caducidad</th>
        <th align=\"right\">Cantidad </th>
        </tr>
        </thead>
        <tbody>";
        
        foreach($query->result() as $row)
        {
            ////campos
            
        $tabla.="
        <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
        <td align=\"center\">$row->lote</td>
        <td align=\"center\">$row->caducidad</td>
        <td align=\"right\">$row->cantidad</td>
        </tr>
            ";
        $num=$num+1;
        $tocan=$tocan+$row->cantidad;
        }
        $tabla.="
        <tr>
        <td align=\"left\"colspan=\"4\">Productos con diferente lote.: $num</td>
        <td align=\"right\">$tocan</td>
        </tr>
        </table>
        </tbody>";
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////////////////////

function busca_lotess($clave,$id_cc)
	{
		
        $sql = "SELECT id,clave,lote, caducidad,cantidad,descri FROM inventario_d where descri like '%$clave%' and cantidad>0";
        $query = $this->db->query($sql);
        
        
        if($query->num_rows()== 0){
            $tabla = 0;
        }else{
        $tabla = "<option value=\"0\">Selecciona un Descripcion</option>";
        foreach($query->result() as $row)
        {
        //$sql1 = "SELECT * FROM pedido_d where clave=$row->clave and id_cc= ?";
        //$query1 = $this->db->query($sql1,array($id_cc));    

            $tabla.="
            <option value =\"".$row->id."\">".$row->descri." - $row->cantidad Pzas</option>
            ";
        }
        }
        
        return $tabla;
	}

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function trae_datos($clave,$lote){
    $sql = "SELECT *  FROM inventario_d  where clave= ? and  lote= ? ";
    $query = $this->db->query($sql,array($clave,$lote));
     return $query;
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function busca_cans($id_inv,$can)
	{
		$sql = "SELECT * FROM inventario_d a 
        where a.id=$id_inv and a.cantidad>= $can ";
        $query = $this->db->query($sql);
        return $query->num_rows(); 
	}
/////////////////////////////////////////////////////////////////////////////////
function imprime_control()
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT sum(a.cantidad)as inv, a.*,b.*
        from inventario_d a
        left join catalogo.cat_nuevo_general_clagob b on a.clave=b.clagob
        where cantidad>0 and persona='ES' group by clave";
        $query = $this->db->query($sql,array());
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"3\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"70\"><strong>Clave</strong></th>
        <th width= \"460\"><strong>Sustancia Activa</strong></th>
        <th width= \"80\" align=\"right\"><strong>Existencia</strong></th>
        </tr>
        <tr>
        <th colspan=\"3\">__________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"70\" align=\"left\">".$row->clave."</td>
            <td width= \"460\" align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td width= \"80\" align=\"right\">".$row->inv."</td>
            
            
            </tr>
            ";
        $tocan=$tocan+$row->inv;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"3\">__________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"530\" align=\"left\">Total de productos : $num</td>
        <td width= \"80\" align=\"right\">".$tocan."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_detalle()
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT a.*,b.susa1
        from inventario_d a
        left join catalogo.segpop_cla_per b on a.clave=b.claves
        where cantidad>0 and persona='ES' order by clave,lote";
        $query = $this->db->query($sql,array());
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"70\"><strong>Clave</strong></th>
        <th width= \"300\"><strong>Sustancia Activa</strong></th>
        <th width= \"80\" align=\"left\"><strong>Lote</strong></th>
        <th width= \"80\" align=\"right\"><strong>Caducidad</strong></th>
        <th width= \"80\" align=\"right\"><strong>Existencia</strong></th>
        </tr>
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"70\" align=\"left\">".$row->clave."</td>
            <td width= \"300\" align=\"left\">".$row->susa1."</td>
            <td width= \"80\" align=\"left\">".$row->lote."</td>
            <td width= \"80\" align=\"right\">".$row->caducidad."</td>
            <td width= \"80\" align=\"right\">".$row->cantidad."</td>
            
            
            </tr>
            ";
        $tocan=$tocan+$row->cantidad;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"530\" align=\"left\">Total de productos con lotes diferentes.: $num</td>
        <td width= \"80\" align=\"right\">".$tocan."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
    function detalle_inv_suc($suc)
    {
        
        $this->db->select('a.*,b.susa1,b.susa2,b.codigo');
        $this->db->from('inv_suc a');
        $this->db->join('catalogo.sec_generica b' , 'a.clave=b.sec' , "left");
        $this->db->where('suc' , $suc);
        $this->db->order_by('clave');
        
        
        $query = $this->db->get();
        
        $l0 = anchor('inventario/imprime_d_suc/'.$suc, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" />Imprime Inventario</a>', array('title' => 'Haz Click aqui para imprimir inventario!', 'class' => 'encabezado','target'=>'blank'));
        
        $num=0;
        $tocan=0;
        $tabla= "
        <table  border=\"1\">
        <thead>
        <tr>
        <th align=\"right\" colspan=\"4\" >$l0</th>
        </tr>
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa<br/ >Descripcion</th>
        <th align=\"center\">Codigo</th>
        <th align=\"center\">Lote</th>
        <th align=\"center\">Caducidad</th>
        <th align=\"right\">Cantidad </th>
        </tr>
        </thead>
        <tbody>";
        $lote='';
        $cad='';
        foreach($query->result() as $row)
        {
         
        $l2 = anchor('inventario/borrar_inv/'.$row->id.'/'.$suc, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar factura!', 'class' => 'encabezado'));    ////campos
            
        $tabla.="
        <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">$row->susa1 <br />$row->susa2</td>
        <td align=\"center\">$row->codigo</td>
        <td align=\"center\">$row->lote</td>
        <td align=\"center\">$row->cadu</td>
        <td align=\"right\">$row->can</td>
        <td align=\"right\">$l2</td>
        
        </tr>
            ";
        $num=$num+1;
        $tocan=$tocan+$row->can;
        }
        $tabla.="
        <tr>
        <td align=\"left\"colspan=\"5\">Productos con diferente lote.: $num</td>
        <td align=\"right\">$tocan</td>
        </tr>
        </table>
        </tbody>";
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function create_member_d_inv($clave,$lote,$cad,$can,$suc)
	{
        
        $sql1 = "SELECT * FROM inv_suc where clave= ? and lote= ? and suc = ? ";
       $query1 = $this->db->query($sql1,array($clave,$lote,$suc));
       
       if($query1->num_rows()== 0){
        
    //////////////////////////////////////////////inserta los datos en la base de datos
    	//suc, clave, can, fecha, codigo, sec, lote, cadu
        $new_member_insert_data = array(
			'suc' => $suc,
			'clave' => $clave,
			'lote' =>  str_replace(' ', '',strtoupper(trim($lote))),
            'cadu' => $cad,
			'can' => $can,
			'fecha'=> date('Y-m-d')
            						
		);
		
		$insert = $this->db->insert('inv_suc', $new_member_insert_data);
		
	}


 return FALSE;
}    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c($id)
{
        $this->db->delete('inv_suc', array('id' => $id));

}     
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
    function detalle_inv_suc_imp($suc)
    {
        
        $this->db->select('a.*,b.susa1,b.codigo');
        $this->db->from('inv_suc a');
        $this->db->join('catalogo.sec_generica b' , 'a.clave=b.sec' , "left");
        $this->db->where('suc' , $suc);
        $this->db->order_by('clave');
        
        
        $query = $this->db->get();
        
        $num=0;
        $tocan=0;
        $tabla= "
        <table  border=\"1\">
        <thead>
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"center\">Codigo</th>
        <th align=\"center\">Lote</th>
        <th align=\"center\">Caducidad</th>
        <th align=\"right\">Cantidad </th>
        </tr>
        </thead>
        <tbody>";
        $lote='';
        $cad='';
        foreach($query->result() as $row)
        {
         
            ////campos
            
        $tabla.="
        <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">$row->susa1</td>
        <td align=\"center\">$row->codigo</td>
        <td align=\"center\">$row->lote</td>
        <td align=\"center\">$row->cadu</td>
        <td align=\"right\">$row->can</td>
        </tr>
            ";
        $num=$num+1;
        $tocan=$tocan+$row->can;
        }
        $tabla.="
        <tr>
        <td align=\"left\"colspan=\"5\">Productos con diferente lote.: $num</td>
        <td align=\"right\">$tocan</td>
        </tr>
        </table>
        </tbody>";
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////    















}