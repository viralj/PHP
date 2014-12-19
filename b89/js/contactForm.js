$('#form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                        type: 'POST',
                        url: 'http://f1a.c/about',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function (data) {
                                console.log(data);
                                $('#response').html(data.msg);
                        }
                });
        });