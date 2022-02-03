<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use Log;
use Illuminate\Support\Facades\Validator;
class FormController extends Controller
{
    //
    public function add(Request $req)
    {
        // print_r($req->all());
        $user = new Form;
        $user->firstname=$req->firstname;
        $user->lastname=$req->lastname;
        $user->email=$req->email;
        $user->password=$req->password;
        $user->phonenumber=$req->phonenumber;
        $user->birthdate=$req->birthdate;
        $user->vaccine=$req->vaccine;
        $result=$user->save();
        if($result)
        {
            return response()->json(['message' => 'data save', 'data' =>$req->json()->all()],200);
        }
        else{
            return response()->json(['message' => 'internal server error', 'data' => $req->json()->all()],500);
        }
    }
    public function validation(Request $req)
    {
        try
        {
            $rules=[
                "firstname"=>"required|max:100",
                "lastname"=>"required|max:100",
                "email"=>"required|email",
                "password"=>"required",
                "phonenumber"=>"required|numeric|digits:10",
                "birthdate"=>"required|date_format:Y/m/d",
                'vaccine'=>"in:yes,no",
                'vaccine'=>"in:COVAXIN,COVISHIELD"

            ];
            $messages = [
                'firstname.required' => 'FirstName is Required.',
                'lastname.required' => 'LastName is Required.',
                'email' => 'EmailAddress is Required.',
                'password' => 'password is Required.',
                'phonenumber'=> 'phonenumber is Required',
                'phonenumber'=> "The phonenumber must be a number.",
                'phonenumber'=> "The phonenumber may not be greater than 10.",
                'birthdate'=> 'birthdate is Required',
                'birthdate'=> '"The birthdate does not match the format Y/m/d."',
                'vaccine'=>"vaccine name is not a available."
            ];
            // $validator = Validator::make($req->json()->all(),$rules, $messages);
            $validator=Validator::make($req->json()->all(),$rules,$messages);
            // return $validator->errors();
            if($validator->fails())
            {
                return response()->json(['validation' =>'error', 'validationerror' =>$validator->errors()],422);
                // return $validator->error();
            }
            else
            {
                $user = new Form;
                $user->firstname=$req->firstname;
                $user->lastname=$req->lastname;
                $user->email=$req->email;
                $user->password=$req->password;
                $user->phonenumber=$req->phonenumber;
                $user->birthdate=$req->birthdate;
                $user->vaccine=$req->vaccine;
                $result=$user->save();
                if(isset($result))
                {
                    return response()->json(['message' => 'data are save', 'data' =>$req->json()->all()],200);
                }
                else
                {
                    return response()->json(['message' => 'internal servers error','status' => false ],500);
                }
            }
        }
        catch (\Exception $e) 
        {

            Log::info('message:'.$e->getMessage());
            Log::info('code:'.$e->getCode());
            return response()->json(['message' => 'internal server error'],500);
        }
    }
    public function update(Request $req)
    {
        try
        {
            $user = Form::find($req->id);
            $user->firstname=$req->firstname;
            $user->lastname=$req->lastname;
            $user->email=$req->email;
            $user->password=$req->password;
            $user->phonenumber=$req->phonenumber;
            $user->birthdate=$req->birthdate;
            $result=$user->save();
            if($result)
            {
                return response()->json(['message' => 'data has been updated', 'data' =>$req->json()->all()],200);
            }
            else{
                return response()->json(['message' => 'internal server error'],500);
            }
        }
        catch (\Exception $e) 
        {
            Log::info('message:'.$e->getMessage());
            Log::info('code:'.$e->getCode());
            return response()->json(['message' => 'internal server error'],500);
        }
    }
    public function index($id)
    {
        // @PostMapping("index/{id}");
        $user=Form::find($id);
        if($user)
        {
            return response()->json(['status' => true, 'data' => $user],200);
        }
        else{
            return response()->json(['status' => false,'message'=>'Data Not Found'],400);
        }
    }
    public function delete($id)
    {
        try
        {
            $user= Form::find($id);
            $result=$user->delete();
            if($result)
            {
                return response()->json(['result'=>'record has been deleted','data'=>$user],200);
            }
            else
            {
                return response()->json(['result'=>'internal server error'],500);

            }
        }
        catch (\Exception $e) 
        {

            Log::info('message:'.$e->getMessage());
            Log::info('code:'.$e->getCode());
            return response()->json(['message' => 'internal server error'],500);
        }
    }
}
