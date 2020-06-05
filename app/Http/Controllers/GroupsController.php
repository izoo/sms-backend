<?php

namespace App\Http\Controllers;
use App\Groups;
use Illuminate\Http\Request;
use Validator;
use Response;
use DB;
class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
     
        return DB::table('groups')->orderby('id','DESC')->get();
    }
   
    public function groupInfo(Request $request)
    {
        if(!empty($request->key) && Groups::where('id',$request->key)->exists())
        {
            return response()->json(['status' => 'success','info'=>Groups::where('id',$request->key)->first(),'message' => '']);
        }
        else
        {
            return response()->json(['status'=>'error','info'=>null,'message'=> 'Action failed try again later!']);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'groupName' => 'required|max:255'
        ]);
        if($validator->passes())
        {
            if(Groups::where([
                'name'=>$request->groupName
            ])->exists())
            {
                return response()->json(['status'=>'error','message'=>'Contact Already Registered']);
            }
            $contact = Groups::create([
            'name' => $request->groupName
            ]);
            if($contact)
            {
                return response()->json(['status'=>'success','info'=>DB::table('contacts')->orderBy('id','DESC')->get(),'message' => 'New Contact Successfully Registered!']);
            }
            return response()->json(['status'=>'error','message'=>'Action failed, Try again later.']);
        }
        else
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       // return Company::find()
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!empty($id) && Groups::where('id',$id)->exists() && Groups::where('id',$id)->update($request->all())) 
        {
            return response()->json([
                'status' => 'success',
                'info' => Groups::all()->orderBy('id','DESC')->get(),
                'message' => 'Contacts Details Successfully Updated'
            ]);
        }
        else
        {
            return response()->json(['status' => 'error','info'=>'','message' => 'Action failed,try again later']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!empty($id) && Groups::where('id',$id)->delete())
        {
            return response()->json(['status'=>'error','info'=>Groups::all()->orderBy('id','DESC')->get(),'message' => 'Contacts Has Been Removed']);
        }
        else
        {
            return response()->json(['status'=>'error','info'=>Groups::all()->orderBy('id','DESC')->get(),'message' => 'Action failed,try again later']);
        }
    }
}
