<?php

namespace App\Http\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
//
//use App\Events\Illuminate\Mail\Events\UserRegisteredEvent;

use Illuminate\Database\Eloquent\Model;
use DB,
    Request,
    Auth;

class Task extends Model {

//    use Notifiable; 

    protected $table = 'task';
    public $field;

    public static function getOnlineUserTasks() {

        $status = 0;
        $message = '';
        $arrData = [];
        $arrResp = [];

        try {

            $arrData = DB::select('select task.task_name,task.minutes, users.name, subscriptions.id as subscription_id from task left join users on users.id = task.user_id left join subscriptions on subscriptions.user_id = task.user_id order by task.id DESC');
            // 
//            $query = self::query();
////            $query->where('user_id', '=', $userId);
//            $query->where('is_active', '=', 1);
//            $query->where('is_deleted', '=', 0);
//            $query->orderBy('created_at', 'DESC');
//            $arrData = $query->get();

            $status = 1;
            $message = 'Success';
        } catch (Exception $ex) {

            $status = 0;
            $message = $ex->getMessage();
        }

        $arrResp['status'] = $status;
        $arrResp['message'] = $message;
        $arrResp['data'] = $arrData;

        return $arrResp;
    }

    public function addTask() {
        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrResp    = [];
        
        try {
            
            //
            $taskObj = new Task();
            $taskObj->user_id   = $this->field['user_id'];
            $taskObj->task_name      = $this->field['task_name'];
            $taskObj->minutes     = $this->field['minutes'];
            
            if($taskObj->save()){
                
                $status = 1;
                $message = 'Task addded successfully.';
                
            } else {
                
                // 
                throw new \Exception('Unabel to add task, please try again later!');
                
            }
        } catch (\Exception $ex) {
            
            $status = 0;
            $message = $ex->getMessage();
            
        }
        
        $arrResp['status']  = $status;
        $arrResp['message'] = $message;
        $arrResp['data']    = $taskObj;
        
        return $arrResp;
    }


    public function updateTaskTime(){
        $status     = 0;
        $message    = '';
        $arrData = $arrResp  = [];
        dump($this->field);
        try {
            $task = $this->find($this->field['id']);
            $task->completed_time = $this->field['completed_time'];
            if($task->save()){
                $status = 1;
                $message = 'Task time updated successfully.';
            } else {
                throw new \Exception('Unabel to update task time, please try again later!');
            }
        } catch (\Exception $ex) {
            $status = 0;
            $message = $ex->getMessage();
        }
        $arrResp['status']  = $status;
        $arrResp['message'] = $message;
        $arrResp['data']    = $task;
        return $arrResp;
    }

    public function getAvarageTime($userId){
        $task = new Task();
        // dd($userId);
        $time24hrs =  DB::table('task')
                        ->select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( completed_time ) ) ) as total_time_24"))
                        ->where('user_id', '=', $userId)
                        ->where('updated_at','>', date('Y-m-d H:i:s', (time()-86400)))
                        ->first();
        $time7days =  DB::table('task')
                        ->select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( completed_time ) ) ) as total_time_7"))
                        ->where('user_id', '=', $userId)
                        ->where('updated_at','>', date('Y-m-d H:i:s', (time()-(7*86400))))
                        ->first();
        $time30 =  DB::table('task')
                        ->select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( completed_time ) ) ) as total_time_30"))
                        ->where('user_id', '=', $userId)
                        ->where('updated_at','>', date('Y-m-d H:i:s', (time()-(30*86400))))
                        ->first();
        $alltime = DB::table('task')
            ->select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( completed_time ) ) ) as total_time"))
            ->where('user_id', '=', (int)$userId) ->first();

        $analitics['time24'] = $time24hrs->total_time_24;
        $analitics['time7'] = $time7days->total_time_7;
        $analitics['time30'] = $time30->total_time_30;
        $analitics['alltime'] = $alltime->total_time;

        return $analitics;
    }
}


