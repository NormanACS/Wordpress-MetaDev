<?php
if (post_password_required()):
    return;
endif;
?>


<div class="post-comments col-padding mdc-elevation--z5">
    <?php if (have_comments()): ?>
        <div class="flexbox middle-sm space-bottom-large comments-counter-wrapper">
            <h3 class="comments-title">
			<span class="comments-number">
				<?php comments_number(__('No Comments', 'materialis'), __('Comments: <span>1</span>', 'materialis'), __('Comments: <span>%</span>', 'materialis')); ?>
	    	</span>
            </h3>
            <button class="button color2 add-comment-toggler mdc-elevation--z7"><?php esc_html_e('Add comment', 'materialis') ?></button>
        </div>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'avatar_size' => '40',
                'max_depth'   => '2',
                'reply_text'  => '<i class="mdi mdi-message-text"></i>&nbsp;' . __('Reply', 'materialis'),
            ));
            ?>
        </ol>

        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')):
            ?>
            <div class="navigation mdc-elevation--z5">
                <div class="prev-posts">
                    <?php previous_comments_link("<i class=\"font-icon-post mdi mdi-chevron-left\"></i> " . __('Older Comments', 'materialis')); ?>
                </div>
                <div class="next-posts">
                    <?php next_comments_link(__('Newer Comments', 'materialis') . " <i class=\"font-icon-post mdi mdi-chevron-right\"></i>"); ?>
                </div>
            </div>
        <?php
        endif;

    elseif (comments_open() && post_type_supports(get_post_type(), 'comments')): ?>
        <div class="flexbox middle-sm space-bottom-large  comments-counter-wrapper">
            <h4 class="comments-title">
                <span class="comments-number"><?php esc_html_e('No Comments', 'materialis'); ?></span>
            </h4>
            <button class="button color2 add-comment-toggler mdc-elevation--z7"><?php esc_html_e('Add comment', 'materialis') ?></button>
        </div>
    <?php endif;

    if ( ! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'materialis'); ?></p>
    <?php endif; ?>

    <div class="comments-form">
        <div class="comment-form">
            <?php
            comment_form(
                array(
                    'title_reply'          => __('Add your comment', 'materialis'),
                    'class_submit'         => 'submit button color2 mdc-elevation--z7',
                    'label_submit'         => __('Send', 'materialis'),
                    'comment_notes_before' => '',
                    'comment_field'        => '<div class="comment-form-comment mdc-text-field mdc-text-field--textarea">' .
                                              '<textarea id="comment" name="comment" class="mdc-text-field__input" rows="8" cols="40" required></textarea>' .
                                              '<label for="comment" class="mdc-floating-label">' . __('Comment', 'materialis') . '</label>' .
                                              '</div>',
                    'fields'               => apply_filters(
                        'comment_form_default_fields',
                        array(
                            'author' => '<div class="comment-form-author mdc-text-field half right-margin">' .
                                        '<input type="text" id="author" name="author" class="mdc-text-field__input" size="30" maxlength="245" required>' .
                                        '<label class="mdc-floating-label" for="author">' . __('Your Name', 'materialis') . '</label>' .
                                        '<div class="mdc-line-ripple"></div>' .
                                        '</div>',
                            'email'  => '<div class="comment-form-email mdc-text-field half left-margin">' .
                                        '<input type="email" id="email" name="email" class="mdc-text-field__input" size="30" maxlength="100" required>' .
                                        '<label class="mdc-floating-label" for="email">' . __('Your Email', 'materialis') . '</label>' .
                                        '<div class="mdc-line-ripple"></div>' .
                                        '</div>',
                            'url'    => '<div class="comment-form-url mdc-text-field">' .
                                        '<input type="text" id="url" name="url" class="mdc-text-field__input" size="30" maxlength="200">' .
                                        '<label class="mdc-floating-label" for="url">' . __('Your Website', 'materialis') . '</label>' .
                                        '<div class="mdc-line-ripple"></div>' .
                                        '</div>',
                        )
                    ),
                )
            );
            ?>
        </div>
    </div>

</div>
<!-- /post-comments -->
