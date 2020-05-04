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

        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), res => {
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
                    ${res.program.length ? `<ul class="link-list min-list">` : `<p>No programs matches search. <a href="${universityData.root_url}/programs">View all programs</a></p>`}
                     ${res.program.map((item) => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                    ${res.program.length ? `</ul>` : ``}
                    <h2 class="search-overlay__section-title">Professors</h2>
                    ${res.professor.length ? `<ul class="professor-cards">` : `<p>No professors matches search.</p>`}
                     ${res.professor.map((item) => `
                        <li class="professor-card__list-item">
                <a class="professor-card" href="${item.permalink}">
                <img src="${item.image}" alt="123" class="professor-card__image">
               <span class="professor-card__name">${item.title}</span>
                </a>
                </li>
                     `).join('')}
                    ${res.professor.length ? `</ul>` : ``}
</div>
                    <div class="one-third">
                    <h2 class="search-overlay__section-title">Campuses</h2>
                    ${res.campus.length ? `<ul class="link-list min-list">` : `<p>No campuses matches search. <a href="${universityData.root_url}/campuses">View all campuses</a></p>`}
                     ${res.campus.map((item) => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                    ${res.campus.length ? `</ul>` : ``}
                    <h2 class="search-overlay__section-title">Events</h2>
                    ${res.event.length ? `` : `<p>No events matches search. <a href="${universityData.root_url}/events">View all events</a></p>`}
                    ${res.event.map((item) => `
                   
                    <div class="event-summary">
	<a class="event-summary__date t-center" href="${item.permalink}">
                            <span class="event-summary__month">${item.month}</span>
		<span class="event-summary__day">${item.day}</span>
	</a>
	<div class="event-summary__content">
		<h5 class="event-summary__title headline headline--tiny"><a
				href="${item.permalink}">${item.title}</a></h5>
		<p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
	</div>
</div>
                    
                    `).join('')}
</div>
</div>
            `);
            this.isSpinnerVisible = false;
        });
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        setTimeout(() => {
            this.searchField.focus();
        }, 301);
        this.isOverlayOpened = true;
        return false;
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