<?php
require_once('../functions/class_wtwhandlers.php');
require_once('../functions/class_wtwcommunities.php');
global $wtwhandlers;
global $wtwcommunities;

	$zanalyticsid = '';
	$zactionzoneind = '';
	$zcommunityid = '';
	$ztitle = '(High) 3D Community';
	if (isset($_GET['analyticsid']) && !empty($_GET['analyticsid'])) {
		$zanalyticsid = $_GET['analyticsid'];
	}
	if (isset($_GET['actionzoneind']) && !empty($_GET['actionzoneind'])) {
		$zactionzoneind = $_GET['actionzoneind'];
	}
	if (isset($_GET['communityid']) && !empty($_GET['communityid'])) {
		$zcommunityid = $_GET['communityid'];
	}
	if (!empty($zcommunityid)) {
		$ztitle = "(High) ".$wtwcommunities->getCommunityName($zcommunityid);
	}
?>
<html>
<head>
<title><?php echo $ztitle; ?></title>
<?php if (!empty($_GET['analyticsid'])) { ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $zanalyticsid; ?>" onload="pageView();"></script>
<script type="text/javascript">
	var zanalyticsid = '<?php echo $zanalyticsid; ?>';
	var zactionzoneind = '<?php echo $zactionzoneind; ?>';
	function pageView() {
		if (zanalyticsid != '') {
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', zanalyticsid, {
				'send_page_view': false
			});
			gtag('event', 'page_view', {
				'event_callback': function() {
					/* console.log('High is ready'); */
					window.parent.WTW.removeIFrame('analyticsframe'+zactionzoneind);
				}
			});
		}
	}
	window.onload = function() {
		window.setTimeout(function() {
			window.parent.WTW.removeIFrame('analyticsframe'+zactionzoneind);
		},10000);
	}
</script>
<?php } ?>
</head>
<body>
	<h1><?php echo $ztitle; ?></h1>
</body>

</html>