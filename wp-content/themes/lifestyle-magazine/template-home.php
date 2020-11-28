<?php // Template Name: Home

get_header(); ?>

<?php
get_template_part( 'template-parts/home-sections/featured', '' );
get_template_part( 'template-parts/home-sections/blog', '' );
?>

<?php get_footer(); ?>
