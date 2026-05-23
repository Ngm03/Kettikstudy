(function() {
    var token = document.querySelector('meta[name="csrf-token"]');
    if (!token) return;
    token = token.getAttribute('content');

    var originalFetch = window.fetch;
    window.fetch = function(url, options) {
        options = options || {};
        if (options.method && options.method.toUpperCase() !== 'GET') {
            options.headers = options.headers || {};
            if (options.headers instanceof Headers) {
                options.headers.set('X-CSRF-TOKEN', token);
            } else {
                options.headers['X-CSRF-TOKEN'] = token;
            }
        }
        return originalFetch.call(this, url, options);
    };
})();
