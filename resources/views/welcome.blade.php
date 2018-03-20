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
        <link rel="stylesheet" href="{{ URL::asset('css/my.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Styles -->
        <style type="text/css">
            @font-face {
                font-family: OptimusPrinceps;
                src: url('{{ public_path('fonts/OptimusPrinceps.tff') }}');
            }
        </style>

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
            $(document).ready(function (e) {
                var token = sessionStorage.getItem("token");
                if (token == null)
                {
                    window.location.href = "http://localhost:8000/login";
                }
            });
        </script>
        <script src="{{ URL::asset('js/myJS.js') }}"> </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                    {{--<button id="post_create" class="btn btn-success">Create Post</button>--}}
                    <button id="post_create" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Post</button>

                </div>


        </div>
                <div class="container">
                    <div class="post_table">
                        <h2>Posts</h2>
                        <table class="table">
                            <thead style="text-align: right">
                            <tr>
                                <th>User</th>
                                <th>Title</th>
                                <th>Content</th>
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
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="inputTitle">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="inputTitle" placeholder="Title of post"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputBody" >Body</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="inputBody" placeholder="Body of post"/>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="postCreateModal"> Create Post</button>
                    </div>
                </div>

            </div>
        </div>

        <div id="myModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit post</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <input type="hidden" name="id" id="id" value="-1">
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"
                                       for="inputBody" >Body</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="inputBody" placeholder="Body of post"/>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="editPost" class="btn btn-success" id="postEditModal"> Edit Post</button>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>
