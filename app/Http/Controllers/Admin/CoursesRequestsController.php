<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseRequest;
use App\Devicetoken;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\TutorsCourse;
use App\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CoursesRequestsController extends Controller
{


    public function acceptCourserequest(Request $request){

        $courserequest= CourseRequest::where('id' , $request->courserequest_id)->first();
        if( $courserequest ){

            if($request->accept == 1){
                $courserequest->status = 1 ;
                $courserequest->save();

                // we will add the couser with code and parent course

                $course = new Course;
                $course->name_en = $request->course_name ;
                $course->name_ar = $request->course_name ;
                $course->code = $request->course_code ;
                $course->parent = $request->parent_course ;

                $course->save();

            }else{
                $courserequest->status = 2 ;
                $courserequest->save();

            }

            if($courserequest->user_id != ''){

                $user_id = $courserequest->user_id ;
                $tokens = Devicetoken::where('user_id', $user_id)->first();

                if( $courserequest->status == 1){
                    $title = ' تم قبول طلبك  ';
                    $body = 'لقد تم قبول طلبك باضافة المادة  '.' '.  $course->name_en;
                }else{
                    $title = '  تم رفض طلبك ';
                    $body = 'لقد تم رفض طلبك باضافة المادة  '.' '.  $course->name_en;
                }


                $data['action_type'] = 'responseaddcourse';
                $data['action_id'] = $courserequest->id;
                $data['user_id'] = $user_id;
                $data['date'] = Carbon::now()->timestamp;
                $data['title'] = $title;
                $data['body'] = $body;

                sendFCM($title, $body, $data, $tokens, 1, 1);
            }


            // send Notification to user how have accept or not


        }

        return response(['status' => 1]);
    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseRequest::where('status' , 0)->select(sprintf('%s.*', (new CourseRequest())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_showuu';
                $editGate = 'course_edit';
                $deleteGate = 'course_delete';
                $crudRoutePart = 'coursesrequests';

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
            $table->editColumn('course_name', function ($row) {
                return $row->course_name ? $row->course_name : '';
            });
            $table->editColumn('course_code', function ($row) {
                return $row->course_code ? $row->course_code : '';
            });

            $table->editColumn('details', function ($row) {
                return $row->details ? $row->details : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        $courses  = Course::where('parent' , 0)->get();
        return view('admin.coursesrequsts.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        toastr()->success('Data has been saved successfully!');
        return redirect()->route('admin.courses.index');
    }

    public function edit($id)
    {

        //dd();
         $course = CourseRequest::where('id' , $id)->first();
         $course->status = 1 ;
         $course->save();
        return view('admin.coursesrequsts.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {

        //dd('heeloo');
        $course = CourseRequest::where('id' , $id)->first();

        $course->update($request->all());

        return redirect()->route('admin.coursesrequests.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy($id)
    {


        $is_exist =  CourseRequest::where('id' , $id)->first();

        $message= 'api.delete_successfully';
        toastr()->success( __( $message) );
        $is_exist->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
