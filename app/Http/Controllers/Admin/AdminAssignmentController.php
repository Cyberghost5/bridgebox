<?php

namespace App\Http\Controllers\Admin;

use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminAssignmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $assignments = Assignment::query()
            ->with(['lesson.topic'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.assignments.index', [
            'assignments' => $assignments,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        $lessons = Lesson::query()
            ->with('topic')
            ->orderBy('title')
            ->get();

        return view('admin.assignments.create', [
            'lessons' => $lessons,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'allow_late' => $request->boolean('allow_late') ? 1 : 0,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'lesson_id' => 'required|integer|exists:lessons,id',
            'description' => 'required|string',
            'due_at' => 'required|date',
            'max_points' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:0|lte:max_points',
            'retake_attempts' => 'required|integer|min:0|max:100',
            'allow_late' => 'boolean',
            'late_mark' => 'required_if:allow_late,1|nullable|integer|min:0|lte:max_points',
            'late_due_at' => 'required_if:allow_late,1|nullable|date|after:due_at',
        ]);

        Assignment::create($data);

        return redirect()->route('admin.assignments.index')->with([
            'message' => 'Assignment created successfully.',
            'status' => 'success',
        ]);
    }

    public function edit(Assignment $assignment): View
    {
        $lessons = Lesson::query()
            ->with('topic')
            ->orderBy('title')
            ->get();

        return view('admin.assignments.edit', [
            'assignment' => $assignment->load('lesson.topic'),
            'lessons' => $lessons,
        ]);
    }

    public function update(Request $request, Assignment $assignment): RedirectResponse
    {
        $request->merge([
            'allow_late' => $request->boolean('allow_late') ? 1 : 0,
        ]);

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'lesson_id' => 'required|integer|exists:lessons,id',
            'description' => 'required|string',
            'due_at' => 'required|date',
            'max_points' => 'required|integer|min:1|max:1000',
            'pass_mark' => 'required|integer|min:0|lte:max_points',
            'retake_attempts' => 'required|integer|min:0|max:100',
            'allow_late' => 'boolean',
            'late_mark' => 'required_if:allow_late,1|nullable|integer|min:0|lte:max_points',
            'late_due_at' => 'required_if:allow_late,1|nullable|date|after:due_at',
        ]);

        $assignment->update($data);

        return redirect()->route('admin.assignments.index')->with([
            'message' => 'Assignment updated successfully.',
            'status' => 'success',
        ]);
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        $assignment->delete();

        return back()->with([
            'message' => 'Assignment deleted.',
            'status' => 'success',
        ]);
    }
}
