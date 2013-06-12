(function() {
    // 网站根地址
    // e.g.
    //      http://exmaple.com/index.php
    //      http://exmaple.com/subpath/index.php
    var basic_uri = (function() {
        var index_script = 'index.php';

        if (location.href.lastIndexOf(index_script) !== -1) {
            return location.href.split(index_script)[0] + index_script;
        } else {
            // FIXME
            // 默认使用根地址
            //
            // 应该从 config/config.php 的配置来确定？
            return location.origin;
        }
    })();

    var Editor = function(selector) {
        this._editor = $(selector);
        this.context = $(selector);
        this.kick();
    };
    Editor.prototype.kick = function() {
        var that = this;

        this._editor
            .attr('contenteditable', 'true')
            .attr('designmode', 'on');

        this.keypress(function(e) {
            if (e.keyCode === 13 && /div>/g.test(that._editor.html())) {
                // 换行用的是 p 而不是 div
                document.execCommand('formatblock', false, 'p');
            }
        });

        $('h1.title', this.context).bind('click', function(e) {
            if ($(this).attr('data-click') === 'false') {
                $(this).html('<br />');
                $(this).attr('data-click', 'true');
            }
        });

        // 每 15 秒保存一次
        setInterval(function() {
            that.autosave();
        }, 15000);
    };
    Editor.prototype.value = function() {
        return {
            title: $('h1.title', this.context).text(),
            content: this.context.html()
                    .replace(/.*class="title".*h1>/, '')
                    .replace(/div>/g, 'p>')
        };
    };
    // TODO
    // 获取当前节点有时会出现不对，
    // 应该精确到光标下的元素
    Editor.prototype.currentNode = function() {
        var sel = document.getSelection();

        if (!sel.focusNode || !sel.focusNode.parentNode)
            return null;
        return sel.focusNode.parentNode;
    };
    Editor.prototype.attr = function(name, value) {
        if (value !== undefined) {
            return this._editor.attr(name, value);
        } else {
            return this._editor.attr(name);
        }
    };
    Editor.prototype.bind = function(events, cb) {
        this._editor.bind(events, cb);
    };
    Editor.prototype.keypress = function(cb) {
        this._editor.keypress(cb);
    };
    Editor.prototype.execute = function(command, value) {
        document.execCommand(command, false, value);
    };
    Editor.prototype.autosave = function() {
        var that = this,
            value = this.value();

        if (this.attr('data-status') !== '-1') {
            value.post_id = this.attr('data-id');
        }

        $.ajax({
            type: 'POST',
            url: basic_uri + '/backend/post/autosave',
            data: value,
            dataType: 'json'
        }).done(function(resp) {
            if (that.attr('data-status') === '-1') {
                window.history.pushState('new', value.title,
                                         basic_uri + '/backend/post/' + resp.post_id);
                that.attr('data-id', resp.post_id);
            }
            that.attr('data-status', resp.status);
            $('.save-show').html('已保存');
            $('title').html(value.title);
        }).fail(function(resp) {
            $('.save-show').html('保存失败').addClass('error');
            console.log(resp);
        });
    };

    var Toolbar = function(selector, editor) {
        this.editor = editor;
        this._toolbar = $(selector);
        this.context = $(selector);
        this.buttons = $('a[role="button"]', this.context);
        this.kick();
    };
    Toolbar.prototype.kick = function() {
        var that = this;

        this.buttons.click(function(e) {
            var command, value;
            e.preventDefault();

            command = $(this).attr('data-command');
            if (command) {
                value = $(this).attr('data-value') || false;
                that.editor.execute(command, value);
            }
        });

        this.editor.bind('keydown click focus', function(e) {
            var nodeName = that.editor.currentNode();

            if (nodeName) {
                nodeName = nodeName.tagName.toLowerCase();
            } else {
                nodeName = 'p';
            }
            if (nodeName === 'div' || nodeName === 'article') {
                nodeName = 'p';
            }

            $('.status', that.context).html(
                $('.format-buttons a[data-value="' + nodeName + '"]',
                  that.context).text() || '普通文本'
            );
        });
    };

    var editor = new Editor('#editwrap article'),
        toolbar = new Toolbar('#editor-commands', editor);
})();
