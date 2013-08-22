  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'pedido_c_form');
    echo form_open('pedido/insert_c', $atributos);
 
  ?>
  
  <table>
<tr>
	<td>sucursal: </td>
	<td align="left"><?php echo form_dropdown('suc', $sucx, '', 'id="suc"') ;?> </td>
</tr>

 

	<td colspan="2"><?php echo form_submit('envio', 'GENERAR PEDIDO');?></td>
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
     
    $(document).ready(function(){
    
  
 


    $('#pedido_c_form').submit(function() {
        
        var suc = $('#suc').attr("value");
        
         
    	  if(suc >0 ){
    	
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