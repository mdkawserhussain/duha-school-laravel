@extends('admin.layouts.app')

@section('title', 'Admission Application')
@section('page-title', 'View Admission Application')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Admission Application</h2>
            <p class="mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ match($application->status) { 'pending' => 'bg-yellow-100 text-yellow-800', 'accepted' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-gray-100 text-gray-800' } }}">
                    {{ ucfirst($application->status) }}
                </span>
            </p>
        </div>
        <a href="{{ route('admin.admission-applications.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
    </div>

    <form action="{{ route('admin.admission-applications.update', $application) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Student Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Student Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->student_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->student_dob?->format('F j, Y') ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->student_gender ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Current Grade</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->current_grade ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Applying for Grade</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->applying_grade }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Previous School</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->previous_school ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Parent Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Parent/Guardian Information</h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->parent_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->parent_email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->parent_phone }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->parent_address ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Additional Information -->
        @if($application->medical_conditions || $application->additional_notes)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
            @if($application->medical_conditions)
            <div class="mb-4">
                <dt class="text-sm font-medium text-gray-500">Medical Conditions</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $application->medical_conditions }}</dd>
            </div>
            @endif
            @if($application->additional_notes)
            <div>
                <dt class="text-sm font-medium text-gray-500">Additional Notes</dt>
                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $application->additional_notes }}</dd>
            </div>
            @endif
        </div>
        @endif

        <!-- Status Update -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-za-green-primary focus:ring-za-green-primary">
                        <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="px-6 py-2 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg" style="background-color: #008236;" onmouseover="this.style.backgroundColor='#0a4536'" onmouseout="this.style.backgroundColor='#008236'">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

