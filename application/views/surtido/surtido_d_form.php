    <p><strong><?php echo $tit;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'surtido_d_form');
    echo form_open('surtido/insert_d', $atributos);
    $data_clave = array(
              'name'        => 'clave',
              'id'          => 'clave',
              'value'       => '',
              'maxlength'   => '10',
              'size'        => '10',
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
	<td>Clave: </td>
	<td><?php echo form_input($data_clave, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
	<td>Lote: </td>
	<td align="left">
    <select name="lotex" id="lotex">
      
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
<div id="lokote"></div>
</div>    
   <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#clave").focus();
    }); 
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
    $('#clave').blur(function(){
     var clave = $('#clave').attr("value"); 
     var id_cc = $('#id_cc').attr("value"); 
  
  if(clave > ' '){
            $.post("<?php echo site_url();?>/surtido/busca_lote/", { clave: clave, id_cc: id_cc }, function(data){
                if(data == '0'){
                    alert('La clave ' + clave + ' no tiene existencia o no fue solicitada en el pedido.');
                    $('#clave').val('').focus();
                }else{
                
            $("#lotex").html(data);
            $('#lotex').focus();
            }
             });
             }
  });
 
      $('#can').blur(function(){
     var can = $('#can').attr("value"); 
     var clave = $('#clave').attr("value");
     var lotex = $('#lotex').attr("value");
  
  if(can > 0){
///////////////////////////////
            $.post("<?php echo site_url();?>/surtido/busca_can/", { clave : clave, lotex : lotex, can: can  }, function(data1){
            if(data1 == '0'){
            alert("La cantidad capturada es mayor a la existente");
            $('#can').val('').focus();
            var can = $('#can').attr("value");   
            }
            });
///////////////////////////////            
            $.post("<?php echo site_url();?>/surtido/busca_canped/", { clave : clave, can: can  }, function(data0){
            if(data0 == '0'){
            alert("La cantidad capturada es mayor a la solicitada");
            }
            });
///////////////////////////////

             }


});
  ///////////////////////////////////////////////////////////////////////  


    $('#surtido_d_form').submit(function() {
        
        var clave = $('#clave').attr("value").length;
        var can = $('#can').attr("value").length;
    	  if(clave >0 && can>0 ){
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