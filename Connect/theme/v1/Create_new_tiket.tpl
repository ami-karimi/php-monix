	{include file="header.tpl" title=""}     
	
 
  <div class="col-lg-10 col-md-10 col-sm-10" style="padding: 0;">
  
	 <ol class="breadcrumb">
     <li><a href="/">خانه</a></li>
     <li><a href="#" >مديريت درخواست ها</a></li>
     <li><a href="?route=Create_new_tiket" class="active">ايجاد درخواست جديد</a></li>	 
     </ol> 
    
	  <div class="content-page">
	    {if !isset($id_dep) }
	        <h4> دپارتمان  مورد نظر </h4>
			 {if (count($Department) > 0)}
			 {foreach $Department as  $row}
			 <a  href="?route=Create_new_tiket&send_tiket&dep_id={$row.id_dep}">
	         <div class="alert alert-info" role="alert"> 
	         <strong><i class="fa fa-comment" aria-hidden="true"></i>{$row.dep_title}</strong> </br>
	         {$row.dep_dicription}
	        </div> 
			</a>
		    {/foreach}
			 {else}
				 <div class="alert alert-warning" role="alert">
				 <strong>دپارتمانی موجود نیست !</strong></br>
				  متاسفانه دپارتمانی  جهت ارسال  درخواست  موجود  نیست
				</div>
			  {/if}
		  

		 {elseif  isset($id_dep) and !isset($id) }
		  {if (count($Department) > 0)}			 
		  <form action="{$REQUEST_URI}" id="form-req" method="POST" enctype="multipart/form-data">
          <h4> ارسال درخواست </h4>
		  <div class="col-lg-5">
		  
		  			<div class="form-group">
			  <label> فایل ضمیمه  </label>
			  <input name="file" id="file_1" type="file"  >
			  <span style="display: inline-block;"  name="file" class="label label-info fa-number">پسوند  مجاز : .zip </br>
			   حجم مجاز : 1 مگابایت </span> 
			</div>
			
		  </div>
		  <div class="col-lg-7" style="float:right;">
		  
		       <div class="form-group">
      		    <label> موضوع درخواست </label>
      		    <input class="form-control" value="{if (isset($data['f1']))} $data['f1'] {/if}" name="f1" placeholder="موضوع درخواست را وارد نمایید">
      		  </div>
		       <div class="form-group">
      		    <label> دپارتمان </label>
      		     <select   name="f2" style="padding: 0 10px;" class="form-control">
				  {foreach $Department_all as $row }
				   <option {if $row.id_dep == $id_dep}  selected {/if} value="{$row.id_dep}" >{$row.dep_title}</option>
				  {/foreach}
				 </select>
				 
      		  </div>			  
			  
			<div class="form-group">
      		    <label> اولویت </label>
      		     <select   name="f3" style="padding: 0 10px;" class="form-control">
				   <option {if (isset($data['f3']))}{if ($data['f3'] == "1")} selected {/if}{/if} value="1" > کم </option>
				   <option {if (isset($data['f3']))}{if ($data['f3'] == "2")} selected  {/if}{/if} value="2" > متوسط </option>
				   <option {if (isset($data['f3']))}{if ($data['f3'] == "3")} selected  {/if}{/if} value="3" > زیاد </option>				   
				 </select> 
				  
      		  </div>
			  
			
		    <div class="form-group">
      		    <label> متن درخواست </label>
      		    <textarea   name="f4" class="form-control" rows="4"  placeholder="متن درخواست  خود را وارد نمایید">{if (isset($data['f4']))}  $data['f4'] {/if}</textarea> 
      		</div>
            <p>
			<button type="button" onClick="send_tikets()" class="btn btn-primary">ارسال درخواست</button>  
			<button type="reset" class="btn btn-default">از  نو</button>
			</p>
		  </div> 
		  </form>
			 {else}
				<div class="alert alert-warning" role="alert">
				 <strong>دپارتمانی موجود نیست !</strong></br>
				  متاسفانه دپارتمانی  جهت ارسال  درخواست  موجود  نیست
				</div>
			  {/if}
		   {/if}
 		  
		  {if (isset($id))}
			      {if (count($get_code) > 0)}		 
		
			  <div class="alert alert-success" role="alert">  
	         <strong>درخواست شما  ارسال شد</strong> <br> 
	         با تشکر  درخواست شما با   کد   <a href="?route=show_tiket&tiket_code={$get_code.tk_code}" class="fa-number">#{$get_code.tk_code}</a>  با  موفقیت  ارسال شد  منتظر  پاسخ از سوی  کارشناسان باشید      </div>
		      {else}
			  <div class="alert alert-warning" role="alert">
				 <strong>چیزی یافت نشد!</strong></br>
				  متاسفانه  درخواستی با این  ای دی  یافت نشد !
				</div>
		     {/if}
		{/if}
		  
	</div>
	
	</div>
	
   {include file="footer.tpl" }