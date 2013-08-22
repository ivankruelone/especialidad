<!-- Add class .fixed for fixed layout. You would need also edit CSS file for width -->
<body>

	<!-- Fixed Layout Wrapper -->
	<div class="fixed-wraper">

	<!-- Aside Block -->
	<section role="navigation">

        <?php $this->load->view('head/titulo');?>

        <?php $this->load->view('head/usuario');?>

        <?php $this->load->view('head/menu');?>
        
        <?php 
        
        if(isset($sidebar))
        {
        $this->load->view($sidebar);
        }
        
        ?>
		
	</section>
	<!-- /Aside Block -->
		
	
	<!-- Main Content -->
	<section role="main">
	
        <?php 
        
        if(isset($widgets))
        {
        $this->load->view($widgets);
        }
        
        ?>

        <?php 
        
        if(isset($dondeestoy))
        {
        $this->load->view($dondeestoy);
        }
        
        ?>
		
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2><?php echo $titulo;?></h2>
					<!-- Article Header Tab Navigation -->
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
				
				<?php $this->load->view($contenido);?>
					
				</section>
				<!-- /Article Content -->
                
                <?php $this->load->view('main/footer')?>
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Full Content Block -->
	
	</section>
	<!-- /Main Content -->
	
	</div>
	<!-- /Fixed Layout Wrapper -->

	<!-- JS Libs at the end for faster loading -->
	<script src="<?php echo base_url();?>js/libs/selectivizr.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.nyromodal.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.tipsy.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.wysiwyg.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.datatables.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.datepicker.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.fileinput.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.fullcalendar.min.js"></script>
	<script src="<?php echo base_url();?>js/jquery/excanvas.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.visualize.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.visualize.tooltip.js"></script>
	<script src="<?php echo base_url();?>js/script.js"></script>
    

	
	<script>
		var _gaq=[['_setAccount','UA-XXXXXXX'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>