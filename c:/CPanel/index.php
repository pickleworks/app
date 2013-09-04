<?php
?>
<HTML>
	<HEAD>
	</HEAD>
	<BODY>
		<script type='text/javascript'>
			var mobile = (/iphone|ipod|android|blackberry|phone|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
			if (mobile) {
				document.location='/app/geo_list.php';
			}
		</script>
		Not a mobile device
	</BODY>
</HTML>
