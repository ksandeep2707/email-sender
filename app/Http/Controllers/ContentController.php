<?php

namespace App\Http\Controllers;

use App\Mail\SendMailContent;
use App\Models\Content;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class ContentController extends Controller
{
    //
    public function index(Request $request)
    {
        $topic=Topic::orderby('topic')->get();
        
        return view('main')->with(compact('topic'));
    }

    public function saveTopic(Request $request)
    {
        $request->validate([
            'topic'=>'required'
        ]);

        $check=Topic::where('topic',strtoupper($request->topic))->first();

        if($check){
            return redirect()->back()->with(['error'=>true,'message'=>$request->topic.' topic already exists']);
        }
        Topic::create(['topic' => strtoupper($request->topic)]);

        return redirect()->back()->with(['error'=>false,'message'=>'Successfully added topic']);

    }


    public function saveUser(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'user_topic'=>'required'
        ]);


        $check=User::where('email',$request->email)->first();

        if($check){
            return redirect()->back()->with(['error'=>true,'message'=>'User already exists']);
        }
     
        User::create(['email' =>$request->email,'topic_id'=>$request->user_topic]);

        return redirect()->back()->with(['error'=>false,'message'=>'Successfully added user']);

    }

    public function saveContent(Request $request)
    {
     try{

        if(Carbon::parse($request->time)<Carbon::now('Asia/kolkata')->toDateTimeString()){
            return response()->json(['error'=>true,'message'=>'Past time entered']);
        }

         $check=Content::where(['content'=>$request->content,'topic_id'=>$request->content_topic])->first();


        if($check){
            return response()->json(['error'=>true,'message'=>'Content with same topic title already exist']);
        }

        Content::create([
        'content' =>$request->content,
        'topic_id'=>$request->content_topic,
        'time'=>$request->time
        ]);

     }
     catch(\exception  $e){

        return response()->json(['error'=>true,'message'=>$e->getMessage()]);


     }
       
        return response()->json(['error'=>false,
        'message'=>'Successfully added Content',
        'time_diff'=>round((strtotime($request->time)- strtotime(Carbon::now('Asia/Kolkata')->toDateTimeString()))/60,0)
    ]);

    }

    public function sendMail(Request $request)
    {
        try{

        
            // return $request;
            $data=Content::join('users',function ($join){
                $join->on('users.topic_id','contents.topic_id');
            })
            ->join('topics',function ($join){
                $join->on('topics.id','contents.topic_id');
            })
            ->where([
            'contents.content' =>$request->content,
            'contents.topic_id'=>$request->content_topic,
            'contents.time'=>$request->time
            ])
            ->select('users.email','contents.content','topics.topic')->get();


            foreach($data as $item)
            {
                Mail::to($item->email)->send(new SendMailContent($item->content,$item->topic));

            }
        }
        catch(\exception  $e){

            return response()->json(['error'=>true,'message'=>$e->getMessage()]);
    
    
         }
        
         return response()->json(['error'=>false,'message'=>'Successfully sent the mail']);
    }




    
}
