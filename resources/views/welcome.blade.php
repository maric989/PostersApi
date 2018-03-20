<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #records_table{
                width: 50%;
            }
            #content{
                color: black;
            }
        </style>

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "http://localhost:8000/api/post",
                    method: "GET",
                    success: function (result) {
                        for (var post in result.data) {
                            var tr = $('<tr>').append(
                                $('<td>').text(result.data[post].title),
                                $('<td>').text(result.data[post].body)
                            );
                            tr.attr("data-id", result.data[post].id);
                            $("#content").append(tr);
                        }

                    }
                });
                $("#content").on('click', function (event) {
                    $('.single_post').show();
                    var id = $(event.target.parentElement).attr("data-id");
                    $.ajax({
                        url: "http://localhost:8000/api/post/" + id,
                        method: "GET",
                        success: function (result) {

                            var title = '<h2>' + result.data.title + '</h2>';
                            var body = '<p>' + result.data.body + '</p>';
                            var user = '<p>' + result.data.user.data.username + '</p>';


                            $(".post_content").append("<div id='postId' style='display:none'>" + result.data.id + "</div>");
                            $('#post_title').append(title);
                            $('#post_body').append(body);
                            $('#author').append(user);
                            createCommentList(result.data.comments.data);
                            $('.post_table').hide();

                        }
                    })
                });
                $("#buttonOK").on('click', function (event) {
                    $('#post_title').html('');
                    $('#post_body').html('');
                    $('#author').html('');
                    $('#post_comment').html('');
                    $('.single_post').hide();
                    $('.post_table').show();
                });

                $("#comment_subbmit").on('click', function (event) {

                    var id = $('#postId').text();
                    var body = $('#comment_body').val();
                    var token = "Bearer "+ sessionStorage.getItem("token");

                    $.ajax({
                        url: "http://localhost:8000/api/post/" + id + "/comment",
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
                            $('#post_comment').append(result.data.body);
                            $('#comment_body').html('');
                        },
                        error: function(ts) {
                            alert(ts.responseText) }
                    });

                });

                $("#post_create").on('click', function (event) {

                    $('#myModal').modal('toggle')
                    $('#myModal').modal('show')

                });




                //TODO NA refresh nestaju komentari
                function createCommentList(commentList) {
                    var comments = '';
                    for (var com in commentList) {
                        comments += '<p>' + commentList[com].body + '</p>';
                    }

                    $('#post_comment').append(comments);
                }
            });
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                    {{--<button id="post_create" class="btn btn-success">Create Post</button>--}}
                    <button id="post_create" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

                </div>


        </div>
                <div class="container">
                    <div class="post_table">
                        <h2>Posts</h2>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>body</th>
                            </tr>
                            </thead>
                            <tbody id="content">

                            </tbody>
                        </table>
                    </div>

                    <div class="single_post" style="text-align: center">
                        <div class="post_content" style="color: black">

                            <div id="post_title"></div>
                            <div id="post_body"></div>

                            <div id="author">
                                <p>Author name</p>
                            </div>

                            <div id="post_comment" style="text-align: left">
                                <p> Comments</p>
                                <input type="text" id="comment_body">
                                <button id="comment_subbmit">Add Comment</button>
                            </div>
                        </div>
                        <button class="btn btn-info" id="buttonOK">Ok</button>
                    </div>
                </div>

        <!-- Trigger the modal with a button -->

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
