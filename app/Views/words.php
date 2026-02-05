<?= $this->layout('partials/template', ['title' => $title]) ?>

<?= $this->start('mainSection') ?>
<section class="uk-section">
    <div class="uk-container uk-container-small">

        <h1><?= $title ?></h1>
        <hr class="uk-divider-small">

        <?php if (hasFlashData('success')): ?>
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?= getFlashData('success') ?></p>
            </div>
        <?php endif; ?>

        <ul class="uk-list uk-list-striped">
            <?php foreach ($data->data as $word): ?>
                <li class="<?= $class ?>">

                    <div class="uk-flex uk-flex-middle uk-flex-between">
                        <a href="<?= baseUrl('get-word/' . $word->id) ?>" class="uk-link-text uk-text-bold uk-text-capitalize">
                            <?= $word->word ?> - <span style="font-size: 10px;color: #ababab; margin-left: 55px"><?= $word->translation ?></span>
                        </a>
                        
                        <div class="uk-flex uk-flex-middle">
                            <div>
                                <label uk-tooltip="<?= $lang::translate('translations.show_hide_word') ?>" class="uk-switch uk-margin-small-right" for="<?= $word->id ?>" style="top: 10px">
                                    <input type="checkbox" id="<?= $word->id ?>"  <?= $word->repeatable ? 'checked' : '' ?>>
                                    <div class="uk-switch-slider"></div>
                                </label>

                                <a data-id="<?= $word->id ?>" uk-tooltip="<?= $lang::translate('translations.i_learned_this_word') ?>" href="#" uk-icon="icon: star" class="uk-margin-small-right uk-icon-button uk-button-primary add-to-learned <?= $word->learned ? 'uk-background-success' : '' ?>"></a>
                                <a data-id="<?= $word->id ?>" uk-tooltip="<?= $lang::translate('translations.edit_word') ?>" href="<?= baseUrl("words/{$word->id}/edit") ?>" uk-icon="icon: pencil" class="uk-margin-small-right uk-icon-button uk-button-primary edit-word"></a>
                                <a target="_blank" uk-tooltip="showmeword.com info" href="https://showmeword.com/definition/english_word/<?= str_replace(' ', '+', strtolower($word->word)) ?>" uk-icon="icon: info" class="uk-margin-small-right uk-icon-button uk-button-primary"></a>
                                
                                <a data-id="<?= $word->id ?>" uk-tooltip="See note" uk-toggle="target: #note-<?= $word->id ?>; animation: uk-animation-fade;" href="#note-<?= $word->id ?>" uk-icon="icon: chevron-down" class="<?= ($word->note && !empty($word->note)) ? '' : 'uk-disabled' ?> uk-margin-small-right uk-icon-button uk-button-primary"></a>

                                <form method="POST" action="<?= baseUrl("words/$word->id") ?>" class="uk-display-inline" onsubmit="return confirm('Are you sure?')">
                                    <?= setMethod('delete') ?>
                                    <button type="submit" uk-tooltip="<?= $lang::translate('translations.remove_word') ?>" uk-icon="icon: trash" class="uk-icon-button uk-button-primary"></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if ($word->note && !empty($word->note)): ?>
                    <div class="word-note uk-card uk-card-default uk-card-body uk-margin-small" id="note-<?= $word->id ?>" hidden>
                        <p><?= $word->note ?></p>
                    </div>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($data->pager): ?>
            <div class="uk-margin-top uk-flex uk-flex-center">
                <?= $data->pager ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?= $this->stop() ?>