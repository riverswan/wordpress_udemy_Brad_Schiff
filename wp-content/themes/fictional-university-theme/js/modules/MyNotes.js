import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events(){
        $('.delete-note').on('click',this.deleteNote.bind(this))
    }

    deleteNote(e){
        // alert('clicked');
        let thisNote = $(e.target).parents('li');
        $.ajax({
            url : universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
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