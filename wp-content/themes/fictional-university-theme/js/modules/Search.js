import $ from 'jquery';

class Search {

    constructor() {
        this.openButtom = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
    }

    events(){
      this.openButtom.on('click',this.openOverlay);
      this.closeButton.on('click',this.closeOverlay)
    };

    openOverlay(){};
    closeOverlay(){};
}


export default Search;