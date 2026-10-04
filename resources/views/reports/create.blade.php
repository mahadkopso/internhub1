@extends('layouts.app')
@section('title', 'Submit Report')

@section('content')
<h3 class="section-title mb-4">Submit Internship Report</h3>
<div class="card p-4">
    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Internship Placement</label>
                <select name="application_id" class="form-select" required>
                    @foreach($activeApplications as $app)
                        <option value="{{ $app->id }}">{{ $app->internship->title }} ({{ $app->internship->employer->company_name ?? '' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Report Type</label>
                <select name="report_type" class="form-select" required>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="midterm">Midterm</option>
                    <option value="final">Final</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Week Number (optional)</label>
                <input type="number" name="week_number" min="1" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. Week 3 Progress Report">
            </div>
            <div class="col-12">
                <label class="form-label">Summary / Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Summarize tasks completed, skills gained, challenges faced..."></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Report File (PDF/DOC, max 10MB)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-4">Submit Report</button>
    </form>
</div>
@endsection
