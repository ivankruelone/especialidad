  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
    <p><strong><?php echo $tit;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'compra_d_form');
    echo form_open('compra_c/insert_d', $atributos);
    $data_codigo = array(
              'name'        => 'codigo',
              'id'          => 'codigo',
              'value'       => '',
              'maxlength'   => '14',
              'size'        => '14',
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
        $data_cantidadr = array(
              'name'        => 'canr',
              'id'          => 'canr',
              'value'       => '',
              'maxlength'   => '7',
              'size'        => '7'
            );
 $data_costo= array(
              'name'        => 'costo',
              'id'          => 'costo',
              'value'       => '',
              'maxlength'   => '7',
              'size'        => '7'
            );
  ?>
  
  <table>
 <tr>
	<td>Codigo de Barras: </td>
	<td><?php echo form_input($data_codigo, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td>Cantidad: </td>
	<td><?php echo form_input($data_cantidad, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td>Cantidad sin costo: </td>
	<td><?php echo form_input($data_cantidadr, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td>Lote: </td>
	<td><?php echo form_input($data_lote, "", 'required');?><span id="mensaje"></span></td>
</tr>

<tr>
	<td>Caducidad: </td>
	<td><?php echo form_input($data_caducidad, "", 'required');?>A&Ntilde;O-MES-DIA<span id="mensaje"></span></td>
</tr>
<tr>
	<td>Costo: </td>
	<td><?php echo form_input($data_costo, "", 'required');?><span id="mensaje"></span></td>
</tr>
	<td colspan="2"><?php echo form_submit('envio', 'grabar producto');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $id_cc?>" name="id_cc" id="id_cc" />
<input type="hidden" value="<?php echo $orden?>" name="orden" id="orden" />
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
    


    $('#compra_d_form').submit(function() {
        
        var clave = $('#clave').attr("value").length;
        
         
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