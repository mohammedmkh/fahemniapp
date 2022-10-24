<?php

namespace App\Http\Controllers\Admin;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyConversationRequest;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
class ConversationsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('conversation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Conversation::with(['user', 'tutor'])->select(sprintf('%s.*', (new Conversation())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'conversation_show';
                $editGate = 'conversation_edit';
                $deleteGate = 'conversation_delete';
                $crudRoutePart = 'conversations';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('tutor_name', function ($row) {
                return $row->tutor ? $row->tutor->name : '';
            });

            $table->editColumn('accept', function ($row) {
                return $row->accept_name ? $row->accept_name : '';
            });
            $table->editColumn('end_conv', function ($row) {
                return $row->end_conv ? $row->end_conv : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'tutor']);

            return $table->make(true);
        }

        return view('admin.conversations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('conversation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.conversations.create', compact('users', 'tutors'));
    }

    public function store(StoreConversationRequest $request)
    {
        $conversation = Conversation::create($request->all());

        return redirect()->route('admin.conversations.index');
    }

    public function edit(Conversation $conversation)
    {
        abort_if(Gate::denies('conversation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $conversation->load('user', 'tutor');

        return view('admin.conversations.edit', compact('users', 'tutors', 'conversation'));
    }

    public function update(UpdateConversationRequest $request, Conversation $conversation)
    {
        $conversation->update($request->all());

        return redirect()->route('admin.conversations.index');
    }

    public function show(Conversation $conversation)
    {
        abort_if(Gate::denies('conversation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $conversation->load('user', 'tutor');

        // get messages from the application
        $teacher_id = $conversation->tutor->application_chat_id ;
        $student_id = $conversation->student->application_chat_id ;

        //$m="1629923467823";
       // $msg['date']=date('Y-m-d H:i:s', strtotime($message->createdAtTime));


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            "https://apps.applozic.com/rest/ws/analytics/message?applicationId=3b7632a496392dc1eb19f9302fa269&pageSize=300&from=". $teacher_id."&to=".$student_id );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           0 );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json' , 'Application-Key: 3b7632a496392dc1eb19f9302fa269', 'Authorization: Basic YWRtaW5ib3Q6YWRtaW5ib3Q=' , 'Of-User-Id:adminbot'));
        $result=curl_exec ($ch);

        $chat = [];
        $teacher['name']=$conversation->tutor->name ;
        $teacher['image']=$conversation->tutor->image_path ;
        $student['name']=$conversation->student->name ;
        $student['image']=$conversation->student->image_path ;
      //  dd($result ,$teacher_id  , $student_id);
        $result = json_decode( $result);

        if($result && count($result->response) > 0){
            $msg = [] ;
          foreach ($result->response as $message){


              $message->createdAtTime =(String)$message->createdAtTime;
             // $msg['date']=date('Y-m-d H:i:s', strtotime($message->createdAtTime));
              //dd( $msg ,$message->createdAtTime );
              $msg['date']= Carbon::parse($message->createdAtTime /1000)->toDateTimeString();
              $msg['content']= $message->content ;
              if(isset($message->fileMeta) && $message->fileMeta != ''){
                  $msg['type'] = 'audio' ;
              }else{
                  $msg['type'] = 'text' ;
              }
            //  $msg['type']= isset($message->fileMeta) ? 'text': 'audio' ;
              if($message->fromUserId ==  $teacher_id){
                  $msg['is_teacher']=true;
              }else{
                  $msg['is_teacher']=false;
              }

             // dd($message->createdAtTime);
             $chat[]=   $msg ;
          }
        }
        $chat = array_reverse( $chat);

        return view('admin.conversations.show', compact('conversation' , 'chat' , 'teacher' , 'student'));
    }

    public function destroy(Conversation $conversation)
    {
        abort_if(Gate::denies('conversation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $conversation->delete();

        return back();
    }

    public function massDestroy(MassDestroyConversationRequest $request)
    {
        Conversation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
