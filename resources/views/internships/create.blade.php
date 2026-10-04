@extends('layouts.app')
@section('title', 'Post Internship')

@section('content')
<h3 class="section-title mb-4">Post a New Internship</h3>
<div class="card p-4">
    <div class="alert alert-info">New postings require approval from the university internship coordinator before they go live.</div>
    <form method="POST" action="{{ route('internships.store') }}">
        @csrf
        @include('internships._form')
        <button type="submit" class="btn btn-accent mt-4"><i class="bi bi-send me-1"></i>Submit for Approval</button>
    </form>
</div>
@endsection
