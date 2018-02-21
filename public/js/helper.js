// Helper functions
function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}

function isImage(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'png':
            return true;
    }
    return false;
}

function reportError(node, message) {
    $(node).addClass("is-invalid");
    $(node).after("<div class='invalid-feedback'>" + message + "</div>");
}

function flushErrors() {
    $(".is_invalid").removeClass("is-invalid");
    $(".invalid-feedback").detach();
}