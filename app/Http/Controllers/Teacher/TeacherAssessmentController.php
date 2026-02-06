<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherAssessmentController extends Controller
{
    public function index(Request $request, string $type): View
    {
        $this->assertType($type);
        $search = $request->string('q')->trim()->toString();

        $assessments = Assessment::query()
            ->with(['schoolClass', 'subject', 'topic'])
            ->where('type', $type)
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('teacher.assessments.index', [
            'assessments' => $assessments,
            'search' => $search,
            'type' => $type,
        ]);
    }

    public function create(string $type): View
    {
        $this->assertType($type);

        return view('teacher.assessments.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'type' => $type,
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $this->assertType($type);

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'topic_id' => 'required|integer|exists:topics,id',
            'description' => 'required|string',
            'time_limit_minutes' => 'required|integer|min:1|max:600',
            'total_mark' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:0|lte:total_mark',
            'retake_attempts' => 'required|integer|min:0|max:100',
        ]);

        $data['type'] = $type;

        Assessment::create($data);

        return redirect()
            ->route($this->routePrefix($type) . '.index')
            ->with([
                'message' => ucfirst($type) . ' created successfully.',
                'status' => 'success',
            ]);
    }

    public function edit(Assessment $assessment, string $type): View
    {
        $this->assertType($type, $assessment);

        return view('teacher.assessments.edit', [
            'assessment' => $assessment->load(['schoolClass', 'subject', 'topic']),
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
            'type' => $type,
        ]);
    }

    public function update(Request $request, Assessment $assessment, string $type): RedirectResponse
    {
        $this->assertType($type, $assessment);

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'topic_id' => 'required|integer|exists:topics,id',
            'description' => 'required|string',
            'time_limit_minutes' => 'required|integer|min:1|max:600',
            'total_mark' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:0|lte:total_mark',
            'retake_attempts' => 'required|integer|min:0|max:100',
        ]);

        $assessment->update($data);

        return redirect()
            ->route($this->routePrefix($type) . '.index')
            ->with([
                'message' => ucfirst($type) . ' updated successfully.',
                'status' => 'success',
            ]);
    }

    public function destroy(Assessment $assessment, string $type): RedirectResponse
    {
        $this->assertType($type, $assessment);

        $assessment->delete();

        return back()->with([
            'message' => ucfirst($type) . ' deleted.',
            'status' => 'success',
        ]);
    }

    private function assertType(string $type, ?Assessment $assessment = null): void
    {
        if (!in_array($type, [Assessment::TYPE_QUIZ, Assessment::TYPE_EXAM], true)) {
            abort(404);
        }

        if ($assessment && $assessment->type !== $type) {
            abort(404);
        }
    }

    private function routePrefix(string $type): string
    {
        return $type === Assessment::TYPE_EXAM ? 'teacher.exams' : 'teacher.quizzes';
    }
}
