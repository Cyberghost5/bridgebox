<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private const MANAGED_ROLES = [
        User::ROLE_TEACHER,
        User::ROLE_STUDENT,
    ];

    public function teachers(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $teachers = User::query()
            ->where('role', User::ROLE_TEACHER)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.teachers.index', [
            'teachers' => $teachers,
            'search' => $search,
        ]);
    }

    public function students(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();

        $students = User::query()
            ->where('role', User::ROLE_STUDENT)
            ->with('studentProfile')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.students.index', [
            'students' => $students,
            'search' => $search,
        ]);
    }

    public function createStudent(): View
    {
        return view('admin.users.students.create');
    }

    public function createTeacher(): View
    {
        return view('admin.users.teachers.create');
    }

    public function storeTeacher(StoreTeacherRequest $request): RedirectResponse
    {
        $autoGenerate = $request->boolean('auto_generate');
        $plainPassword = $autoGenerate ? Str::random(12) : $request->string('password')->toString();

        $teacher = User::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString(),
            'role' => User::ROLE_TEACHER,
            'password' => Hash::make($plainPassword),
        ]);

        return redirect()
            ->route('admin.users.teachers.created', $teacher)
            ->with([
                'generated_password' => $autoGenerate ? $plainPassword : null,
                'password_mode' => $autoGenerate ? 'auto' : 'manual',
            ]);
    }

    public function createdTeacher(User $user): View
    {
        abort_unless($user->role === User::ROLE_TEACHER, 404);

        return view('admin.users.teachers.created', [
            'teacher' => $user,
            'generatedPassword' => session('generated_password'),
            'passwordMode' => session('password_mode', 'manual'),
        ]);
    }

    public function storeStudent(StoreStudentRequest $request): RedirectResponse
    {
        $autoGenerate = $request->boolean('auto_generate');
        $plainPassword = $autoGenerate ? Str::random(12) : $request->string('password')->toString();
        $profileData = array_filter([
            'class' => $request->input('class'),
            'department' => $request->input('department'),
            'admission_id' => $request->input('admission_id'),
        ], static fn ($value) => $value !== null && $value !== '');

        $student = DB::transaction(function () use ($request, $plainPassword, $profileData) {
            $student = User::create([
                'name' => $request->string('name')->toString(),
                'email' => $request->string('email')->toString(),
                'phone' => $request->string('phone')->toString(),
                'role' => User::ROLE_STUDENT,
                'password' => Hash::make($plainPassword),
            ]);

            if ($profileData) {
                $student->studentProfile()->create($profileData);
            }

            return $student;
        });

        return redirect()
            ->route('admin.users.students.created', $student)
            ->with([
                'generated_password' => $autoGenerate ? $plainPassword : null,
                'password_mode' => $autoGenerate ? 'auto' : 'manual',
            ]);
    }

    public function createdStudent(User $user): View
    {
        abort_unless($user->role === User::ROLE_STUDENT, 404);

        return view('admin.users.students.created', [
            'student' => $user,
            'profile' => $user->studentProfile,
            'generatedPassword' => session('generated_password'),
            'passwordMode' => session('password_mode', 'manual'),
        ]);
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $this->assertManageable($user);

        if ($user->id === auth()->id()) {
            return back()->with([
                'status' => 'error',
                'message' => 'You cannot disable your own account.',
            ]);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $action = $user->is_active ? 'user_enable' : 'user_disable';
        $message = sprintf('%s %s account (%s).', $user->is_active ? 'Enabled' : 'Disabled', $user->role, $user->email);

        $this->logAdminAction($action, 'success', $message);

        return back()->with([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $this->assertManageable($user);

        $plainPassword = Str::random(12);
        $user->password = Hash::make($plainPassword);
        $user->save();

        $message = sprintf('Password reset for %s account (%s).', $user->role, $user->email);
        $this->logAdminAction('user_reset_password', 'success', $message);

        return redirect()
            ->route('admin.users.password-reset', $user)
            ->with([
                'generated_password' => $plainPassword,
                'status' => 'success',
                'message' => $message,
            ]);
    }

    public function showPasswordReset(User $user)
    {
        $this->assertManageable($user);

        $generatedPassword = session('generated_password');
        if (!$generatedPassword) {
            return redirect()
                ->route($this->indexRouteFor($user))
                ->with([
                    'status' => 'error',
                    'message' => 'The reset password is no longer available. Please reset again if needed.',
                ]);
        }

        return view('admin.users.password-reset', [
            'user' => $user,
            'generatedPassword' => $generatedPassword,
            'backRoute' => $this->indexRouteFor($user),
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->assertManageable($user);

        if ($user->id === auth()->id()) {
            return back()->with([
                'status' => 'error',
                'message' => 'You cannot delete your own account.',
            ]);
        }

        $email = $user->email;
        $role = $user->role;
        $user->delete();

        $message = sprintf('Deleted %s account (%s).', $role, $email);
        $this->logAdminAction('user_delete', 'success', $message);

        return back()->with([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    private function assertManageable(User $user): void
    {
        abort_unless(in_array($user->role, self::MANAGED_ROLES, true), 404);
    }

    private function indexRouteFor(User $user): string
    {
        return $user->role === User::ROLE_TEACHER
            ? 'admin.users.teachers.index'
            : 'admin.users.students.index';
    }

    private function logAdminAction(string $action, string $result, string $message): void
    {
        AdminActionLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'result' => $result,
            'message' => $message,
        ]);
    }
}
