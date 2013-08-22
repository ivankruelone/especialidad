  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'orden_c_form');
    echo form_open('compra_c/insert_c_orden', $atributos);
    $data_orden = array(
              'name'        => 'folio',
              'id'          => 'folio',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
              'autofocus'   => 'autofocus'
            );
            $data_factura = array(
              'name'        => 'factura',
              'id'          => 'factura',
              'value'       => '',
              'maxlength'   => '20',
              'size'        => '20'
            );
              $data_cia = array(
              'name'        => 'cia',
              'id'          => 'cia',
              'value'       => '',
              'maxlength'   => '2',
              'size'        => '2'
            );
 
  ?>
  
  <table>
 
 <tr>
     <td align="left" ><font size="+1">PRV: </font></td>
   <td colspan="3" align="center" ><?php echo form_dropdown('prv', $prv, '', 'id="prv"') ;?> </td> 
</tr>
 <tr>
     <td align="left" ><font size="+1">ALMACEN: </font></td>
   <td colspan="3" align="center" ><?php echo form_dropdown('almacen', $almacen, '', 'id="almacen"') ;?> </td> 
</tr>

<tr>
	<td>Tipo:</td>
    <td align="left"> 
    <select name="cia" id="cia">
    <option value="0" >Seleccionar Compa&ntilde;ia</option>
    <option value="1" >FARMACIAS EL FENIX</option>
    <option value="13" >FARMACIA DE GENERICOS</option>
    </select>
    </td>
</tr>

	<td colspan="2"><?php echo form_submit('envio', 'NUEVA ORDEN');?></td>
</tr>
</table>
<input type="hidden" value="0" name="valida" id="valida" />
  <?php
	echo form_close();
  ?>
<table align="center">
<tr>
	<td><?php echo $tabla;?></td>
</tr>
</table>

</div>    
  <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#prv").focus();
    });
    
    $(document).ready(function(){
    
    $('#prv').blur(function(){
            var prv = $('#prv').attr("value"); 
     });
 
   


    $('#orden_c_form').submit(function() {
        
        var prv = $('#prv').attr("value");
        var cia = $('#cia').attr("value");
         
    	  if(prv >0 && cia > 0){
    	    echo ;
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion de producto por favor');
    	    $('#clave').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>