<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVaforiteRequest;
use App\Http\Requests\StoreVaforiteRequest;
use App\Http\Requests\UpdateVaforiteRequest;
use App\User;
use App\Vaforite;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VaforiteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vaforite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vaforites = Vaforite::with(['user', 'tutor'])->get();

        return view('admin.vaforites.index', compact('vaforites'));
    }

    public function create()
    {
        abort_if(Gate::denies('vaforite_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vaforites.create', compact('users', 'tutors'));
    }

    public function store(StoreVaforiteRequest $request)
    {
        $vaforite = Vaforite::create($request->all());

        return redirect()->route('admin.vaforites.index');
    }

    public function edit(Vaforite $vaforite)
    {
        abort_if(Gate::denies('vaforite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vaforite->load('user', 'tutor');

        return view('admin.vaforites.edit', compact('users', 'tutors', 'vaforite'));
    }

    public function update(UpdateVaforiteRequest $request, Vaforite $vaforite)
    {
        $vaforite->update($request->all());

        return redirect()->route('admin.vaforites.index');
    }

    public function show(Vaforite $vaforite)
    {
        abort_if(Gate::denies('vaforite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vaforite->load('user', 'tutor');

        return view('admin.vaforites.show', compact('vaforite'));
    }

    public function destroy(Vaforite $vaforite)
    {
        abort_if(Gate::denies('vaforite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vaforite->delete();

        return back();
    }

    public function massDestroy(MassDestroyVaforiteRequest $request)
    {
        Vaforite::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
