@extends('admin.master')

{{-- PAGETITLES --}}
@section('title', 'Bewerken: ' . ucfirst($product->name))

{{-- PAGE CSS --}}
@section('page-css')
  <link rel="stylesheet" href="{{ asset('cms-assets/plugins/select2/select2.min.css') }}">
@stop

{{-- PAGECONTENT --}}
@section('content')
  {!! Form::open(array('route' => array('cms.product.update', $product->product_id), 'method' => 'post')) !!}
    <input type="hidden" name="_method" value="PUT">
    <div class="row" data-product="{{ $product->product_id }}">
      <div class="col-md-12">
        <div class="box box-solid bg-boeketwinkel-gradient">
          <div class="box-header">
            <button data-remove-product="{{ route('cms.product.destroy', $product->product_id) }}" class="btn btn-flat btn-danger pull-right margin-left"><i class="fa fa-trash"></i></button>
            <button type="submit" name="save" id="save" class="btn btn-flat btn-success pull-right margin-left"><i class="fa fa-save"></i> Opslaan</button>
            <h2 class="box-title source-mainproduct"><i class="ion ion-ios-flower-outline"></i> @{{ productName }} <span class="small">(@{{ productSku.toUpperCase() }})</span></h2>
          </div><!-- /.box-header -->
          <div class="box-body">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom text-black">
              <ul class="nav nav-tabs">
                @foreach ($languages as $key => $language)
                  <li class="@if ($key == 0) active @endif"><a href="#tab_{{ $language->locale }}" data-toggle="tab" aria-expanded="false">{{ $language->name }}</a></li>
                @endforeach
              </ul>
              <div class="tab-content">
                @foreach ($languages as $key => $language)
                  <?php $options = array('class' => 'form-control'); ?>
                  <div class="tab-pane @if ($key == 0) active @endif" id="tab_{{ $language->locale }}">
                    <div class="form-group">
                      {!! Form::label('main[name]['.$language->locale.']', 'Productnaam (Website)') !!}
                      <?php if ($key == 0) $options['v-model'] = 'productName'; $options['v-on:keyup'] = 'updateSKU' ?>
                      {!! Form::text('main[name]['.$language->locale.']', $product->translate($language->locale, true)->name, $options) !!}
                      <?php unset($options['v-on:keyup']) ?>
                    </div>
                    <div class="form-group">
                      {!! Form::label('main[sku]['.$language->locale.']', 'SKU (Interne Naam)') !!}
                      <?php if ($key == 0) $options['v-model'] = 'productSku'; ?>
                      {!! Form::text('main[sku]['.$language->locale.']', $product->translate($language->locale, true)->sku, $options) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('main[description]['.$language->locale.']', 'Omschrijving') !!}
                      {!! Form::textarea('main[description]['.$language->locale.']', $product->translate($language->locale, true)->description, array('class' => 'form-control', 'rows' => '3')) !!}
                    </div>
                  </div><!-- /.tab-pane -->
                @endforeach
              </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->

            <div class="row ">

              {{-- Categorieën --}}
              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('main[options][categories][]', 'Toon product in categorieën:') !!}
                  <select class="form-control text-black" name="main[options][categories][]" id="main[options][categories][]" multiple>
                    @foreach ($categories as $category)
                      <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Product Label - Frontend --}}
              <div class="col-md-4">
                <div class="form-group">
                {!! Form::label('main[options][label]', 'Label: @{{productLabelLength}} (Optioneel)') !!}
                {!! Form::text('main[options][label]', $product->label, array('v-model' => 'productLabel', 'class' => 'form-control', 'maxlength' => '6')) !!}
                </div>
              </div>

              {{-- BTW Groep --}}
              <div class="col-md-4">
                <div class="form-group">
                  <label for="main[options][taxgroup]">BTW Groep</label>
                  <select class="form-control text-black" name="main[options][taxgroup]" type="text" id="main[options][taxgroup]">
                    @foreach ($taxes as $taxgroup)
                      <option @if ($taxgroup->tax_group_id === $product->tax->tax_group_id ) selected @endif value="{{ $taxgroup->tax_group_id }}">{{ $taxgroup->name }} ({{ $taxgroup->tax_amount }}%)</option>
                    @endforeach
                  </select>
                </div>
              </div>

            </div><!-- /.row -->
            <div class="row">

              {{-- Koppelen Acties --}}
              <div class="col-md-4">
                <div class="form-group">
                {!! Form::label('main[options][discounts][]', 'Gekoppelde Acties:') !!}
                <select class="form-control text-black" name="main[options][discounts][]" id="main[options][discounts][]" multiple>
                  @foreach ($discounts as $discount)
                    <option value="{{ $discount->discount_id }}">{{ $discount->title }} &emsp; {{ $discount->date_start->formatLocalized('%e %b %Y') }} &ndash; {{ $discount->date_end->formatLocalized('%e %b %Y') }}</option>
                  @endforeach
                </select>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

    @forelse ($productVariants as $variant)
      <div class="row" data-product-variant="{{ $variant->variant_id }}">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <button data-remove-variant="{{ route('cms.variant.destroy', $variant->variant_id) }}" class="btn btn-flat bg-red pull-right margin-left"><i class="fa fa-trash"></i></button>
              <button data-toggle-variant="{{ route('cms.variant.toggle', $variant->variant_id) }}" class="btn btn-flat pull-right margin-left {{ $variant->active ? 'btn-success' : 'btn-warning' }} ">{{ $variant->active ? 'ACTIEF' : 'INACTIEF' }}</button>
              <h3 class="box-title"><i class="ion ion-ios-flower"></i> Variant: @{{ productSku.toUpperCase() }}-{{ $variant->sku }} (#{{ $variant->variant_id }})</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    {!! Form::label('variants['.$variant->variant_id.'][price]', 'Productprijs (incl. '.$product->tax->tax_amount.'% BTW)') !!}
                    <div class="input-group input-group-lg">
                      <span class="input-group-addon">€</span>
                      {!! Form::text('variants['.$variant->variant_id.'][price]', $variant->price, array('class' => 'form-control variant-price', 'data-mask' => '', 'data-inputmask' => '"alias":"numeric" , "digits": 2, "digitsOptional": false,  "placeholder": "0"')) !!}
                      <span class="input-group-addon ex-vat greywash">Excl. BTW: <span class="vat">{{ round($variant->price / ($product->tax->tax_amount + 100) * 100, 2) }}</span></span>
                    </div>
                  </div>
                  <!-- Custom Tabs -->
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      @foreach ($languages as $key => $language)
                        <li class="@if ($key == 0) active @endif"><a href="#tab_variant_{{ $variant->variant_id }}_{{ $language->locale }}" data-toggle="tab" aria-expanded="false">{{ $language->name }}</a></li>
                      @endforeach
                    </ul>
                    <div class="tab-content">
                      @foreach ($languages as $key => $language)
                        <div class="tab-pane @if ($key == 0) active @endif" id="tab_variant_{{ $variant->variant_id }}_{{ $language->locale }}">
                          <div class="form-group">
                            {!! Form::label('variants['.$variant->variant_id.'][name]['.$language->locale.']', 'Variantaanduiding (Website)') !!}
                            {!! Form::text('variants['.$variant->variant_id.'][name]['.$language->locale.']', $variant->translate($language->locale, true)->name, array('class' => 'form-control variant-name')) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('variants['.$variant->variant_id.'][sku]['.$language->locale.']', 'SKU (Interne Naam)') !!}
                            {!! Form::text('variants['.$variant->variant_id.'][sku]['.$language->locale.']', $variant->translate($language->locale, true)->sku, array('class' => 'form-control variant-sku')) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('variants['.$variant->variant_id.'][description]['.$language->locale.']', 'Omschrijving') !!}
                            {!! Form::textarea('variants['.$variant->variant_id.'][description]['.$language->locale.']', $variant->translate($language->locale, true)->description, array('class' => 'form-control', 'rows' => '3')) !!}
                          </div>
                        </div><!-- /.tab-pane -->
                      @endforeach
                    </div><!-- /.tab-content -->
                  </div><!-- nav-tabs-custom -->

                </div>
                <div class="col-md-4">
                  <img class="img-responsive pad" src="{{ $variant->image }}" alt="Product">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <span class="pull-right small greywash">Laatst gewijzigd: {{ $variant->updated_at }}</span>
            </div>
          </div>
        </div>
      </div>

    @empty

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
                Geen productvarianten gevonden.
            </div><!-- /.box-body -->
          </div>
        </div>
      </div>

    @endforelse

    <button type="submit" name="save" id="save2" class="btn btn-flat btn-block bg-olive"><i class="fa fa-save"></i> Opslaan</button>
  {!! Form::close(); /* End of Product Form */ !!}

  {!! Form::open(array('route' => 'cms.variant.store', 'method' => 'post')) !!}
    <input type="hidden" name="pid" value="{{ $product->product_id }}">
    <button class="btn btn-flat btn-block bg-light-blue margin-top" name="addVariant" id="addVariant"><i class="fa fa-plus"></i> Productvariant Toevoegen</button>
  {!! Form::close(); /* End of Add-Variant Form */ !!}

@endsection



@section('page-js')

  @include('admin.partials.formtools')


  <script>

    // Instantiate Vue ViewModel
    new Vue({
      el: '#app',
      data : {
        productName : '',
        productSku : '',
        productLabel : '',
      },
      methods : {
        updateSKU : function() {
          this.productSku = this.productName.toUpperCase();
        }
      },
      computed : {
        productLabelLength : function() {
          return '(' + this.productLabel.length + '/6 karakters)';
        }
      }
    });

    // Remove Product Button
    $('button[data-remove-product]').on('click', function(e) {
      e.preventDefault();
      var $self             = $(this);
      var $product          = $self.parents('.row');
      var $productID        = $self.parents('.row').data('product');
      var $productVariants  = $('[data-product-variant]');
      formChanged = false;
      bootbox.dialog({
        message: 'U staat op het punt een heel product te verwijderen, inclusief alle varianten.<br> \
                  Weet u zeker dat u dit product (#' + $productID + ') wilt verwijderen?',
        title: 'Product Verwijderen',
        buttons: {
          success:  { label: 'Annuleer', className: 'btn' },
          danger:   { label: 'Verwijderen', className: 'btn-danger',
            callback: function() {
              // Remove Product AJAX request
              console.log($self.data('remove-product'));
              $.post( $self.data('remove-product') , {
                _method : 'delete',
                _token  : '{{ csrf_token() }}'
              }).done(function( data ) {
                  $productVariants.delay(100).slideUp(700, function(){
                    $product.delay(100).slideUp(700, function(){
                      Notification.success('Product (#' + $productID + ') verwijderd!');
                      triggerNotification();
                      setTimeout(function() {
                        window.location.replace("{{ route('cms.product.index') }}");
                      }, 2000);
                    });
                  });
              }).fail(function( data ) {
                  Notification.error('Kon product niet verwijderen!');
                  triggerNotification();
              });
            }
          }
        }
      });
    });


    // Toggle Active on ProductVariant
    $('button[data-toggle-variant]').on('click', function(e) {
      e.preventDefault();
      var $self       = $(this);
      var $variantID  = $self.parents('.row').data('product-variant');
      $.post( $self.data('toggle-variant') , {
        _method : 'patch',
        _token  : '{{ csrf_token() }}'
      }).done(function( data ) {
          if (data.active) {
            $self.removeClass('btn-warning').addClass('btn-success').html('ACTIEF');
          }
          else {
            $self.removeClass('btn-success').addClass('btn-warning').html('INACTIEF');
          }

      }).fail(function( data ) {
          Notification.error('Kon Productvariant niet aanpassen!');
          triggerNotification();
      });
    });


    // Remove ProductVariant Button
    $('button[data-remove-variant]').on('click', function(e) {
      e.preventDefault();
      var $self       = $(this);
      var $variant    = $self.parents('.row');
      var $variantID  = $self.parents('.row').data('product-variant');
      bootbox.dialog({
        message: 'Weet u zeker dat u deze variant (#' + $variantID + ') wilt verwijderen?',
        title: 'Productvariant Verwijderen',
        buttons: {
          success:  { label: 'Annuleer', className: 'btn' },
          danger:   { label: 'Verwijderen', className: 'btn-danger',
            callback: function() {
              // Remove ProductVariant AJAX request
              $.post( $self.data('remove-variant') , {
                _method : 'delete',
                _token  : '{{ csrf_token() }}'
              }).done(function( data ) {
                  $variant.delay(300).slideUp(600, function(){
                    $variant.remove();
                  });
                  Notification.success('Productvariant (#' + $variantID + ') verwijderd!');
                  triggerNotification();
              }).fail(function( data ) {
                  Notification.error('Kon productvariant niet verwijderen!');
                  triggerNotification();
              });
            }
          }
        }
      });
    });


    // Copy Productname to SKU field
    $('.variant-name').on('keyup', function(e) {
        var txtVal = $(this).val();
        $(this).parent().parent().find('.variant-sku').attr('value', txtVal.toUpperCase());
    });

    // Calculate VAT
    $('.variant-price').keyup(function(e) {
        var price_vat     = $(this).val();
        var price_ex_vat  = parseFloat(price_vat) / {{ $product->tax->tax_amount + 100 }} * 100;
        $(this).parent().find('.ex-vat').find('span').text(price_ex_vat.toFixed(2));
    });

    // Warn for unsaved changes
    $('input, select, textarea').change(function(){
        formChanged = true;
        $("#addVariant").prop('disabled', true);
    });
    $("button[name='save']").click(function(e) {
            formChanged = false;
    });


  </script>

@endsection