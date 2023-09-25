<div class="full section__request">
    <div class="grid-container text-center">
        <?php $title = get_field('title_request', 'options');
        if (!empty($title)) : ?>
            <p><?php echo $title; ?></p>
        <?php endif; ?>
        <?php $button = get_field('button_label_request', 'options');
        if (!empty($button)) : ?>
            <button class="button primary-button"
                    data-open="newPatient"><?php echo $button; ?></button>
        <?php endif; ?>
    </div>
</div>