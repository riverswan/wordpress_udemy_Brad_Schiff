(function() {
    tinymce.PluginManager.add('wdm_mce_button', function( editor, url ) {
        editor.addButton('wdm_mce_button', {
            text: 'SB',
            icon: false,
            classes : 'sb-button',
            onclick: function() {

                let content = tinymce.activeEditor.selection.getNode();
                console.log(content.textContent)
                if (content.classList.contains('bold')){
                    tinymce.activeEditor.selection.setNode(`<p>${content.textContent}</p>`);
                }else {
                    tinymce.activeEditor.selection.setContent(`<span class="bold" style="font-weight: bold">${content.textContent}</span>`);
                }

            }
        });
    });
})();