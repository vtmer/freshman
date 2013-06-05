(function() {
    // 清除所有错误
    var remove_errors = function() {
        $('.error').removeClass('error');
    };

    // 网站根地址
    // e.g.
    //      http://exmaple.com/index.php
    //      http://exmaple.com/subpath/index.php
    var basic_uri = (function() {
        var index_script = 'index.php',
            index_scriptr = /index\.php/;

        return location.href.split(index_scriptr)[0] + index_script;
    })();

    // Input 类
    // 提供 modal 下表单 input 的逻辑支持
    // 
    // @set_error   设置错误
    // @validate    验证元素
    // @grab        获取元素值

    // @constructor
    //
    // selector     选择器路径
    // context      父级元素选择器
    var Input = function(selector, context) {
        this.input = $(selector, context);
        this.name = this.input.attr('name');
    };
    Input.prototype.set_error = function() {
        this.input.addClass('error');
        return this;
    };
    Input.prototype.validate = function() {
        if (!this.grab()) {
            return false;
        }
        return true;
    };
    Input.prototype.grab = function() {
        return this.input.val();
    };

    // Modal 类
    // 提供 Modal 组件逻辑支持
    //
    // @get_input   获取子 input 组件
    // @validate    验证子 input 组件
    // @grab        获取组件数据
    // @send        发送数据

    // @constructor
    //
    // uri          数据保存地址
    // name         modal 名字
    // inputs       子 input 组件名字
    var Modal = function(uri, name, inputs) {
        var _modal, _inputs;

        this.uri = basic_uri + uri;

        _modal = $('#' + name);
        this.modal = _modal;
        this.context = this.modal;

        _inputs = [];
        inputs.forEach(function(name, idx, arr) {
            _inputs.push(new Input('[name=' + name + ']', _modal));
        });
        this.inputs = _inputs;
    };
    Modal.prototype.get_input = function(name) {
        var input = null;

        this.inputs.forEach(function(value, idx, arr) {
            if (value.name === name)
                input = value;
        });
        return input;
    };
    Modal.prototype.validate = function() {
        var flag = true;

        remove_errors();
        this.inputs.forEach(function(value, idx, arr) {
            if (!value.validate()) {
                flag = false;
                value.set_error();
            }
        }, this);

        return flag;
    };
    Modal.prototype.grab = function() {
        var data = {}, inputs, i;

        if (!this.validate())
            return null;

        this.inputs.forEach(function(value, idx, arr) {
            data[value.name] = value.grab();
        });
        return data;
    };
    Modal.prototype.send = function() {
        var payload = this.grab();

        if (!payload)
            return;
        $.post(this.uri, payload)
            .success(this.send_success())
            .error(this.send_error());
    };
    Modal.prototype.send_success = function() {
        var that = this;

        return function(resp) {
            that.modal.modal('hide');
            location.reload();
        };
    };
    Modal.prototype.send_error = function() {
        var that = this;

        return function(resp) {
            var err = resp.responseJSON;

            if (!err || !err.error)
                return;

            that.inputs.forEach(function(value, idx, arr) {
                if (value.name === err.error) {
                    value.set_error();
                }
            });
        };
    };

    $('[role="button"]').click(remove_errors);

    // personal info 模块
    var personal = new Modal('/backend/self/update', 'personal-info-modal',
                             ['display_name', 'password']);
    personal.get_input('password').validate = function() { return true; };
    $('a.submit', personal.context).click(function(e) {
        e.preventDefault();
        personal.send();
    });

    // create user 模块
    var user_create = new Modal('/backend/user/create', 'create-user-modal',
                                ['login_name', 'display_name', 'password', 'roles']);
    $('a.submit', user_create.context).click(function(e) {
        e.preventDefault();
        user_create.send();
    });

    // edit user 模块
    $('.edit-user select[name="roles"]').each(function(k, v) {
        var selected = [];

        $('option[checked]', $(v)).each(function(key, value) {
            selected.push($(value).attr('value'));
        });

        $(v).val(selected);
    });
    $('.edit-user a.submit').click(function (e) {
        var user_id = $(this).attr('data-user-id'),
            modal;

        e.preventDefault();

        modal = new Modal('/backend/user/' + user_id + '/update',
                          'edit-user-modal-' + user_id,
                          ['login_name', 'display_name', 'password', 'roles']);
        modal.get_input('password').validate = function() { return true; };
        modal.send();
    });

    // create category 模块
    create_modal = new Modal('/backend/category/create', 'create-category-modal',
                             ['name']);
    $('a.submit', create_modal.context).click(function(e) {
        e.preventDefault();
        create_modal.send();
    });

    // edit category 模块
    $('.edit-category a.submit').click(function(e) {
        var cate_id = $(this).attr('data-category-id'),
            modal;

        e.preventDefault();

        modal = new Modal('/backend/category/' + cate_id + '/update',
                          'edit-category-modal-' + cate_id,
                          ['name']);
        modal.send();
    });
    $('.edit-category a.remove').click(function(e) {
        var cate_id = $(this).attr('data-category-id');

        e.preventDefault();

        $.post(basic_uri + '/backend/category/' + cate_id + '/remove')
            .success(function(resp) {
                location.reload();
            }).error(function(resp) {
                console.log(resp);
            });
    });

    // select2 设置
    $('select[name="roles"]').select2({
        placeholder: "设定用户的角色",
        allowClear: true
    });
})();
