{{-- MESSAGE MODAL --}}
{{--
<div class="message-modal">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ $langg->lang385 }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="emailreply1">
                                        {{csrf_field()}}
                                        <div class="input-field">
                                            <input type="text" class="input-field" id="order" name="order_numkber"
                                                   placeholder="{{ $langg->lang386 }} *" required="">
                                        </div>

                                        <div class="input-field">
                                            <input type="text" class="input-field" id="subj1" name="subject"
                                                   placeholder="{{ $langg->lang387 }} *" required="">
                                        </div>
                                        <div class="input-field">
                                            <textarea class="input-field textarea" name="message" id="msg1"
                                                      placeholder="{{ $langg->lang388 }} *" required=""></textarea>
                                        </div>
                                        <input type="hidden" name="type" value="Dispute">

                                        <button class="submit-btn" id="emlsub1"
                                                type="submit">{{ $langg->lang389 }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

<div class="message-modal">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('front.add-dispute') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="emailreply1">
                                        {{csrf_field()}}
                                        <ul>
                                            <li>
                                                <select class="form-select ml-10 mb-5" id="order" name="order_numkber" required>
                                                    <option value="">Sipariş Seç</option>
                                                    @foreach($orders as $order)
                                                    <option value="{{ $order->order_number }}">{{ $order->order_number }}</option>
                                                    @endforeach
                                                </select>
{{--
                                                <input type="text" class="input-field" id="order" name="order_numkber" placeholder="{{ __('front.order-number') }} *" required="">
--}}
                                            </li>

                                            <li>
                                                <input type="text" class="input-field" id="subj1" name="subject" placeholder="{{ __('front.subject') }} *" required="">
                                            </li>
                                            <li>
                                                <textarea class="input-field textarea" name="message" id="msg1" placeholder="{{ __('front.message') }} *" required=""></textarea>
                                            </li>
                                        </ul>
                                        <input type="hidden"  name="type" value="Dispute">

                                        <button class="submit-btn" id="emlsub1" type="submit">{{ __('front.send') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MESSAGE MODAL ENDS --}}