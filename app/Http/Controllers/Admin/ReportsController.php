<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Report;
use App\TutorsCourse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Report::query()->select(sprintf('%s.*', (new Report())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_show66';
                $editGate = 'course_edit';
                $deleteGate = 'course_delete';
                $crudRoutePart = 'reports';

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
            $table->editColumn('student_id', function ($row) {
                return $row->student_id ? $row->student_id : '';
            });
            $table->editColumn('conversation_id', function ($row) {
                $url = url('admin/conversations') . '/'. $row->conversation_id ;
                $data = '<a href="'. $url .'"> ' . $row->conversation_id . '</a>';
                return $data;
            });
            $table->editColumn('text', function ($row) {
                return $row->text ? $row->text : '';
            });

            $table->editColumn('user_id', function ($row) {
                return $row->user->name ? $row->user->name : '';
            });
            $table->rawColumns(['actions', 'placeholder' , 'conversation_id']);

            return $table->make(true);
        }

        return view('admin.reports.index');
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       // return view('admin.courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        toastr()->success('Data has been saved successfully!');
        return redirect()->route('admin.courses.index');
    }

    public function edit($id)
    {

        $report = Report::where('id' , $id)->first();
        $report->status = 1 ;
        $report->save();
        return view('admin.reports.edit', compact('report'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        return redirect()->route('admin.reports.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy($id)
    {


        $is_exist =  TutorsCourse::where('course_id' , $course->id)->first();


        $message= 'api.delete_successfully';
        toastr()->success( __( $message) );
        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
