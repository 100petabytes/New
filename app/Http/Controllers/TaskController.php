<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;

use App\Http\Models\UserTask;
use App\Http\Models\Task;

use Validator, DB, Auth;

class TaskController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function add(Request $request) {
        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        
        try {
            // 
            $input = $request->all();
            if(!empty($input)){
                // echo '<pre>'; print_r($input); exit('here');
                
                $validator = Validator::make($request->all(), [
                    'type' => "required",
                    'title' => "required"
                ],[
                    'type.required' => 'Please provide type',
                    'title.required' => 'Please enter title'
                ]);

                if ($validator->fails()) {
                    // Throw New Exception
                    $error = $validator->errors()->first();
                    throw new \Exception("$error");
                }
                
                $type  = $input['type'];
                $title  = $input['title'];
                
                // User
                $userId = 0;
                if(Auth::check()){
                    $user = auth()->user();
                    $userId = $user->id;
                }
                
                // User Task Obj
                $userTaskObj = new UserTask();
                $userTaskObj->field['user_id']  = $userId;
                $userTaskObj->field['type']     = $type;
                $userTaskObj->field['title']    = $title;
                $userTaskObj->field['status']   = 1;
                
                $arrResp = $userTaskObj->addTask();
                // dd($arrResp);
                if($arrResp['status']==1){
                    
                    $status = 1;
                    $message = $arrResp['message'];
                    $user_task = $arrResp['data'];
                    $arrData['user_task'] = [
                        'id' => $user_task->id,
                        'title' => $user_task->title,
                        'date_time' => date('Y-m-d h:m A', strtotime($user_task->created_at)),
                    ];
                    
                } else {
                    
                    $error = $arrResp['message'];
                    throw new \Exception($error);
                    
                }
                
            }  else {
                
                // Throw New Exception
                throw new \Exception('Missing params, please try again!');
                
            }
            
        } catch (\Exception $ex) {
            $status = 0;
            $message = $ex->getMessage();
        }
        
        $arrJson['status']  = $status;
        $arrJson['message'] = $message;
        $arrJson['data']    = $arrData;
        
        return response()->json($arrJson);         
    }
    
    public function delete(Request $request) {
        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        
        try {
            // 
            $input = $request->all();
            if(!empty($input)){
                // echo '<pre>'; print_r($input); exit('here');
                
                $validator = Validator::make($request->all(), [
                    'user_task_id' => "required"
                ],[
                    'user_task_id.required' => 'Please provide user task id'
                ]);

                if ($validator->fails()) {
                    // Throw New Exception
                    $error = $validator->errors()->first();
                    throw new \Exception("$error");
                }
                
                $user_task_id  = $input['user_task_id'];
                
                // User Task Obj
                $userTaskObj = new UserTask();
                $userTaskObj->field['id'] = $user_task_id;
                
                $arrResp = $userTaskObj->deleteTask();
                // dd($arrResp);
                if($arrResp['status']==1){
                    
                    $status = 1;
                    $message = $arrResp['message'];
                    
                } else {
                    
                    $error = $arrResp['message'];
                    throw new \Exception($error);
                    
                }
                
            }  else {
                
                // Throw New Exception
                throw new \Exception('Missing params, please try again!');
                
            }
            
        } catch (\Exception $ex) {
            $status = 0;
            $message = $ex->getMessage();
        }
        
        $arrJson['status']  = $status;
        $arrJson['message'] = $message;
        
        return response()->json($arrJson);         
    }
    
    public function updateTask(Request $request) {
        
        
        // User Task Obj
        $taskObj = new UserTask();
        $user = auth()->user();
        $userId = $user->id;
        $taskObj->field['id']       = $request->task_id;
        $taskObj->field['type']     = $request->type;
        $taskObj->field['user_id']  = $userId;

        $arrResp = $taskObj->updateTask();    
        return response()->json($arrResp); 
    }


    public function getAvgTime()
    {        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        
        try{
            $userId = auth()->user()->id;
            $objTask = new Task;
            if($arrData = $objTask->getAvarageTime($userId)){
                $status = 1;
                $message = 'Analitic report';
                $arrJson['data']    = $arrData;
            }

        }catch(Exception $e){
            $status = 0;
            $message = $ex->getMessage();
        }

        $arrJson['status']  = $status;
        $arrJson['message'] = $message;
        
        return response()->json($arrJson);

    }
     
    // 
    public function getTop10Task()
    {        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        
        try{

            //
            $userId = auth()->user()->id;
            // 
            $startDTObj = new \DateTime('now');
            $startDateTime = $startDTObj->format('Y-m-d H:i:s');
            // 
            $dateObj = new \DateTime($startDateTime);
            $endDateTime = $dateObj->format('Y-m-d H:i:s');
            $dateObj->modify('-24 hours');
            $startDateTime = $dateObj->format('Y-m-d H:i:s');

            // Get Top 10 Users Who worked maximum time
            $task = DB::table('task')
                ->select('user_id',
                    DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( completed_time ) ) ) as total_time_24"),
                    DB::raw('users.name AS user_name')
                )
                ->join('users', 'task.user_id', '=', 'users.id')
                ->whereBetween('task.created_at', [$startDateTime, $endDateTime])
                ->groupBy('task.user_id','users.name')
                ->orderBY('total_time_24', 'DESC')
                ->limit(10)
                ->get();

            if(!empty($task)){
                $status = 1;
                $message = 'Analitic report';
                $arrJson['data']    = $task;
}

        }catch(Exception $e){
            $status = 0;
            $message = $ex->getMessage();
        }

        $arrJson['status']  = $status;
        $arrJson['message'] = $message;
        
        return response()->json($arrJson);

    }
     
}