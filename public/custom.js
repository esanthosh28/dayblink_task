$( document ).ready(function() {

    var base_path = window.location.origin;
    var baseUrl = '';

    if (base_path == 'http://localhost' || base_path == 'http://day_blink_task.test') {
        baseUrl = 'http://day_blink_task.test/api/';
    }

    function asyncAjaxCall(url, method, postData) {

        var getInternetState = window.navigator.onLine;

        if (!getInternetState) {
           alert("check network connection");
            return;
        }

        function setHeader(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + window.localStorage.getItem('auth_token'));
        }

        var deferred = $.Deferred();

        $.ajax({
            type: method,
            contentType: 'application/json',
            url: baseUrl + url,
            dataType: "json",
            crossDomain: true,
            data: postData,
            beforeSend: setHeader,
            success: function(response) {

                deferred.resolve(response);

                $('body').removeClass('loader');
            },
            error: function(jqXHR, textStatus, errorThrown) {

                deferred.reject(errorThrown);

                $('body').removeClass('loader');
            },
            complete: function(xhr, status) {

                $('body').removeClass('loader');
            },
            statusCode: {
                401: function() {

                },
                500: function(xhr) {
                    $('body').removeClass('loader');

                }
            }
        });

        return deferred.promise();
    }

    $('.btnaddtocarts').click(function(){
        console.log('clicked');

        var jsonData = JSON.stringify({
            productId: $('.productid').val(),
            qty: $('.productqty').val()
        });

        $.when(asyncAjaxCall('addToCart', 'POST', jsonData).done(function(results) {

            if (!results.error) {


            }
        }));
    });
});
