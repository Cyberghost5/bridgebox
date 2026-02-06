<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherTopicController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $topics = Topic::query()
            ->with(['schoolClass', 'subject'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('teacher.topics.index', [
            'topics' => $topics,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('teacher.topics.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'description' => 'nullable|string',
        ]);

        Topic::create($data);

        return redirect()->route('teacher.topics.index')->with([
            'message' => 'Topic created successfully.',
            'status' => 'success',
        ]);
    }

    public function edit(Topic $topic): View
    {
        return view('teacher.topics.edit', [
            'topic' => $topic->load(['schoolClass', 'subject']),
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Topic $topic): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'description' => 'nullable|string',
        ]);

        $topic->update($data);

        return redirect()->route('teacher.topics.index')->with([
            'message' => 'Topic updated successfully.',
            'status' => 'success',
        ]);
    }

    public function destroy(Topic $topic): RedirectResponse
    {
        $topic->delete();

        return back()->with([
            'message' => 'Topic deleted.',
            'status' => 'success',
        ]);
    }

    public function bySubject(Request $request): JsonResponse
    {
        $subjectId = $request->integer('subject_id');
        $classId = $request->integer('class_id');

        if (!$subjectId) {
            return response()->json([]);
        }

        $query = Topic::query()
            ->where('subject_id', $subjectId);

        if ($classId) {
            $query->where('school_class_id', $classId);
        }

        $topics = $query->orderBy('title')->get(['id', 'title']);

        return response()->json($topics);
    }
}
