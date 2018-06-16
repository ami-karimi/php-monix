   <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php asset('js/jquery.js');?>"></script>
    <script src="<?php asset('js/jquery-1.8.3.min.js');?>"></script>
    <script src="<?php asset('js/bootstrap.min.js');?>"></script>
    <script src="<?php asset('js/jquery.scrollTo.min.js');?>"></script>
    <script src="<?php asset('js/jquery.nicescroll.js');?>" type="text/javascript"></script>
    <script src="<?php asset('js/jquery.sparkline.js');?>" type="text/javascript"></script>
    <script src="<?php asset('js/owl.carousel.js');?>" ></script>
    <script src="<?php asset('js/jquery.customSelect.min.js');?>" ></script>
    <script type="text/javascript" src="<?php asset('assets/bootstrap-fileupload/bootstrap-fileupload.js');?>"></script>
    <script type="text/javascript" src="<?php asset('assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js');?>"></script>
	<script type="text/javascript" src="<?php asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js');?>"></script>
	<!--common script for all pages-->
    <script src="<?php asset('js/common-scripts.js');?>"></script>
    <script src="<?php asset('js/sweetalert.min.js');?>"></script>
    <!--script for this page-->
	<script>
	 var ajax_url = '<?=Mo_url('?ajax=');?>';
	 </script>
	 
    <script src="<?php asset('js/novinCompany.js');?>"></script>
	<script src="<?php asset('assets/fancybox/source/jquery.fancybox.js');?>"></script>
  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

    $('.wysihtml5').wysihtml5();

  </script>
  <?php $hooks->do_action('Footer_Admin');?>
  <?php if(isset($msg)){echo $msg;}?>
  <div id="result_show" > </div>
  </body>
</html>