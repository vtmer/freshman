require.config({
    paths: {
        jquery: 'libs/jquery.min.js',
        bootmodal: 'libs/bootstrap-modal.js',
        bootdrop: 'libs/bootstrap-dropdown.js',
        select2: 'libs/select2.min.js'
    }
});

require([
        'modal'
], function() {
    return {};
});
