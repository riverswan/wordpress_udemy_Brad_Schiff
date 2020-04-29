import $ from 'jquery';

class Search {

    constructor() {
        this.resultsDiv = $('#search-overlay__results');
        this.openButtom = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
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
        this.searchField.on('keydown', this.typingLogic.bind(this));
    };

    typingLogic(){
        clearTimeout(this.typingTimer);
        if (! this.isSpinnerVisible ) {
            this.resultsDiv.html('<div class="spinner-loader"></div>');
            this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this),500);
    }

    getResults(){
        this.resultsDiv.html(this.searchField.val());
        this.isSpinnerVisible = false;
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
        if (key.keyCode === 83 && !this.isOverlayOpened) {
            this.openOverlay();
        }

        if (key.keyCode === 27 && this.isOverlayOpened) {
            this.closeOverlay();
        }
    }
}


export default Search;