<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentLessonController extends Controller
{
    public function index(Request $request): View
    {
        $student = $request->user();
        $classId = $student?->school_class_id;
        $search = $request->string('q')->trim()->toString();
        $subjectId = $request->integer('subject_id');
        $topicId = $request->integer('topic_id');

        $subjects = Subject::query()
            ->whereIn('id', Topic::query()
                ->where('school_class_id', $classId)
                ->select('subject_id')
                ->distinct())
            ->orderBy('name')
            ->get();

        $topics = collect();
        if ($subjectId && $classId) {
            $topics = Topic::query()
                ->where('school_class_id', $classId)
                ->where('subject_id', $subjectId)
                ->orderBy('title')
                ->get();
        }

        $lessons = Lesson::query()
            ->with(['topic.subject', 'topic.schoolClass'])
            ->whereHas('topic', function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
            ->when($subjectId, function ($query) use ($subjectId) {
                $query->whereHas('topic', function ($topicQuery) use ($subjectId) {
                    $topicQuery->where('subject_id', $subjectId);
                });
            })
            ->when($topicId, function ($query) use ($topicId) {
                $query->where('topic_id', $topicId);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('student.lessons.index', [
            'student' => $student,
            'lessons' => $lessons,
            'subjects' => $subjects,
            'topics' => $topics,
            'search' => $search,
            'selectedSubjectId' => $subjectId ?: null,
            'selectedTopicId' => $topicId ?: null,
        ]);
    }

    public function show(Request $request, Lesson $lesson): View
    {
        $student = $request->user();
        $this->assertLessonAccess($student?->school_class_id, $lesson);

        return view('student.lessons.show', [
            'student' => $student,
            'lesson' => $lesson->load(['topic.subject', 'topic.schoolClass']),
        ]);
    }

    public function file(Request $request, Lesson $lesson)
    {
        $student = $request->user();
        $this->assertLessonAccess($student?->school_class_id, $lesson);

        if (!$lesson->file_path || !Storage::disk('local')->exists($lesson->file_path)) {
            abort(404);
        }

        $path = Storage::disk('local')->path($lesson->file_path);
        $filename = $lesson->file_name ?: basename($lesson->file_path);
        $mime = $lesson->file_type ?: null;

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    private function assertLessonAccess(?int $classId, Lesson $lesson): void
    {
        if (!$classId || $lesson->topic?->school_class_id !== $classId) {
            abort(404);
        }
    }
}
