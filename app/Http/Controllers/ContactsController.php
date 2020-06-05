<?php

namespace App\Http\Controllers;
use App\Contacts;
use App\Groups;
use Illuminate\Http\Request;
use Validator;
use Response;
use DB;
class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
     
        return DB::table('contacts')->orderby('id','DESC')->get();
    }
   
    public function contactInfo(Request $request)
    {
        if(!empty($request->key) && Contacts::where('id',$request->key)->exists())
        {
            return response()->json(['status' => 'success','info'=>Contacts::where('id',$request->key)->first(),'message' => '']);
        }
        else
        {
            return response()->json(['status'=>'error','info'=>null,'message'=> 'Action failed try again later!']);
        }
    
    }  
      
 public function sendSms(Request $request)
    {
                
        $username="yutman";
        $Key="tYVRB5y6OIMziHvt6B9mFFsSlRYeQNfwXEHlOra5nGcN6e7EQM";
        $senderId="SMARTLINK";
        $tophonenumber="254".$request->hiddenphonenumber;
        echo $tophonenumber;
        $finalmessage="Hello,This is a bulk sms test message.From Izoo";

        $url="https://sms.movesms.co.ke/api/compose?";
        $postData = array(
        'username' => $username,
        'api_key' => $Key,
        'sender' => $senderId,
        'to' => $tophonenumber,
        'message' => $finalmessage,
        'msgtype' => 5,
        'dlr' => 0,
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData

        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);
        echo $output;
        if (curl_errno($ch)) {

        $output = curl_error($ch);
        echo $output;
        }

        curl_close($ch);
    }
    public function assignGroup(Request $request, $id)
    {
        $form_data = array(
            'groupid' => $request->group_contact_id,
         
        );
        if (!empty($id) && Contacts::where('id',$id)->exists() && Contacts::where('id',$id)->update($form_data)) {
            return response()->json([
                  'status' => 'success',
                  'info'=>DB::table('contacts')->orderby('id','DESC')->get(),
                  'message'=>'Contact information updated!'
                ]);
        }else{
            return response()->json(['status' => 'error','info'=>DB::table('contacts')->orderby('id','DESC')->get(),'message'=>'Action failed ,try again later!']);
        }
    }
    public function fetchGroups()
    {
        $data=DB::table('contacts')->join('groups','groups.id', '=', 'contacts.groupid')->get();

        return($data);
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
            'fullnames' => 'required|max:255',
            'phonenumber' => 'required|max:255'
        ]);
        if($validator->passes())
        {
            if(Contacts::where([
                'phone_no'=>$request->phone_number
            ])->exists())
            {
                return response()->json(['status'=>'error','message'=>'Contact Already Registered']);
            }
            $contact = Contacts::create([
            'name' => $request->fullnames,
            'phone_no' => $request->phonenumber
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
        if(!empty($id) && Contacts::where('id',$id)->exists() && Contacts::where('id',$id)->update($request->all())) 
        {
            return response()->json([
                'status' => 'success',
                'info' => Contacts::all()->orderBy('id','DESC')->get(),
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
        if(!empty($id) && Contacts::where('id',$id)->delete())
        {
            return response()->json(['status'=>'error','info'=>Contacts::all()->orderBy('id','DESC')->get(),'message' => 'Contacts Has Been Removed']);
        }
        else
        {
            return response()->json(['status'=>'error','info'=>Contacts::all()->orderBy('id','DESC')->get(),'message' => 'Action failed,try again later']);
        }
    }
}
