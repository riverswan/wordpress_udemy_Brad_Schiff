import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events(){
        $('.delete-note').on('click',this.deleteNote);
        $('.edit-note').on('click',this.editNote);
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
                thisNote.slideUp();
            },
            error : (resp)=>{
                console.log('error');
                console.log(resp);
            },
        })
    }


    editNote(e){
        let thisNote = $(e.target).parents('li');
        thisNote.find('.update-note').addClass('update-note--visible');
        thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field')
    }

}

export default MyNotes;