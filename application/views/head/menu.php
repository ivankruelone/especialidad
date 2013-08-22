		<?php
        //" class=\"current\"";
        $nivel = $this->session->userdata('nivel');
        if(!isset($menu))$menu = null;
        if(!isset($submenu))$submenu = null;
        ?>
        
        <!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
                <li<?php if($menu == "productos")echo ' class="current"';?>><?php echo anchor('welcome', 'Productos' , 'class="products"')?>
                    <ul>
                        <li><?php echo anchor('welcome', 'Catalogo Completo')?></li>
                    </ul>
                </li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
  		<?php
        if($nivel==2 || $nivel==1){
        ?>              
				<li<?php if($menu == "compra")echo ' class="current"';?>>
					<?php echo anchor('Compra', 'Compra' , 'class="dashboard"')?><span title="You have 3 new tasks">4</span>
                    <ul>
                        <li><?php echo anchor('compra_c/tabla_orden', 'Nueva Orden')?></li>
                        <li><?php echo anchor('compra_c/tabla_pendiente', 'Orden de Compra')?></li>
                        <li><?php echo anchor('compra_c/tabla_orden_his', 'Historico Orden')?></li>
						<li><?php echo anchor('compra_c/tabla_control', 'Facturas')?></li>
                        <li><?php echo anchor('compra_c/tabla_control_historico', 'Historico')?></li>
                        <li><?php echo anchor('compra_c/periodo_reporte', 'Reporte por Dia')?></li>
                    </ul>
				</li>
                
        <?php
        }
        if($nivel==3 || $nivel==1){
        ?>              
                
                
                <li<?php if($menu == "pedido")echo ' class="current"';?>>
					<?php echo anchor('pedido', 'Pedido', 'class="dashboard"')?><span title="You have 3 new tasks">2</span>
					<ul>
						<li><?php echo anchor('pedido/tabla_control', 'Generar pedido')?></li>
						<li><?php echo anchor('pedido/tabla_control_historico', 'Pedidos Pendientes')?></li>
                        <li><?php echo anchor('pedido/tabla_control_historico_s', 'Historico de Pedidos')?></li>
					</ul>
				</li>
        <?php
        }
        if($nivel==5 || $nivel==1 || $nivel==4){
        ?>    
                
                
                <li<?php if($menu == "surtido")echo ' class="current"';?>>
					<?php echo anchor('surtido', 'Surtido', 'class="dashboard"')?><span title="You have 3 new tasks">2</span>
					<ul>
						<li><?php echo anchor('surtido/tabla_control', 'Surtido de Productos')?></li>
						<li><?php echo anchor('surtido/tabla_control_historico', 'Historico de Surtido')?></li>
					</ul>
				</li>
                
               
        <?php
        }
        
        if($nivel==4 || $nivel==1){
        ?> 
                 <li<?php if($menu == "inventario")echo ' class="current"';?>>
					<?php echo anchor('inventario', 'Inventario', 'class="dashboard"')?><span title="You have 2 new tasks">2</span>
					<ul>
						<li><?php echo anchor('inventario/tabla_control', 'Inventario')?></li>
						<li><?php echo anchor('inventario/tabla_detalle', 'Inventario por lotes')?></li>
					</ul>
				</li>
				<li<?php if($menu == "devolucion")echo ' class="current"';?>>
					<?php echo anchor('devolucion', 'Devolucion', 'class="dashboard"')?><span title="You have 2 new tasks">2</span>
                    
					<ul>
						<li><?php echo anchor('Devolucion/tabla_control', 'Devolucion')?></li>
						<li><?php echo anchor('Devolucion/tabla_control_historico', 'Devolucion historico')?></li>
					</ul>
				</li>
                <li<?php if($menu == "traspaso")echo ' class="current"';?>>
                <?php echo anchor('traspaso', 'Traspaso', 'class="dashboard"')?><span title="You have 2 new tasks">2</span>
					<ul>
						<li><?php echo anchor('traspaso/tabla_control', 'Traspaso')?></li>
						<li><?php echo anchor('traspaso/tabla_control_historico', 'Traspaso historico')?></li>
					</ul>
				</li>
				
    <?php
        }
        
        ?>             
                <li>
                <?php echo anchor('login/logout', 'Salir del Sistema', 'class="no-submenu"')?>
				</li>
                
 			</ul>
		</nav>
		<!-- /Main Navigation -->