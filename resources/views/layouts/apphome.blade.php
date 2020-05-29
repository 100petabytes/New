<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
        <!--<script src="{{ asset('js/user-task.js') }}"></script>-->

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- CSS only -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link href="{{ asset('css/apphome.css') }}" rel="stylesheet">
        
        <style type="text/css">
            #todo-ul li, #wip-ul li {
                height: auto;
                width: 100%;
                margin: 0px 0 10px 0;
                z-index: 999;
            }
            .draggable
            {
                filter: alpha(opacity=60);
                opacity: 1;
            }
            .dropped
            {
                position: static !important;
            }
            #todo-ul, #wip-ul, #completed-ul {
                border: 2px dashed #0cbe62a3;
                padding: 8px;
                min-height: 412px;
                width: 100%;
                border-radius: 6px;
                margin: 0;
            }
            #todo-ul li:last-child, 
            #wip-ul li:last-child {
                margin: 0;
            }
            .dropdown-menu{
                right: 80px;
            }
            /* Safari 7.1+ */
            _::-webkit-full-page-media, _:future, :root .dropdown-menu {
                right: 95px;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="dropdown">
                            <div class="dropbtn"></div>
                            <img src="/img/music.png" height="45px" width="45px"/>
                            <div class="dropdown-content">
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/5qap5aO4i9A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/sjkrrmBnpGE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/xFZSLUC5x-I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/XULUBg_ZcAU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/Dx5qFachd3A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/QEDZd066a2k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        <!-- the start of the to do drop down -->
                        <div class="dropdown" id="todo-dropdown">
                            <div class="dropbtn"></div>
                            <img src="/img/todo.png" height="45px" width="45px"/>
                            <div class="dropdown-content to_do_drop">
                                <div class="box_outer" id="userTaskSection"  style="display:block">
                                    <div class="row">

                                        <div class="col-lg-4">
                                            <div class="list_boxes">
                                                <div class="header">
                                                    <h2>Todo's</h2>
                                                    <a href="javascript:void(0)" id="todoFormBtn" data-form-show="false">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <div class="list_boxes_content">
                                                    <ul id="todo-ul" data-tasktab="todo">

                                                        <li id="todoFormCont" style="display: none;">
                                                            <div class="alert" id="todoFormAlert" style="display: none"></div>
                                                            <form method="post" class="todo-form" id="todoForm">
                                                                <input type="hidden" name="type" id="type" value="1">
                                                                <div class="form-group">
                                                                    <label>Title:</label>
                                                                    <input maxlength="50" type="text" name="title" id="title" class="form-control">
                                                                </div>
                                                                <button type="submit" name="" class="btn btn-default">Add</button>
                                                                <button id="todoformCloseBtn" type="button" name="" class="btn btn-default">Close</button>
                                                            </form>
                                                        </li>

                                                        @if(count($todo_tasks) >0)
                                                        @foreach($todo_tasks AS $key => $todo_task)
                                                        <?php
                                                        // print_r($row); exit; 
                                                        $id = $todo_task->id;
                                                        $encId = base64_encode($todo_task->id);
                                                        $title = $todo_task->title;
                                                        // 
                                                        $status = $todo_task->status;
                                                        $statusText = ($status == 1) ? 'Active' : 'Inactive';
                                                        $statusClass = ($status == 1) ? 'label-success' : 'label-danger';
                                                        // 
                                                        $createdAt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $todo_task->created_at, 'UTC')->setTimezone('Asia/Kolkata')->format('M d, Y h:i A');
                                                        ?>
                                                        <li id="user-task-{{ $id }}" data-taskid="{{ $id }}">
                                                            <div class="form-group">
                                                                <label>{{ $title }}</label>
                                                                <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <p class="time">&nbsp;</p>
                                                        </li>
                                                        @endforeach
                                                        @else
                                                        <li id="todoNoTaskCont">
                                                            <h5>Task Not Available</h5>
                                                        </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="list_boxes">
                                                <div class="header">
                                                    <h2>In Progress</h2>
                                                    <a href="javascript:void(0)" id="wipFormBtn" data-form-show="false">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <div class="list_boxes_content">
                                                    <ul id="wip-ul" data-tasktab="wip">

                                                        <li id="wipFormCont" style="display: none;">
                                                            <div class="alert" id="wipFormAlert" style="display: none"></div>
                                                            <form method="post" class="wip-form" id="wipForm">
                                                                <input maxlength="50" type="hidden" name="type" id="type" value="2">
                                                                <div class="form-group">
                                                                    <label>Title:</label>
                                                                    <input type="text" name="title" id="title" class="form-control">
                                                                </div>
                                                                <button type="submit" name="" class="btn btn-default">Add</button>
                                                                <button id="wipformCloseBtn" type="button" name="" class="btn btn-default">Close</button>
                                                            </form>
                                                        </li>

                                                        @if(count($wip_tasks) >0)
                                                        @foreach($wip_tasks AS $key => $wip_task)
                                                        <?php
                                                        // print_r($row); exit; 
                                                        $id = $wip_task->id;
                                                        $encId = base64_encode($wip_task->id);
                                                        $title = $wip_task->title;
                                                        // 
                                                        $status = $wip_task->status;
                                                        $statusText = ($status == 1) ? 'Active' : 'Inactive';
                                                        $statusClass = ($status == 1) ? 'label-success' : 'label-danger';
                                                        // 
                                                        $createdAt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $wip_task->created_at, 'UTC')->setTimezone('Asia/Kolkata')->format('M d, Y h:i A');
                                                        ?>
                                                        <li id="user-task-{{ $id }}" data-taskid="{{ $id }}">
                                                            <div class="form-group">
                                                                <label>{{ $title }}</label>
                                                                <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <!--<p class="time"><b>Time:</b> {{ $createdAt }}</p>-->
                                                            <p class="time">&nbsp;</p>
                                                        </li>
                                                        @endforeach
                                                        @else
                                                        <li id="wipNoTaskCont">
                                                            <h5>Task Not Available</h5>
                                                        </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="list_boxes">
                                                <div class="header">
                                                    <h2>Completed</h2>
                                                    <a href="javascript:void(0)" id="completedFormBtn" data-form-show="false">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <div class="list_boxes_content">
                                                    <ul id="completed-ul" data-tasktab="completed">
                                                        <li id="completedFormCont" style="display: none;">
                                                            <div class="alert" id="completedFormAlert" style="display: none"></div>
                                                            <form method="post" class="completed-form" id="completedForm">
                                                                <input maxlength="50" type="hidden" name="type" id="type" value="3">
                                                                <div class="form-group">
                                                                    <label>Title:</label>
                                                                    <input type="text" name="title" id="title" class="form-control">
                                                                </div>
                                                                <button type="submit" name="" class="btn btn-default">Add</button>
                                                                <button id="completedformCloseBtn" type="button" name="" class="btn btn-default">Close</button>
                                                            </form>
                                                        </li>

                                                        @if(count($completed_tasks) >0)
                                                        @foreach($completed_tasks AS $key => $completed_task)
                                                        <?php
                                                        // print_r($row); exit; 
                                                        $id = $completed_task->id;
                                                        $encId = base64_encode($completed_task->id);
                                                        $title = $completed_task->title;
                                                        // 
                                                        $status = $completed_task->status;
                                                        $statusText = ($status == 1) ? 'Active' : 'Inactive';
                                                        $statusClass = ($status == 1) ? 'label-success' : 'label-danger';
                                                        // 
                                                        $createdAt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $completed_task->created_at, 'UTC')->setTimezone('Asia/Kolkata')->format('M d, Y h:i A');
                                                        ?>
                                                        <li id="user-task-{{ $id }}" data-taskid="{{ $id }}">
                                                            <div class="form-group">
                                                                <label>{{ $title }}</label>
                                                                <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                            <p class="time">&nbsp;</p>
                                                        </li>
                                                        @endforeach
                                                        @else
                                                        <li id="completedNoTaskCont">
                                                            <h5>Task Not Available</h5>
                                                        </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!-- <div id="ppparent">
                                    <div id="pparent">
                                        <div id="myDIV" class="headertodo">
                                              <h2 style="margin:5px">My To Do List</h2>
                                              <input type="text" id="myInput" placeholder="Task To Do">
                                              <span onclick="newElement()" class="addBtn">Add</span>
                                              </div>
                                            <ul id="myUL">
                          
                          
                                  </div>
                              </div> -->
                            </div>
                        </div>

                        <!-- the end of drop down to do list -->

                        <div class="dropdown">
                            <div class="dropbtn"></div>
                            <img src="/img/analize.png" height="45px" width="45px"/>
                            <div class="dropdown-content">
                                <h1> Analytics of Personal Performance</h1>
                                <p>
                                    Coming Soon.
                                </p>

                            </div>
                        </div>

                        <!-- <div class="dropdown">
                        <div class="dropbtn"></div>
                        <img src="/img/takeabreak.png" height="45px" width="45px"/>
                          <div class="dropdown-content">
                              <h1> a break time or something</h1>
                        
                                      </div>
                        
                        </div> -->

                        <div class="dropdown">
                            <div class="dropbtn"></div>
                            <img src="/img/best.png" height="55px" width="55px"/>
                            <div class="dropdown-content">
                                <h1> Top 10 in the last 24 hrs</h1>
                                <p>
                                    Coming Soon.
                                </p>

                            </div>

                        </div>
                    </div>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown" id="logout-dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
        $(function () {
            
            jQuery("#todoForm").validate({
                rules: {
                    title: 'required'
                }
            });
            
            jQuery("#wipForm").validate({
                rules: {
                    title: 'required'
                }
            });
            
            jQuery("#completedForm").validate({
                rules: {
                    title: 'required'
                }
            });
            
            $("#todo-ul li, #wip-ul li, #completed-ul  li").draggable({
                revert: true,
                refreshPositions: true,
                drag: function (event, ui) {
                    ui.helper.addClass("draggable");
                },
                stop: function (event, ui) {
                    ui.helper.removeClass("draggable");
                }
            });
            
            $("#todo-ul, #wip-ul, #completed-ul").droppable({
                drop: function (event, ui) {
                    ui.draggable.addClass("dropped");
                    var dropabbleTab = $(this).data('tasktab');
                    var dropabbleId = ui.helper.data('taskid');
                    if(dropabbleTab == 'todo') {
                        var type = 1;
                        $("#todo-ul").append(ui.draggable);
                        $("#todoNoTaskCont").remove();
                    }
                    if(dropabbleTab == 'wip') {
                        var type = 2;
                        $("#wip-ul").append(ui.draggable);
                        $("#wipNoTaskCont").remove();
                    }
                    if(dropabbleTab == 'completed') {
                        var type = 3;
                        $("#completed-ul").append(ui.draggable);
                        $("#completedNoTaskCont").remove();
                    }
                    
                    var taskId = ui.helper.data('taskid');
                    var reqData = 'task_id='+taskId+'&type='+type;
                    jQuery.ajax({
                        type: "POST",
                        url: '/update-task',
                        data: reqData,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {

                        },
                        complete: function () {

                        },
                        success: function (response) {
                        }
                    });
                }
            });
            
            $('#todoformCloseBtn').click(function() {
                $('#todoFormBtn').trigger('click');
            });
            $('#wipformCloseBtn').click(function() {
                $('#wipFormBtn').trigger('click');
            });
            $('#completedformCloseBtn').click(function() {
                $('#completedFormBtn').trigger('click');
            });
            
//            $('#todo-dropdown').mouseout(function() {
//                $('#todoFormBtn').trigger('click');
//                $('#wipFormBtn').trigger('click');
//                $('#completedFormBtn').trigger('click');
//            });
        });
        
        /* Created By Ajay Jain
        * Used to check mobile validation
        */
        function validateNumber(e) {
           var invalidcharacters = /[^0-9]/gi
           var phn = document.getElementById('minutes');
           if (invalidcharacters.test(phn.value)) {
               newstring = phn.value.replace(invalidcharacters, "");
               phn.value = newstring
           }
        }
        
        $('#navbarDropdown').click(function() {
            $('.dropdown-menu').show();
        });
        $('body').click(function() {
            $('.dropdown-menu').hide();
        });
        
//        $('#buttonTimer')[0].onclick =  function(e) {
//            e.preventDefault();
//            const mins = $('#minutes')[0].value;
//            timer(mins * 60);
//        };
        </script>
    </body>
</html>
