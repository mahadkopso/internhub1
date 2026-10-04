@extends('layouts.app')
@section('title', 'Company Profile')

@section('content')
<h3 class="section-title mb-4">Company Profile</h3>
<div class="card p-4">
    <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name', $employer->company_name) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Industry</label>
                <input type="text" name="industry" value="{{ old('industry', $employer->industry) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Company Description</label>
                <textarea name="company_description" class="form-control" rows="4">{{ old('company_description', $employer->company_description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Website</label>
                <input type="url" name="website" value="{{ old('website', $employer->website) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Person</label>
                <input type="text" name="contact_person" value="{{ old('contact_person', $employer->contact_person) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Company Address</label>
                <input type="text" name="company_address" value="{{ old('company_address', $employer->company_address) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Company Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                @if($employer->logo_path)
                    <div class="small mt-1"><a href="{{ asset('storage/'.$employer->logo_path) }}" target="_blank">View current logo</a></div>
                @endif
            </div>
            <div class="col-md-6 d-flex align-items-center">
                @if($employer->is_verified)
                    <span class="badge badge-status-approved">Verified Employer</span>
                @else
                    <span class="badge badge-status-pending">Pending Verification</span>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-accent mt-4">Save Company Profile</button>
    </form>
</div>
@endsection
