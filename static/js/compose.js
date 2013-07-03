require.config({
    shim: {
        select2: ['jquery'],
        bootmodal: ['jquery'],
        bootdrop: ['jquery']
    },
    paths: {
        jquery: 'libs/jquery.min',
        bootmodal: 'libs/bootstrap-modal',
        bootdrop: 'libs/bootstrap-dropdown',
        select2: 'libs/select2.min'
    }
});

define([
       'jquery',
       'select2',
       'misc',
       'modal',
       'bootdrop',
       'editor'
], function($, select2, misc, modal, dropdown, Editor) {
    var status = new Editor.StatusBar('#status-bar'),
        editor = new Editor.Editor('/backend/post/autosave',
                                   '#editwrap article', status),
        toolbar = new Editor.Toolbar('#editor-commands', editor),
        selection;

    if (editor.attr('data-status') === '-1') {
        $('.publish').hide();
    }
    setInterval(function() {
        if (editor.changed) {
            editor.autosave();
            editor.changed = false;
        }
        if (editor.attr('data-status') !== '-1') {
            $('.publish').show();
        }
    }, 5000);

    if (editor.attr('data-status') === '1') {
        status.setDefault('已发表');
    } else {
        status.setDefault('草稿');
    }

    $('.save-draft').click(function(e) {
        e.preventDefault();
        editor.autosave();
    });

    $('.publish').click(function(e) {
        var post_id = editor.attr('data-id'),
            publish_modal = new modal.Modal('/backend/post/' + post_id + '/publish',
                                            '#publish-modal',
                                            ['tags', 'status', 'categories', 'campus'],
                                            'a.submit');
        publish_modal.getInput('campus').getValue =
        publish_modal.getInput('tags').getValue = function() {
            return this._input.val().split(',');
        };
        publish_modal.getInputsValue = publish_modal.getValue;
        publish_modal.getValue = function() {
            var post = editor.value();

            data = this.getInputsValue();

            if (!data) {
                return data;
            }

            data.title = post.title;
            data.content = post.content;

            return data;
        };
    });
   
    $('select[name="categories"]').select2();
    $('select[name="status"]').select2();
    $.get(misc.basic_uri + '/backend/post/campus', function(campus) {
        $('input[name="campus"]').select2({
            tags: campus
        });
    });
    $.get(misc.basic_uri + '/backend/post/tags', function(resp) {
        var tags = [];

        resp.forEach(function(v, i) {
            tags.push(v.name);
        });

        $('input[name="tags"]').select2({
            tags: tags
        });
    });

    $('.insert-link').click(function(e) {
        selection = editor.currentSelection();
        $('#insert-link-modal input').val('');
    });
    $('#insert-link-modal .submit').click(function(e) {
        var modal = $('#insert-link-modal'),
            link = $('input[name="uri"]', modal);

        e.preventDefault();

        misc.remove_errors();
        if (!link.val()) {
            link.addClass('error');
            return;
        }

        editor.select(selection);
        editor.execute('createLink', link.val());

        $(modal).modal('hide');
    });

    return {};
});
