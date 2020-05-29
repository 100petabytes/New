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

            $arrData = DB::select('select task.task_name,task.minutes, users.name from task left join users on users.id = task.user_id order by task.id DESC');
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
}
