  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
    
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'traspaso_d_form');
    echo form_open('traspaso/insert_d', $atributos);
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
    $data_cad = array(
              'name'        => 'cad',
              'id'          => 'cad',
              'value'       => '',
              'maxlength'   => '10',
              'size'        => '10'
            );

  ?>
  
  <table>
<tr>
<th colspan="4" align="left"><p><strong><?php echo $tit;?></strong></p></th>
</tr>
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
	<td><?php echo form_input($data_cad, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td colspan="2"><?php echo form_submit('envio', 'grabar producto');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $id_cc?>" name="id_cc" id="id_cc" />

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
        $("#clave").focus();
    });  
    
    $(document).ready(function(){
        
    
    $('#clave').blur(function(){
            var clave = $('#clave').attr("value"); 
        
    });
    


    $('#traspaso_d_form').submit(function() {
        
         var clave = $('#clave').attr("value");
         var can = $('#can').attr("value");
         var lote = $('#lote').attr("value").length;
         var cad = $('#cad').attr("value").length;
        
        
    	  if(clave >0 && can>0 && lote>0 && cad=10){
    	   
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