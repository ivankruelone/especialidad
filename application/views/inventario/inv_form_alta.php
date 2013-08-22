  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
    <p><strong><?php echo $tit;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'inv_form_alta');
    echo form_open('inventario/insert_d_inv', $atributos);
    $data_clave = array(
              'name'        => 'clave',
              'id'          => 'clave',
              'value'       => '',
              'maxlength'   => '6',
              'size'        => '6',
              'autofocus'   => 'autofocus'
            );
    $data_cantidad = array(
              'name'        => 'can',
              'id'          => 'can',
              'value'       => '',
              'maxlength'   => '7',
              'size'        => '7'
            );
    $data_lote = array(
              'name'        => 'lote',
              'id'          => 'lote',
              'value'       => '',
              'maxlength'   => '20',
              'size'        => '20'
            );
    $data_caducidad = array(
              'name'        => 'cad',
              'id'          => 'cad',
              'value'       => '',
              'maxlength'   => '10',
              'size'        => '12',
              'type'        => 'date'
            );
  ?>
  
  <table>
 <tr>
	<td>Clave: </td>
	<td><?php echo form_input($data_clave, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td>Cantidad: </td>
	<td><?php echo form_input($data_cantidad, "", 'required');?><span id="mensaje"></span></td>
</tr>

<tr>
	<td>Lote: </td>
	<td><?php echo form_input($data_lote, "", 'required');?><span id="mensaje"></span></td>
</tr>

<tr>
	<td>Caducidad: </td>
	<td><?php echo form_input($data_caducidad, "", 'required');?>A&Ntilde;O-MES-DIA<span id="mensaje"></span></td>
</tr>
	<td colspan="2"><?php echo form_submit('envio', 'grabar producto');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $suc?>" name="suc" id="suc" />
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
    
    $('#clave').blur(function(){
            var clave = $('#clave').attr("value"); 
        
    });
    


    $('#inv_form_alta').submit(function() {
        
        var clave = $('#clave').attr("value");
        
         
    	  if(clave >0 ){
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