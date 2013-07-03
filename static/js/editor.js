define([
       'jquery',
       'misc'
], function($, misc) {
    var StatusBar = function(selector, _default) {
        this._statusBar = $(selector);
        this.context = $(selector);
        this._default = _default || ' ';
        this.kick();
    };
    StatusBar.prototype.kick = function() {
        this.display(this._default);
    };
    StatusBar.prototype.display = function(str) {
        this._statusBar
            .html((str === undefined) ? (this._default) : (str));
        // 链式引用
        return this;
    };
    StatusBar.prototype.setDefault = function(_default) {
        this._default = _default;
        this.kick();
        return this;
    };

    var Editor = function(uri, selector, statusBar) {
        this._uri = uri;
        this._editor = $(selector);
        this.context = $(selector);
        this.statusBar = statusBar;
        this.changed = false;
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
            that.changed = true;
        });

        $('h1.title', this.context).bind('click', function(e) {
            if ($(this).attr('data-click') === 'false') {
                $(this).html('<br />');
                $(this).attr('data-click', 'true');
            }
        });
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
    Editor.prototype.currentSelection = function() {
        var sel= document.getSelection();

        return sel.getRangeAt(0);
    };
    Editor.prototype.select = function(range) {
        var sel = document.getSelection();
        
        if (!range) {
            return;
        }

        sel.removeAllRanges();
        sel.addRange(range);
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
            url: misc.basic_uri + this._uri,
            data: value,
            dataType: 'json'
        }).done(function(resp) {
            if (that.attr('data-status') === '-1') {
                window.history.pushState('new', value.title,
                                         misc.basic_uri + '/backend/post/' + resp.post_id);
                that.attr('data-id', resp.post_id);
            }
            that.attr('data-status', resp.status);
            $('title').html(value.title);
            that.statusBar.display('已保存');
            setTimeout(function() { that.statusBar.display(); }, 2500);
        }).fail(function(resp) {
            that.statusBar.display('保存失败');
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
                that.editor.changed = true;
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

    return {
        StatusBar: StatusBar,
        Toolbar: Toolbar,
        Editor: Editor
    };
});
