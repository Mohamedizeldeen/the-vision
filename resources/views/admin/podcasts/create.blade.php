@extends('admin.layouts.layout')

@section('title', 'Create Podcast')
@section('page-title', 'Create Podcast')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.podcasts.index') }}">Podcasts</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('admin.podcasts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Podcast Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
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
                            <small class="form-text text-muted">Additional content or show notes.</small>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="m-0">Audio Upload</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="audio_file" class="form-label">Audio File</label>
                            <input type="file" class="form-control @error('audio_file') is-invalid @enderror" 
                                   id="audio_file" name="audio_file" accept="audio/*">
                            <small class="form-text text-muted">Upload MP3, WAV, or other audio formats. Max size: 50MB.</small>
                            @error('audio_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration') }}" 
                                           placeholder="e.g., 45:30 or 01:23:45">
                                    <small class="form-text text-muted">Format: MM:SS or HH:MM:SS</small>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file_size" class="form-label">File Size</label>
                                    <input type="text" class="form-control @error('file_size') is-invalid @enderror" 
                                           id="file_size" name="file_size" value="{{ old('file_size') }}" 
                                           placeholder="e.g., 25.5 MB">
                                    @error('file_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" 
                                       id="schedule" value="schedule" {{ old('publish_status') == 'schedule' ? 'checked' : '' }}>
                                <label class="form-check-label" for="schedule">
                                    <i class="fas fa-clock text-info me-1"></i>Schedule for Later
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
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" value="{{ old('tags') }}" 
                                   placeholder="Comma separated tags">
                            <small class="form-text text-muted">Separate tags with commas</small>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3" 
                                      placeholder="SEO description...">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Podcast
                            </button>
                            <a href="{{ route('admin.podcasts.index') }}" class="btn btn-outline-secondary">
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

            // Audio file upload handling
            const audioInput = document.getElementById('audio_file');
            const durationInput = document.getElementById('duration');
            const fileSizeInput = document.getElementById('file_size');

            audioInput.addEventListener('change', function() {
                if (this.files[0]) {
                    const file = this.files[0];
                    
                    // Auto-fill file size
                    const sizeInMB = (file.size / (1024 * 1024)).toFixed(1);
                    fileSizeInput.value = sizeInMB + ' MB';

                    // Create audio element to get duration
                    const audio = document.createElement('audio');
                    audio.src = URL.createObjectURL(file);
                    
                    audio.addEventListener('loadedmetadata', function() {
                        const duration = audio.duration;
                        const hours = Math.floor(duration / 3600);
                        const minutes = Math.floor((duration % 3600) / 60);
                        const seconds = Math.floor(duration % 60);
                        
                        let durationStr = '';
                        if (hours > 0) {
                            durationStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        } else {
                            durationStr = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        }
                        
                        durationInput.value = durationStr;
                        
                        // Clean up
                        URL.revokeObjectURL(audio.src);
                    });
                }
            });
        });
    </script>
@endsection