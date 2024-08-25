import SketchEngine from './SketchEngine.js';

export default class MainClass extends SketchEngine {
    constructor(baseurl) {
        super();
        this.variables.baseurl = baseurl;
    }


    variables = {
        position: 'bottom-center',
        timeout: 2000
    }

    execute = [
        'linkWords', 'activeNavLinks'
    ];


    selectors = {
        addWordField: '#add-word-field',
        addWordButton: '#add-word-button',
        addTranslationFirld: '#add-translation-field',
        mainForm: '#main-form',
        randomizeWords: '#randomize-words',
        wordPar: '#word',
        translationPar: '#translation span',
        addToLearned: '.add-to-learned',
        addToNotLearned: '.add-to-not-learned',
        doNotShow: '.do-not-show',
        switcher: '.uk-switch input',
        edit: '.edit-word',
        showMeWordUrl: '#show-me-word',
        nav: '.uk-navbar-nav',
        wordItem: '.word-list-item'
    };


    catchDOM() {}


    bindEvents() {
        this.lib(this.selectors.randomizeWords).on('click', this.functions.randomizeWords.bind(this));
        this.lib('body').on('click', this.functions.addToLearned.bind(this), this.selectors.addToLearned);
        this.lib('body').on('click', this.functions.doNotShow.bind(this), this.selectors.doNotShow);
        this.lib(this.selectors.switcher).on('change', this.functions.repeatableToggle.bind(this));
    }


    functions = {

        // Active navigation
        activeNavLinks()
        {
            const navLinks = document.querySelectorAll(`${this.selectors.nav} li a`);
            const currentUrl = location.href.split('?')[0];

            navLinks.forEach(el => el.href == currentUrl ? el.closest('li').classList.add('uk-active') : '')
        },


        showMeWordUrl(word)
        {
            const href = 'https://showmeword.com/definition/english_word/%URL%';
            document.querySelector(this.selectors.showMeWordUrl).href = href.replace('%URL%', word.toLowerCase());
        },

        repeatableToggle(e)
        {
            const toggler = e.target;
            const int = toggler.checked ? 1 : 0;
            const id = toggler.getAttribute('id');
            
            fetch(`${this.variables.baseurl}/words/${id}/repeatable/${int}`, {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(res => {
                UIkit.notification({
                    message: `<span class="uk-text-small">${res}</span>`,
                    status: 'success',
                    pos: this.variables.position,
                    timeout: this.variables.timeout
                });
            })
        },


        doNotShow(e)
        {
            e.preventDefault();

            const id = e.target.closest('a').getAttribute('data-id');

            fetch(`${this.variables.baseurl}/words/${id}/do-not-show`, {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(res => {
                UIkit.notification({
                    message: `<span class="uk-text-small">${res}</span>`,
                    status: 'success',
                    pos: this.variables.position,
                    timeout: this.variables.timeout
                });

            })
        },


        addToNotLearned(e, id)
        {
            fetch(`${this.variables.baseurl}/words/not-learned/${id}`, {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(res => {

                const li = e.target.closest(this.selectors.wordItem);
                if (li) li.remove();

                UIkit.notification({
                    message: `<span class="uk-text-small">${res}</span>`,
                    status: 'primary',
                    pos: this.variables.position,
                    timeout: this.variables.timeout
                });

            })
        },


        addToLearned(e)
        {
            e.preventDefault();

            const el = e.target.closest('a')
            const id = el.getAttribute('data-id');

            if (el.className.includes('uk-background-success')) {
                this.functions.addToNotLearned.call(this, e, id);
                el.classList.remove('uk-background-success');
                return false;
            }

            fetch(`${this.variables.baseurl}/words/learned/${id}`, {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(res => {

                el.classList.add('uk-background-success');

                const li = el.closest(this.selectors.wordItem);
                if (li) li.remove();

                UIkit.notification({
                    message: `<span class="uk-text-small">${res}</span>`,
                    status: 'success',
                    pos: this.variables.position,
                    timeout: this.variables.timeout
                });

            })
        },

        
        randomizeWords(e)
        {
            e.preventDefault();

            const button = e.target.closest(this.selectors.randomizeWords);
            const id = button.getAttribute('data-id');
            
            fetch(`${this.variables.baseurl}/words/randomize?word_id=${id}`, {
                method: 'GET',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.json())
            .then(res => {

                this.lib('.word-note p').text('...');
                if (!res.note) {
                    this.lib('.note-collapse').addClass('uk-disabled');
                } else {
                    this.lib('.note-collapse').removeClass('uk-disabled');
                    this.lib('.word-note p').text(res.note);
                    this.functions.linkWords.call(this);
                }

                button.setAttribute('data-id', res.id);

                document.querySelector(this.selectors.wordPar).innerText = res.word;
                document.querySelector(this.selectors.translationPar).innerText = '- ' + res.translation;

                document.querySelectorAll('a[data-id]').forEach(a => a.setAttribute('data-id', res.id));

                this.functions.showMeWordUrl.call(this, res.word);

                this.lib('.uk-button-primary.uk-background-success').removeClass('uk-background-success');
            })
            .catch(err => console.log(err));
        },



        linkWords()
        {
            const notes = document.querySelectorAll('.word-note p');
            
            if (notes.length) {

                notes.forEach(note => {
                
                    const text = note.innerText;
                    const match = text.match(/\%(.*?)\%/gm);

                    if (match && match.length) {
                        const newOne = text.replace(/%([^%]+)%/g, '<strong><u>$1</u></strong>');
                        note.innerHTML = this.functions.nl2br(newOne);
                    }

                });

            }
        },


        nl2br (str, is_xhtml = true) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            const breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }
    }
}