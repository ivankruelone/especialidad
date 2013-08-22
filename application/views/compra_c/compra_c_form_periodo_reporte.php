  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'compra_c_form_periodo_reporte');
    echo form_open('compra_c/imprime_concentrado', $atributos);
    $data_fecha = array(
              'name'        => 'fecha',
              'id'          => 'fecha',
              'value'       => '',
              'maxlength'   => '12',
              'size'        => '12',
              'type'        => 'date',
              'autofocus'   => 'autofocus'
            );
   ?>
  
  <table>
 <tr>
	<td>Escribe Fecha: </td>
	<td><?php echo form_input($data_fecha, "", 'required');?><span id="mensaje"></span></td>
</tr>


	<td colspan="2"><?php echo form_submit('envio', 'IMPRIME');?></td>
</tr>
</table>
<input type="hidden" value="0" name="valida" id="valida" />
  <?php
	echo form_close();
  ?>


</div>    
  <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#fecha").focus();
    });
    
    $(document).ready(function(){
    
    $('#fecha').blur(function(){
            var folio = $('#fecha').attr("value"); 
     });
 
 

    $('#compra_c_form_periodo_reporte').submit(function() {
        
        var fecha = $('#fecha').attr("value").length;
         
    	  if(fecha ==10 ){
    	    
    	  }else{

    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>