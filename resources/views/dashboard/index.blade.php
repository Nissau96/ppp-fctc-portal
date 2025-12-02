@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="col-span-2">
    <!-- Greeting card -->
    <div class="bg-gradient-to-r from-indigo-600 to-violet-500 text-white p-6 rounded-lg mb-6 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
        <p class="mt-2">Overview of Government Projects</p>
      </div>
      <div><img src="{{ asset('images/hero-avatar.svg') }}" alt="avatar" class="w-28"></div>
    </div>

    <!-- Analytics cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Projects</p>
        <p class="text-2xl font-bold">{{ $total }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Completed</p>
        <p class="text-2xl font-bold">{{ $completed }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">In Progress</p>
        <p class="text-2xl font-bold">{{ $inProgress }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Active</p>
        <p class="text-2xl font-bold">{{ $active }}</p>
      </div>
    </div>

    <!-- Latest 10 projects -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-4">Latest 10 Projects</h3>
      <table class="w-full">
        <thead>
          <tr class="text-left text-gray-600">
            <th class="py-2">Reg. ID</th>
            <th>Title</th>
            <th>MDA</th>
            <th>Status</th>
            <th>Cost</th>
          </tr>
        </thead>
        <tbody>
          @foreach($latest as $p)
          <tr class="border-t">
            <td class="py-2">{{ $p->registration_id }}</td>
            <td>{{ $p->title }}</td>
            <td>{{ $p->mda }}</td>
            <td>{{ $p->status }}</td>
            <td>{{ $p->cost }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div>
    <!-- Right column: charts + small widgets -->
    <div class="bg-white p-4 rounded shadow mb-4">
      <div id="statusChart" style="height:250px;"></div>
    </div>

    <div class="bg-white p-4 rounded shadow">
      <!-- additional widgets can go here -->
      <h4 class="font-semibold mb-2">Quick Stats</h4>
      <p>Total attachments: {{ \App\Models\Project::whereNotNull('attachments')->count() }}</p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var statusChart = echarts.init(document.getElementById('statusChart'));
  fetch('{{ url('/api/reports/projects-by-status') }}')
    .then(r=>r.json()).then(data=>{
      statusChart.setOption({
        title:{ text:'By Status', left:'center' },
        tooltip:{ trigger:'item' },
        legend:{ bottom:5 },
        series:[{ type:'pie', radius:['45%','70%'], data:data }]
      });
  });
});
</script>
@endpush
