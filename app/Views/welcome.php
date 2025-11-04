<?= $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container uk-container-small">

        <div class="uk-margin-large-top uk-border-rounded">
            <div class="uk-card uk-card-default uk-border-rounded">
                <div class="uk-card-body">
                    <div class="uk-flex">
                        <div class="uk-text-lead uk-margin-remove uk-flex-1">
                            <p id="word" class="uk-margin-small-right uk-text-capitalize uk-margin-remove-bottom"><?= $word->word ?></p>
                            <p id="translation" hidden class="uk-margin-remove-top uk-margin-remove-bottom"><span class="uk-text-small"><?= $word->translation ?></span></p>
                        </div>

                        <a uk-toggle="target: #translation" uk-tooltip="<?= translate('translations.word_meaning') ?>" href="#" uk-icon="icon: eye" class="uk-margin-small-right uk-icon-button uk-button-primary"></a>
                        <a data-id="<?= $word->id ?>" uk-tooltip="<?= translate('translations.i_learned_this_word') ?>" href="#" uk-icon="icon: star" class="uk-margin-small-right uk-icon-button uk-button-primary add-to-learned"></a>
                        <a data-id="<?= $word->id ?>" uk-tooltip="<?= $lang::translate('translations.edit_word') ?>" href="<?= baseUrl("words/{$word->id}/edit") ?>" uk-icon="icon: pencil" class="uk-margin-small-right uk-icon-button uk-button-primary edit-word"></a>
                        <a data-id="<?= $word->id ?>" uk-tooltip="<?= translate('translations.dont_show_word') ?>" href="#" uk-icon="icon: ban" class="uk-margin-small-right uk-icon-button uk-button-primary do-not-show"></a>
                        <a id="show-me-word" target="_blank" uk-tooltip="showmeword.com info" href="https://showmeword.com/definition/english_word/<?= strtolower($word->word) ?>" uk-icon="icon: info" class="uk-margin-small-right uk-icon-button uk-button-primary"></a>
                        <!-- <a data-id="<?= '' // $word->id ?>" uk-tooltip="ეს სიტყვა არ ვიცი" href="#" uk-icon="icon: question" class="uk-icon-button uk-button-primary"></a> -->
                        <a uk-tooltip="See note" uk-toggle="target: #note-collapse; animation: uk-animation-fade;" href="#note-collapse" uk-icon="icon: chevron-down" class="<?= $word->note && !empty($word->note) ? '' : 'uk-disabled' ?> uk-margin-small-right uk-icon-button uk-button-primary note-collapse"></a>
                    </div>
                </div>
            </div>

            <div class="word-note uk-card uk-card-default uk-card-body uk-margin-small uk-border-rounded" id="note-collapse" hidden>
                <p><?= $word->note ?></p>
            </div>

            <div class="uk-flex uk-flex-right uk-margin">
                <button id="randomize-words" class="uk-button uk-button-primary uk-border-rounded uk-button-icon uk-button-icon-left uk-width-1-1" data-id="<?= $word->id ?>">
                    <span class="uk-position-relative" style="top: 1px; font-size: 12px"><?= $lang::translate('translations.other_word') ?></span>
                    <span uk-icon="icon: refresh; ratio: .8"></span>
                </button>
            </div>
        </div>
        
    </div>
</section>

<?= $this->stop() ?>