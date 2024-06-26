<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUniversiteRequest;
use App\Http\Requests\StoreUniversiteRequest;
use App\Http\Requests\UpdateUniversiteRequest;
use App\Universite;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UniversitesController extends Controller
{
    public function index()
    {
       // abort_if(Gate::denies('universite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $universites = Universite::all();

        return view('admin.universites.index', compact('universites'));
    }

    public function create()
    {
        abort_if(Gate::denies('universite_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.universites.create');
    }

    public function store(StoreUniversiteRequest $request)
    {
        $universite = Universite::create($request->all());

        return redirect()->route('admin.universites.index');
    }

    public function edit(Universite $universite)
    {
        abort_if(Gate::denies('universite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.universites.edit', compact('universite'));
    }

    public function update(UpdateUniversiteRequest $request, Universite $universite)
    {
        $universite->update($request->all());

        return redirect()->route('admin.universites.index');
    }

    public function show(Universite $universite)
    {
        abort_if(Gate::denies('universite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.universites.show', compact('universite'));
    }

    public function destroy(Universite $universite)
    {

        $is_exist_user_has_this_universite = User::where('university_id' ,$universite->id )->first();
        if( $is_exist_user_has_this_universite ){
            $message= 'api.cant_delete';
            toastr()->error( __( $message) );
            return back();
        }
        $universite->delete();
        $message= 'api.delete_successfully';
        toastr()->success( __( $message) );
        return back();

    }

    public function massDestroy(MassDestroyUniversiteRequest $request)
    {
        Universite::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
