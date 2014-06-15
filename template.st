<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><? echo $st_subject; ?></title>
</head>

<body bgcolor="#3f3f3f" style="width:100%;margin:0;padding:0;background:#3f3f3f;">
  <!-- main table wrapper -->
  <table border="0" cellspacing="0" cellpadding="0" width="100%" style="background:#3f3f3f" bgcolor="#3f3f3f">
	  <tbody>
		  <tr>
			  <td>
			  	<!-- top head links -->
			    <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
			      <tbody>
			        <tr>
			          <td align="center" valign="middle">
			            <p style="font-size:11px;color:#fff;font-family:Arial,Tahoma,sans-serif;">We have you currently subscribed to receive our monthly site newsletter.
			            <br />
			            Is this message too small? <a href="#" style="text-decoration:none;" target="_blank"><span style="color:#728fd9;">Open a copy in your web browser.</span></a>
			            <br />
			            Sick of getting these updates? <a href="#" style="text-decoration:none;" target="_blank"><span style="color:#728fd9;">Unsubscribe now.</span></a>
			            </p>
			          </td>
			        </tr>
			      </tbody>
			    </table>
			    
			    <!-- logo and default heading -->
			    <table align="center" border="0" cellpadding="0" cellspacing="0" width="550" height="60">
			      <tbody>
			        <tr>
			          <td width="150">
			            <a href="#" target="_blank"><img src="http://placehold.it/147x58" alt="Logo" /></a>
			          </td>
			          <td width="380" align="right">
			            <p style="font-size:11px;font-style:italic;color:#a5a7a5;font-family:Georgia,Times,serif;">Hello, World!</p>
			          </td>
			        </tr>
			      </tbody>
			    </table>
			    
			    <!-- newsletter content area -->
			    <table align="center" border="0" cellpadding="0" cellspacing="0" width="550" bgcolor="#f5f8f6" style="background:#f5f8f6;">
			      <tbody>
			        <tr>
			          <td style="text-align:center;">
			            <h2 style="font-size:22px;font-style:italic;font-weight:normal;font-family:Georgia,Times,serif;color:#636363;margin-bottom:2px;"><? echo $st_date; ?></h2>
			            <p style="font-size:12px;line-height:17px;color:#343434;font-family:Georgia,Times,serif;padding:2px 10px;"><? echo $st_intro; ?></p>
			          </td>
			        </tr>
			        <tr>
			          <td>
			            <table border="0" cellpadding="0" cellspacing="0" width="100%">
			              <tbody>
			                <?
							for ($i = 0; $i < $st_numberOfItems; $i++)
							{?>
							<tr>
			                  <td width="280" height="125" style="padding-left:6px;padding-top:4px;">
			                    <a href="<? echo $st_item[$i]['image_link']; ?>" target="_blank"><img src="<? echo $st_item[$i]['image_path']; ?>" alt="<? echo $st_item[$i]['title']; ?>" width="280" height="120" /></a>
			                  </td>
			                  <td width="240" height="125" style="text-align:center;padding-right:8px;">
			                    <h3 style="font-size:15px;color:#64686e;font-family:'Lucida Grande',sans-serif;font-weight:bold;"><? echo $st_item[$i]['title']; ?></h3>
			                    <p style="font-size:11px;color:#666;font-family:Arial,Tahoma,sans-serif;padding:0 12px;margin-bottom:0;"><? echo $st_item[$i]['content']; ?></p>
			                    <p style="margin:0;text-align:right;font-family:Arial,Tahoma,sans-serif;"><span style="font-size:11px;font-weight:bold;"><a href="<? echo $st_item[$i]['link_url']; ?>" style="color:#5977c3;" target="_blank"><? echo $st_item[$i]['link_title']; ?> &rarr;</a></span></p>
			                  </td>
			                </tr>
							<? } ?>
			              </tbody>
			            </table>
			          </td>
			        </tr>
              <tr style="background:#e5e9ee;">
              	<td width="100%" style="padding: 4px 10px;">
              	  <h2 style="font-size:17px;font-style:italic;font-weight:normal;font-family:Georgia,Times,serif;color:#636363;margin-bottom:2px;">About the Website</h2>
              	  <p style="font-size:13px;line-height:17px;color:#787878;font-family:Georgia,Times,serif;padding:2px 12px;margin-bottom:18px;">Vandelay Design Blog publishes interesting articles related to modern-day web designers &amp; Developers. The site is often home to freebie releases which include icons, PSDs, UI kits, and even full templates. You can get in touch via social networks on <a href="http://www.facebook.com/VandelayDesign" style="color:#5977c3;" target="_blank">Facebook</a> and Twitter <a href="https://twitter.com/vandelaydesign" style="color:#5977c3;" target="_blank">@vandelaydesign</a>.</p>
              	</td>
              </tr>
			      </tbody>
			    </table>
			    
			    <!-- main footer credits -->
			    <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
			      <tbody>
			        <tr>
			          <td align="center" valign="middle">
			            <p style="font-size:11px;color:#fff;font-family:Arial,Tahoma,sans-serif;">
			            Is this message too small? <a href="#" style="text-decoration:none;" target="_blank"><span style="color:#728fd9;">Open a copy in your web browser.</span></a>
			            <br />
			            Sick of getting these updates? <a href="#" style="text-decoration:none;" target="_blank"><span style="color:#728fd9;">Unsubscribe now.</span></a>
			            </p>
			          </td>
			        </tr>
			      </tbody>
			    </table>
			  </td>
		  </tr>
	  </tbody>
  </table>
</body>
</html>