<?php
/**
 * The template used to display Comments
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to twentyten_comment which is
 * located in the functions.php file
 *
 * @package WordPress
 * @subpackage CompNet
 * @since 3.0.0
 */
?>
	
	<!-- Start Comments -->
	
	<div id="comments">
		
		<?php if ( post_password_required() ) : ?>
		
			<p>This post is password protected. Enter the password to view any comments.</p>
		
		<?php else: ?>
		
			<?php if ( have_comments() ) : ?>
			
				<h3 class="subtitle comments_title"><?php comments_number(
					sprintf( 'No Responses to %s', '<em>' . get_the_title() . '</em>' ),
					sprintf( 'One Response to %s', '<em>' . get_the_title() . '</em>' ),
					sprintf( '%% Responses to %s', '<em>' . get_the_title() . '</em>' )
				); ?></h3>
				
				<?php if( get_comment_pages_count() > 1 ) : // are there comments to navigate through ?>
					
					<div class="navigation">
						<div class="nav_previous"><?php previous_comments_link('&larr; Older Comments'); ?></div>
						<div class="nav_next"><?php next_comments_link('Newer Comments &rarr;'); ?></div>
					</div>
					
				<?php endif; // check for comment navigation ?>
				
				<ol class="commentlist">
					<?php wp_list_comments(); ?>
				</ol>
				
				<?php if( get_comment_pages_count() > 1 ) : // are there comments to navigate through ?>
					
					<div class="navigation">
						<div class="nav_previous"><?php previous_comments_link('&larr; Older Comments'); ?></div>
						<div class="nav_next"><?php next_comments_link('Newer Comments &rarr;'); ?></div>
					</div>
					
				<?php endif; // check for comment navigation ?>
				
			<?php endif; ?>
			
			<?php if( comments_open() ) : // If comments are open, but there are no comments ?>
				
				<?php custom_comment_form(); //See Below ?>
				
			<?php endif; ?>
		
		<?php endif; ?>
	
	</div>
	
	<!-- End Comments -->
	
<?php


/**
 * Outputs a complete commenting form for use within a template.
 * Most strings and form fields may be controlled through the $args array passed
 * into the function, while you may also choose to use the comments_form_default_fields
 * filter to modify the array of default fields if you'd just like to add a new
 * one or remove a single field. All fields are also individually passed through
 * a filter of the form comments_form_field_$name where $name is the key used
 * in the array of fields.
 *
 * @since 3.0.0
 * @param array $args Options for strings, fields etc in the form
 * @param mixed $post_id Post ID to generate the form for, uses the current post if null
 * @return void
 */
function custom_comment_form( $args = array(), $post_id = null ) {
	
	global $user_identity, $id;
	
	if ( null === $post_id ){ $post_id = $id; }
	else{ $id = $post_id; }
	
	$commenter = wp_get_current_commenter();
	
	$req = get_option( 'require_name_email' );
	$defaults = array(
					'fields' => apply_filters('comment_form_default_fields', array(
						'author' => '<p class="comment-form-author">
										<label for="author">'.__( 'Name' ).'</label>
										'.( $req ? '<span class="required">*</span>' : '' ).'
										<input id="author" name="author" type="text" value="'.esc_attr( $commenter['comment_author'] ).'" size="30" tabindex="1"'.$aria_req.' />
									</p><!-- #form-section-author .form-section -->',
						'email' => '<p class="comment-form-email">
										<label for="email">'. __( 'Email' ).'</label>'
										.( $req ? '<span class="required">*</span>' : '' ).
										'<input id="email" name="email" type="text" value="'.esc_attr(  $commenter['comment_author_email'] ).'" size="30" tabindex="2"'.$aria_req.' />
									</p><!-- #form-section-email .form-section -->',
						'url' => 	'<p class="comment-form-url">
										<label for="url">'. __( 'Website' ).'</label>
										<input id="url" name="url" type="text" value="'.esc_attr( $commenter['comment_author_url'] ).'" size="30" tabindex="3" />
									</p><!-- #form-section-url .form-section -->' ) ),
						'comment_field' => '<p class="comment-form-comment">
												<label for="comment">'.__( 'Comment' ).'</label>
												<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4"></textarea>
											</p><!-- #form-section-comment .form-section -->',
						'must_log_in' => '<p class="must-log-in">'.sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id) ) ) ).'</p>',
						'logged_in_as' => '<p class="logged-in-as">'.sprintf( __( 'Logged in as <a href="%s">%s</a>. <a href="%s" title="Log out of this account">Log out?</a></p>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
						'comment_notes_before' => '<p class="comment-notes">'.__( 'Your email is <em>never</em> published nor shared.' ).( $req ? __( ' Required fields are marked <span class="required">*</span>' ) : '' ).'</p>',
						'comment_notes_after' => '<dl class="form-allowed-tags">
													<dt>'.__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:' ).'</dt>
													<dd><code>'.allowed_tags().'</code></dd>
												  </dl>',
						'id_form' => 'commentform',
						'id_submit' => 'submit',
						'title_reply' => __( 'Leave a Reply' ),
						'title_reply_to' => __( 'Leave a Reply to %s' ),
						'cancel_reply_link' => __( 'Cancel reply' ),
						'label_submit' => __( 'Post Comment' ),
				);
	$args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
	
	?>
		<?php if ( comments_open() ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php echo $args['comment_notes_after']; ?>
						<p class="form-submit">
							<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" tabindex="<?php echo ( count( $args['fields'] ) + 2 ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields(); ?>
						</p>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div>
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}

?>
