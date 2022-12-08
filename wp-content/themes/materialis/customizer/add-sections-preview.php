<style>
	.materialis-add-section-wrapper.col-xs-12.middle-xs {
		margin-top: 40px;
	}

	.materialis-add-section-wrapper-inner {
		padding: 60px 0px;
		border-width: 2px;
		border-style: dashed;
		text-align: center;
	}

	.materialis-add-section-wrapper-inner button {
		text-transform: uppercase;
		letter-spacing: 1px;
		font-size: 16px;
		margin: 0;
		padding: 10px 30px;
	}

	.materialis-add-section-wrapper-inner p.small {
		margin-top: 0.8rem;
	}

</style>
<div class="col-xs-12 materialis-add-section-wrapper middle-xs">
	<div class="border materialis-add-section-wrapper-inner">
		<button data-install-companion-button="true" class="button blue"><?php esc_html_e('Add Section', 'materialis'); ?></button>
		<script>
            (function () {
                jQuery(function () {
                    jQuery('[data-install-companion-button="true"]').click(function (event) {
                        parent.ExtendThemesCompanionPopover.showPopover(event.currentTarget, 'down')
                    })
                });
            })();
		</script>
	</div>
</div>
