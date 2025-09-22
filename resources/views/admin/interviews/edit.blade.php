@extends('admin.layouts.layout')

@section('title', 'Edit Interview')
@section('page-title', 'Edit Interview')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.interviews.index') }}">Interviews</a></li>
    <li class="breadcrumb-item active">Edit: {{ Str::limit($interview->title, 30) }}</li>
@endsection

@section('content')
    <form action="{{ route('admin.interviews.update', $interview) }}" method="POST" enctype="multipart/form-data" data-loading>
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Interview Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $interview->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="candidate_name" class="form-label">Candidate Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('candidate_name') is-invalid @enderror" 
                                           id="candidate_name" name="candidate_name" value="{{ old('candidate_name', $interview->candidate_name) }}" required>
                                    @error('candidate_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position', $interview->position) }}" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" required>{{ old('description', $interview->description) }}</textarea>
                            <div class="form-text">Provide a detailed description of the interview content.</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" data-preview="image_preview">
                            <div class="form-text">Upload a new image to replace the current one. Max size: 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Current Image -->
                            @if($interview->image)
                                <div class="mt-3">
                                    <label class="form-label">Current Image:</label>
                                    <div>
                                        <img src="{{ asset('img/' . $interview->image) }}" 
                                             alt="{{ $interview->title }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Image Preview -->
                            <img id="image_preview" class="image-preview mt-3" alt="Preview">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Publishing</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $interview->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="date" class="form-control @error('published_at') is-invalid @enderror" 
                                   id="published_at" name="published_at" 
                                   value="{{ old('published_at', $interview->published_at ? $interview->published_at->format('Y-m-d') : '') }}">
                            <div class="form-text">Leave empty to save as draft</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $interview->published_at ? 'success' : 'warning' }}">
                                    {{ $interview->published_at ? 'Published' : 'Draft' }}
                                </span><br>
                                <strong>Created:</strong> {{ $interview->created_at->format('M d, Y g:i A') }}<br>
                                <strong>Updated:</strong> {{ $interview->updated_at->format('M d, Y g:i A') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.interviews.show', $interview) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye me-1"></i>View Interview
                            </a>
                            <a href="{{ route('admin.interviews.create') }}?category={{ $interview->category_id }}" 
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus me-1"></i>Create Similar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SEO Preview -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="seo-preview">
                            <div class="seo-title fw-bold text-primary" id="seo-title">{{ $interview->title }}</div>
                            <div class="seo-description text-muted small" id="seo-description">
                                {{ Str::limit($interview->description, 160) }}
                            </div>
                            <div class="seo-candidate small mt-2">
                                <strong>Candidate:</strong> <span id="seo-candidate">{{ $interview->candidate_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.interviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        
                        <button type="submit" name="action" value="publish" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i>{{ $interview->published_at ? 'Update' : 'Publish' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form class="mt-8" action="{{ route('admin.interviews.destroy', $interview) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger mt-2" 
                                data-confirm-delete="Are you sure you want to delete this interview?">
                            <i class="fas fa-trash me-1"></i>Delete Interview
                        </button>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const candidateInput = document.getElementById('candidate_name');
    
    const seoTitle = document.getElementById('seo-title');
    const seoDescription = document.getElementById('seo-description');
    const seoCandidate = document.getElementById('seo-candidate');
    
    function updatePreview() {
        seoTitle.textContent = titleInput.value || 'Interview Title';
        seoDescription.textContent = descriptionInput.value.substring(0, 160) || 'Interview description will appear here...';
        seoCandidate.textContent = candidateInput.value || 'Candidate Name';
    }
    
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    candidateInput.addEventListener('input', updatePreview);
    
    // Handle publish action
    const publishBtn = document.querySelector('button[value="publish"]');
    publishBtn.addEventListener('click', function() {
        const publishDateInput = document.getElementById('published_at');
        if (!publishDateInput.value) {
            publishDateInput.value = new Date().toISOString().split('T')[0];
        }
    });
});
</script>
@endpush