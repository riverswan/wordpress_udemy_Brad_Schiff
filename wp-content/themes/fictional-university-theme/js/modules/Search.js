import $ from 'jquery';

class Search {

    constructor() {
        this.addSearchHtml();
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

        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(),res=>{
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${res.general_info.length ? `<ul class="link-list min-list">` : `<p>No general info matches search</p>`}
                     ${res.general_info.map((item) => `<li><a href="${item.permalink}">${item.title}</a>${item.post_type ? ` by ` + item.author_name : ``}</li>`).join('')}
                    ${res.general_info.length ? `</ul>` : ``}
                    
</div>
                    <div class="one-third">
                    <h2 class="search-overlay__section-title">Programs</h2>
                    <h2 class="search-overlay__section-title">Professors</h2>
</div>
                    <div class="one-third">
                    <h2 class="search-overlay__section-title">Campuses</h2>
                    <h2 class="search-overlay__section-title">Events</h2>
</div>
</div>
            `);
        });


    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        setTimeout(() => {
            this.searchField.focus();
        }, 301);
        this.isOverlayOpened = true;
    };

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.searchField.val('');
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

    addSearchHtml() {
        $('body').append(`
            <div class="search-overlay">
    <div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" id="search-term" placeholder="Type your info here">
            <i class="fa fa-window-close search-overlay__close"></i>
        </div>
    </div>
    <div class="container">
        <div id="search-overlay__results"></div>
    </div>
</div>`)
    }
}


export default Search;