import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events(){
        $('#mynotes').on('click','.delete-note',this.deleteNote.bind(this));
        $('#mynotes').on('click','.edit-note',this.editNote.bind(this));
        $('#mynotes').on('click','.update-note',this.updateNote.bind(this));
        $('.submit-note').on('click',this.createNote.bind(this));
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


    makeNoteEditable(thisNote){
        thisNote.find('.edit-note').html('<i class="fa fa-times"></i>Cancel');
        thisNote.find('.update-note').addClass('update-note--visible');
        thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
        thisNote.data('state', 'editable');
    }
    makeNoteReadonly(thisNote){
        thisNote.find('.edit-note').html('<i class="fa fa-pencil"></i>Edit');
        thisNote.find('.update-note').removeClass('update-note--visible');
        thisNote.find('.note-title-field, .note-body-field').attr('readonly','readonly').removeClass('note-active-field');
        thisNote.data('state', 'cancel');
    }

    editNote(e){
        let thisNote = $(e.target).parents('li');
        if (thisNote.data('state') === 'editable') {
            this.makeNoteReadonly(thisNote);
        }else {
            this.makeNoteEditable(thisNote)
        }

    }



    updateNote(e){
        // alert('clicked');
        let thisNote = $(e.target).parents('li');
        let updatedPost = {
            'title' : thisNote.find('.note-title-field').val(),
            'content' : thisNote.find('.note-body-field').val()
        };

        $.ajax({
            url : universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type : 'POST',
            data : updatedPost,
            beforeSend : (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            success :  (resp) => {
                this.makeNoteReadonly(thisNote);
            },
            error : (resp)=>{
                console.log('error');
                console.log(resp);
            },
        })
    }


    createNote(e){
        let updatedPost = {
            'title' : $('.new-note-title').val(),
            'content' : $('.new-note-body').val(),
            'status' : 'publish',
        };

        $.ajax({
            url : universityData.root_url + '/wp-json/wp/v2/note/',
            type : 'POST',
            data : updatedPost,
            beforeSend : (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            success :  (resp) => {
                $('.new-note-title, .new-note-body').val('');
                $(`
                    <li data-id="${resp.id}">
                    <input readonly class="note-title-field" type="text" value="${resp.title.raw}">
                    <span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o"></i>Delete</span>
                    <textarea readonly class="note-body-field" name="" id="" cols="30"
                              rows="10">${resp.content.raw}</textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i>Save</span>

                </li>
                `).prependTo('#mynotes').hide().slideDown();
            },
            error : (resp)=>{
                console.log('error');
                console.log(resp);
            },
        })
    }


}

export default MyNotes;