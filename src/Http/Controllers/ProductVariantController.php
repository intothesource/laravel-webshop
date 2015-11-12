<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product_variant;
use App\Product_variant_i18n;

use Notification;

class ProductVariantController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productid = $request->pid;

        // Create New Variant
        $productVariant = new Product_variant;
        $productVariant->product_id = $productid;

        if (! $productVariant->save()) {
            Notification::error('<i class="fa fa-cross"></i> Fout: Kon Productvariant niet aanmaken!');
            return redirect()->route('product.edit', [$productid]);
        }

        // Create initial translation record (nl)
        $productVariantI18n = new Product_variant_i18n;
        $productVariantI18n->locale = 'nl';
        $productVariantI18n->product_variant()->associate($productVariant);
        $productVariantI18n->save();

        if (! $productVariantI18n->save()) {
            Notification::error('<i class="fa fa-cross"></i> Fout: Kon Productvariant niet aanmaken!');
            return redirect()->route('product.edit', [$productid]);
        }

        Notification::success('<i class="fa fa-check"></i> Nieuwe Productvariant aangemaakt! (#'.$productVariantI18n->variant_id.')');
        return redirect()->route('product.edit', [$productid]);
    }


    /**
     * Toggle the active column on the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $productVariant = Product_variant::find($id);
        $productVariant->active = $productVariant->active ? 0 : 1;


        return ( $productVariant->save() ? response()->json(['success' => true, 'active' => $productVariant->active]) : response()->json(['success' => false], 422) );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $id;
        return ( Product_variant::destroy($id) ? response()->json(['success' => true]) : response()->json(['success' => false], 422) );
    }
}
