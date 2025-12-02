<div class="flex items-center space-x-2">
  <a href="{{ route('projects.show', $p->id) }}" class="text-sm text-blue-600">View</a>
  @can('edit projects')
    <a href="{{ route('projects.edit', $p->id) }}" class="text-sm text-yellow-600">Edit</a>
  @endcan
  @can('delete projects')
    <form method="POST" action="{{ route('projects.destroy', $p->id) }}" onsubmit="return confirm('Delete?')">
      @csrf @method('DELETE')
      <button class="text-sm text-red-600">Delete</button>
    </form>
  @endcan
</div>
