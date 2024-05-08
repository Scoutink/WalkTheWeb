<?php
	$zanalyticsid = '';
	if (isset($_GET['analyticsid']) && !empty($_GET['analyticsid'])) {
		$zanalyticsid = $_GET['analyticsid'];
	}
?>
<html>
<head>
<title>Analytics - 3D Thing Loaded at High Distance</title>
<?php if (!empty($_GET['analyticsid'])) { ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $zanalyticsid; ?>"></script>
<script type="text/javascript">
	function getQuerystring(zkey, zdefault) {
		var zquery = "";
		try {
			if (zdefault == null) zdefault = "";
			zkey = zkey.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
			var zregex = new RegExp("[\\?&]" + zkey + "=([^&#]*)");
			var zqs = zregex.exec(window.location.href);
			if (zqs == null) {
				zquery = zdefault;
			} else {
				zquery = zqs[1];
			}
		} catch (ex) {
			console.log(ex.message);
		}
		return zquery;
	}
	var zanalyticsid = getQuerystring('analyticsid', '');
	if (zanalyticsid != '') {
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', zanalyticsid);
	}
</script>
<?php } ?>
</head>
<body>
Analytics - 3D Thing Loaded at High Distance

	<input type='hidden' id='wtw_iframename' name='wtw_iframename' maxlength="64" />

</body>
</html>