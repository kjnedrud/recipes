<?php
/**
 * Footer
 */
?>

<?php wp_footer(); ?>

<script type="text/javascript">
$ = jQuery;
$(function(){
	// quick way to prevent orphans - replace the last space in a <p> tag with a non-breaking space
	$('p').each(function(){
		var html = $(this).html();
		var lastSpaceIndex = html.lastIndexOf(' ');
		if (lastSpaceIndex > 0) {
			html = html.substring(0,lastSpaceIndex) + '&nbsp;' + html.substring(lastSpaceIndex+1);
			$(this).html(html);
		}
	});
});
</script>

</body>
</html>
