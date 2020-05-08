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
            this.deleteLike( currLikeBox )
        }else {
            this.createLike( currLikeBox )
        }
    }

    createLike( currLikeBox ){
        $.ajax({
            url : universityData.root_url + '/wp-json/university/v1/manageLike' ,
            type : 'POST',
            beforeSend : (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            data : {
              'professorId' : currLikeBox.data('professor')
            },
            success : (resp)=>{
                console.log(resp)
            },
            error : (resp)=>{
                console.log(resp)
            }
        })
    }

    deleteLike( currLikeBox ){
        $.ajax({
            url : universityData.root_url + '/wp-json/university/v1/manageLike' ,
            type : 'DELETE',
            success : (resp)=>{
                console.log(resp)
            },
            error : (resp)=>{
                console.log(resp)
            }
        })
    }
}

export default Like;