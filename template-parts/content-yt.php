<?php
/**
 * Template part for displaying Youtube channel layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */
?>
 <div class="social-section">
    <div class="container social-container">
        <h2>Join the Community</h2>
        <p><b>Soodacode</b> is the way to understand and improve your skills in HTML, CSS & JavaScript.</p>
        <div class="social-grid">
            <div class="social-card youtube">
                <?php echo do_shortcode('[yt_subscribe_button]'); ?>
            </div>
        </div>
    </div>
</div><!-- categoty-section -->