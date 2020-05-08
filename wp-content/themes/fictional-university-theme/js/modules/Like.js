import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events(){
        $('.like-box').on('click',this.ourClickDispatcher.bind(this))
    }

    ourClickDispatcher(e){
        let currLikeBox = $(e.target).closest('.like-box');
        if (currLikeBox.data('exists') === 'yes'){
            this.deleteLike()
        }else {
            this.createLike()
        }
    }

    createLike(){

    }

    deleteLike(){
        alert('delete')
    }
}

export default Like;