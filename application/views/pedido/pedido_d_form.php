  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
    <p><strong><?php echo $tit;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'pedido_d_form');
    echo form_open('pedido/insert_d', $atributos);
    $data_clave = array(
              'name'        => 'clave',
              'id'          => 'clave',
              'value'       => '',
              'maxlength'   => '20',
              'size'        => '20',
              'autofocus'   => 'autofocus'
            );
    $data_cantidad = array(
              'name'        => 'can',
              'id'          => 'can',
              'value'       => '',
              'maxlength'   => '7',
              'size'        => '7'
            );

  ?>
  
  <table>
 <tr>
	<td>Marca: </td>
	<td><?php echo form_input($data_clave, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td align="left" ><font size="+1">Producto: </font></td>
    <td align="left">
    <select name="codigo" id="codigo">
    </select>
    </td>
</tr>
<tr>
	<td>Cantidad: </td>
	<td><?php echo form_input($data_cantidad, "", 'required');?><span id="mensaje"></span></td>
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
    
    
    $(document).ready(function(){
///////////////////////////////////////////////////////////////////////            
        function enter2tab(e) { 
       if (e.keyCode == 13) { 
           cb = parseInt($(this).attr('tabindex')); 
     
           if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) { 
               $(':input[tabindex=\'' + (cb + 1) + '\']').focus(); 
               $(':input[tabindex=\'' + (cb + 1) + '\']').select(); 
               e.preventDefault(); 
     
               return false; 
           } 
       } 
   }
///////////////////////////////////////////////////////////////////////    
    
    $('#clave').change(function(){
    clave = $('#clave').attr("value"); 
 if(clave > '  '){
  $.post("<?php echo site_url();?>/pedido/busca_producto/", { clave: clave}, function(data) {
  $("#codigo").html(data);

  }
  );
   }
   
   }); 

    $('#pedido_d_form').submit(function() {
        
        var clave = $('#clave').attr("value").length;
        var can = $('#can').attr("value");
        
         
    	  if(clave >0 && can>0 ){
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