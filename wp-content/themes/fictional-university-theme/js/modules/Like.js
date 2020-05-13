import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events() {
        $('.like-box').on('click', this.ourClickDispatcher.bind(this))
    }

    ourClickDispatcher(e) {
        let currLikeBox = $(e.target).closest('.like-box');
        if (currLikeBox.attr('data-exists') === 'yes') {
            this.deleteLike(currLikeBox)
        } else {
            this.createLike(currLikeBox)
        }
    }

    createLike(currLikeBox) {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            data: {
                'professorId': currLikeBox.data('professor')
            },
            success: (resp) => {
                currLikeBox.attr('data-exists', 'yes');

                let likeCount = parseInt(currLikeBox.find('.like-count').html(), 10);
                likeCount++;
                currLikeBox.find('.like-count').html(likeCount);
                currLikeBox.attr('data-like', resp);
                console.log(resp)
            },
            error: (resp) => {
                console.log(resp)
            }
        })
    }

    deleteLike(currLikeBox) {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'DELETE',
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            data: {
                'like': currLikeBox.attr('data-like')
            },
            success: (resp) => {
                currLikeBox.attr('data-exists', 'no');

                let likeCount = parseInt(currLikeBox.find('.like-count').html(), 10);
                likeCount--;
                currLikeBox.find('.like-count').html(likeCount);
                currLikeBox.attr('data-like', '');
                console.log(resp)
            },
            error: (resp) => {
                console.log(resp)
            }
        })
    }
}

export default Like;