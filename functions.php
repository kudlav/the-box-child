<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */
$content_width = 636; /* pixels */

function my_theme_enqueue_styles() {
	wp_enqueue_style('the-box', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
remove_action('wp_head', 'wp_generator');

/** Own meta-box 'Soubory' */
function attachments_meta_box_content()
{
	$attachments = get_attached_media('', 0);
	if (!empty($attachments)) {
		echo '<table class="fixed striped widefat"><tbody>';
		foreach ($attachments as $file_page) {
			echo '<tr>';
			echo '<td><a href="'.$file_page->guid.'" target="_blank">'.($file_page->post_title).'</a></td>';
			echo '<td>'.$file_page->post_mime_type.'</td>';
			echo '<td><a href="?action=edit&post='.$file_page->ID.'" target="_blank">Editovat</a></td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		echo '<p style="margin: 0.2em;">Celkem souborů: '.sizeof($attachments).'</p>';
	} else {
		echo 'K příspěvku nejsou přiřazeny žádné soubory.';
	}
}

function add_attachments_meta_box()
{
	add_meta_box('attachments-meta-box', 'Soubory', 'attachments_meta_box_content', ['post', 'page'], 'normal', 'high', null);
}

add_action('add_meta_boxes', 'add_attachments_meta_box');
