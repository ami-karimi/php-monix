     <section id="main-content">
  
     <section class="wrapper">
	  
	 
	    <div class="col-lg-12">
         <section class="panel">
		 
		 <header class="panel-heading"> 
                         مدیریت پلاگین ها
						    <div class="row">
							 <div class="col-lg-3 pull-left">
							 <a data-target="#show_models" data-toggle="modal" href="javascript:void(0)" class="btn btn-success">بارگذاری افزونه</a>
							  <a target="_blank" href="http://forum.munix.ir/index.php?forums/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%D9%87%D8%A7%DB%8C-%D9%85%D9%88%D9%86%DB%8C%DA%A9%D8%B3.7/"  class="btn btn-primary">فروشگاه افزونه</a>
							 </div>
							</div>
                            </header>
		<div class="panel-body">	
         <?php if(isset($msg_install)){ echo $msg_install;}?>		
     	 <table class="table table-striped table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" /></th>									
                                        <th>نام پلاگین</th>
                                        <th>توضیحات</th>
                                        <th></th> 
                                        <th></th>  	
                                        <th></th>	  
                                        <th></th>	
                                        <th></th>	 	 										
                                    </tr>
                                </thead>
                                <tbody>  
                                  <?php $plugin->Get_plugin(); ?>
		                         </tbody> 
                                </table>	     
	     
	                       <?php $plugin->Get_Paging();?>
	     </div>
		 
		 
	     <section>
	   </div>


         <div id="show_models" class="modal fade" role="dialog">
             <div class="modal-dialog">

                 <!-- Modal content-->
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">×</button>
                         <h4 class="modal-title">ایجاد کاربر جدید</h4>

                     </div>
                     <div class="modal-body">

                         <form method="POST" enctype="multipart/form-data"  action="?">

                             <div class="form-group">
                                 <label>  انتخاب فایل </label>
                                 <input class="form-control" name="file" type="file" placeholder="نام کاربر">
                             </div>


                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                         <button type="submit"  data-id="3" class="btn btn-send-message btn-primary">بارگذاری</button>
                         </form>
                     </div>
                 </div>

             </div>
         </div>


	 </section> <!--/.wrapper-->
	 
   </section> <!--/.main-content-->
   

