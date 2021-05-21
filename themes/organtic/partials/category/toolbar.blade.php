<div class="col-main col-sm-9 col-sm-push-3 product-grid">
    <div class="pro-coloumn tool-coloumn">
        <article>
            <div class="toolbar">
                <div class="pager">
                    <div class="pages">
                    {!! $prods->appends(['search' => request()->input('search')])->links() !!}
                    <!--<ul class="pagination">
                            <li><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>-->
                    </div>
                </div>
                <div class="sort-by">
                    <label class="left"></label>
                    <select id="sortby" name="sort" class="short-item">
                        <option value="date_desc">{{ __('front.latest-product') }}</option>
                        <option value="date_asc">{{ __('front.oldest-product') }}</option>
                        <option value="price_asc">{{ __('front.lowest-price') }}</option>
                        <option value="price_desc">{{ __('front.highest-price') }}</option>
                    </select>

                </div>

            </div>
        </article>
    </div>
</div>
