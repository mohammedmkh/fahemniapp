<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Level;
use App\Role;
use App\Universite;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::where('role' , 2)->with(['roles', 'country', 'level', 'university'])
                ->select(sprintf('%s.*', (new User())->table));

            if (request()->has('status') and request()->status > -1 ) {
                $query->where('verify', request()->status );
            }

            if (request()->has('name') and request()->name <> '' ) {
                $query->where('name', 'like' , '%' .request()->name .'%' );
            }
            if (request()->has('phone') and request()->phone <> '' ) {
                $query->where('phone', 'like' , '%' .request()->phone .'%' );
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'students';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('verify', function ($row) {
                if($row->verify){
                    return '<span class="label label-lg label-light-primary label-inline">'.$row->verify_name.'</span>';

                }
                return '<span class="">'.$row->verify_name.'</span>';

                // return $row->verify ? $row->verify : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('sex', function ($row) {
                return $row->sex ? $row->sex_name : '';
            });
            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->addColumn('country_name_ar', function ($row) {
                return $row->country ? $row->country->name_ar : '';
            });

            $table->editColumn('lat', function ($row) {
                return $row->lat ? $row->lat : '';
            });
            $table->editColumn('long', function ($row) {
                return $row->long ? $row->long : '';
            });
            $table->addColumn('level_name_ar', function ($row) {
                return $row->level ? $row->level->name_ar : '';
            });

            $table->addColumn('university_name_en', function ($row) {
                return $row->university ? $row->university->name_en : '';
            });

            $table->editColumn('bio', function ($row) {
                return $row->bio ? $row->bio : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'verify','roles', 'country', 'level', 'university']);

            return $table->make(true);
        }

        return view('admin.students.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $countries = Country::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $levels = Level::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $universities = Universite::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'countries', 'levels', 'universities'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
       // dd($id);

        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $countries = Country::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $levels = Level::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $universities = Universite::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');
        $user = User::where('id' , $id)->first();
        $user->load('roles', 'country', 'level', 'university');
       // dd(  $user);
       // $user = 'mm' ;
        return view('admin.students.edit', compact('roles', 'countries', 'levels', 'universities', 'user'));
    }

    public function update(Request $request, $id)
    {
        //dd($id);
        $user = User::where('id' , $id)->first();
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.students.index');
    }

    public function show($id)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::where('id' , $id)->first();
        $user->load('roles', 'country', 'level', 'university', 'userTutorsCourses');

        return view('admin.students.show', compact('user'));
    }

    public function destroy($id)
    {
        $is_exist =  Booking::where('user_id' , $id)->first();
        if(  $is_exist ){
            $message= 'api.cant_delete';
            toastr()->error( __( $message) );
            return back();
        }

        $message= 'api.delete_successfully';
        toastr()->success( __( $message) );

        $user = User::find($id);
        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
