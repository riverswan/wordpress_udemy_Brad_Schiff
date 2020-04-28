import $ from 'jquery';

class Search {

    constructor() {
        this.openButtom = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchField = $('#search-term');
        this.events();
        this.isOverlayOpened = false;
        this.typingTimer;

    }

    events() {
        this.openButtom.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keydown', this.typingLogic);
    };

    typingLogic(){
        clearTimeout(this.typingTimer);
        this.typingTimer = setTimeout(()=>{
            console.log('hello')
        },1000);
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