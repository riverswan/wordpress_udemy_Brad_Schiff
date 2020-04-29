import $ from 'jquery';

class Search {

    constructor() {
        this.resultsDiv = $('#search-overlay__results');
        this.openButtom = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.previousValue;
        this.searchField = $('#search-term');
        this.isSpinnerVisible = false;
        this.events();
        this.isOverlayOpened = false;
        this.typingTimer;

    }

    events() {
        this.openButtom.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
    };

    typingLogic() {
        if (this.searchField.val() !== this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 500);
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }

        }
        this.previousValue = this.searchField.val()
    }

    getResults() {
        $.getJSON(
            'http://localhost:3000/wp-json/wp/v2/posts?search=' + this.searchField.val(),
            (posts) => {

                this.resultsDiv.html(
                    `
                    <h2 class="search-overlay__section-title">General Information</h2>
                    <ul class="link-list min-list">
                     ${posts.map((item)=>`<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                    </ul>
                    `
                );
            },
        )
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        this.isOverlayOpened = true;
    };

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpened = false;
    };

    keyPressDispatcher(key) {
        if (key.keyCode === 83 && !this.isOverlayOpened && !$('input, textarea').is(':focus')) {
            this.openOverlay();
        }

        if (key.keyCode === 27 && this.isOverlayOpened) {
            this.closeOverlay();
        }
    }
}


export default Search;