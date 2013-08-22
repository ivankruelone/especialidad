  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'devolucion_c_form');
    echo form_open('devolucion/insert_c', $atributos);
 
  ?>
  
  <table>


<tr>
	<td align="left" ><font size="+1">SELE: </font></td>
 <td colspan="3" align="center" ><?php echo form_dropdown('sale', $sale, '', 'id="sale"') ;?> </td>

    <td align="left" ><font size="+1">ENTRA: </font></td>
   <td colspan="3" align="center" ><?php echo form_dropdown('entra', $entra, '', 'id="entra"') ;?> </td> 
    </td>
    <td align="left" ><font size="+1">TIPO: </font></td>
    <td align="left"> 
    <select name="tipo" id="tipo">
    <option value="0" <?php if($tipo=='0') echo "Selected"?> >selecciona tipo</option>
    <option value="1" <?php if($tipo=='1') echo "Selected"?> >EXCEDENTE</option>
    <option value="2" <?php if($tipo=='2') echo "Selected"?> >NO SOLICITADO</option>
    <option value="3" <?php if($tipo=='3') echo "Selected"?> >MAL ESTADO</option>
    <option value="4" <?php if($tipo=='4') echo "Selected"?> >PROXIMO A CADUCAR</option>
    <option value="5" <?php if($tipo=='5') echo "Selected"?> >CADUCADO</option>
    </select>
    </td>
    
</tr>
 

	<td colspan="4" align="center"><?php echo form_submit('envio', 'GENERAR DEVOLUCION');?></td>
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
   <script language="javascript" type="text/javascript">
   $(window).load(function () {
        $("#sale").focus();
    });
    $(document).ready(function(){
    
  
 


    $('#devolucion_c_form').submit(function() {
        
        var sale = $('#sale').attr("value");
        alert(sale)
         
    	  if(sale >0 && entra>0 ){
    	
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