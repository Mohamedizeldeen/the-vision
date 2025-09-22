@extends('admin.layouts.layout')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit: {{ $category->name }}</li>
@endsection

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" data-loading>
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Category Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" 
                                   data-slug-target="slug" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                            <div class="form-text">URL-friendly version of the name.</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category Statistics -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Content Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border-end pe-3">
                                    <h4 class="text-success mb-1">{{ $category->interviews()->count() }}</h4>
                                    <small class="text-muted">Interviews</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-end pe-3">
                                    <h4 class="text-info mb-1">{{ $category->events()->count() }}</h4>
                                    <small class="text-muted">Events</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-warning mb-1">{{ $category->podcasts()->count() }}</h4>
                                <small class="text-muted">Podcasts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color', $category->color) }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon', $category->icon) }}" 
                                   placeholder="e.g., fas fa-star">
                            <div class="form-text">Font Awesome icon class</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Preview</h6>
                    </div>
                    <div class="card-body">
                        <div id="category-preview" class="badge" style="background-color: {{ $category->color }}; color: white;">
                            @if($category->icon)
                                <i class="{{ $category->icon }} me-1"></i>
                            @endif
                            {{ $category->name }}
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
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye me-1"></i>View Category
                            </a>
                            <a href="{{ route('admin.interviews.index') }}?category={{ $category->id }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-microphone me-1"></i>View Interviews
                            </a>
                            <a href="{{ route('admin.events.index') }}?category={{ $category->id }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar me-1"></i>View Events
                            </a>
                            <a href="{{ route('admin.podcasts.index') }}?category={{ $category->id }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-podcast me-1"></i>View Podcasts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <div>
                        <!-- Destroy form moved outside the update form -->
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this category and all its content?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger mt-3">
            <i class="fas fa-trash me-1"></i>Delete Category
        </button>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const colorInput = document.getElementById('color');
    const iconInput = document.getElementById('icon');
    const preview = document.getElementById('category-preview');
    
    function updatePreview() {
        const name = nameInput.value || 'Sample Category';
        const color = colorInput.value || '#007bff';
        const icon = iconInput.value;
        
        preview.style.backgroundColor = color;
        let html = '';
        if (icon) {
            html += `<i class="${icon} me-1"></i>`;
        }
        html += name;
        preview.innerHTML = html;
    }
    
    nameInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('change', updatePreview);
    iconInput.addEventListener('input', updatePreview);
});
</script>
@endpush