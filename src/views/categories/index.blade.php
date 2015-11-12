<table class="table">
  <thead>
    <tr>
      <th style="width: 40px">ID</th>
      <th>Category</th>
      <th>Active?</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($categories as $category)
    <tr>
      <td>{{ $category->category_id }}</td>
      <td><a href="{{ route('cms.category.edit', $category->category_id) }}">{{ $category->name }}</a></td>
      <td><span class="label bg-{{ $category->active ? 'green' : 'orange' }}">{{ $category->active ? 'Active' : 'Inactive' }}</span></td>
    </tr>
  @endforeach
  </tbody>
</table>