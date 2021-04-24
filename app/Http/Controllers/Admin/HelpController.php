<?php

namespace App\Http\Controllers\Admin;

use App\Help;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHelpRequest;
use App\Http\Requests\StoreHelpRequest;
use App\Http\Requests\UpdateHelpRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HelpController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('help_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $helps = Help::all();

        return view('admin.helps.index', compact('helps'));
    }

    public function create()
    {
        abort_if(Gate::denies('help_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helps.create');
    }

    public function store(StoreHelpRequest $request)
    {
        $help = Help::create($request->all());

        return redirect()->route('admin.helps.index');
    }

    public function edit(Help $help)
    {
        abort_if(Gate::denies('help_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helps.edit', compact('help'));
    }

    public function update(UpdateHelpRequest $request, Help $help)
    {
        $help->update($request->all());

        return redirect()->route('admin.helps.index');
    }

    public function show(Help $help)
    {
        abort_if(Gate::denies('help_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.helps.show', compact('help'));
    }

    public function destroy(Help $help)
    {
        abort_if(Gate::denies('help_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $help->delete();

        return back();
    }

    public function massDestroy(MassDestroyHelpRequest $request)
    {
        Help::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
