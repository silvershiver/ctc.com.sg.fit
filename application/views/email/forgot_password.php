<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

    <title>CTCFITApp - Forgot password email address</title>

    <style type="text/css">
    	
	    body{
            width: 100%; 
            background-color: #666666; 
            margin:0; 
            padding:0; 
            -webkit-font-smoothing: antialiased;
        }
        
        html{
            width: 100%; 
        }
        
        table{
            font-size: 14px;
            border: 0;
        }
        
        /* ----------- responsivity ----------- */
        @media only screen and (max-width: 640px){
        
            /*------ top header ------ */
            .header-bg{width: 440px !important; height: 10px !important;}
            .main-header{line-height: 28px !important;}
            .main-subheader{line-height: 28px !important;}
            
            .container{width: 440px !important;}
            .container-middle{width: 420px !important;}
            .mainContent{width: 400px !important;}
            
            .main-image{width: 400px !important; height: auto !important;}
            .banner{width: 400px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 400px !important;}
            .section-img{width: 400px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important; line-height: 24px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 24px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 420px !important; height: auto !important;}            
        }
        
        @media only screen and (max-width: 479px){
        
        	/*------ top header ------ */
            .header-bg{width: 280px !important; height: 10px !important;}
            .top-header-left{width: 260px !important; text-align: center !important;}
            .top-header-right{width: 260px !important;}
            .main-header{line-height: 28px !important; text-align: center !important;}
            .main-subheader{line-height: 28px !important; text-align: center !important;}
            
            /*------- header ----------*/
            .logo{width: 260px !important;}
            .nav{width: 260px !important;}
            
            .container{width: 280px !important;}
            .container-middle{width: 260px !important;}
            .mainContent{width: 240px !important;}
            
            .main-image{width: 240px !important; height: auto !important;}
            .banner{width: 240px !important; height: auto !important;}
            /*------ sections ---------*/
            .section-item{width: 240px !important;}
            .section-img{width: 240px !important; height: auto !important;}
            /*------- prefooter ------*/
            .prefooter-header{padding: 0 10px !important;line-height: 28px !important;}
            .prefooter-subheader{padding: 0 10px !important; line-height: 28px !important;}
            /*------- footer ------*/
            .top-bottom-bg{width: 260px !important; height: auto !important;}

            
	    }
	    
	    
    </style>
    
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 40px;">
        <tr bgcolor="#666666">
            <td width="100%" align="center" valign="top" bgcolor="#666666">
                <!---------   top header   ------------>
                <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
                    <tr>
                        <td style="line-height: 10px;">
	                        <img style="display: block;" src="<?php echo base_url(); ?>assets/email/img/top-header-bg.png" width="600" height="10" alt="" class="header-bg" />
	                    </td>
                    </tr>          
                    <tr bgcolor="2780cb"><td height="5"></td></tr>
                    <tr bgcolor="2780cb">
	                    <td align="center">
	                    	<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
	                    		<tr>
	                    			<td>
					                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-left">
					                    	<tr>
					                    		<td align="center">
					                    			<table border="0" cellpadding="0" cellspacing="0" class="date">
					                    				<tr>
								                    		<td>
									                    		<img editable="true" mc:edit="icon1" width="13" height="13" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/icon-cal.png" alt="icon 1" />
								                    		</td>
								                    		<td>&nbsp;&nbsp;</td>
								                    		<td mc:edit="date" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">						                    			
									                    		<?php echo date("l, d F Y"); ?>
								                    		</td>
								                    	</tr>
				
					                    			</table>
					                    		</td>
					                    	</tr>
					                    </table>
					                    
					                    <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
					                    	<tr><td width="10" height="20"></td></tr>
					                    </table>
					                    
					                    <table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="top-header-right">
					                    	<tr>
					                    		<td align="center">
					                    			<table border="0" cellpadding="0" cellspacing="0" align="center" class="tel">
					                    				<tr>
								                    		<td>
									                    		<img editable="true" mc:edit="icon2" width="17" height="12" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/icon-tel.png" alt="icon 2" />
								                    		</td>
								                    		<td>&nbsp;&nbsp;</td>
								                    		<td mc:edit="tel" style="color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">        			
								                    			Contact us : <?php echo $contact_no_ontop; ?>	                    			
								                    		</td>
								                    	</tr>
					                    			</table>
					                    		</td>
					                    	</tr>					                    	
					                    </table>
	                    			</td>
	                    		</tr>
	                    	</table>
	                    </td>
                    </tr>                
                    <tr bgcolor="2780cb"><td height="10"></td></tr>               
                </table>   
                <!----------    end top header    ------------>
                
                
                <!----------   main content----------->
                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="404040">
                	
                	
                	<!--------- Header  ---------->
                	<tr bgcolor="404040"><td height="40"></td></tr>    	
                	<tr>
	                	<td>
	                		<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
	                			<tr>
	                				<td>
	                					<table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="logo">
				                			<tr>
				                				<td align="center">
				                					<a href="" style="display: block; border-style: none !important; border: 0 !important;">
					                					<!--<img editable="true" mc:edit="logo" width="160" height="40" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/iotstream.png" alt="logo" />-->
					                					{Logo CTCFITApp Here}
					                				</a>
				                				</td>
				                			</tr>
				                		</table>
	                				</td>
	                			</tr>
	                		</table>
	                	</td>
                	</tr>              	
                	<tr bgcolor="404040"><td height="30"></td></tr>
                	<!---------- end header --------->
                	           	
                	<!--------- section 1 --------->
                	<tr mc:repeatable>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="<?php echo base_url(); ?>assets/email/img/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                				<tr bgcolor="565656">
                					<td>
                						<table width="536" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                							<tr><td height="20"></td></tr>
                							<tr>
                								<td>                									
                									<table border="0" width="536" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                										<tr>
                											<td mc:edit="title2" style="color: #ffffff; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">        											
