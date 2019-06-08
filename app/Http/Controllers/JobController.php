<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Company;
use App\Http\Requests\JobPostRequest;

class JobController extends Controller
{   
    public function __construct(){
        $this->middleware('employer',['except'=>array('index','show')]);//indexとshowだけは見ることができる
    }
    //
    public function index(){
        $jobs = Job::all()->take(10);//10件だけデータを取ってくる
        return view('welcome',compact('jobs'));//welcome.blade.phpの内容を持ってきて表示する
    }

    public function show($id,Job $job){//web.phpで宣言したやつ(Job)はモデル　use App\Job
        //$job=Job::find($id);
        //dd($job->id);//jobの情報を持ってくる上のコードでもok idの値を返す　jobモデルから情報を持ってくる
        return view('jobs.show',compact('job'));//sho.blade.phpの内容を表示する
    }

    public function company(){
        return view('company.index');
    }

    public function create(){
        return view('jobs.create');
    }

    public function edit($id)
    { $job = Job::findOrFail($id);
        return view('edit-jobs.edit',compact('job')); }

    public function update(Request $request,$id){
        //dd($request->all());//getする情報を表示する
        $job = JOB::findOrFail($id);
        $job->update($request->all());
        return redirect()->back()->with('message','Job successfully updated!');
    }

    public function store(JobPostRequest $request){
        $user_id = auth()->user()->id;
        $company = Company::where('user_id', $user_id)->first();//company_idと紐ずいてる
        $company_id = $company->id;
        Job::create([
            'user_id' => $user_id,
            'company_id' => $company_id,
            'title'=>request('title'),
            'slug'=>str_slug(request('title')),//titleの名前と紐づいてる
            'description'=>request('description'),
            'roles'=>request('roles'),
            'category_id'=>request('category'),
            'position'=>request('position'),
            'address'=>request('address'),
            'type'=>request('type'),
            'status'=>request('status'),
            'last_date'=>request('last_date'),
        ]);
        return redirect()->back()->with('message', 'Job posted successfully!');
    }

    public function myjob(){
        $jobs = Job::where('user_id', auth()->user()->id)->get();
        return view('jobs.my-job', compact('jobs'));
    }


}
