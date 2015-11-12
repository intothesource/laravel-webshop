{!! Form::open(array('route' => 'cms.product.store', 'method' => 'post')) !!}

	<div class="form-group">
		{!! Form::label('product[name]', 'Productname') !!}
		{!! Form::text('product[name]' , '', array('class' => 'form-control')) !!}
	</div>
	<div class="form-group">
		{!! Form::label('product[sku]', 'SKU') !!}
		{!! Form::text('product[sku]' , '', array('class' => 'form-control')) !!}
	</div>

	<div>
		<button class="btn">Create Product</button>
	</div>

{!! Form::close() !!}