Dear user,					
                											</td>
                										</tr>
                										<tr><td height="15"></td></tr>
                										<tr>
                											<td mc:edit="subtitle2" style="color: #a4a4a4; line-height: 25px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
<p>This is a receipt to your Forgot Password Request.</p>
<p>
    <div>Please <a href="<?php echo $reset_link; ?>" style="color:white" target="_blank">CLICK HERE</a> to reset your password.</div>
</p>
<p><strong style="color:yellow;">Note:</strong> For security measures, please change the default password generated by the CTCFITApp</p>
                											</td>
                										</tr>
                									</table>
                								</td>
                							</tr>
                							
                							<tr><td height="20"></td></tr>
                							
                						</table>
                					</td>
                				</tr>
                				
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="<?php echo base_url(); ?>assets/email/img/bottom-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                				
                			</table>
                		</td>
                	</tr><!--------- end section 1 --------->          	
                	
                	<tr mc:repeatable><td height="35"></td></tr>
                	
                	<!-------- section 4 ------->
                	<tr mc:repeatable>
                		<td>
                			<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="<?php echo base_url(); ?>assets/email/img/top-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                				<tr bgcolor="565656">
                					<td>
                						<table width="536" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                							<tr><td height="20"></td></tr>
                							<tr>
                								<td>
                									
                									<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                										<tr><td height="6"></td></tr>
                										<tr>
                											<td><a href="" style="width: 128px; display: block; border-style: none !important; border: 0 !important;"><img editable="true" mc:edit="image4" width="128" height="126" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/image4.png" alt="image4" class="section-img" /></a></td>
                										</tr>
                										<tr><td height="10"></td></tr>
                									</table>
                									
                									<table border="0" align="left" width="10" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                										<tr><td height="30" width="10"></td></tr>
                									</table>
                									
                									<table border="0" width="360" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="section-item">
                										<tr>
                											<td mc:edit="title5" style="color: #ffffff; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">       											
	                												Help & Support		
                											</td>
                										</tr>
                										<tr><td height="15"></td></tr>
                										<tr>
                											<td mc:edit="subtitle5" style="color: #a4a4a4; line-height: 25px; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
																Need help? Start here to get support. Tell us your details and issue case.
                											</td>
                										</tr>
                										<tr><td height="15"></td></tr>
                										<tr>
                											<td>
                												<a href="<?php echo base_url(); ?>backend" style="display: block; width: 80px; border-style: none !important; border: 0 !important;"><img editable="true" mc:edit="readMoreBtn" width="80" height="26" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/readmore-btn.png" alt="Read more" /></a>
                											</td>
                										</tr>
                									</table>
                									
                								</td>
                							</tr>          							
                							<tr><td height="20"></td></tr>           							
                						</table>
                					</td>
                				</tr>           				
                				<tr><td align="center" style="line-height: 6px;"><img style="display: block;" width="560" height="6" src="<?php echo base_url(); ?>assets/email/img/bottom-rounded-bg.png" alt="" class="top-bottom-bg" /></td></tr>
                			</table>
                		</td>
                	</tr><!--------- end section 4 --------->
                	
                	<tr><td height="35"></td></tr>
                	
                	<!---------- prefooter  --------->      	
                	<tr>
	                	<td>
	                		<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">
	                			<tr>
	                				<td>
				                		<table border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="nav">
				                			<tr><td height="10"></td></tr>
				                			<tr>
				                				<td align="center" mc:edit="socials" style="font-size: 13px; font-family: Helvetica, Arial, sans-serif;">
				                					<table border="0" align="center" cellpadding="0" cellspacing="0">
				                						<tr>
				                							<td>
				                								<a style="display: block; width: 16px; border-style: none !important; border: 0 !important;" href="#"><img editable="true" mc:edit="google" width="16" height="16" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/social-google.png" alt="google plus" /></a>		
				                							</td>
				                							<td>&nbsp;&nbsp;&nbsp;</td>
				                							<td>
				                								<a style="display: block; width: 16px; border-style: none !important; border: 0 !important;" href="#"><img editable="true" mc:edit="youtube" width="16" height="16" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/social-youtube.png" alt="youtube" /></a>
				                							</td>
				                							<td>&nbsp;&nbsp;&nbsp;</td>
				                							<td>
				                								<a style="display: block; width: 16px; border-style: none !important; border: 0 !important;" href="#"><img editable="true" mc:edit="facebook" width="16" height="16" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/social-facebook.png" alt="facebook" /></a>
				                							</td>
				                							<td>&nbsp;&nbsp;&nbsp;</td>
				                							<td>
				                								<a style="display: block; width: 16px; border-style: none !important; border: 0 !important;" href="#"><img editable="true" mc:edit="twitter" width="16" height="16" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/social-twitter.png" alt="twitter" /></a>
				                							</td>
				                							<td>&nbsp;&nbsp;&nbsp;</td>
				                							<td>
				                								<a style="display: block; width: 16px; border-style: none !important; border: 0 !important;" href="#"><img editable="true" mc:edit="linkedin" width="16" height="16" border="0" style="display: block;" src="<?php echo base_url(); ?>assets/email/img/social-linkedin.png" alt="linkedin" /></a>
				                							</td>
				                						</tr>
				                					</table>
				                				</td>
				                			</tr>
				                		</table>
	                				</td>
	                			</tr>
	                		</table>
	                	</td>
                	</tr><!---------- end prefooter  --------->
                	
                	<tr><td height="40"></td></tr>
                	
                	<tr>
                		<td align="center" mc:edit="copy1" style="color: #939393; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" class="prefooter-header">	
							You are automatically signed up to CTCFITApp's newsletters as: 
							<span style="color: #2780cb">usersignupemail@gmail.com</span> 
							<br /><br />
							<a style="text-decoration: none; color: #2780cb;" href="">unsubscribe from our newsletters</a>
                		</td>
                	</tr>	
                	
                	<tr><td height="30"></td></tr>
                	
                	<tr>
                		<td align="center" mc:edit="copy2" style="color: #939393; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;" class="prefooter-subheader">
	                		
	                			<span style="color: #2780cb">Address :</span> 
	                			Singapore, Chinatown &nbsp;&nbsp;&nbsp;
	                			<span style="color: #2780cb">Tlp :</span> 
	                			(+64) 1234567890 &nbsp;&nbsp;&nbsp; 
	                			<span style="color: #2780cb">Email :</span> info@ctcfitapp.sg	
                		</td>
                	</tr>
                	
                	<tr><td height="30"></td></tr>
                </table>
                <!------------ end main Content ----------------->
                                
                <!---------- footer  --------->
                <table border="0" width="600" cellpadding="0" cellspacing="0" align="center" class="container">
                	<tr bgcolor="2780cb"><td height="14"></td></tr>
                	<tr bgcolor="2780cb">
                		<td mc:edit="copy3" align="center" style="color: #cecece; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">               			
                			CTCFITApp.sg © Copyright 2015. All Rights Reserved.  			
                		</td>
                	</tr>             	
                	<tr>
                        <td style="line-height: 10px;">
	                        <img style="display: block;" src="<?php echo base_url(); ?>assets/email/img/bottom-footer-bg.png" width="600" height="10" alt="" class="header-bg" />
	                    </td>
                    </tr>
                </table>
                <!---------  end footer --------->
            </td>
        </tr>
        
        <tr><td height="30"></td></tr>
      
	</table>
</body>
</html>   