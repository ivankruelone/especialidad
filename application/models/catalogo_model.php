<?php
	class Catalogo_model extends CI_Model {

    function productos()
    {
        $sql = "SELECT * FROM catalogo.cat_nuevo_general  order by clagob";
        $query = $this->db->query($sql);
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Clave</th>
        <th>Codigo</th>
        <th></th>
        <th>Sustancia Activa</th>
        <th>Laboratorio</th>
        <th>Registro San</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            //$l1 = anchor('catalogo/cambiar_accesorio/'.$row->id, '<img src="'.base_url().'img/edit.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para modificar productos!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clagob."</td>
            <td align=\"center\">".$row->codigo."</td>
            <td align=\"center\">_</td>
            <td align=\"left\">".$row->susa." ".$row->gramaje." ".$row->contenido." ".$row->presenta."</td>
            <td align=\"center\">".$row->lab."</td>
            <td align=\"left\">".$row->registro."</td>
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////    
/////////////////////////////////////////////////////////////////
function trae_datos($clave){
    $sql = "SELECT *  FROM catalogo.cat_nuevo_general where clagob= ? ";
    $query = $this->db->query($sql,array($clave));
     return $query;
    }
/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_sucursal()
	{
		$sql = "SELECT suc,nombre FROM  catalogo.sucursal where suc=175 or suc=176 or suc=177 or suc=178 or 
        suc=179 or suc=180 or suc=181 or suc=103 or suc=108 or suc=107 or suc=141 or suc=105 or suc=102 or 
        suc=109 OR SUC=17000 OR SUC=14000 OR SUC=16000 or suc=106 or suc=187 order by nombre";
        $query = $this->db->query($sql);
        
        $suc = array();
        $suc[0] = "Selecciona una Sucursal";
        
        foreach($query->result() as $row){
            $suc[$row->suc] = $row->nombre." - ".$row->suc;
        }
        
        
        return $suc;
	} 
  /////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_sucursal_dev()
	{
		$sql = "SELECT suc,nombre FROM  catalogo.sucursal where suc=99990 or suc=100 or suc=177 or suc=178 or suc=179 or suc=180 or suc=181 or suc=103 or suc=108 or suc=107 or suc=141 or suc=105 or suc=102 or suc=109 order by suc";
        
        $query = $this->db->query($sql);
        
        $suc = array();
        $suc[0] = "Selecciona una Sucursal";
        
        foreach($query->result() as $row){
            $suc[$row->suc] = $row->nombre." - ".$row->suc;
        }
        
        
        return $suc;
	}   
/////////////////////////////////////////////////////////////
 function busca_suc_unica($suc)
    {
      $sql = "SELECT  nombre FROM  catalogo.sucursal where suc = ?";
    $query = $this->db->query($sql,array($suc));
    $row= $query->row();
    $sucx=$row->nombre;
     return $sucx; 
    }

///////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_almacen()
	{
		$sql = "SELECT *from catalogo.cat_almacenes";
        $query = $this->db->query($sql);
        
        $alm = array();
        $alm[0] = "Selecciona un Almacen";
        
        foreach($query->result() as $row){
            $alm[$row->tipo] = $row->nombre;
        }
        
        
        return $alm;
	} 
  /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_prv()
	{
		$sql = "SELECT *from catalogo.cat_nuevo_general_prv a left join catalogo.provedor b on b.prov=a.prv
        group by prv";
        $query = $this->db->query($sql);
        
        $var = array();
        $var[0] = "Selecciona un Proveedor";
        
        foreach($query->result() as $row){
            $var[$row->prov] = $row->corto;
        }
        
        
        return $var;
	} 
/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_orden($id)
	{
		$sql = "SELECT a.*,b.*,c.razon as razof, c.dire as diref, c.pobla as poblaf, c.col as colf,c.cp as cpf, c.rfc as rfcf from orden a 
        left join catalogo.provedor b on b.prov=a.prv
        left join catalogo.compa c on c.cia=a.cia
        where a.id=$id
        group by prv";
        $query = $this->db->query($sql);
        
        return $query;
	} 
  /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////     

  /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////     
}