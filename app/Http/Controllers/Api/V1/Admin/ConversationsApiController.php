<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\Http\Resources\Admin\ConversationResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConversationsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('conversation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConversationResource(Conversation::with(['user', 'tutor'])->get());
    }

    public function store(StoreConversationRequest $request)
    {
        $conversation = Conversation::create($request->all());

        return (new ConversationResource($conversation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Conversation $conversation)
    {
        abort_if(Gate::denies('conversation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ConversationResource($conversation->load(['user', 'tutor']));
    }

    public function update(UpdateConversationRequest $request, Conversation $conversation)
    {
        $conversation->update($request->all());

        return (new ConversationResource($conversation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Conversation $conversation)
    {
        abort_if(Gate::denies('conversation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $conversation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
