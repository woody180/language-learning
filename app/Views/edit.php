<?= $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container uk-container-small">

        <h1><?= $lang::translate('translations.edit_word') ?></h1>
        <hr class="uk-divider-small">

        <?php if (hasFlashData('success')): ?>
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?= getFlashData('success') ?></p>
            </div>
        <?php endif; ?>

        <form id="main-form" class="uk-flex uk-flex-column" method="POST" action="<?= baseUrl("words/{$word->id}") ?>">

            <?= setMethod('put') ?>

            <div class="uk-margin-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.foreign_word') ?></label>
                <input name="word" id="add-word-field" type="text" class="uk-input uk-border-rounded" value="<?= $word->word ?>">
                <?= show_error('errors', 'word') ?>
            </div>
            
            <div class="uk-margin-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.foreign_word_translation') ?></label>
                <input name="translation" id="add-translation-field" type="text" class="uk-input uk-border-rounded" value="<?= $word->translation ?>">
                <?= show_error('errors', 'translation') ?>
            </div>

            <div class="uk-margin-medium-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.transcription') ?></label>
                <input name="transcription" id="add-transcription-field" type="text" class="uk-input uk-border-rounded" value="<?= $word->transcription ?>">
                <?= show_error('errors', 'transcription') ?>
            </div>

            <div class="uk-margin-medium-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.additional') ?></label>
                <textarea name="note" id="add-transcription-field" type="text" class="uk-textarea uk-border-rounded"><?= $word->note ?></textarea>
                <?= show_error('errors', 'note') ?>
            </div>


            <button type="submit" id="add-word-button" href="#" class="uk-button uk-button-rounded uk-button-primary uk-width-1-1 uk-border-rounded">სიტყვის განახლება</button>
        </form>
        
    </div>
</section>

<?= $this->stop() ?>