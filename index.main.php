<?php
/**
 * This is the main/default page template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://manual.b2evolution.net/Skins_2.0}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage pixelgreen
 *
 * @version $Id: index.main.php,v 1.3 2007/10/01 01:06:31 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( version_compare( $app_version, '2.4.1' ) < 0 )
{ // Older 2.x skins work on newer 2.x b2evo versions, but newer 2.x skins may not work on older 2.x b2evo versions.
	die( 'This skin is designed for b2evolution 2.4.1 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php' );
// Note: You can customize the default HTML header by copying the generic
// /skins/_html_header.inc.php file into the current skin folder.
// -------------------------------- END OF HEADER --------------------------------
?>

<!-- wrap starts here -->
<div id="wrapper">
<div id="outertable">
  <div id="innertable" >
    <div id="headerPic">
    <div id="top_menu">
				<?php if ( true /* change to false to hide the blog list */ ) { ?>
				<div class="blog_list">
				<?php
				  // START OF BLOG LIST
				  skin_widget( array(
						'widget' => 'colls_list_public',
						'block_start' => '',
						'block_end' => '',
						'block_display_title' => false,
						'list_start' => '<ul>',
						'list_end' => '</ul>',
						'item_start' => '<li>',
						'item_end' => '</li>',
						'item_selected_start' => '<li class="selected">',
						'item_selected_end' => '</li>',
					  ) );
				?>
				</div>
				<?php } ?>
			<?php
				// Display container and contents:
				skin_container( NT_('Page Top'), array(
						// The following params will be used as defaults for widgets included in this container:
						'block_start' => '<div class="$wi_class$">',
						'block_end' => '</div>',
						'block_display_title' => false,
						'list_start' => '<ul>',
						'list_end' => '</ul>',
						'item_start' => '<li>',
						'item_end' => '</li>',
					) );
			?>
			&nbsp;</div>
    	<div id="titleContainer">
		<?php
			// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			skin_container( NT_('Header'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'       => '<div class="$wi_class$">',
					'block_end'         => '</div>',
					'block_title_start' => '<h1>',
					'block_title_end'   => '</h1>',
				) );
			// ----------------------------- END OF "Header" CONTAINER -----------------------------
		?>
		</div>
		
            </div>

<div id="menu">
<ul class="lavaLampBottomStyle" id="m1">
			<?php
				// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
				// Display container and contents:
				// Note: this container is designed to be a single <ul> list
				skin_container( NT_('Menu'), array(
						// The following params will be used as defaults for widgets included in this container:
						'block_start'         => '',
						'block_end'           => '',
						'block_display_title' => false,
						'list_start'          => '',
						'list_end'            => '',
						'item_start'          => '<li>',
						'item_end'            => '</li>',
					) );
				// ----------------------------- END OF "Menu" CONTAINER -----------------------------
			?>
			</ul>


</div>
<?php
		// ------------------------- SIDEBAR INCLUDED HERE --------------------------
		skin_include( '_sidebar.inc.php' );
		// Note: You can customize the default BODY footer by copying the
		// _body_footer.inc.php file into the current skin folder.
		// ----------------------------- END OF SIDEBAR -----------------------------
		?>
