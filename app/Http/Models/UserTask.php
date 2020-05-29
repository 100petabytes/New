<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB, Request, Auth;

class UserTask extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_tasks';
    public $field;
       
    public static function getUserTasksByType($type='', $userId=0) {
        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrResp    = [];
        
        try {
            
            // 
            $query = self::query();
            if(!empty($type)){
                $query->where('type', '=', $type);
            }
            $query->where('user_id', '=', $userId);
            $query->where('status', '=', 1);
            $query->where('is_deleted', '=', 0);
            $query->orderBy('created_at', 'DESC');
            $arrData = $query->get();
            
            // print("<pre>"); print_r($arrData); exit('sadas');
            
            $status = 1;
            $message = 'Success';
            
        } catch (Exception $ex) {
            
            $status = 0;
            $message = $ex->getMessage();
            
        }
        
        $arrResp['status']  = $status;
        $arrResp['message'] = $message;
        $arrResp['data']    = $arrData;
        
        return $arrResp;
    }
           
    public function addTask() {
        
        $status     = 0;
        $message    = '';
        $arrData    = [];
        $arrResp    = [];
        
        try {
            
            //
            $userTaskObj = new UserTask();
            $userTaskObj->user_id   = $this->field['user_id'];
            $userTaskObj->type      = $this->field['type'];
            $userTaskObj->title     = $this->field['title'];
            $userTaskObj->status    = $this->field['status'];
            
            if($userTaskObj->save()){
                
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
        $arrResp['data']    = $userTaskObj;
        
        return $arrResp;
    }
        
    public function deleteTask() {
        
        $arrResp    = [];
        $status     = 0;
        $message    = '';
        
        try {
            
            $userTaskObj = new UserTask();
            $userTaskObj->id           = $this->field['id'];
            $userTaskObj->exists       = true;
            $userTaskObj->is_deleted   = 1;
            if($userTaskObj->save()){
                
                $status = 1;
                $message = 'Page deleted successfully.';
                
            } else {
                
                // 
                throw new \Exception('Unabel to delete page, please try again later!');
                
            }
        } catch (Exception $ex) {
            
            $status = 0;
            $message = $ex->getMessage();
            
        }
        $arrResp['status'] = $status;
        $arrResp['message'] = $message;
        return $arrResp;
    }
    
    public function updateTask() {
    $arrResp    = [];
    $status     = 0;
    $message    = '';
    try {
        $taskObj = UserTask::find($this->field['id']);
//        $taskObj->id   = $this->field['id'];
        $taskObj->type = $this->field['type'];
        $taskObj->user_id = $this->field['user_id'];

        if($taskObj->save()){
            $message = 'Post updated successfully.';
            $status = 1;
        } else {
            $status = 0;
            $message = 'Unabel to update post, please try again later!';
        }
    } catch (Exception $ex) {
        $status = 0;
        $message = $ex->getMessage();
    }
    $arrResp['status'] = $status;
    $arrResp['message'] = $message;
    return $arrResp;
}
    
}