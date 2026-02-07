<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $student = $request->user();
        $classId = $student?->school_class_id;

        $lessonsCount = $classId
            ? Lesson::query()
                ->whereHas('topic', function ($query) use ($classId) {
                    $query->where('school_class_id', $classId);
                })
                ->count()
            : 0;

        $assignmentsCount = $classId
            ? Assignment::query()
                ->whereHas('lesson.topic', function ($query) use ($classId) {
                    $query->where('school_class_id', $classId);
                })
                ->count()
            : 0;

        $quizzesCount = $classId
            ? Assessment::where('type', Assessment::TYPE_QUIZ)
                ->where('school_class_id', $classId)
                ->count()
            : 0;

        $examsCount = $classId
            ? Assessment::where('type', Assessment::TYPE_EXAM)
                ->where('school_class_id', $classId)
                ->count()
            : 0;

        $topicsCount = $classId
            ? Topic::where('school_class_id', $classId)->count()
            : 0;

        return view('dashboards.student', [
            'student' => $student,
            'lessonsCount' => $lessonsCount,
            'assignmentsCount' => $assignmentsCount,
            'quizzesCount' => $quizzesCount,
            'examsCount' => $examsCount,
            'topicsCount' => $topicsCount,
        ]);
    }
}
