/**
 * Created by vova on 02.06.16.
 */
$(document).ready(function () {

    $("#button1").click(function (e) {
        e.preventDefault();

        var name = prompt('Как вас зовут', 100);
        $(".heading").html(name);
    });

    $("#button2").click(function (e) {
        e.preventDefault();

        var input1 = $('#input1');
        input1.attr('type', 'input');
    });

    $("#button3").click(function (e) {
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

        //var xmlhttp = new XMLHttpRequest();
        //
        //xmlhttp.open("GET", "create.php?q=" + input1.val(), true);
        //xmlhttp.send();
        //if (xmlhttp.status != 200) {
        //    window.location.reload();
        //}
        console.log(JSON.stringify(person));
        console.log(person);

        $.ajax({
            type: 'post',
            url: 'create.php',
            data: {data:JSON.stringify(person)},
            success: function (data) {
                window.location.reload();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    });

    $("select").on('change', function (e) {
        e.preventDefault();
        console.log($(this).val());
        var person ={

            id: $(this).val()
        };

        $.ajax({
            type: 'post',
            url: 'delete.php',
            data: {data:JSON.stringify(person)},
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    });

    $(".reply_button").on("click", function (e) {
        e.preventDefault();

        $this = $(this);
        var id = $this.attr("id");
        $(".li_comment_" + id).append($(".form_wrapper"));
        console.log(id);
        //$(".reply_id").attr("value", id);
        $(".reply_id").attr("value", id);
    });

});



