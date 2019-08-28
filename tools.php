<!DOCTYPE html>
<html>
<head>
	<title>My Tools</title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(
			function() 
			{
				$('#tools').hide();
			}
		);
		function getAccess(key)
		{
			var hash = key.charCodeAt(0);
			var chr;
			for (var i = 1; i < key.length; i++) {
				chr = key.charCodeAt(i)
				hash = ((hash << 5) - hash) + chr;
			}
			if(hash == 2697897325)
			{
				return true
			}
			else
			{
				return false;
			}

			
		};
	</script>
	<center>
		<section style="font-style: italic;font-size: 20px">Welcome To The Tools Page</section>
		<section><p title="password">Password: <input id="password" type="password" name="password" value="" /></p></section>
		<section><button onclick="show()">SHOW TOOLS</button></section>
		<script type="text/javascript">
			function show()
			{
				if(getAccess(document.getElementById("password").value))
				{
					$('#tools').show();
				}
				else
				{
					$('#tools').hide();
				}
	 		}
		</script>
	</center>
</head>
<body>
	<section id="tools">
		<section id="advisor" style="float: left;text-align: center;margin-left: 20px">
			<p>
				<a href="https://www.remoteutilities.com/download/rut6.3.zip" download="REMOTE AGENT">Download Remote Agent By</a>
			</p>
			<p> 
				<img src="public/images/logo.png" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left;text-align: center;margin-left: 20px">
			<p>
				<a href="http://www.belarc.com/es/Programs/advisorinstaller.exe" download="BELRAC ADVISOR">Download Belrac Advisor By</a>
			</p>
			<p> 
				<img src="/public/images/belrac.gif" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left;text-align: center;margin-left: 20px">
			<p>
				<a href="https://www.winrar.es/descargas/37" download="WINRAR">Download Belrac Advisor By</a>
			</p>
			<p> 
				<img src="/public/images/winrar.png" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left; text-align: center;margin-left: 20px">
			<p>
				<a href="http://liveupdate.symantecliveupdate.com/upgrade/NSS/SymCCIS/Production/NPI/symantec/Setup.exe" download="NORTON SCAN">Download Norton Scan By</a>
			</p>
			<p> 
				<img src="/public/images/symantec.gif" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left; text-align: center;margin-left: 20px">
			<p>
				<a href="http://usa.kaspersky.com/acq/kss-thank-you?ICID=ACQ_KSS_product_page_USA_KSS_TYFD/kss16.0.0.1344en_9702.exe" download="KASPERSKY SCAN">Download Kaspersky Scan By</a>
			</p>
			<p> 
				<img src="/public/images/kaspersky.jpg" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left; text-align: center;margin-left: 20px">
			<p>
				<a href="http://acs.pandasoftware.com/pandacloudcleaner/rescuedisk/PandaCloudCleaner.zip" download="KPANDA SCAN">Download Panda Scan By</a>
			</p>
			<p> 
				<img src="/public/images/panda.png" width="100px" height="40px">
			</p>
		</section>
		<section style="float: left; text-align: center;margin-left: 20px">
			<p>
				<a href="http://acs.pandasoftware.com/pandacloudcleaner/rescuedisk/PandaCloudCleaner.zip" download="KPANDA SCAN">Download Panda Scan By</a>
			</p>
			<p> 
				<img src="/public/images/panda.png" width="100px" height="40px">
			</p>
		</section>
	</section>
</body>
</html>
