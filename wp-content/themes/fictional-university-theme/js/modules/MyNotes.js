import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events(){
        $('.delete-note').on('click',this.deleteNote.bind(this))
    }

    deleteNote(){
        alert('clicked')
    }

}

export default MyNotes;