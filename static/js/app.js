(function() {
    var basic_uri, set_error, remove_errors;

    basic_uri = (function() {
        var current = location.href,
            index_script = 'index.php',
            index_scriptr = /index\.php/;

        return current.split(index_scriptr)[0] + index_script;
    })();

    set_error = function(obj) {
        $(obj).addClass('error');
    };
    remove_errors = function() {
        $('.error').removeClass('error');
    };

    // personal info 模块
    (function() {
        var modal, inpDispName, inpPassword,
            oldDispName, oldPassword;

        modal = $('#personal-info-modal');
        inpDispName = $('#personal-info-modal input[name="display_name"]');
        inpPassword = $('#personal-info-modal input[name="password"]');
        oldDispName = inpDispName.val();
        oldPassword = inpPassword.val();

        $('#personal-info-modal a.submit').click(function(e) {
            var dispName, password,
                data = {};
        
            remove_errors();
        
            dispName = inpDispName.val();
            password = inpPassword.val();
            
            if (dispName !== oldDispName)
                data.display_name = dispName;
            if (password !== oldPassword)
                data.password = password;

            if ($.isEmptyObject(data)) {
                modal.modal('hide');
                return;
            }

            /* FIXME better url path */
            $.post(basic_uri + '/backend/self/update', data).success(function(resp) {
                modal.modal('hide');
                location.reload();
            }).error(function(resp) {
                var err = resp.responseJSON;

                if (err.error === 'display_name') {
                    set_error(inpDispName);
                }
                if (err.error === 'password') {
                    set_error(inpPassword);
                }
            });

            e.preventDefault();
        });
    })();

    // create user 模块
    (function() {
        var modal, roles,
            inpLogName, inpDispName, inpPassword, inpRole,
            data;

        modal = $('#create-user-modal');
        roles = $('#create-user-modal select[name="roles"]');
        inpLogName = $('#create-user-modal input[name="login_name"]');
        inpDispName = $('#create-user-modal input[name="display_name"]');
        inpPassword = $('#create-user-modal input[name="password"]');
        inpRole = roles;

        $('#create-user-modal a.submit').click(function(e) {
            var ok = true;
        
            remove_errors();

            if (!inpLogName.val()) {
                set_error(inpLogName);
                ok = false;
            }
            if (!inpDispName.val()) {
                set_error(inpDispName);
                ok = false;
            }
            if (!inpPassword.val()) {
                set_error(inpPassword);
                ok = false;
            }
            if (!inpRole.val()) {
                set_error(inpRole);
                ok = false;
            }

            if (!ok) {
                e.preventDefault();
                return;
            }

            data = {
                'login_name': inpLogName.val(),
                'display_name': inpDispName.val(),
                'password': inpPassword.val(),
                'roles': inpRole.val()
            };
            $.post(basic_uri + '/backend/user/create', data).success(function(resp) {
                modal.modal('hide');
                location.reload();
            }).error(function(resp) {
                var err = resp.responseJSON;

                if (err.error === 'login_name')
                    set_error(inpLogName);
                if (err.error === 'display_name')
                    set_error(inpDispName);
            });

            e.preventDefault();
        });
    })();

    // edit user 模块
    (function() {
        $('.edit-user select[name="roles"]').each(function(k, v) {
            var selected = [];

            $('option[checked]', $(v)).each(function(key, value) {
                selected.push($(value).attr('value'));
            });

            $(v).val(selected);
        });

        $('.edit-user a.submit').click(function(e) {
            var user_id = $(this).attr('data-user-id'),
                modal, inpLogName, inpDispName, inpPassword, inpRole,
                ok = true;

            modal = $('#edit-user-modal-' + user_id);
            inpLogName = $('input[name="login_name"]', modal);
            inpDispName = $('input[name="display_name"]', modal);
            inpPassword = $('input[name="password"]', modal);
            inpRole = $('select[name="roles"]', modal);
        
            remove_errors();

            if (!inpLogName.val()) {
                set_error(inpLogName);
                ok = false;
            }
            if (!inpDispName.val()) {
                set_error(inpDispName);
                ok = false;
            }
            if (!inpRole.val()) {
                set_error(inpRole);
                ok = false;
            }

            if (!ok) {
                e.preventDefault();
                return;
            }
            data = {
                'login_name': inpLogName.val(),
                'display_name': inpDispName.val(),
                'roles': inpRole.val(),
                'password': inpPassword.val()
            };

            $.post(basic_uri + '/backend/user/' + user_id + '/update', data)
                .success(function(resp) {
                    modal.modal('hide');
                    location.reload();
                }).error(function(resp) {
                    var err = resp.responseJSON;

                    if (err.error === 'login_name') {
                        set_error(inpLogName);
                    }
                    if (err.error === 'display_name') {
                        set_error(inpDispName);
                    }
                    if (err.error === 'password') {
                        set_error(inpPassword);
                    }
                    if (err.error === 'roles')
                        set_error(inpRole);
                });

            e.preventDefault();
        });

    })();

    // create category 模块
    (function() {
        var modal, inpName;

        modal = $('#create-category-modal');
        inpName = $('input[name="name"]', modal);

        $('a.submit', modal).click(function(e) {
            var data, ok = true;

            remove_errors();

            if (!inpName.val()) {
                set_error(inpName);
                ok = false;
            }
            
            if (!ok) {
                e.preventDefault();
                return;
            }

            data = {
                name: inpName.val()
            };

            $.post(basic_uri + '/backend/category/create', data).success(function(resp) {
                modal.modal('hide');
                location.reload();
            }).error(function(resp) {
                var err = resp.responseJSON;

                if (err.error === 'name')
                    set_error(inpName);

                e.preventDefault();
            });
        });
    })();

    // edit category 模块
    (function () {
        $('.edit-category a.submit').click(function(e) {
            var cate_id = $(this).attr('data-category-id'),
                modal, inpName, ok = true, data;

            modal = $('#edit-category-modal-' + cate_id);
            inpName = $('input[name="name"]', modal);

            remove_errors();

            if (!inpName.val()) {
                set_error(inpName);
                ok = false;
            }

            if (!ok) {
                e.preventDefault();
                return;
            }
            data = {
                'name': inpName.val()
            };

            $.post(basic_uri + '/backend/category/' + cate_id + '/update', data)
                .success(function(resp) {
                    modal.modal('hide');
                    location.reload();
                }).error(function(resp) {
                    console.log(resp);
                    var err = resp.responseJSON;

                    if (err.error === 'name') {
                        set_error(inpName);
                    }
                });

            e.preventDefault();
        });

        $('.edit-category a.remove').click(function(e) {
            var cate_id = $(this).attr('data-category-id');

            $.post(basic_uri + '/backend/category/' + cate_id + '/remove')
                .success(function(resp) {
                    location.reload();
                }).error(function(resp) {
                    console.log(resp);
                });

            e.preventDefault();
        });
    })();

    $('select[name="roles"]').select2({
        placeholder: "设定用户的角色",
        allowClear: true
    });
    $('[role="button"]').click(remove_errors);
})();
