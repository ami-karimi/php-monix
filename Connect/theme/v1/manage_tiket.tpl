  {include file="header.tpl" }  
  <div class="col-lg-10 col-md-10 col-sm-10 " style="padding: 0;">
  
    <ol class="breadcrumb">
     <li><a href="/">خانه</a></li>
     <li><a >مديريت درخواست ها</a></li>
	 <li><a class="active"><?=$page_title;?></a></li>
   </ol>

   
  <div class="content-page">

 
  <!-- Table -->
  <table class="table">
  <thead>
    <tr> 
	  <th>کد - موضوع</th> 
	  <th class="hidden-xs">دپارتمان</th> 
	  <th class="hidden-xs">اخرين بروزرساني</th> 	  
	  <th>آخرين پاسخ از</th> 	
	  <th>وضعيت</th> 	  	
	  <th class="hidden-xs">عمليات</th> 		  
	  </tr> 
	  </thead> 
	  <tbody> 
       {foreach $tiket as $row}
		 <tr> 
		    <td class="fa-number"><a class="btn btn-xs btn-primary" href="?route=show_tiket&tiket_code={$row.tk_code}">{$row.tk_code}#-{$row.tk_title}</a></td>
		    <td  class="fa-number hidden-xs">{$row.dep_title}</td>
		    <td  class="fa-number hidden-xs">{$row.tk_timestamp_res}</td> 
		    <td >{last_massage($row.tk_last_req)}</td> 			
		    <td >{state_tiket($row.tk_state)}</td> 
		    <td  class="hidden-xs"><a href="?route=show_tiket&tiket_code={$row.tk_code}" class="btn btn-xs btn-danger">مشاهده</a></td>			
         </tr>		 
		   
	  {/foreach}
	  </tbody> 
	  </table>
  
      {$pages->page_links('?route=manage_tiket&')}



  </div> 
  <!-- Content --> 
  
  </div>


   {include file="footer.tpl" }