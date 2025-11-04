<?= $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container uk-container-small">

        <h1><?= $title ?></h1>
        <hr class="uk-divider-small">

        <form id="main-form" class="uk-flex uk-flex-column" method="POST" action="<?= baseUrl('words/add') ?>">
            <div class="uk-margin-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.native_word') ?></label>
                <input name="word" id="add-word-field" type="text" class="uk-input uk-border-rounded" value="<?= getForm('word') ?>">
                <?= show_error('errors', 'word') ?>
            </div>
            
            <div class="uk-margin-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.translation') ?></label>
                <input name="translation" id="add-translation-field" type="text" class="uk-input uk-border-rounded" value="<?= getForm('translation') ?>">
                <?= show_error('errors', 'translation') ?>
            </div>

            <div class="uk-margin-medium-bottom">
                <label for="" class="uk-form-label uk-margin-remove">[<?= $lang::translate('translations.transcription') ?>]</label>
                <input name="transcription" id="add-transcription-field" type="text" class="uk-input uk-border-rounded" value="<?= getForm('transcription') ?>">
                <?= show_error('errors', 'transcription') ?>
            </div>

            <div class="uk-margin-medium-bottom">
                <label for="" class="uk-form-label uk-margin-remove"><?= $lang::translate('translations.additional') ?></label>
                <textarea name="note" id="add-transcription-field" type="text" class="uk-textarea uk-border-rounded"><?= getForm('note') ?></textarea>
                <?= show_error('errors', 'note') ?>
            </div>

            <button type="submit" id="add-word-button" href="#" class="uk-button uk-button-rounded uk-button-primary uk-width-1-1 uk-border-rounded"><?= $lang::translate('translations.add_word') ?></button>
        </form>
        
    </div>
</section>

<?= $this->stop() ?>