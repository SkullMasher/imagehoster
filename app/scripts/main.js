console.log('\'Allo \'Allo!');

$(function() {
    'use strict';

    var container = $('[data-resource-container');

    // Get all resources
    $.ajax('/api/resource.php', { dataType: 'json' })
    .done(function(data) {
        data.resources.forEach(function(resource) {

            var div = $('<div>').appendTo(container)
                .append('<h4>' + resource.name + '</h4>');

            // Get resource descriptions
            $.ajax(resource.href, { dataType: 'json' })
            .done(function(resourceData) {
                div.append('<p>' + resourceData.description + '</p>');
            })
            .fail(function(jqXHR) {
                var data;
                try {
                    data = $.parseJSON(jqXHR.responseText);
                }
                catch (e) {
                    data = {
                        description: 'Server is unreachable'
                    };
                }
                container.append('<div class="alert alert-danger">' + data.description + '</div>');
            });
        });
    })
    .fail(function(jqXHR) {
        var data;
        try {
            data = $.parseJSON(jqXHR.responseText);
        }
        catch (e) {
            data = {
                description: 'Server is unreachable'
            };
        }
        container.append('<div class="alert alert-danger">' + data.description + '</div>');
    });

});
