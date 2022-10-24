<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCountryRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CitiesController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('country_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::with('country')->get();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::all()->pluck('name_ar', 'id');
        return view('admin.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $country = City::create($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        abort_if(Gate::denies('country_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $countries = Country::all()->pluck('name_ar', 'id');
        return view('admin.cities.edit', compact('city' , 'countries'));
    }

    public function update(Request $request, $id)
    {
        $city = City::where('id' , $id)->first();
        if($city){
            $city->update($request->all());

            return redirect()->route('admin.cities.index');
        }

    }

    public function show($id)
    {
        abort_if(Gate::denies('country_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $city = City::where('id' , $id)->first();
        if($city)
            return view('admin.cities.show', compact('city'));
    }

    public function destroy(Country $country)
    {

        // check if this country has related data
        $is_exist_user_has_this_country = User::where('city_id' ,$country->id )->first();
        if( $is_exist_user_has_this_country ){
            $message= 'api.cant_delete';
            toastr()->error( __( $message) );
            return back();
        }
        $country->delete();
        $message= 'api.delete_successfully';
        toastr()->success( __( $message) );
        return back();
    }

    public function massDestroy(MassDestroyCountryRequest $request)
    {
        Country::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
