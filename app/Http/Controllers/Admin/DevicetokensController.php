<?php

namespace App\Http\Controllers\Admin;

use App\Devicetoken;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDevicetokenRequest;
use App\Http\Requests\StoreDevicetokenRequest;
use App\Http\Requests\UpdateDevicetokenRequest;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DevicetokensController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('devicetoken_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $devicetokens = Devicetoken::with(['user'])->get();

        return view('admin.devicetokens.index', compact('devicetokens'));
    }

    public function create()
    {
        abort_if(Gate::denies('devicetoken_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.devicetokens.create', compact('users'));
    }

    public function store(StoreDevicetokenRequest $request)
    {
        $devicetoken = Devicetoken::create($request->all());

        return redirect()->route('admin.devicetokens.index');
    }

    public function edit(Devicetoken $devicetoken)
    {
        abort_if(Gate::denies('devicetoken_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $devicetoken->load('user');

        return view('admin.devicetokens.edit', compact('users', 'devicetoken'));
    }

    public function update(UpdateDevicetokenRequest $request, Devicetoken $devicetoken)
    {
        $devicetoken->update($request->all());

        return redirect()->route('admin.devicetokens.index');
    }

    public function show(Devicetoken $devicetoken)
    {
        abort_if(Gate::denies('devicetoken_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $devicetoken->load('user');

        return view('admin.devicetokens.show', compact('devicetoken'));
    }

    public function destroy(Devicetoken $devicetoken)
    {
        abort_if(Gate::denies('devicetoken_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $devicetoken->delete();

        return back();
    }

    public function massDestroy(MassDestroyDevicetokenRequest $request)
    {
        Devicetoken::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
