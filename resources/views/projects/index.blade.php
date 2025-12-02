@extends('layouts.app')

@section('content')
<div class="container mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Projects</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">Current Projects</p>
      <p class="text-3xl font-bold">{{ $totalProjects }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">Completed</p>
      <p class="text-3xl font-bold">{{ $completed }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">In Progress</p>
      <p class="text-3xl font-bold">{{ $inProgress }}</p>
    </div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <table id="projects-table" class="min-w-full">
      <thead>
        <tr>
          <th>Registration ID</th>
          <th>Title</th>
          <th>MDA</th>
          <th>Sector</th>
          <th>Status</th>
          <th>Cost</th>
          <th>Date of Entry</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- FAB -->
<button id="openProjectModal" class="fixed right-6 bottom-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg">
  <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" /></svg>
</button>

<!-- Modal -->
<div id="projectModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-lg w-11/12 md:w-2/3 p-6">
    <h2 class="text-xl font-semibold mb-4">Add Project</h2>
    <form id="projectForm" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input name="registration_id" class="border p-2 rounded" placeholder="Registration ID (optional)">
        <input name="title" class="border p-2 rounded" placeholder="Project Title" required>
        <input name="mda" class="border p-2 rounded" placeholder="MDA">
        <input name="sector" class="border p-2 rounded" placeholder="Sector">
        <input name="cost" type="number" step="0.01" class="border p-2 rounded" placeholder="Cost">
        <input name="expected_start" type="date" class="border p-2 rounded">
        <input name="expected_end" type="date" class="border p-2 rounded">
        <textarea name="description" class="border p-2 rounded col-span-2" placeholder="Description"></textarea>

        <div class="col-span-2">
          <label class="block text-sm">Attachments (max 500MB each)</label>
          <input type="file" name="attachments[]" multiple class="mt-2">
        </div>
      </div>

      <div class="mt-4 flex justify-end">
        <button type="button" id="closeModal" class="px-4 py-2 mr-2 border rounded">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
  $('#projects-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('api.projects.datatables') !!}',
    columns: [
      { data: 'registration_id', name: 'registration_id' },
      { data: 'title', name: 'title' },
      { data: 'mda', name: 'mda' },
      { data: 'sector', name: 'sector' },
      { data: 'status', name: 'status' },
      { data: 'cost', name: 'cost' },
      { data: 'date_of_entry', name: 'date_of_entry' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    pageLength: 10,
  });

  $('#openProjectModal').on('click', function(){ $('#projectModal').removeClass('hidden'); });
  $('#closeModal').on('click', function(){ $('#projectModal').addClass('hidden'); });
});
</script>
@endpush
