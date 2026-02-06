<?php

namespace App\Http\Controllers\Student;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    public function show(Assignment $assignment): View
    {
        $assignment->load('lesson.topic');

        $submission = AssignmentSubmission::query()
            ->where('assignment_id', $assignment->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('student.assignments.show', [
            'assignment' => $assignment,
            'submission' => $submission,
        ]);
    }

    public function submit(Request $request, Assignment $assignment): RedirectResponse
    {
        $data = $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:51200|mimetypes:application/pdf,video/mp4,video/webm,video/ogg',
        ]);

        $content = trim((string) ($data['content'] ?? ''));
        $file = $request->file('file');

        if ($content === '' && !$file) {
            return back()
                ->withErrors(['content' => 'Provide assignment text or upload a file.'])
                ->withInput();
        }

        $submission = AssignmentSubmission::firstOrNew([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
        ]);

        if ($file) {
            if ($submission->file_path && Storage::disk('local')->exists($submission->file_path)) {
                Storage::disk('local')->delete($submission->file_path);
            }

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::uuid()->toString();
            if ($extension !== '') {
                $storedName .= '.' . $extension;
            }

            $filePath = $file->storeAs('assignment-submissions', $storedName, 'local');
            $submission->file_path = $filePath;
            $submission->file_name = $originalName;
            $submission->file_type = $file->getClientMimeType();
        }

        $submission->content = $content !== '' ? $content : $submission->content;
        $submission->submitted_at = now();
        $submission->status = 'submitted';
        $submission->save();

        return back()->with([
            'status' => 'success',
            'message' => 'Assignment submitted successfully.',
        ]);
    }
}
