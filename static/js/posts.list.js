define([
       'jquery'
], function($) {
    var Post = function(selector) {
        this.context = $(selector);
        this.id = this.context.attr('data-post');
        this.categories = (function(context) {
            return (context.attr('data-categories') || '').split(',');
        })(this.context);
    };
    Post.prototype.is_category = function(cid) {
        var i = 0;

        for (i = 0;i < this.categories.length;i++) {
            if (this.categories[i] === cid) {
                return true;
            }
        }

        return false;
    };
    Post.prototype.toggle = function() {
        this.context.toggle();
        this.context.trigger('lists-wrapper-resized');
    };
    Post.prototype.show = function() {
        this.context.show();
        this.context.trigger('lists-wrapper-resized');
    };
    Post.prototype.hide = function() {
        this.context.hide();
        this.context.trigger('lists-wrapper-resized');
    };

    var lists = $('table.articles'),
        posts = [];

    $('tr.post-item').each(function(i, e) {
        posts.push(new Post(e));
    });

    // filter
    posts.forEach(function(post, i) {
        $('td.category .tag', post.context).click(function(e) {
            var cid = $(this).attr('data-category-id'),
                currentDisplayCid = lists.attr('data-display-category');

            if (currentDisplayCid === cid) {
                lists.attr('data-display-category', 'all');
                posts.forEach(function(post, i) { post.show(); });
            } else {
                lists.attr('data-display-category', cid);
                posts.forEach(function(post, i) {
                    if (!post.is_category(cid)) {
                        post.hide();
                    }
                });
            }
        });
    });

    $('a[data-command="remove"]').click(function(e) {
        var choice = confirm('人家写得那么辛苦你真的要删除么？！！！！');

        if (!choice) {
            e.preventDefault();
        }
    });

    return {
        'posts': posts
    };
});
