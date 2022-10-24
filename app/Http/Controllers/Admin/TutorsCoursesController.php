<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTutorsCourseRequest;
use App\Http\Requests\StoreTutorsCourseRequest;
use App\Http\Requests\UpdateTutorsCourseRequest;
use App\TutorsCourse;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TutorsCoursesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tutors_course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutorsCourses = TutorsCourse::with(['user', 'course'])->get();

        return view('admin.tutorsCourses.index', compact('tutorsCourses'));
    }

    public function create()
    {
        abort_if(Gate::denies('tutors_course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courses = Course::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tutorsCourses.create', compact('users', 'courses'));
    }

    public function store(StoreTutorsCourseRequest $request)
    {
        $tutorsCourse = TutorsCourse::create($request->all());

        return redirect()->route('admin.tutors-courses.index');
    }

    public function edit(TutorsCourse $tutorsCourse)
    {
        abort_if(Gate::denies('tutors_course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courses = Course::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutorsCourse->load('user', 'course');

        return view('admin.tutorsCourses.edit', compact('users', 'courses', 'tutorsCourse'));
    }

    public function update(UpdateTutorsCourseRequest $request, TutorsCourse $tutorsCourse)
    {
        $tutorsCourse->update($request->all());

        return redirect()->route('admin.tutors-courses.index');
    }

    public function show(TutorsCourse $tutorsCourse)
    {
        abort_if(Gate::denies('tutors_course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutorsCourse->load('user', 'course');

        return view('admin.tutorsCourses.show', compact('tutorsCourse'));
    }

    public function destroy(TutorsCourse $tutorsCourse)
    {
        abort_if(Gate::denies('tutors_course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutorsCourse->delete();

        return back();
    }

    public function massDestroy(MassDestroyTutorsCourseRequest $request)
    {
        TutorsCourse::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
