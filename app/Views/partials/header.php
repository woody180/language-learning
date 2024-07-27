<div class="uk-position-z-index uk-background-secondary uk-light" uk-sticky>
    <nav class="uk-container uk-container-small" uk-navbar>
        <div class="uk-navbar-left nav-overlay">
            <ul class="uk-navbar-nav">
                <li><a href="/">
                    <span uk-icon="icon: home; ratio: .75" class="uk-inline-block uk-position-relative" style="margin-right: 4px; top: -1px"></span>
                    <?= translate('nav.home') ?></a></li>
                <li><a href="<?= baseUrl('words/learned') ?>"><?= translate('nav.learned') ?></a></li>
                <li><a href="<?= baseUrl('words/unlearned') ?>"><?= translate('nav.unknown') ?></a></li>
                <li><a href="<?= baseUrl('words') ?>"><?= translate('nav.all') ?> <span class="uk-badge"><?= initModel('word')->totalWords() ?></span></a></li>
            </ul>
        </div>


        <div class="nav-overlay uk-navbar-right">

            <a class="uk-button uk-button-default add-word-nav uk-button-small uk-border-rounded" href="<?= baseUrl('words/add') ?>">
                <span uk-icon="icon: plus; ratio: .6"></span>
                <?= translate('translations.add_word') ?>
            </a>

            <a class="uk-navbar-toggle" uk-search-icon uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>

        </div>

        <div class="nav-overlay uk-navbar-left uk-flex-1" hidden>

            <div class="uk-navbar-item uk-width-expand">
                <form method="GET" action="<?= baseUrl("search") ?>" class="uk-search uk-search-navbar uk-width-1-1">
                    <input name="word" class="uk-search-input" type="search" placeholder="Search" aria-label="Search" value="<?= query('word') ?>" autofocus>
                </form>
            </div>

            <a class="uk-navbar-toggle" uk-close uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#"></a>

        </div>

    </nav>
</div>