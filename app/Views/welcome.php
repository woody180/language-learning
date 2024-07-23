<?= $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container uk-container-small">

        <div class="uk-margin-large-top uk-border-rounded">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-middle">
                        <div class="uk-text-lead uk-margin-remove uk-flex-1 uk-flex uk-flex-middle">
                            <p id="word" class="uk-margin-right uk-text-capitalize"><?= $word->word ?></p>
                            <p id="translation" hidden class="uk-margin-remove-top"><span style="font-size: 11px;color: #9b9b9b;margin-left: 55px;"><?= $word->translation ?></span></p>
                        </div>

                        <a uk-toggle="target: #translation" uk-tooltip="სიტყვის მნიშვნელობის ნახვა" href="#" uk-icon="icon: eye" class="uk-margin-small-right uk-icon-button uk-button-primary"></a>
                        <a data-id="<?= $word->id ?>" uk-tooltip="ეს სიტყვა ვისწავლე" href="#" uk-icon="icon: star" class="uk-margin-small-right uk-icon-button uk-button-primary add-to-learned"></a>
                        <a data-id="<?= $word->id ?>" uk-tooltip="სიტყვის არ ჩვენება" href="#" uk-icon="icon: ban" class="uk-margin-small-right uk-icon-button uk-button-primary do-not-show"></a>
                        <a id="show-me-word" target="_blank" uk-tooltip="showmeword.com info" href="https://showmeword.com/definition/english_word/<?= strtolower($word->word) ?>" uk-icon="icon: info" class="uk-margin-small-right uk-icon-button uk-button-primary"></a>
                        <!-- <a data-id="<?= '' // $word->id ?>" uk-tooltip="ეს სიტყვა არ ვიცი" href="#" uk-icon="icon: question" class="uk-icon-button uk-button-primary"></a> -->
                        <a uk-tooltip="See note" uk-toggle="target: #note-collapse; animation: uk-animation-fade;" href="#note-collapse" uk-icon="icon: chevron-down" class="<?= $word->note && !empty($word->note) ? '' : 'uk-disabled' ?> uk-margin-small-right uk-icon-button uk-button-primary note-collapse"></a>
                    </div>
                </div>
            </div>

            <div class="word-note uk-card uk-card-default uk-card-body uk-margin-small" id="note-collapse" hidden>
                <p><?= $word->note ?></p>
            </div>

            <div class="uk-flex uk-flex-right uk-margin">
                <button id="randomize-words" class="uk-button uk-button-primary uk-border-rounded" data-id="<?= $word->id ?>">
                    <span><?= $lang::translate('translations.other_word') ?></span>
                    <span uk-icon="icon: refresh"></span>
                </button>
            </div>
        </div>
        
    </div>
</section>

<?= $this->stop() ?>