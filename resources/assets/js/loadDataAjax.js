function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getData() {
    let pageUrl = window.location.href.split('/');
    let dataId = $('#load-articles').data('id');
    let dataBody;
    
    if(window.location.href.indexOf("subscription") > -1) {
        dataBody = {id:dataId, feed:'subscription', subscription_id:pageUrl[5], query:null};
    } else if (window.location.href.indexOf("search") > -1) {
        let query = getParameterByName('query');
        dataBody = {id:dataId, feed:'search', subscription_id:null, query:query};
    } else {
        dataBody = {id:dataId, feed:'homepage', subscription_id:null, query:null};
    }

    if (typeof Laravel.apiToken !== 'undefined') {
        $("#load-articles").html("Loading...");
        fetch('/api/browse/load', {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Content-Type": "application/json"
            },
            method: "POST",
            body: JSON.stringify({
                id: dataBody.id,
                feed: dataBody.feed,
                subscription_id: dataBody.subscription_id,
                query: dataBody.query,
                api_token: Laravel.apiToken
            }),
        })
        .then((res) => {
            return res.text();
        })
        .then((j) => {
            if(j != "") {
                $('#load-articles').remove();
                $('.more-articles-btn').remove();
                $('.my-feed-box .box-content').append(j);
            } else {
                $('#load-articles').html("No data");
            }
        })
        .catch((err) => {
            console.log(err);
        });
    }
}

$(document).ready(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() === $(document).height()) {
            getData();
        }
    });

    $(document).on('click', '#load-articles', function(e) {
        e.preventDefault();
        getData();
    });
});