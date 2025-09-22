@extends('admin.layouts.layout')

@section('title', 'Create Interview')
@section('page-title', 'Create Interview')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.interviews.index') }}">Interviews</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('admin.interviews.store') }}" method="POST" enctype="multipart/form-data" data-loading>
        @csrf
        
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
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="candidate_name" class="form-label">Candidate Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('candidate_name') is-invalid @enderror" 
                                           id="candidate_name" name="candidate_name" value="{{ old('candidate_name') }}" required>
                                    @error('candidate_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position') }}" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                            <div class="form-text">Provide a detailed description of the interview content.</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" data-preview="image_preview">
                            <div class="form-text">Upload a featured image for the interview. Max size: 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
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
                                            {{ old('category_id', request('category')) == $category->id ? 'selected' : '' }}>
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
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            <div class="form-text">Leave empty to save as draft</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <div class="seo-title fw-bold text-primary" id="seo-title">Interview Title</div>
                            <div class="seo-description text-muted small" id="seo-description">
                                Interview description will appear here...
                            </div>
                            <div class="seo-candidate small mt-2">
                                <strong>Candidate:</strong> <span id="seo-candidate">Candidate Name</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.interviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="action" value="draft" class="btn btn-outline-primary">
                        <i class="fas fa-save me-1"></i>Save as Draft
                    </button>
                    <button type="submit" name="action" value="publish" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>Publish Interview
                    </button>
                </div>
            </div>
        </div>
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