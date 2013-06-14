define([], function() {
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

    var remove_errors = function() {
        $('.error').removeClass('error');
    };

    return {
        basic_uri: basic_uri,
        remove_errors: remove_errors
    };
});
