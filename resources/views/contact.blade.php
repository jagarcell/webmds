<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@extends('layouts.master')
<!DOCTYPE HTML>
<head>
@section('header')
<title id="Contact_Tab">@lang('contact.title')</title>
@endsection
</head>
<body>
@section('main')
	<div class="main">
    	<div class="content">
    		<div class="section group">
				<div class="col span_2_of_3">
				  	<div class="contact-form">
				  		<h2>@lang('contact.contactus')</h2>
					    <form method="post" action="contact-post">
					    	<div>
						    	<span><label>@lang('contact.name')</label></span>
						    	<span><input name="userName" type="text" class="textbox" ></span>
						    </div>
						    <div>
						    	<span><label>@lang('contact.email')</label></span>
						    	<span><input name="userEmail" type="text" class="textbox"></span>
						    </div>
						    <div>
						     	<span><label>@lang('contact.companyname')</label></span>
						    	<span><input name="userPhone" type="text" class="textbox"></span>
						    </div>
						    <div>
						    	<span><label>@lang('contact.subject')</label></span>
						    	<span><textarea name="userMsg"> </textarea></span>
						    </div>
						   <div>
						   		<span><input type="submit" value="Submit"  class="myButton"></span>
						  </div>
					    </form>
				  	</div>
  				</div>
				<div class="col span_1_of_3">
					<div class="contact_info">
    	 				<h3>@lang('contact.findushere')</h3>
			    	  	<div class="map">
					   	    <iframe width="100%" height="175" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3920.908209670688!2d-71.62856608598106!3d10.664232592397708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e89991bedffb1e9%3A0x8351c4cb623c14a5!2sMICRO+DATA+SYSTEMS%2C+C.A.!5e0!3m2!1ses-419!2sus!4v1502412968529;output=embed"></iframe><br><small><a href="https://www.google.com/maps/place/MICRO+DATA+SYSTEMS,+C.A./@10.6642326,-71.6285661,17z/data=!4m5!3m4!1s0x8e89991bedffb1e9:0x8351c4cb623c14a5!8m2!3d10.6642326!4d-71.6263774" style="color:#666;text-align:left;font-size:12px">@lang('contact.viewlargermap')</a></small>
					  	</div>
      				</div>
      				<div class="company_address">
				     	<h3>@lang('contact.companyinformation') :</h3>
				    	<p>500 Lorem Ipsum Dolor Sit,</p>
				   		<p>22-56-2-9 Sit Amet, Lorem,</p>
				   		<p>USA</p>
				   		<p>Phone:(00) 222 666 444</p>
				   		<p>Fax: (000) 000 00 00 0</p>
				 	 	<p>Email: <span>info@mycompany.com</span></p>
				   		<p>Follow on: <span>Facebook</span>, <span>Twitter</span></p>
				   </div>
			 	</div>
		  	</div>		
     	</div> 
	</div>
@endsection
</body>
</html>
