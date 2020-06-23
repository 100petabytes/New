<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;

use App\Http\Models\UserTask;
use App\Http\Models\Task;
use App\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Validator, DB, Auth;
use Stripe\Subscription;

class SubscriptionController extends Controller
{
    public $view = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function getCustomer( Request $request ){
        $users = new User;
        $users->getStripeId();
    }
    

    public function subscribe(Request $request)
    {
        $status     = 1;
        $message    = '';
        $arrData    = [];
        $arrJson    = [];
        $user = [];

        try{
            // $users = new User;
            $user = User::find( Auth::User()->id );
            // $user = Auth::User();
    
            $user->createOrGetStripeCustomer();
    
            $paymentMethod = $request->payment_method;
            // dump($paymentMethod);
            // $user->addPaymentMethod($paymentMethod);
            // $user->updateStripeCustomer($options);
            $newSubscr = $user->newSubscription('default', env( 'STRIPE_PRODUCT_ID' ) )->create($paymentMethod, [
                'email'=> Auth::User()->email,
                'name' => Auth::User()->name,
                'ends_at'=> strtotime( date( "Y-m-d", strtotime("+1 year") ) ),
            ])->recurring();
            if( $newSubscr ){
                $status = 1;
                $message = 'Payment is done successfully.';
            }
            // echo '<pre/>',print_r($newSubscr);

        }catch(Exception $e){
            $status = 0;
            $message = $e->getMessage();
        }
        $arrJson['status']  = $status;
        $arrJson['message'] = $message;
        $arrJson['data']    = $user;
        
        return response( $arrJson );
    }

    public function subscriptions(){
        // User
        $userId = 0;
        if( Auth::check() ){
            $user = auth()->user();
            $userId = $user->id;
            $this->view['user_id'] = $userId;
            $this->view['subscribed'] = $user->subscribed('default');
            $this->view['user'] = $user;
        }
        
        $user = User::find(Auth::User()->id);
        // Get all active subscriptions...
        $subscriptions = Subscription::all();// query()->active()->get();
        dump($subscriptions);
        $this->view['subscriptions'] = $user->subscriptions()->active()->get();
        dump($this->view['subscriptions']);
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
        
        return view('subscriptions', $this->view );
    }
}