<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\UserTask;
use App\Http\Models\Task;
use App\User;
use Cartalyst\Stripe\Api\Products;
use Stripe\Plan;
use Validator, DB, Auth;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Subscription;
// use Stripe\Plan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        
        
        // User
        $userId = 0;
        if( Auth::check() ){
            $user = auth()->user();
            $userId = $user->id;
            $this->view['user_id'] = $userId;
            $this->view['subscribed'] = $user->subscribed('default');
        }
        
        // User Task Obj
        // Todo task
        $type = 1; // Todo
        $userTaskObj = new UserTask();
        $userTaskObjResp = $userTaskObj->getUserTasksByType($type, $userId);
        $todo_tasks = $userTaskObjResp['data'];
        $this->view['todo_tasks'] = $todo_tasks;
        // dd($userTaskObjResp);
        
        // WIP Task
        $type = 2; // WIP
        $userTaskObj = new UserTask();
        $userTaskObjResp = $userTaskObj->getUserTasksByType($type, $userId);
        $wip_tasks = $userTaskObjResp['data'];
        $this->view['wip_tasks'] = $wip_tasks;
        // dd($userTaskObjResp);
        
        // Completed Task
        $type = 3; // Completed
        $userTaskObj = new UserTask();
        $userTaskObjResp = $userTaskObj->getUserTasksByType($type, $userId);
        $completed_tasks = $userTaskObjResp['data'];
        $this->view['completed_tasks'] = $completed_tasks;
        // dd($userTaskObjResp);
        
        $taskListObj = new Task();
        $taskListResp = $taskListObj->getOnlineUserTasks();
        $task_list = $taskListResp['data'];
        $this->view['task_list'] = $task_list;

        $userObj = new User;
        $this->view['intent'] = $user->find($userId)->createSetupIntent();
        
        // Get Online Users Count
        $onlineUsersCount = $this->getOnlineUsersCount();
        $this->view['online_users_count'] = $onlineUsersCount;
        
        Stripe::setApiKey(env( 'STRIPE_SECRET_KEY' ) );
        //get plan price 
        $product = Plan::retrieve( env( 'STRIPE_PRODUCT_ID' ) );

        // Get all active subscriptions...        
        $subscriptions = [];        
        foreach($user->subscriptions as $key=> $subscription){
            $subPlan = Plan::retrieve( $subscription->stripe_plan );
            $subscriptions[$key] = $subscription;
            $subscriptions[$key]['subPlan'] = $subPlan;
            $subscriptions[$key]['product'] = Product::retrieve( $subPlan->product );
        }
        $this->view['subscriptions'] = $subscriptions;
        
        $this->view['subscriptionPrice'] = strtoupper($product->currency).' '. number_format( ($product->amount/ 100), 2 );
        return view('home', $this->view);
    }
    
    public function createTask(Request $request)
    {
        
        // return response()->json(array('res'=>true,'msg'=>"Task inserted successfully."));
        
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
                    'task' => "required",
                    'minutes' => "required"
                ],[
                    'task.required' => 'Please provide task',
                    'minutes.required' => 'Please enter min'
                ]);

                if ($validator->fails()) {
                    // Throw New Exception
                    $error = $validator->errors()->first();
                    throw new \Exception("$error");
                }
                
                // User
                $userId = 0;
                if(Auth::check()){
                    $user = auth()->user();
                    $userId = $user->id;
                    $username = $user->name;
                }
                
                // Task Obj
                $taskListObj = new Task();
                $taskListObj->field['user_id']  = $userId;
                $taskListObj->field['task_name'] = $request->task;
                $taskListObj->field['minutes']    = $request->minutes;

                $arrResp = $taskListObj->addTask();
                // dd($arrResp);
                if($arrResp['status']==1){
                    
                    $status = 1;
                    $message = $arrResp['message'];
                    $task = $arrResp['data'];
                    $arrData = [
                        'id' => $task->id,
                        'task_name' => $task->task_name,
                        'minute' => $task->minutes,
                        'username' => $username
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
    
    public function taskList()
    {
     
        $taskListObj = new Task();
        $taskListResp = $taskListObj->getOnlineUserTasks();
        $task_list = $taskListResp['data'];
        // $this->view['task_list'] = $task_list;
        
        $onlineUsersCount = $this->getOnlineUsersCount();

        // $taskDetails = getOnlineUserTasksDB::select('select task.task_name,task.minutes, users.name from task left join users on users.id = task.user_id');
        return response()->json(
                                array(
                                        'res'=>$task_list,
                                        'msg'=>"success",
                                        'online_users_count' => $onlineUsersCount
                                    )
                            );
        //return view('stud_view',['users'=>$users]);
    }


    public function updateTime(Request $request){
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        try {
            // 
            $input = $request->all();
            if(!empty($input)){
                $validator = Validator::make($request->all(), [
                    'minutes' => "required"
                ],[
                    'minutes.required' => 'Please enter min'
                ]);
                if ($validator->fails()) {
                    // Throw New Exception
                    $error = $validator->errors()->first();
                    throw new \Exception("$error");
                }
                // User
                $userId = 0;
                if(Auth::check()){
                    $user = auth()->user();
                    $userId = $user->id;
                    $username = $user->name;
                }
                // Task Obj
                $taskListObj = new Task();
                $taskListObj->field['user_id']  = $userId;
                $taskListObj->field['id'] = $request->id;
                $taskListObj->field['completed_time'] = date( 'H:i:s', $request->minutes );
                $arrResp = $taskListObj->updateTaskTime();
                if( $arrResp['status'] == 1 ){
                    $status = 1;
                    $message = $arrResp['message'];
                    $task = $arrResp['data'];
                    $arrData = [
                        'id' => $task->id,
                        'task_name' => $task->task_name,
                        'minute' => $task->minutes,
                        'completed_time' => $task->completed_time,
                        'username' => $username
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
    
    public function getIntent(){
        $intent = User::find(Auth::User()->id)->createSetupIntent();
        return response()->json(['intent'=>$intent->client_secret]);
    }

    public function getOnlineUsersCount(){
        // 
        $onlineUsersCount = 0;
        $users = User::where('is_login', '=', 1)->get();
        $onlineUsersCount = $users->count();
        // 
        return $onlineUsersCount;
}

}
