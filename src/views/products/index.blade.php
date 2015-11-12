<div>
  <a class="btn" href="{{ route('cms.product.create') }}">Add Product</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th style="width: 40px">ID</th>
      <th>SKU#</th>
      <th>Name</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($products as $product)
    <tr>
      <td>{{ $product->product_id }}</td>
      <td><a href="{{ route('cms.product.edit', $product->product_id) }}">{{ $product->sku }}</a></td>
      <td><a href="{{ route('cms.product.edit', $product->product_id) }}">{{ $product->name }}</a></td>
      <td>{{ str_limit($product->description,90) }}</td>
    </tr>
  @endforeach
  </tbody>
</table>