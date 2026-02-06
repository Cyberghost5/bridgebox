<?php

namespace App\Http\Controllers\Admin;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminAssignmentSubmissionController extends Controller
{
    public function index(Assignment $assignment): View
    {
        $submissions = AssignmentSubmission::query()
            ->with('user')
            ->where('assignment_id', $assignment->id)
            ->orderByDesc('submitted_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.assignments.submissions.index', [
            'assignment' => $assignment->load('lesson.topic'),
            'submissions' => $submissions,
        ]);
    }

    public function download(Assignment $assignment, AssignmentSubmission $submission)
    {
        if ($submission->assignment_id !== $assignment->id) {
            abort(404);
        }

        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404);
        }

        $downloadName = $submission->file_name ?: basename($submission->file_path);

        return Storage::disk('local')->download($submission->file_path, $downloadName);
    }

    public function destroy(Assignment $assignment, AssignmentSubmission $submission): RedirectResponse
    {
        if ($submission->assignment_id !== $assignment->id) {
            abort(404);
        }

        if ($submission->file_path && Storage::disk('local')->exists($submission->file_path)) {
            Storage::disk('local')->delete($submission->file_path);
        }

        $submission->delete();

        return back()->with([
            'status' => 'success',
            'message' => 'Submission deleted.',
        ]);
    }
}
