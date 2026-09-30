<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\GuruDashboardController;
use App\Http\Controllers\Guru\StudentController;
use App\Http\Controllers\Guru\QuestionnaireController;
use App\Http\Controllers\Guru\GuruCounselingController;
use App\Http\Controllers\Guru\GuruCalendarController;
use App\Http\Controllers\Siswa\StudentDashboardController;
use App\Http\Controllers\Siswa\StudentProfileController;
use App\Http\Controllers\Siswa\StudentQuestionnaireController;
use App\Http\Controllers\Siswa\StudentCounselingController;
use App\Http\Controllers\Siswa\StudentCalendarController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Guru\CounselingNoteController;

Route::get('/hosting-setup', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        return '<div style="font-family:sans-serif;padding:40px;text-align:center;"><h2>✅ Setup Hosting Berhasil!</h2><p>Storage symlink telah dibuat dan seluruh cache telah dibersihkan.</p><br><a href="/login" style="display:inline-block;padding:10px 24px;background:#4F46E5;color:white;text-decoration:none;border-radius:8px;font-weight:bold;">Masuk ke Aplikasi SIM-BK</a></div>';
    } catch (\Exception $e) {
        return 'Setup error: ' . $e->getMessage();
    }
});

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'guru' 
            ? redirect()->route('guru.dashboard') 
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/preview/register', fn() => view('auth.register'));
Route::get('/preview/login', fn() => view('auth.login'));

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/password/update', [\App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');
    
    // NOTIFIKASI SISTEM (GURU & SISWA)
    Route::get('/api/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.index');
    Route::post('/api/notifications/test', [NotificationController::class, 'sendTestNotification'])->name('notifications.test');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');

    // PORTAL SISWA
    Route::middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('siswa')->name('siswa.')->group(function () {
            // Profil Siswa
            Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile.index');
            Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');

            // Kuisioner & Angket
            Route::get('/questionnaires', [StudentQuestionnaireController::class, 'index'])->name('questionnaires.index');
            Route::get('/questionnaires/{id}', [StudentQuestionnaireController::class, 'show'])->name('questionnaires.show');
            Route::post('/questionnaires/{id}', [StudentQuestionnaireController::class, 'store'])->name('questionnaires.store');
            Route::get('/questionnaires/{id}/result', [StudentQuestionnaireController::class, 'result'])->name('questionnaires.result');

            // Layanan & Pengajuan Konseling Siswa
            Route::get('/counseling', [StudentCounselingController::class, 'index'])->name('counseling.index');
            Route::post('/counseling', [StudentCounselingController::class, 'store'])->name('counseling.store');
            Route::delete('/counseling/{id}', [StudentCounselingController::class, 'destroy'])->name('counseling.destroy');

            // Kalender & Agenda Siswa
            Route::get('/calendar', [StudentCalendarController::class, 'index'])->name('calendar.index');
        });
    });

    // PORTAL GURU BK
    Route::middleware('role:guru')->prefix('guru')->group(function () {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
        
        // Data Siswa
        Route::get('/students', [StudentController::class, 'index'])->name('guru.students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('guru.students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('guru.students.store');
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('guru.students.show');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('guru.students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('guru.students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('guru.students.destroy');

        // Catatan Bimbingan & Print PDF Rekam Kasus Siswa
        Route::post('/students/{id}/notes', [CounselingNoteController::class, 'store'])->name('guru.students.notes.store');
        Route::put('/students/{id}/notes/{noteId}', [CounselingNoteController::class, 'update'])->name('guru.students.notes.update');
        Route::delete('/students/{id}/notes/{noteId}', [CounselingNoteController::class, 'destroy'])->name('guru.students.notes.destroy');
        Route::get('/students/{id}/print-notes', [CounselingNoteController::class, 'printNotes'])->name('guru.students.notes.print');
        Route::post('/report-settings', [CounselingNoteController::class, 'updateReportSettings'])->name('guru.report_settings.update');

        // Kuisioner & Angket BK
        Route::get('/questionnaires', [QuestionnaireController::class, 'index'])->name('guru.questionnaires.index'); 
        Route::get('/questionnaires/create', [QuestionnaireController::class, 'create'])->name('guru.questionnaires.create');
        Route::post('/questionnaires', [QuestionnaireController::class, 'store'])->name('guru.questionnaires.store');
        Route::get('/questionnaires/{id}', [QuestionnaireController::class, 'show'])->name('guru.questionnaires.show_direct');
        Route::get('/questionnaires/{id}/show', [QuestionnaireController::class, 'show'])->name('guru.questionnaires.show');
        Route::get('/questionnaires/{id}/export-excel', [QuestionnaireController::class, 'exportExcel'])->name('guru.questionnaires.export_excel');
        Route::get('/questionnaires/{id}/print-student/{studentId}', [QuestionnaireController::class, 'printStudent'])->name('guru.questionnaires.print_student');
        Route::get('/questionnaires/{id}/print-all', [QuestionnaireController::class, 'printAll'])->name('guru.questionnaires.print_all');
        Route::get('/questionnaires/{id}/edit', [QuestionnaireController::class, 'edit'])->name('guru.questionnaires.edit');
        Route::put('/questionnaires/{id}', [QuestionnaireController::class, 'update'])->name('guru.questionnaires.update');
        Route::delete('/questionnaires/{id}', [QuestionnaireController::class, 'destroy'])->name('guru.questionnaires.destroy');
        Route::get('/questionnaires/preview/{id?}', [QuestionnaireController::class, 'preview'])->name('guru.questionnaires.preview');
        Route::patch('/questionnaires/{id}/status', [QuestionnaireController::class, 'updateStatus'])->name('guru.questionnaires.update_status');

        // Manajemen Layanan & Jadwal Konseling
        Route::get('/counseling', [GuruCounselingController::class, 'index'])->name('guru.counseling.index');
        Route::post('/counseling', [GuruCounselingController::class, 'store'])->name('guru.counseling.store');
        Route::put('/counseling/{id}/status', [GuruCounselingController::class, 'updateStatus'])->name('guru.counseling.update_status');
        Route::delete('/counseling/{id}', [GuruCounselingController::class, 'destroy'])->name('guru.counseling.destroy');
        
        // Kalender & Agenda BK
        Route::get('/calendar', [GuruCalendarController::class, 'index'])->name('guru.calendar.index');
        Route::post('/calendar', [GuruCalendarController::class, 'store'])->name('guru.calendar.store');
        Route::put('/calendar/{id}', [GuruCalendarController::class, 'update'])->name('guru.calendar.update');
        Route::delete('/calendar/{id}', [GuruCalendarController::class, 'destroy'])->name('guru.calendar.destroy');
    });
});