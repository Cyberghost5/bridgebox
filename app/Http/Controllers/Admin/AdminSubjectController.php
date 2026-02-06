<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminSubjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $subjects = Subject::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.subjects.index', [
            'subjects' => $subjects,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
        ]);

        $data['code'] = Str::slug($data['name']);

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with([
            'message' => 'Subject created successfully.',
            'status' => 'success',
        ]);
    }

    public function edit(Subject $subject): View
    {
        return view('admin.subjects.edit', [
            'subject' => $subject,
        ]);
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
        ]);

        $data['code'] = Str::slug($data['name']);

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with([
            'message' => 'Subject updated successfully.',
            'status' => 'success',
        ]);
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return back()->with([
            'message' => 'Subject deleted.',
            'status' => 'success',
        ]);
    }
}
