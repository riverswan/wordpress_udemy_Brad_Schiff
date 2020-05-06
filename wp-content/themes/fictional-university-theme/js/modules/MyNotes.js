import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events(){
        $('.delete-note').on('click',this.deleteNote.bind(this))
    }

    deleteNote(){
        // alert('clicked');
        $.ajax({
            url : universityData.root_url + '/wp-json/wp/v2/note/' + '95',
            type : 'DELETE',
            beforeSend : (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            success :  (resp) => {
                console.log('deleted');
                console.log(resp);
            },
            error : (resp)=>{
                console.log('error');
                console.log(resp);
            },
        })
    }

}

export default MyNotes;