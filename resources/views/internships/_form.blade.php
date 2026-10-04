<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input type="text" name="title" value="{{ old('title', $internship->title ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Work Mode</label>
        <select name="work_mode" class="form-select" required>
            @foreach(['onsite'=>'Onsite','remote'=>'Remote','hybrid'=>'Hybrid'] as $val => $label)
                <option value="{{ $val }}" @selected(old('work_mode', $internship->work_mode ?? '') == $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $internship->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Requirements</label>
        <textarea name="requirements" class="form-control" rows="3">{{ old('requirements', $internship->requirements ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Location</label>
        <input type="text" name="location" value="{{ old('location', $internship->location ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" value="{{ old('duration', $internship->duration ?? '') }}" class="form-control" placeholder="e.g. 3 months">
    </div>
    <div class="col-md-4">
        <label class="form-label">Slots Available</label>
        <input type="number" name="slots_available" min="1" value="{{ old('slots_available', $internship->slots_available ?? 1) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($internship->start_date) ? $internship->start_date->format('Y-m-d') : '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="application_deadline" value="{{ old('application_deadline', isset($internship->application_deadline) ? $internship->application_deadline->format('Y-m-d') : '') }}" class="form-control">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" name="is_paid" value="1" class="form-check-input" id="isPaid" @checked(old('is_paid', $internship->is_paid ?? false))>
            <label class="form-check-label" for="isPaid">This is a paid internship</label>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Stipend (if paid)</label>
        <input type="number" step="0.01" name="stipend" value="{{ old('stipend', $internship->stipend ?? '') }}" class="form-control">
    </div>
    @isset($internship)
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="open" @selected($internship->status=='open')>Open</option>
            <option value="closed" @selected($internship->status=='closed')>Closed</option>
        </select>
    </div>
    @endisset
</div>
