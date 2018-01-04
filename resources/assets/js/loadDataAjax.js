$(document).ready(function() {
    $(window).scroll(function() {
        var urlDoc = window.location.href.split('/');
        var idDoc = $('#load-articles').data('id');
        if(window.location.href.indexOf("subscription") > -1) {
            var dataDoc = {id:idDoc, _token:window.axios.defaults.headers.common['X-CSRF-TOKEN'], subscription_id:urlDoc[5]};
            urlDoc = '/browse/load-subscription';
        } else {
            var dataDoc = {id:idDoc, _token:window.axios.defaults.headers.common['X-CSRF-TOKEN']};
            urlDoc = '/browse/load';
        }

        if($(window).scrollTop() + $(window).height() === $(document).height()) {
            $("#load-articles").html("Loading...");
            $.ajax({
                url: urlDoc,
                method: "POST",
                data: dataDoc,
                dataType: "text",
                success: function(data) {
                    if(data != "") {
                        $('#load-articles').remove();
                        $('.more-articles-btn').remove();
                        $('.my-feed-box .box-content').append(data);
                    } else {
                        $('#load-articles').html("No data");
                    }
                }
            });
        }
    });

    $(document).on('click', '#load-articles', function(e) {
        e.preventDefault();
        
        var urlDoc = window.location.href.split('/');
        var idDoc = $('#load-articles').data('id');
        if(window.location.href.indexOf("subscription") > -1) {
            var dataDoc = {id:idDoc, _token:window.axios.defaults.headers.common['X-CSRF-TOKEN'], subscription_id:urlDoc[5]};
            urlDoc = '/browse/load-subscription';
        } else {
            var dataDoc = {id:idDoc, _token:window.axios.defaults.headers.common['X-CSRF-TOKEN']};
            urlDoc = '/browse/load';
        }

        $("#load-articles").html("Loading...");
        $.ajax({
            url: urlDoc,
            method: "POST",
            data: dataDoc,
            dataType: "text",
            success: function(data) {
                if(data != "") {
                    $('#load-articles').remove();
                    $('.more-articles-btn').remove();
                    $('.my-feed-box .box-content').append(data);
                } else {
                    $('#load-articles').html("No data");
                }
            }
        });
    });

    $(document).on('click', '#refresh-button', function() {
        window.location.href = "/";
    });
});