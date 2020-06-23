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
                <ul>

                    <li id="todoFormCont" style="display: none;">
                        <div class="alert" id="todoFormAlert" style="display: none"></div>
                        <form method="post" class="todo-form" id="todoForm">
                            <input type="hidden" name="type" id="type" value="1">
                            <div class="form-group">
                                <label>Title:</label>
                                <input type="text" name="title" id="title" class="form-control">
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
                    <li id="user-task-{{ $id }}">
                        <div class="form-group">
                            <label>{{ $title }}</label>
                            <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                        <p class="time"></p>
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
                <ul>

                    <li id="wipFormCont" style="display: none;">
                        <div class="alert" id="wipFormAlert" style="display: none"></div>
                        <form method="post" class="wip-form" id="wipForm">
                            <input type="hidden" name="type" id="type" value="2">
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
                    <li id="user-task-{{ $id }}">
                        <div class="form-group">
                            <label>{{ $title }}</label>
                            <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                        <p class="time"></p>
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

    <div class="col-lg-4 Completed">
        <div class="list_boxes">
            <div class="header">
                <h2>Completed</h2>
                <a href="javascript:void(0)" id="completedFormBtn" data-form-show="false">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
            <div class="list_boxes_content">
                <ul>
                    <li id="completedFormCont" style="display: none;">
                        <div class="alert" id="completedFormAlert" style="display: none"></div>
                        <form method="post" class="completed-form" id="completedForm">
                            <input type="hidden" name="type" id="type" value="3">
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
                    <li id="user-task-{{ $id }}">
                        <div class="form-group">
                            <label>{{ $title }}</label>
                            <a href="javascript:void(0)" class="delete-user-task" id="{{ $id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                        <p class="time"></p>
                    </li>
                    @endforeach
                    @else
                    <li class="completedNoTaskCont">
                        <h5>Task Not Available</h5>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>