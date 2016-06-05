/**
 * Created by vova on 02.06.16.
 */
$(document).ready(function () {

    $('body').on('click', '#button1', function (e) {
        e.preventDefault();

        var name = prompt('Как вас зовут', 100);
        $(".heading").html(name);
    });

    $('body').on('click', '#button2', function (e) {
        e.preventDefault();

        var input1 = $('#input1');
        input1.attr('type', 'input');
    });

    $('body').on('click', '#button3', function (e) {
        e.preventDefault();
        var input1 = $('#input1'),
            parent_id = 1;
        input1.val();
        console.log();

        if ($(".reply_id").attr("value") != "") {
            parent_id = $(".reply_id").attr("value");
        }

        var person = {
            "name": input1.val(),
            "parent_id": parent_id
        };


        console.log(JSON.stringify(person));
        console.log(person);

        $.ajax({
            type: 'post',
            url: 'create.php',
            data: {data: JSON.stringify(person)},
            success: function (data) {
                var array=JSON.parse(data);
                console.log(array["list"]);

                $(".form_wrapper").html($(".form"));

                $(".list_wrapper").html(array["list"]);

                $(".select_wrapper").html(array["select"]);

                //window.location.reload();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    });

    $(".select_wrapper").on('change','select', function (e) {
        e.preventDefault();
        console.log($(this).val());
        var person = {

            id: $(this).val()
        };

        $.ajax({
            type: 'post',
            url: 'delete.php',
            data: {data: JSON.stringify(person)},
            success: function (data) {
                var array=JSON.parse(data);

                $(".form_wrapper").html($(".form"));

                $(".list_wrapper").html(array["list"]);

                $(".select_wrapper").html(array["select"]);
                //window.location.reload();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    });

    $('body').on('click', '.reply_button', function (e) {
            e.preventDefault();

            $this = $(this);
            var id = $this.attr("id");
            $(".li_comment_" + id).append($(".form"));
            console.log(id);
            //$(".reply_id").attr("value", id);
            $(".reply_id").attr("value", id);
        }
    )
    ;

});



