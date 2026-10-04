@extends('layouts.app')
@section('title', 'Edit Internship')

@section('content')
<h3 class="section-title mb-4">Edit Internship Posting</h3>
<div class="card p-4">
    <form method="POST" action="{{ route('internships.update', $internship) }}">
        @csrf
        @method('PUT')
        @include('internships._form')
        <button type="submit" class="btn btn-accent mt-4">Save Changes</button>
    </form>
</div>
@endsection
