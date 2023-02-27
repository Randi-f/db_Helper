<?php
/* 
* @Author: fsh  
* @Date: 2023-02-14 15:55:19   
* @Last Modified time: 2023-02-14 15:55:19  
*/

namespace app\controller;
use app\model\User as UserModel;

use think\facade\view;
use think\route\dispatch\Controller;
class User
{
    public function index(){
        return View::fetch('index',[
            // no seperating pages
            'list'=> UserModel::select()

            //'list'=>UserModel::order('user_id','asc')->paginate(2)

            ]
        );
    }

    /**
     * @description: create new user account
     * @return {*}
     */    
    public function create(){
        // url: http://127.0.0.1:8000/index.php/user/create.html
        return View('create');
    }

    /**
     * @description: save the input information
     * @param {Request} $request
     * @return {*}
     */    
    public function save(Request $request){
        return dd($request->param());
    }

}



