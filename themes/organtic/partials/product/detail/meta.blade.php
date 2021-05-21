@php
    $stck = (string)$product->stock;
@endphp
@if($stck != null)
    <input type="hidden" id="stock" value="{{ $product->stock }}">
@else
    <input type="hidden" id="stock" value="0">
@endif
<input type="hidden" id="product_price" value="{{ round($product->vendorPrice() * $curr->value,2) }}">
<input type="hidden" id="product_id" value="{{ $product->id }}">
<input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
<input type="hidden" id="curr_sign" value="{{ $curr->sign }}">