document.addEventListener('DOMContentLoaded', function() {
    var loadingMessage = document.getElementById('loading-message');

    if (loadingMessage) {
        loadingMessage.style.display = 'block';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', rsMusicParams.ajaxUrl, true); // Use localized AJAX URL
        xhr.onload = function() {
            if (xhr.status === 200) {
                loadingMessage.style.display = 'none';
                location.reload(); // Refresh to show updated options
            } else {
                loadingMessage.innerText = 'Failed to download files.';
            }
        };
        xhr.send();
    }
});