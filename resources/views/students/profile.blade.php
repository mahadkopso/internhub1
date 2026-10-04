@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<h3 class="section-title mb-4">My Profile</h3>
<div class="card p-4">
    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">University</label>
                <input type="text" name="university" value="{{ old('university', $student->university) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Faculty</label>
                <input type="text" name="faculty" value="{{ old('faculty', $student->faculty) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Department</label>
                <input type="text" name="department" value="{{ old('department', $student->department) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Program</label>
                <input type="text" name="program" value="{{ old('program', $student->program) }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Year of Study</label>
                <input type="number" name="year_of_study" min="1" max="8" value="{{ old('year_of_study', $student->year_of_study) }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">GPA</label>
                <input type="number" step="0.01" min="0" max="4" name="gpa" value="{{ old('gpa', $student->gpa) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $student->bio) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Skills (comma separated)</label>
                <input type="text" name="skills" value="{{ old('skills', $student->skills) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $student->linkedin_url) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Upload CV (PDF/DOC)</label>
                <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                @if($student->cv_path)
                    <div class="small mt-1"><a href="{{ asset('storage/'.$student->cv_path) }}" target="_blank">View current CV</a></div>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-4">Save Profile</button>
    </form>
</div>
@endsection
