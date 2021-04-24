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
                return $row->accept ? $row->accept : '';
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

        return view('admin.conversations.show', compact('conversation'));
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
