@extends('admin.layouts.layout')

@section('title', $podcast->title)
@section('page-title', $podcast->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.podcasts.index') }}">Podcasts</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($podcast->title, 30) }}</li>
@endsection

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.podcasts.edit', $podcast) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        @if($podcast->audio_file)
            <a href="{{ route('admin.podcasts.stream', $podcast) }}" target="_blank" class="btn btn-success">
                <i class="fas fa-play me-1"></i>Listen
            </a>
        @endif
        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <form action="{{ route('admin.podcasts.destroy', $podcast) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger" 
                            data-confirm-delete="Are you sure you want to delete this podcast?">
                        <i class="fas fa-trash me-2"></i>Delete Podcast
                    </button>
                </form>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning rounded me-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-podcast text-white fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-2">{{ $podcast->title }}</h2>
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <span class="badge" style="background-color: {{ $podcast->category->color }}; color: white;">
                                    {{ $podcast->category->name }}
                                </span>
                                <span class="badge bg-{{ $podcast->published_at ? 'success' : 'warning' }}">
                                    {{ $podcast->published_at ? 'Published' : 'Draft' }}
                                </span>
                                @if($podcast->audio_file)
                                    <span class="badge bg-info">
                                        <i class="fas fa-file-audio me-1"></i>Audio Available
                                    </span>
                                @endif
                                @if($podcast->duration)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-clock me-1"></i>{{ $podcast->duration }}
                                    </span>
                                @endif
                                @if($podcast->file_size)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-hdd me-1"></i>{{ $podcast->file_size }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted mb-0">{{ $podcast->description }}</p>
                        </div>
                    </div>

                    @if($podcast->audio_file)
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-headphones me-2"></i>Audio Player
                                </h6>
                                <audio controls class="w-100" preload="metadata">
                                    <source src="{{ asset('storage/' . $podcast->audio_file) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ basename($podcast->audio_file) }}</small>
                                    <div>
                                        <a href="{{ route('admin.podcasts.stream', $podcast) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Open in New Tab
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No audio file has been uploaded for this podcast yet.
                            <a href="{{ route('admin.podcasts.edit', $podcast) }}" class="alert-link">Upload audio file</a>
                        </div>
                    @endif

                    @if($podcast->content)
                        <div class="mb-4">
                            <h5>Show Notes</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($podcast->content)) !!}
                            </div>
                        </div>
                    @endif

                    @if($podcast->tags)
                        <div class="mb-4">
                            <h6>Tags</h6>
                            @foreach(explode(',', $podcast->tags) as $tag)
                                <span class="badge bg-secondary me-1"># {{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($podcast->meta_description)
                        <div class="mb-4">
                            <h6>Meta Description</h6>
                            <p class="text-muted">{{ $podcast->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Podcasts -->
            @if($relatedPodcasts && $relatedPodcasts->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="m-0">Related Podcasts</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedPodcasts as $related)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-podcast text-white"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('admin.podcasts.show', $related) }}" class="text-decoration-none">
                                                    {{ Str::limit($related->title, 40) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $related->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Podcast Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Category:</th>
                            <td>
                                <span class="badge" style="background-color: {{ $podcast->category->color }}; color: white;">
                                    {{ $podcast->category->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $podcast->published_at ? 'success' : 'warning' }}">
                                    {{ $podcast->published_at ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                        </tr>
                        @if($podcast->published_at)
                            <tr>
                                <th>Published:</th>
                                <td>{{ $podcast->published_at->format('M d, Y \a\t g:i A') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Created:</th>
                            <td>{{ $podcast->created_at->format('M d, Y \a\t g:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $podcast->updated_at->format('M d, Y \a\t g:i A') }}</td>
                        </tr>
                        @if($podcast->duration)
                            <tr>
                                <th>Duration:</th>
                                <td>{{ $podcast->duration }}</td>
                            </tr>
                        @endif
                        @if($podcast->file_size)
                            <tr>
                                <th>File Size:</th>
                                <td>{{ $podcast->file_size }}</td>
                            </tr>
                        @endif
                        @if($podcast->audio_file)
                            <tr>
                                <th>Audio File:</th>
                                <td>
                                    <small class="text-muted">{{ basename($podcast->audio_file) }}</small>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.podcasts.edit', $podcast) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit Podcast
                        </a>
                        
                        @if($podcast->audio_file)
                            <a href="{{ route('admin.podcasts.stream', $podcast) }}" target="_blank" class="btn btn-success">
                                <i class="fas fa-play me-1"></i>Listen to Audio
                            </a>
                        @endif

                        @if($podcast->published_at)
                            <form action="{{ route('admin.podcasts.unpublish', $podcast) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-eye-slash me-1"></i>Unpublish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.podcasts.publish', $podcast) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-globe me-1"></i>Publish Now
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.podcasts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Podcasts
                        </a>
                    </div>
                </div>
            </div>

            @if($podcast->published_at)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Share Links</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Direct Link:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ route('podcasts.show', $podcast) }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Audio Stream:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ route('admin.podcasts.stream', $podcast) }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(button) {
            const input = button.parentElement.querySelector('input');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            const icon = button.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fas fa-check text-success';
            
            setTimeout(() => {
                icon.className = originalClass;
            }, 2000);
        }
    </script>
@endsection