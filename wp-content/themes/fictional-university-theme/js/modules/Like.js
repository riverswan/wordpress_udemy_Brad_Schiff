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
        $.ajax({
            url : universityData.root_url + '/wp-json/university/v1/manageLike' ,
            type : 'POST',
            data : {
              'professotId' : 1234567
            },
            success : (resp)=>{
                console.log(resp)
            },
            error : (resp)=>{
                console.log(resp)
            }
        })
    }

    deleteLike(){
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