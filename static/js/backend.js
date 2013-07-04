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

require([
        'jquery',
        'select2',
        'modal',
        'posts.list',
        'misc'
], function($, select2, modal, postsList, misc) {
    var personal = new modal.Modal('/backend/self/update',
                                   '#personal-info-modal',
                                   ['display_name', 'password'],
                                   'a.submit');
    personal.getInput('password').validate = function() { return true; };

    var user_create = new modal.Modal('/backend/user/create',
                                      '#create-user-modal',
                                      ['login_name', 'display_name', 'password',
                                       'roles'],
                                      'a.submit');

    $('.edit-user a.submit').click(function(e) {
        var user_id = $(this).attr('data-user-id'),
            user;

        e.preventDefault();

        user = new modal.Modal('/backend/user/' + user_id + '/update',
                         '#edit-user-modal-' + user_id,
                         ['login_name', 'display_name', 'password', 'roles']);
        user.getInput('password').validate = function() { return true; };
        user.send();
    });

    var create_modal = new modal.Modal('/backend/category/create',
                                       '#create-category-modal',
                                       ['name'], 'a.submit');
    
    $('.edit-category a.submit').click(function(e) {
        var cate_id = $(this).attr('data-category-id'),
            cate;

        e.preventDefault();

        cate = new modal.Modal('/backend/category/' + cate_id + '/update',
                               '#edit-category-modal-' + cate_id,
                               ['name']);
        cate.send();
    });

    $('.edit-category a.remove').click(function(e) {
        var cate_id = $(this).attr('data-category-id');

        e.preventDefault();

        $.post(misc.basic_uri + '/backend/category/' + cate_id + '/remove')
            .success(function(resp) {
                location.reload();
            }).error(function(resp) {
                console.log(resp);
            });
    });

    $('select[name="roles"]').select2({
        placeholder: '设定用户的角色',
        allowClear: true
    });

    // TODO 用 CSS 实现两栏等高
    $('#command-nav').height($('.lists-wrapper').height());
    $('.lists-wrapper').bind('lists-wrapper-resized', function() {
        $('#command-nav').height($('.lists-wrapper').height());
    });

    return {};
});
