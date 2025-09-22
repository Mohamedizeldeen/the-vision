@extends('admin.layouts.layout')

@section('title', 'Contact Message Details')
@section('page-title', 'Contact Message Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Contacts</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($contact->name, 20) }}</li>
@endsection

@section('page-actions')
    <div class="btn-group">
        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
            <i class="fas fa-reply me-1"></i>Reply via Email
        </a>
        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger" 
                            data-confirm-delete="Are you sure you want to delete this contact message?">
                        <i class="fas fa-trash me-2"></i>Delete Message
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
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <span class="text-white fw-bold fs-4">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $contact->name }}</h5>
                            <div class="text-muted">
                                <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                                @if($contact->company)
                                    <br><i class="fas fa-building me-1"></i>{{ $contact->company }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <h6 class="mb-3">
                        <i class="fas fa-comment-dots me-2"></i>Message
                    </h6>
                    
                    <div class="bg-light rounded p-4">
                        <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $contact->tell_us_your_story }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Received {{ $contact->created_at->format('l, F j, Y \a\t g:i A') }}
                            ({{ $contact->created_at->diffForHumans() }})
                        </small>
                    </div>
                </div>
            </div>

            <!-- Reply Template -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="m-0">
                        <i class="fas fa-reply me-2"></i>Quick Reply Template
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Email Subject:</label>
                        <input type="text" class="form-control" id="replySubject" 
                               value="Re: Your message to {{ config('app.name', 'Laravel') }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Reply Template:</label>
                        <textarea class="form-control" rows="8" id="replyTemplate" readonly>Hi {{ $contact->name }},

Thank you for contacting us! We have received your message and appreciate you taking the time to reach out.

Your original message:
"{{ Str::limit($contact->tell_us_your_story, 200) }}"

We will review your message and get back to you as soon as possible. If you have any urgent inquiries, please don't hesitate to contact us directly.

Best regards,
The Vision Team</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" onclick="copyReply()">
                            <i class="fas fa-copy me-1"></i>Copy Template
                        </button>
                        <a href="mailto:{{ $contact->email }}?subject={{ urlencode('Re: Your message to ' . config('app.name', 'Laravel')) }}&body={{ urlencode(str_replace(["\n", "\r"], ['%0D%0A', ''], 'Hi ' . $contact->name . ',

Thank you for contacting us! We have received your message and appreciate you taking the time to reach out.

Your original message:
"' . Str::limit($contact->tell_us_your_story, 200) . '"

We will review your message and get back to you as soon as possible. If you have any urgent inquiries, please don\'t hesitate to contact us directly.

Best regards,
The ' . config('app.name', 'Laravel') . ' Team')) }}" class="btn btn-success">
                            <i class="fas fa-external-link-alt me-1"></i>Open in Email Client
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Contact Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="30%">Name:</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </td>
                        </tr>
                        @if($contact->company)
                        <tr>
                            <th>Company:</th>
                            <td>
                                <span class="badge bg-info">{{ $contact->company }}</span>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>Received:</th>
                            <td>{{ $contact->created_at->format('M d, Y \a\t g:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Time Ago:</th>
                            <td>{{ $contact->created_at->diffForHumans() }}</td>
                        </tr>
                        <tr>
                            <th>Message Length:</th>
                            <td>{{ str_word_count($contact->tell_us_your_story) }} words</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                            <i class="fas fa-reply me-1"></i>Reply via Email
                        </a>
                        
                        <button class="btn btn-info" onclick="copyContactInfo()">
                            <i class="fas fa-copy me-1"></i>Copy Contact Info
                        </button>
                        
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Contacts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Contacts from same email -->
            @php
                $recentContacts = \App\Models\Contact::where('email', $contact->email)
                    ->where('id', '!=', $contact->id)
                    ->latest()
                    ->limit(3)
                    ->get();
            @endphp
            
            @if($recentContacts->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0">Previous Messages from {{ $contact->email }}</h6>
                </div>
                <div class="card-body">
                    @foreach($recentContacts as $recent)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="small text-muted">{{ $recent->created_at->format('M d, Y') }}</div>
                            <p class="mb-0 small">{{ Str::limit($recent->tell_us_your_story, 80) }}</p>
                            <a href="{{ route('admin.contacts.show', $recent) }}" class="small">View message →</a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function copyReply() {
            const subject = document.getElementById('replySubject').value;
            const template = document.getElementById('replyTemplate').value;
            const fullReply = `Subject: ${subject}\n\n${template}`;
            
            navigator.clipboard.writeText(fullReply).then(function() {
                // Show success message
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                }, 2000);
            }).catch(function() {
                alert('Could not copy to clipboard. Please copy manually.');
            });
        }

        function copyContactInfo() {
            const contactInfo = `Name: {{ $contact->name }}
Email: {{ $contact->email }}
@if($contact->company)Company: {{ $contact->company }}
@endif
Received: {{ $contact->created_at->format('M d, Y \a\t g:i A') }}

Message:
{{ $contact->tell_us_your_story }}`;

            navigator.clipboard.writeText(contactInfo).then(function() {
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                btn.classList.remove('btn-info');
                btn.classList.add('btn-success');
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-info');
                }, 2000);
            }).catch(function() {
                alert('Could not copy to clipboard. Please copy manually.');
            });
        }
    </script>
@endsection