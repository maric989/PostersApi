$(document).ready(function() {

    // $('.post_content').hide();
    $.ajax({
        url: "http://localhost:8000/api/post",
        method: "GET",
        success: function (result) {
            var button;
            for (var post in result.data) {

                var tr,buttonEdit = $('<button></button>', {
                        text: 'Edit'
                    }).addClass('buttonEdit'),
                    buttonDelete = $('<button></button>', {
                        text: 'Delete'
                    }).addClass('buttonDelete');
                tr = $('<tr>').append(
                    $('<img src="http://nwsid.net/wp-content/uploads/2015/05/dummy-profile-pic.png" style="width: 70%">'),
                    $('<td>').text(result.data[post].title),
                    $('<td>').text(result.data[post].body)
                );
                if (sessionStorage.getItem("userID") == result.data[post].user.data.user_id){
                    tr.append($('<td>').append(buttonEdit,buttonDelete));
                }
                tr.attr("data-id", result.data[post].id);
                $("#content").append(tr);
            }

        }
    });



    $("#content").on('click', function (event) {
        $('.single_post').show();
        sessionStorage.setItem('post-id', $(event.target.parentElement).attr("data-id"));
        getContent();

    });
    $("#buttonOK").on('click', function (event) {
        $('#post_title').html('');
        $('#post_body').html('');
        $('#author').html('');
//                    $('#post_comment').html('');
        $('.single_post').hide();
        $('.post_table').show();
    });

    $("#comment_subbmit").on('click', function (event) {

        var id = $('#postId').text();
        var body = $('#comment_body').val();
        var token = "Bearer "+ sessionStorage.getItem("token");

        $.ajax({
            url: "http://localhost:8000/api/post/" + sessionStorage.getItem('post-id') + "/comment",
            method: "POST",
            data: {
                post_id: id,
                body: body,
                user_id: 1
            },
            headers: {
                "Authorization": token,
            },
            contentType: " application/x-www-form-urlencoded",
            dataType: "json",

            success: function (result) {
                //TODO Ocisti komentare
                $('#post_comment').append('<p>' + result.data.body + '</p>');
                $('#comment_body').val('');
            },
            error: function(ts) {
                alert(ts.responseText) }
        });

    });

    $("#post_create").on('click', function (event) {
        event.preventDefault();
        $('#myModal').show();

    });

    $("#postCreateModal").on('click',function (e) {
        var $this = $(this),title,body,userID,token;
        event.preventDefault();
        title = $('#myModal').find('input#inputTitle').val();
        body = $('#myModal').find('input#inputBody').val();
        userID = sessionStorage.getItem("userID");
        token = "Bearer "+ sessionStorage.getItem("token");

        $.ajax({
            url: "http://localhost:8000/api/post/",
            method: "POST",
            data: {
                user_id: userID,
                body: body,
                title: title
            },
            headers: {
                "Authorization": token,
            },
            contentType: " application/x-www-form-urlencoded",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#myModal').modal('hide');
                tr = $('<tr>').append(
                    $('<img src="http://nwsid.net/wp-content/uploads/2015/05/dummy-profile-pic.png">'),
                    $('<td>').text(data.title),
                    $('<td>').text(data.body)
                )
            }

        })

    });
    // EDIT
    $(document).on('click','.buttonEdit',function (e) {
        var $this = $(this),
            id;
        e.preventDefault();
        id = $this.closest('tr').data('id');
        $.ajax({
            url: "http://localhost:8000/api/post/" + id,
            method: "GET",
            contentType: " application/x-www-form-urlencoded",
            dataType: "json",

            success: function (result) {
                var body = result.data.body;
                var token = "Bearer "+ sessionStorage.getItem("token");
                $('#myModalEdit').find('input#id').val(id);
                $('#myModalEdit').find('input#inputBody').val(body);
                $('#myModalEdit').modal('show');
                $('#postEditModal').on('click',function () {
                    var newBody = $('#myModalEdit').find('input#inputBody').val();
                    console.log(id);
                    $.ajax({
                        url: "http://localhost:8000/api/post/" + id,
                        type: 'POST',
                        data: {
                            _method: 'PATCH',
                            body: newBody
                        },
                        headers: {
                            "Authorization": token
                        },
                        contentType: " application/x-www-form-urlencoded",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $('#myModalEdit').modal('hide');
                        },
                        error: function(ts) {
                            alert(ts.responseText) }

                    })
                })
            },
            error: function(ts) {
                alert(ts.responseText) }
        });
    });


    // Delete Post
    $(document).on('click','.buttonDelete',function (e) {
        var $this = $(this),deleteId;
        e.preventDefault();
        deleteId = $this.closest('tr').data('id');
        var token = "Bearer "+ sessionStorage.getItem("token");

        var confirmation = confirm('Delete Post?');

        if (confirmation)
        {
            $.ajax({
                url: "http://localhost:8000/api/post/" + deleteId,
                type: 'POST',
                data: {
                    _method: 'DELETE'
                },
                headers: {
                    "Authorization": token
                },
                contentType: " application/x-www-form-urlencoded",
                dataType: "json",
                success: function (data) {
                    alert('deleted');
                },
                error: function(ts) {
                    alert(ts.responseText) }

            })
        }
    });

    //TODO NA refresh nestaju komentari
    function createCommentList(commentList) {
        $('#post_comment').html('');
        var comments = '';
        for (var com in commentList) {
            comments += '<p>' + commentList[com].body + '</p>';
        }

        $('#post_comment').append(comments);
    }

    function getContent() {
        $.ajax({
            url: "http://localhost:8000/api/post/" + sessionStorage.getItem('post-id'),
            method: "GET",
            success: function (result) {

                var title = '<h2> <b>' + result.data.title + '</b></h2>';
                var body = '<p><i>' + result.data.body + '</i></p>';
                var user = '<p> <b>Created by: </b>' + result.data.user.data.username + '</p>';


                $(".post_content").append("<div id='postId' style='display:none'>" + result.data.id + "</div>");
                $('#post_title').append(title);
                $('#post_body').append(body);
                $('#author').append(user);
                createCommentList(result.data.comments.data);
                $('.post_table').hide();

            }
        })
    }
});