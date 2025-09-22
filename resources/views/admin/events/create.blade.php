@extends('admin.layouts.layout')

@section('title', 'Create Event')
@section('page-title', 'Create Event')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Event Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="8">{{ old('content') }}</textarea>
                            <small class="form-text text-muted">Additional details about the event.</small>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="m-0">Event Schedule & Location</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date') }}">
                                    <small class="form-text text-muted">Leave empty for single-day events</small>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" name="end_time" value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="e.g., Conference Hall, Online, TBD">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location_url" class="form-label">Location URL</label>
                            <input type="url" class="form-control @error('location_url') is-invalid @enderror" 
                                   id="location_url" name="location_url" value="{{ old('location_url') }}" 
                                   placeholder="https://maps.google.com/... or Zoom link">
                            <small class="form-text text-muted">Link to maps, venue website, or online meeting</small>
                            @error('location_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="event_type" class="form-label">Event Type</label>
                            <select class="form-select @error('event_type') is-invalid @enderror" 
                                    id="event_type" name="event_type">
                                <option value="in-person" {{ old('event_type', 'in-person') == 'in-person' ? 'selected' : '' }}>In-Person</option>
                                <option value="online" {{ old('event_type') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="hybrid" {{ old('event_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('event_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="m-0">Event Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">Upload JPG, PNG, or GIF. Max size: 2MB. Recommended: 1200x630px</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="image_preview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview:</label>
                            <div class="border rounded p-2">
                                <img id="preview_img" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Publishing Options</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Publication Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" 
                                       id="draft" value="draft" {{ old('publish_status', 'draft') == 'draft' ? 'checked' : '' }}>
                                <label class="form-check-label" for="draft">
                                    <i class="fas fa-edit text-warning me-1"></i>Save as Draft
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" 
                                       id="publish_now" value="publish_now" {{ old('publish_status') == 'publish_now' ? 'checked' : '' }}>
                                <label class="form-check-label" for="publish_now">
                                    <i class="fas fa-globe text-success me-1"></i>Publish Now
                                </label>
                            </div>
                            
                        </div>

                        <div class="mb-3" id="schedule_datetime" style="display: none;">
                            <label for="published_at" class="form-label">Publish Date & Time</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" 
                                       id="in_person" value="in_person" {{ old('event_type', 'in_person') == 'in_person' ? 'checked' : '' }}>
                                <label class="form-check-label" for="in_person">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>In-Person
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" 
                                       id="online" value="online" {{ old('event_type') == 'online' ? 'checked' : '' }}>
                                <label class="form-check-label" for="online">
                                    <i class="fas fa-laptop text-success me-1"></i>Online
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" 
                                       id="hybrid" value="hybrid" {{ old('event_type') == 'hybrid' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hybrid">
                                    <i class="fas fa-globe text-info me-1"></i>Hybrid
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Publishing status handling
            const publishRadios = document.querySelectorAll('input[name="publish_status"]');
            const scheduleDiv = document.getElementById('schedule_datetime');
            
            publishRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'schedule') {
                        scheduleDiv.style.display = 'block';
                        document.getElementById('published_at').required = true;
                    } else {
                        scheduleDiv.style.display = 'none';
                        document.getElementById('published_at').required = false;
                    }
                });
            });

            // Image preview handling
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image_preview');
            const previewImg = document.getElementById('preview_img');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    
                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreview.style.display = 'none';
                }
            });

            // Auto-set end date when start date changes
            const eventDate = document.getElementById('event_date');
            const endDate = document.getElementById('end_date');

            eventDate.addEventListener('change', function() {
                if (this.value && !endDate.value) {
                    endDate.value = this.value;
                }
            });

            // Validate end date is not before start date
            endDate.addEventListener('change', function() {
                if (this.value && eventDate.value) {
                    if (new Date(this.value) < new Date(eventDate.value)) {
                        alert('End date cannot be before start date');
                        this.value = eventDate.value;
                    }
                }
            });

            // Auto-update location based on event type
            const eventTypeRadios = document.querySelectorAll('input[name="event_type"]');
            const locationInput = document.getElementById('location');

            eventTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'online' && !locationInput.value) {
                        locationInput.placeholder = 'Online Event';
                    } else if (this.value === 'hybrid' && !locationInput.value) {
                        locationInput.placeholder = 'Hybrid Event (In-person + Online)';
                    } else if (this.value === 'in_person') {
                        locationInput.placeholder = 'e.g., Conference Hall, Address';
                    }
                });
            });
        });
    </script>
@endsection