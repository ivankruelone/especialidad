<?php
	class Compra_model extends CI_Model {
///////////////////////////////////////////////////////////
 private function __actualiza_tipo($tipo,$tipox)
 {
  if($tipo=='cht'){$tipox='CHETUMAL';}
  elseif($tipo=='ver'){$tipox='VERACRUZ';}
  elseif($tipo=='zac'){$tipox='ZACATECAS';}
  elseif($tipo=='alm'){$tipox='CEDIS Y METRO';} 
  elseif($tipo=='agu'){$tipox='AGUASCALIENTES';}
  elseif($tipo=='tep'){$tipox='TEPIC';}
  elseif($tipo=='esp'){$tipox='ESPECIALIDAD';}
 return $tipox;
 }
/////////////////////////////////////////////////////////// 
    function orden()
    {
       $sql = "SELECT a.*,b.corto,sum(canp*costo)as importe FROM orden a
       left join orden_d c on c.id_cc=a.id 
       left join catalogo.provedor b on b.prov=a.prv 
       where a.tipo=0 group by a.id";
        $query = $this->db->query($sql);


        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Almacen</th>
        <th>Orden</th>
        <th>Prv</th>
        <th align=\"center\">Provedor</th>
        <th align=\"center\">Fecha</th>
        <th align=\"right\">Importe</th>
        <th align=\"center\"></th>
        <th align=\"center\">Detalle</th>
        <th align=\"center\">Borrar</th>
        <th align=\"center\" colspan=\"2\">Cerrar</th>
        </tr>
        </thead>
        <tbody>
        ";
        $tipox='';
        foreach($query->result() as $row)
        {
        $l1 = anchor('compra_c/detalle_orden/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la orden!', 'class' => 'encabezado'));
        $l2 = anchor('compra_c/delete_c_orden/'.$row->id, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar orden!', 'class' => 'encabezado'));
        $l3 = anchor('compra_c/cierre_c_orden/'.$row->id, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para cerrar orden!', 'class' => 'encabezado'));
                
        $tipox = $this->__actualiza_tipo($row->almacen,$tipox); 
            $tabla.="
            <tr>
             <td align=\"center\">".$tipox."</td>
            <td align=\"center\">".$row->id."</td>
            <td align=\"center\">".$row->prv."</td>
            <td align=\"left\">".$row->corto."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"right\">".number_format($row->importe,2)."</td>
            <td></td>
            <td align=\"center\">".$l1."</td>
            <td align=\"center\">".$l2."</td>
            <td align=\"center\">".$l3."</td>
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

   function detalle_d_orden($id_cc)
    {
       
       $this->db->select('a.id,a.costo as costoo,a.*,b.codigo,b.gramaje,b.susa,b.contenido,b.presenta');
       $this->db->from('especialidad.orden_d a');
       $this->db->join('catalogo.cat_nuevo_general b', 'a.codigo=b.codigo');
       $this->db->where('id_cc',$id_cc);
       $this->db->group_by('a.codigo');
       $this->db->order_by('a.id desc');
       $query = $this->db->get();
        
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Clave</th>
        <th>Codigo</th>
        <th></th>
        <th>Producto</th>
        <th>Costo</th>
        <th>Cantidad</th>
        <th></th>
        <th>Importe</th>
        </tr>
        </thead>
        <tbody>
        ";
        $totcan=0;
        $num=0;
        $totcanr = 0;
        foreach($query->result() as $row)
        {
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"center\">".$row->codigo."</td>
            <td></td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"left\">".number_format($row->costoo,2)."</td>
            <td align=\"right\">".$row->canp."</td>
            <td align='right'><font size='-1'><input name='cansur_$row->id' type='text' id='cansur_$row->id' size='5' maxlength='5' value='$row->canp' /></font></td>
            <td align=\"right\">".number_format(($row->canp)*($row->costoo),2)."</td>
            </tr>
            ";
        $totcan= $totcan + $row->canp;
       $num=$num+1;
        }
        
        $tabla.="
        <tr>
            <td align=\"left\">Productos= $num</td>
            <td align=\"center\">TOTAL</td>
            <td align=\"center\">".$totcan."</td>
            
        </tr>
        </tbody>
        </table>
        
        
        
        <script language=\"javascript\" type=\"text/javascript\">

$('input:text[name^=\"cansur_\"]').change(function() {
    
    var nombre = $(this).attr('name');
    var valor = $(this).attr('value');
     var id = nombre.split('_');
    id = id[1];
   //alert(id + \" \" + valor);
    actualiza_surtido(id, valor);
});

function actualiza_surtido(id, valor){
    $.ajax({type: \"POST\",
        url: \"".site_url()."/compra_c/actualiza_cansur/\", data: ({ id: id, valor: valor }),
            success: function(data){
        },
        beforeSend: function(data){

        }
        });
}

</script>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////// 
    function ctl_orden_his()
    {
       $sql = "SELECT a.*,b.corto,sum(canp*costo)as importe FROM orden a
       left join orden_d c on c.id_cc=a.id 
       left join catalogo.provedor b on b.prov=a.prv 
       where a.tipo>0 group by a.id order by a.id desc";
        $query = $this->db->query($sql);


        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Almacen</th>
        <th>Orden</th>
        <th>Prv</th>
        <th align=\"center\">Provedor</th>
        <th align=\"center\">Fecha</th>
        <th align=\"right\">Importe</th>
        <th align=\"center\"></th>
        <th align=\"center\">Reporte</th>
        </tr>
        </thead>
        <tbody>
        ";
        $tipox='';
        foreach($query->result() as $row)
        {
        $l1 = anchor('compra_c/imprime_d_his/'.$row->id, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir orden!', 'class' => 'encabezado'));
                 
        $tipox = $this->__actualiza_tipo($row->almacen,$tipox); 
            $tabla.="
            <tr>
             <td align=\"center\">".$tipox."</td>
            <td align=\"center\">".$row->id."</td>
            <td align=\"center\">".$row->prv."</td>
            <td align=\"left\">".$row->corto."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"right\">".number_format($row->importe,2)."</td>
            <td></td>
            <td align=\"center\">".$l1."</td>
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
    function pendiente()
    {
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-15 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

       $sql = "SELECT a.*,(canp-llegan) as faltan,b.prv,b.almacen,
       c.susa,gramaje,contenido,presenta,d.corto as prvx
       FROM orden_d a 
       left join orden b on b.id=a.id_cc
       left join catalogo.cat_nuevo_general c on c.codigo=a.codigo
       left join catalogo.provedor d on d.prov=b.prv
       where a.inv='S' and (canp-llegan)> 0 and a.fecha>='$nuevafecha' order by prv, clave";
        $query = $this->db->query($sql);


        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Almacen</th>
        <th>Orden</th>
        <th>Codigo</th>
        <th>Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"left\">Pedido</th>
        <th align=\"left\">Pendiente</th>
        <th align=\"left\">_</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        </tr>
        </thead>
        <tbody>
        ";
        $tipox='';
        foreach($query->result() as $row)
        {
        $tipox = $this->__actualiza_tipo($row->almacen,$tipox); 
           
            $tabla.="
            <tr>
             <td align=\"center\">".$tipox."</td>
            <td align=\"center\">".$row->id_cc."</td>
            <td align=\"center\">".$row->codigo."</td>
            <td align=\"left\">".$row->clave."</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"right\">".number_format($row->canp,0)."</td>
            <td align=\"right\">".number_format($row->faltan,0)."</td>
            <td align=\"left\"></td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            
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


    function control()
    {
       
       $this->db->select('a.*,b.razon');
       $this->db->from('compra_c a');
       $this->db->join('catalogo.compa b', 'a.cia=b.cia');
       $this->db->where('tipo',0);
       $query = $this->db->get();
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Orden</th>
        <th>Factura</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        <th align=\"left\" colspan=\"2\">Compa&ntilde;ia</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/detalle/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('compra_c/delete_c/'.$row->id, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar factura!', 'class' => 'encabezado'));
            $l3 = anchor('compra_c/cierre_c/'.$row->id.'/'.$row->orden.'/'.$row->almacen, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para cerrar factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->orden."</td>
            <td align=\"center\">".$row->factura."</td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            <td align=\"left\">".$row->cia."</td>
            <td align=\"left\">".$row->razon."</td>
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
       
       $this->db->select('a.*,b.*');
       $this->db->from('especialidad.compra_d a');
       $this->db->join('catalogo.cat_nuevo_general b', 'a.codigo=b.codigo');
       $this->db->where('id_cc',$id_cc);
       $this->db->group_by('lote,clave');
       $this->db->order_by('a.id desc');
       $query = $this->db->get();
        
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Clave</th>
        <th>Producto</th>
        <th>Costo</th>
        <th>Cantidad</th>
        <th>Regalo</th>
        <th>Lote</th>
        <th>Caducidad</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $totcan=0;
        $num=0;
        $totcanr = 0;
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/delete_d/'.$row->id.'/'.$id_cc, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar productos!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."<br /> ".$row->codigo."</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."
            <br />".$row->marca_comercial." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"left\">".number_format($row->costo,2)."</td>
            <td align=\"center\">".$row->can."</td>
            <td align=\"center\">".$row->canr."</td>
            <td align=\"center\">".$row->lote."</td>
            <td align=\"center\">".$row->caducidad."</td>
            <td align=\"center\">$l1</td>
            </tr>
            ";
        $totcan= $totcan + $row->can;
        $totcanr= $totcanr + $row->canr;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
            <td align=\"left\">Productos= $num</td>
            <td align=\"center\">TOTAL</td>
            <td align=\"center\">".$totcan."</td>
            <td align=\"center\">".$totcanr."</td>
        </tr>
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
    function control_historico()
    {
       
       $this->db->select('a.*,b.razon');
       $this->db->from('compra_c a');
       $this->db->join('catalogo.compa b', 'a.cia=b.cia');
       $this->db->where('tipo', 1);
       $this->db->order_by('fecha desc');
       $query = $this->db->get();
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th>Orden</th>
        <th>Factura</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        <th align=\"left\" colspan=\"2\">Compa&ntilde;ia</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/detalle_historico/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('compra_c/imprime_d/'.$row->id, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->orden."</td>
            <td align=\"center\">".$row->factura."</td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            <td align=\"left\">".$row->cia."</td>
            <td align=\"left\">".$row->razon."</td>
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
       $this->db->from('especialidad.compra_d a');
       $this->db->join('catalogo.cat_nuevo_general b', 'a.clave=b.clagob');
       $this->db->where('id_cc',$id_cc);
       $this->db->group_by('lote,clave');
       $query = $this->db->get();
        
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th colspan=\"5\">$tit</th>
        
        <tr>
        <th>Clave</th>
        <th>Producto</th>
        <th>Costo</th>
        <th>Cantidad</th>
        <th>Regalo</th>
        <th>Lote</th>
        <th>Caducidad</th>
        </tr>
        
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido."".$row->presenta."
            <br />".$row->marca_comercial." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"left\">".number_format($row->costo,2)."</td>
            <td align=\"center\">".$row->can."</td>
            <td align=\"center\">".$row->canr."</td>
            <td align=\"center\">".$row->lote."</td>
            <td align=\"center\">".$row->caducidad."</td>
            
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
function trae_datos_c($id_cc)
{
    $sql = "SELECT a.*  FROM compra_c a where a.id= ? ";
    $query = $this->db->query($sql,array($id_cc));
     return $query;
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////


function trae_datos_c_orden($id_cc)
{
    $sql = "SELECT a.*,b.corto,sum(canp*costo)as importe  FROM orden a 
    left join catalogo.provedor b on a.prv=b.prov 
    left join orden_d c on c.id_cc=a.id
    where a.id= ?
    group by a.id";
    $query = $this->db->query($sql,array($id_cc));
     return $query;
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function create_member_c_orden($prv,$tipo,$cia,$almacen)
{
 $new_member_insert_data = array(
			'prv' => $prv,
			'tipo' => $tipo,			
			'fecha'=> '0000-00-00',
            'cia'=> $cia,
            'almacen'=> $almacen				
		);
		
		$insert = $this->db->insert('orden', $new_member_insert_data);  
        $id_cc= $this->db->insert_id();
        $s1="insert into especialidad.orden_d(id_cc, clave, codigo, canp, fecha, costo)
(SELECT $id_cc,b.clagob,a.codigo,0,'0000-00-00',a.costo FROM catalogo.cat_nuevo_general_prv a
left join  catalogo.cat_nuevo_general b on a.codigo=b.codigo
where a.prv=$prv and b.clagob is not null)";
        $this->db->query($s1);
         
}
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function cierre_member_c_orden($id)
{
$s="delete from especialidad.orden_d where id_cc=$id and canp=0";

$this->db->query($s);
$dataf = array(
        'tipo'=>1,
        'fecha'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        $this->db->update('orden', $dataf);    
$dataf = array(
        'inv'=>'S',
        'fecha'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id_cc', $id);
        $this->db->update('orden_d', $dataf);    

}
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////insert y delete
function create_member_c($folio,$tipo,$cia,$factura,$almacen)
	{

$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-15 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

       $sql = "SELECT a.*,b.prv,c.corto as prvx FROM orden_d a
       left join orden b on b.id=a.id_cc
       left join catalogo.provedor c on c.prov=b.prv
       where a.canp>0 and a.llegan < a.canp and a.id_cc= ?  and a.fecha>='$nuevafecha' 
       
       group by id_cc";
        $query = $this->db->query($sql,array($folio));
        if($query->num_rows() > 0){
        
        $row= $query->row();
        $prv=$row->prv;    
        $prvx=$row->prvx;
        
        
        $sql1 = "SELECT * FROM compra_c where factura= ? and prv= ? and orden= ? ";
       $query1 = $this->db->query($sql1,array($factura,$prv,$folio));
       
       if($query1->num_rows()== 0 and $cia>0){
        
    //////////////////////////////////////////////inserta los datos en la base de datos
    	
        $new_member_insert_data = array(
			'orden' => $folio,
			'prv' => $prv,
			'prvx' => $prvx,
            'tipo' => $tipo,			
			'fecha'=> '0000-00-00:00:00',
            'factura'=> str_replace(' ', '',strtoupper(trim($factura))),
            'cia'=> $cia,
            'almacen'=> $almacen,
			'foliocxp' => 0						
		);
		
		$insert = $this->db->insert('compra_c', $new_member_insert_data);
	 	
	}

}
 return FALSE;
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

function create_member_d($id_cc,$orden,$codigo,$lote,$cad,$can,$canr,$costo)
	{
       
       $sql = "SELECT a.canp,a.costo,b.clagob,b.susa,marca_comercial,gramaje,contenido,presenta  FROM orden_d a, catalogo.cat_nuevo_general b
where b.codigo=$codigo and a.llegan < a.canp and a.id_cc= $orden  and (a.CANP-a.LLEGAN) >= $can
group by a.id_cc";
         $query = $this->db->query($sql);

        //echo $this->db->last_query();
        //die();
        
        
        if($query->num_rows() > 0){
        
        $row= $query->row();
        $cans=$row->canp;    
        $clave=$row->clagob;
        $descri=trim($row->marca_comercial).' '.trim($row->gramaje).' '.trim($row->contenido).' '.trim($row->presenta); 
        
        
        $sql1 = "SELECT * FROM compra_d where id_cc= ? and clave= ? and lote= ? ";
       $query1 = $this->db->query($sql1,array($id_cc,$clave,$lote));
       
       if($query1->num_rows()== 0){
       
    //////////////////////////////////////////////inserta los datos en la base de datos
    	//id, id_cc, clave, can, lote, caducidad, fecha, canp, aplica, costo, canr, codigo
        $new_member_insert_data = array(
			'id_cc' => $id_cc,
			'clave' => $clave,
            'lote' =>  str_replace('', '',strtoupper(trim($lote))),
            'caducidad' => $cad,
			'can' => $can,
			'fecha'=> date('Y-m-d H:s:i'),
            'canp'=> $cans,
            'costo'=> $costo,
            'canr'=> $canr,
            'codigo'=>$codigo,
            'descri'=>$descri
            						
		);
		$insert = $this->db->insert('compra_d', $new_member_insert_data);
		
	}

}
 return FALSE;
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c($id)
{
        $this->db->delete('compra_c', array('id' => $id));
        $this->db->delete('compra_d', array('id_cc' => $id));

}    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c_orden($id)
{
        $this->db->delete('orden', array('id' => $id));
        $this->db->delete('orden_d', array('id_cc' => $id, 'inv'=>'N'));
}    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

function delete_member_d($id)
{
        $this->db->delete('compra_d', array('id' => $id));

} 
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function cierre_member_c($id, $orden,$almacen)
{
    $this->__cierra_compra_c($id);


///*****
$sql0 = "SELECT * FROM compra_d where id_cc= ? and aplica='NO' ";
       $query0 = $this->db->query($sql0,array($id));
       foreach($query0->result() as $row0)
        {
       
        
        //////////////////////////////////////////////////////////////////inventario_d
        // clave, can, lote, caducidad
        
        $this->__actualiza_inventario_d($row0->id,$row0->clave, $row0->can,$row0->canr, $row0->lote, $row0->caducidad, $row0->codigo, $row0->descri);
        //////////////////////////////////////////////////////////////////compraped
        
        $this->__actualiza_compraped($orden, $row0->clave, $row0->can,$almacen,$row0->codigo);

        //////////////////////////////////////////////////////////////////
       }
///*****
//die();
//++++++++++++++++++++++++++++//++++++++++++++++++++++++++++/++++++++++++++++++++++++++++/++++++++++++++++++++++++++++/inv        
$scxp = "SELECT *from catalogo.foliador1 where clav='cxp' ";
        $qcxp = $this->db->query($scxp);
        if($qcxp->num_rows() >0){
        $rcxp= $qcxp->row();
        $folcxp=$rcxp->num;
        
        $dataf = array(
        'foliocxp'=> $folcxp
        );
        $this->db->where('id', $id);
        $this->db->update('compra_c', $dataf);
        
        $datacxp = array(
        'num'     => $folcxp+1
        );
        $this->db->where('clav', 'cxp');
        $this->db->update('catalogo.foliador1', $datacxp);  
        
        
        }
}
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
private function __cierra_compra_c($id)
{
    //Actualiza el tipo en compra_c para cerrar una factura
        $data = array(
			'tipo' => 1,
			'fecha'=> date('Y-m-d H:s:i')
		);
		
		$this->db->where('id', $id);
        $this->db->update('compra_c', $data);
        
        return $this->db->affected_rows();

}

private function __actualiza_inventario_d($id_d,$clave, $cantidad,$cantidadr, $lote, $caducidad,$codigo,$descri)
{
        $sql2 = "SELECT * FROM inventario_d where clave= ? and lote = ? ";
           $query2 = $this->db->query($sql2,array($clave,$lote));
           
           
       
           if($query2->num_rows()== 0){
                   $new_member_insert_data = array(
			       'clave' => $clave,
                   'lote' => $lote,
                   'caducidad' => $caducidad,
                   'codigo' => $codigo,
                   'descri' => $descri,
			       'cantidad' => $cantidad+$cantidadr
		           );
		
		  $insert = $this->db->insert('inventario_d', $new_member_insert_data);
          }else{
           $row2= $query2->row();
           $cantidad_existente = $row2->cantidad;
            
                  $data1 = array(
			      'cantidad' => $cantidad +$cantidadr + $cantidad_existente
			      );
		
		$this->db->where('clave', $clave);
        $this->db->where('lote', $lote);
        $this->db->update('inventario_d', $data1);     
        }
        
 ////////////////////////// actualiza compra_d para que no dupliquen existencia
$aplica_d='SI';
$data4 = array(
			  'aplica' => $aplica_d
			  );
		
		$this->db->where('id', $id_d);
        $this->db->update('compra_d', $data4);            
 //////////////////////////
    
}
private function __actualiza_compraped($orden, $clave, $cantidad,$almacen,$codigo)
{
        $sql3 = "SELECT * FROM orden_d where id_cc= ? and clave = ? ";
        $query3 = $this->db->query($sql3,array($orden, $clave));
        //echo $this->db->last_query();
        //die();
        $row3= $query3->row();
        $aplica= $row3->llegan;
        $data2 = array(
			      'llegan' => $aplica + $cantidad
			      );
		
		$this->db->where('id_cc', $orden);
        $this->db->where('clave', $clave);
        $this->db->update('orden_d', $data2);  
   
}
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_detalle_orden($id)
    {
        $imagen='<img src="img/28567.png" width="150" height="100" />';
        $respo='Veronica Rosales Garcia';
        
$text1='Le pedimos la caducidad minima de los productos de 12 meses';
$text2='Favor de incluir el numero de pedido en la factura <BR /><BR />
LA VIGENCIA DE LOS PEDIDOS SER&Agrave; DE 10 DIAS NATURALES A PARTIR DE LA FECHA GENERADA.DESPUES DE ESTA FECHA NO SE PODR&Agrave; RECIBIR NINGUN PEDIDO VENCIDO EN LOS ALMACENES.
';
        $num=0;$tocan=0;$impo=0;
        $sql = "SELECT a.*,b.*
        from orden_d a
        left join catalogo.cat_nuevo_general b on b.codigo=a.codigo
        where a.id_cc= ? order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th colspan=\"6\">____________________________________________________________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"70\"><strong>Clave</strong></th>
        <th width= \"100\"><strong>Codigo</strong></th>
        <th width= \"500\"><strong>Sustancia Activa</strong></th>
        <th width= \"80\" align=\"right\"><strong>Cantidad</strong></th>
        <th width= \"100\" align=\"right\"><strong>Costo</strong></th>
        <th width= \"100\" align=\"right\"><strong>Importe</strong></th>
        </tr>
        <tr>
        <th colspan=\"6\">____________________________________________________________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"70\" align=\"left\">".$row->clave."</td>
            <td width= \"100\" align=\"left\">".$row->codigo."</td>
            <td width= \"500\" align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td width= \"80\" align=\"right\">".$row->canp."</td>
            <td width= \"100\" align=\"right\">".number_format($row->costo,2)."</td>
            <td width= \"100\" align=\"right\">".number_format(($row->canp)*($row->costo),2)."</td>
            </tr>
            ";
        $tocan=$tocan+$row->canp;
        $impo=$impo+($row->canp)*($row->costo);
        $num=$num+1;
        }
        
        $tabla.="
        </tbody>
        <tr>
        <th colspan=\"6\">____________________________________________________________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"670\" align=\"left\"><strong>Total de productos.: $num</strong></td>
        <td width= \"80\" align=\"right\"><strong>".$tocan."</strong></td>
        <td width= \"100\" align=\"right\"></td>
        <td width= \"100\" align=\"right\"><strong>".number_format($impo,2)."<br /></strong></td>
        </tr>
        <tr>
        <th  width= \"950\" colspan=\"6\"  align=\"center\"><font size=\"+2\">ATENTAMENTE</font></th>
        </tr>
        <tr>
        <td  width= \"950\" colspan=\"6\"  align=\"center\">".$imagen."</td>
        </tr>
        <tr>
        <td  width= \"950\" colspan=\"6\"  align=\"center\"><strong>".$respo."</strong></td>
        </tr>
        
        <tr>
        <td  width= \"950\" colspan=\"6\"  align=\"left\">".$text1."</td>
        </tr>
        <tr>
        <td  width= \"950\" colspan=\"6\"  align=\"left\">".$text2."</td>
        </tr>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_detalle($id)
    {
        $tocan=0;
        $tocanr=0;
        $num=0;
        $sql = "SELECT a.*,b.*
        from compra_d a
        left join catalogo.cat_nuevo_general  b on a.codigo=b.codigo
        where a.id_cc= ? order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"7\">_____________________________________________________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"70\"><strong>Clave</strong></th>
        <th width= \"100\"><strong>Codigo</strong></th>
        <th width= \"450\"><strong>Sustancia Activa</strong></th>
        <th width= \"80\" align=\"left\"><strong>Lote</strong></th>
        <th width= \"80\" align=\"right\"><strong>Caducidad</strong></th>
        <th width= \"60\" align=\"right\"><strong>Cantidad</strong></th>
        <th width= \"60\" align=\"right\"><strong>Regalo</strong></th>
        </tr>
        <tr>
        <th colspan=\"7\">_____________________________________________________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"70\" align=\"left\">".$row->clave."</td>
            <td width= \"100\" align=\"left\">".$row->codigo."</td>
            <td width= \"450\" align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."
            <br />".$row->marca_comercial." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td width= \"80\" align=\"left\">".$row->lote."</td>
            <td width= \"80\" align=\"right\">".$row->caducidad."</td>
            <td width= \"60\" align=\"right\">".$row->can."</td>
            <td width= \"60\" align=\"right\">".$row->canr."</td>
            
            
            </tr>
            ";
        $tocan=$tocan+$row->can;
        $tocanr=$tocanr+$row->canr;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"7\">_____________________________________________________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"780\" align=\"left\">Total de productos.: $num</td>
        <td width= \"60\" align=\"right\">".$tocan."</td>
        <td width= \"60\" align=\"right\">".$tocanr."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_control($fecha)
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT * from compra_c where tipo=1 and date_format(fecha, '%Y-%m-%d')= ?
        order by id";
        
        $query = $this->db->query($sql,array($fecha));
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"6\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"80\" align=\"center\"><strong>Cia</strong></th>
        <th width= \"90\" align=\"center\"><strong>Foliocxp</strong></th>
        <th width= \"90\" align=\"left\"><strong>Factura</strong></th>
        <th width= \"90\" align=\"center\"><strong>Prv</strong></th>
        <th width= \"145\" align=\"left\"><strong>Proveedor</strong></th>
        <th width= \"111\" align=\"right\"><strong>Orden de Compra</strong></th>
        </tr>
        <tr>
        <th colspan=\"6\">_________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"80\" align=\"center\">".$row->cia."</td>
            <td width= \"90\" align=\"center\">".$row->foliocxp."</td>
            <td width= \"90\" align=\"left\">".$row->factura."</td>
            <td width= \"90\" align=\"center\">".$row->prv."</td>
            <td width= \"145\" align=\"left\">".$row->prvx."</td>
            <td width= \"111\" align=\"right\">".$row->orden."</td>
            
            
            </tr>
            ";
        
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"6\">_________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"530\" align=\"left\">Total de Facturas.: $num</td>
        
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
}