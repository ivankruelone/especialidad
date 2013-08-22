<?php
	class Envio_model extends CI_Model {

    function devolucion()
    {
        $sql = "SELECT * FROM farmabodega.archivo";
        $query = $this->db->query($sql);
        
        
        
        //titulos//
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Orden</th>
        <th>Factura</th>
        <th>Prv</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            ////campos
            
            $tabla.="
            <tr>
            <td align=\"center\">".$row->orden."</td>
            <td align=\"center\">".$row->factura."</td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"center\">".$row->prvx."</td>
            <td align=\"left\">".$row->fecha."</td>
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
}