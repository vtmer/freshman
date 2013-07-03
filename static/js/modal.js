define([
    'jquery',
    'bootmodal',
    'misc'
], function($, bootmodal, misc) {
    // Input 类
    // 提供 modal 下表单 input 的逻辑验证
    // 
    // @set_error   设置错误
    // @validate    验证元素
    // @grab        获取元素值

    // @constructor
    //
    // selector     选择器路径
    // context      父级元素选择器
    var Input = function(selector, context) {
        this._input = $(selector, context);
        this.name = this._input.attr('name');
    };
    Input.prototype.setError = function() {
        this._input.addClass('error');
        return this;
    };
    // 验证表单内容
    Input.prototype.validate = function() {
        if (!this.getValue()) {
            return false;
        }
        return true;
    };
    // 获取表单值
    Input.prototype.getValue = function() {
        return this._input.val();
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
    // selector     modal 选择器
    // inputs       子 input 组件名字
    // submit       提交选择器
    // cbSubmit     提交回调
    var Modal = function(uri, selector, inputs, submit, cbSubmit) {
        var that = this;

        this.uri = misc.basic_uri + uri;

        this._modal = $(selector);
        this.context = this._modal;

        this._inputs = [];
        inputs.forEach(function(name, idx, arr) {
            this._inputs.push(new Input('[name=' + name + ']', this._modal));
        }, this);

        if (submit) {
            $(submit, this.context).click(cbSubmit || function(e) {
                e.preventDefault();
                that.send();
            });
        }

        // 防止回车提交表单
        $('form', this.context).submit(function() {
            return false;
        });
        // 回车执行 a.submit.click
        $('form', this.context).keyup(function(e) {
            if (e.which === 13 && submit) {
                $(submit, that.context).click();
            }
        });
    };
    Modal.prototype.getInput = function(name) {
        for (var i = 0;i < this._inputs.length;i++) {
            if (this._inputs[i].name === name) {
                return this._inputs[i];
            }
        }
        return null;
    };
    Modal.prototype.validate = function() {
        var flag = true;

        misc.remove_errors();
        this._inputs.forEach(function(value, idx, arr) {
            if (!value.validate()) {
                flag = false;
                value.setError();
            }
        }, this);

        return flag;
    };
    Modal.prototype.getValue = function() {
        var data = {}, inputs, i;

        if (!this.validate())
            return null;

        this._inputs.forEach(function(value, idx, arr) {
            data[value.name] = value.getValue();
        });
        return data;
    };
    Modal.prototype.send = function(success, error) {
        var payload = this.getValue();

        if (!payload) {
            return;
        }
        $.post(this.uri, payload)
            .success(success || this.cbSendSuccess())
            .error(error || this.cbSendError());
    };
    Modal.prototype.cbSendSuccess = function() {
        var that = this;

        return function(resp) {
            that._modal.modal('hide');
            location.reload();
        };
    };
    Modal.prototype.cbSendError = function() {
        var that = this;

        return function(resp) {
            var err = resp.responseJSON;

            console.log(resp);
            if (!err || !err.error)
                return;

            that._inputs.forEach(function(value, idx, arr) {
                if (value.name === err.error) {
                    value.setError();
                }
            });
        };
    };

    return {
        Input: Input,
        Modal: Modal
    };
});
