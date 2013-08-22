  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'compra_c_form');
    echo form_open('compra_c/insert_c', $atributos);
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
	<td>Busca orden de compra: </td>
	<td><?php echo form_input($data_orden, "", 'required');?><span id="mensaje"></span></td>
</tr>
 <tr>
     <td align="left" ><font size="+1">ALMACEN: </font></td>
   <td colspan="3" align="center" ><?php echo form_dropdown('almacen', $almacen, '', 'id="almacen"') ;?> </td> 
</tr>
<tr>
	<td>Factura: </td>
	<td><?php echo form_input($data_factura, "", 'required');?><span id="mensaje"></span></td>
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

	<td colspan="2"><?php echo form_submit('envio', 'TRAER ORDEN');?></td>
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
        $("#folio").focus();
    });
    
    $(document).ready(function(){
    
    $('#folio').blur(function(){
            var folio = $('#folio').attr("value"); 
     });
 
 $('#factura').blur(
        function()
        {
            $('#factura').val($('#factura').attr("value").toUpperCase());
        }
    );   


    $('#compra_c_form').submit(function() {
        
        var folio = $('#folio').attr("value");
        var cia = $('#cia').attr("value");
         
    	  if(folio >0 && cia > 0){
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