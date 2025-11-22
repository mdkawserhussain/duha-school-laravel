@extends('admin.layouts.app')

@section('title', 'Career Application')
@section('page-title', 'View Career Application')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Career Application</h2>
            <p class="mt-1 text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ match($application->status) { 'pending' => 'bg-yellow-100 text-yellow-800', 'shortlisted' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-gray-100 text-gray-800' } }}">
                    {{ ucfirst($application->status) }}
                </span>
            </p>
        </div>
        <a href="{{ route('admin.career-applications.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
    </div>

    <form action="{{ route('admin.career-applications.update', $application) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Applicant Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->full_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Position Applied</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->position_applied }}</dd>
                </div>
            </dl>
        </div>

        <!-- Cover Letter -->
        @if($application->cover_letter)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cover Letter</h3>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
        </div>
        @endif

        <!-- Experience & Education -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Experience & Education</h3>
            <dl class="space-y-4">
                @if($application->experience)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Experience</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $application->experience }}</dd>
                </div>
                @endif
                @if($application->education)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Education</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $application->education }}</dd>
                </div>
                @endif
                @if($application->skills)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Skills</dt>
                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $application->skills }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Resume -->
        @if($application->resume_path)
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Resume</h3>
            <a href="{{ $application->resume_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Resume
            </a>
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
                        <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