<div id="maincontent">
			<?php
				// --------------------------------- START OF POSTS -------------------------------------
				// Display message if no post:
				display_if_empty();

				while( $Item = & mainlist_get_item() )
				{	// For each blog post, do everything below up to the closing curly brace "}"
				?>

				<?php
					// ------------------------------ DATE SEPARATOR ------------------------------
					/*$MainList->date_if_changed( array(
							'before'      => '<h2>',
							'after'       => '</h2>',
							'date_format' => '#',
						) );*/
				?>

				<div class="post bPost bPost<?php $Item->status_raw() ?>" lang="<?php $Item->lang() ?>">

					<?php
						$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)
						$Item->anchor(); // Anchor for permalinks to refer to.
					?>


					<h3 class="bTitle"><?php $Item->title(); ?></h3>
					
					<?php
						// ---------------------- POST CONTENT INCLUDED HERE ----------------------
						skin_include( '_item_content.inc.php', array(
								'image_size'	=>	'fit-400x320',
							) );
						// Note: You can customize the default item feedback by copying the generic
						// /skins/_item_feedback.inc.php file into the current skin folder.
						// -------------------------- END OF POST CONTENT -------------------------
					?>

					<div class="post-footer">
					<div class="bSmallHead">
					<?php
						$Item->categories( array(
							'before'          => T_('Posted in').': ',
							'after'           => ' ',
							'include_main'    => true,
							'include_other'   => true,
							'include_external'=> true,
							'link_categories' => true,
						) );
						// List all tags attached to this post:
						$Item->tags( array(
								'before' =>         T_('Tags').': ',
								'after' =>          '',
								'separator' =>      ', ',
							) );
						?>
						<br />
						<?php
						// Permalink:
						$Item->permanent_link( array(
								'class' => 'permalink_right',
								'text' => '#icon#'
							) );

						// Permalink:
						$Item->issue_date( array(
								'before'    => '',
								'after'     => ' ',
							));
						$Item->issue_time( array(
								'before'    => ' ',
								'after'     => '',
							));


						echo ', ';

						// Link to comments, trackbacks, etc.:
						$Item->feedback_link( array(
										'type' => 'comments',
										'link_before' => '<img src="images/comment.gif" alt="" class="middle" />',
										'link_after' => '',
										'link_text_zero' => '#',
										'link_text_one' => '#',
										'link_text_more' => '#',
										'link_title' => '#',
										'use_popup' => false,
										'class' => 'comments'
									) );

						// Link to comments, trackbacks, etc.:
						$Item->feedback_link( array(
										'type' => 'trackbacks',
										'link_before' => ' &bull; ',
										'link_after' => '',
										'link_text_zero' => '#',
										'link_text_one' => '#',
										'link_text_more' => '#',
										'link_title' => '#',
										'use_popup' => false,
									) );

						$Item->edit_link( array( // Link to backoffice for editing
								'before'    => ' &bull; ',
								'after'     => '',
							) );
						?>
					</div>
					</div>
					<?php
						// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
						skin_include( '_item_feedback.inc.php', array(
								'before_section_title' => '<h4>',
								'after_section_title'  => '</h4>',
							) );
						// Note: You can customize the default item feedback by copying the generic
						// /skins/_item_feedback.inc.php file into the current skin folder.
						// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
					?>

					<?php
						locale_restore_previous();	// Restore previous locale (Blog locale)
					?>
				</div>
				<?php
				} // ---------------------------------- END OF POSTS ------------------------------------
			?>

			<?php
				// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
				mainlist_page_links( array(
						'block_start' => '<p class="center"><strong>',
						'block_end' => '</strong></p>',
		   			'prev_text' => '&lt;&lt;',
		   			'next_text' => '&gt;&gt;',
					) );
				// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
			?>

			<?php
				// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
				//skin_include( '$disp$', array() );
				skin_include( '$disp$', array(
					'disp_posts'  => '',            // We already handled this case above
					'disp_single' => '',            // We already handled this case above
					'disp_page'   => '',            // We already handled this case above
                       ) );
				// Note: you can customize any of the sub templates included here by
				// copying the matching php file into your skin directory.
				// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
			?>


		</div>
<div id="clear"></div>
</div>
<div id="footer"><div id="footer-content">
	<?php
		// ------------------------- "Footer" CONTAINER EMBEDDED HERE --------------------------
		// Display container and contents:
		skin_container( NT_('Footer'), array(
				// The following params will be used as defaults for widgets included in this container:
				'block_start'       => '<div class="col float-left $wi_class$">',
				'block_end'         => '</div>',
				'block_title_start' => '<h1>',
				'block_title_end'   => '</h1>',
			) );
		// ----------------------------- END OF "Footer" CONTAINER -----------------------------
	?>

		<div class="designed">
		Design by <a href="http://mheadley.com">Mheadley</a><br />

		</div>

		<p class="baseline">
			<?php
				// Display a link to contact the owner of this blog (if owner accepts messages):
				$Blog->contact_link( array(
						'before'      => '',
						'after'       => '',
						'text'   => T_('Contact'),
						'title'  => T_('Send a message to the owner of this blog...'),
					) );
			?>
			<?php
				// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
						'before'      => ' &bull; ',
						'after'       => '&nbsp;&nbsp; • &nbsp;&nbsp;',
					) );
			?>
            
			<?php
				// Display additional credits:
				// If you can add your own credits without removing the defaults, you'll be very cool :))
				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
				credits( array(
						'list_start'  => T_('Credits').': ',
						'list_end'    => ' ',
						'separator'   => '|',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );
			?>
		</p>


</div></div><!-- footer ends here -->
</div></div>

<?php
	// Trigger plugin event, which could be used e.g. by a google_analytics plugin to add the javascript snippet here:
	$Plugins->trigger_event('SkinEndHtmlBody');
?>
<!-- wrap ends here -->
</div>

</body>
</html>