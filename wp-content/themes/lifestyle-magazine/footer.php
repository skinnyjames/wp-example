<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Lifestyle Magazine
 */

?>
<footer class="main">
  <div class="container">
		<?php dynamic_sidebar( 'footer-1' ); ?>
  </div>
</footer>
<div class="copyright text-center spacer">
	<?php $copyright = get_theme_mod( 'copyright_text', '&copy; Copyright ' . date( 'Y' ) ); ?>
	<?php echo wp_kses_post( $copyright ); ?>
</div>
<div class="scroll-top-wrapper"><span class="scroll-top-inner"><i class="fa fa-2x fa-angle-up"></i></span></div>

<?php wp_footer(); ?>
</body>
</html>
