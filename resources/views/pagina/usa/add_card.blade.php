@extends('layouts.pagina.app')
@section('content')
<style>
    .breadcrumb_bg_1 {
        background-image: url("{{ asset('images/eu/paso3.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .errors {
        font-size: 12px;
    }
                    <style>
    .payment input{
        height: 42px !important;
        background: #fff !important;
        color: #000000 !important;
        font-size: 16px;
        border-radius: 0px;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }
    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        /* border: 1px solid rgba(0, 0, 0, 0.125); */
        /*border-radius: 0.25rem;*/
    }

    .breadcrumb .overlay_h {
        opacity: .3;
    }
    .radio label{
        font-size: 13px;
    }
</style>
<section class="breadcrumb breadcrumb_bg_1">
    <div class="overlay_h">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>
                            Step 3
                        </h2>
                        <p class="">
                            Congratulations! You have selected your destination, created your User ID (which is your email address) and password, and to finalize your booking all that is missing is your payment information. Enter your Debit or Credit Card information below so that we can finalize your booking.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="hotel_list single_page_hotel_list mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="cardt">
                    <div class="card-header">
                        <div class="">
                            <h3 class="text-center">
                                My Booking Details
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="single_ihotel_list">
                            <div class="hotel_text_iner">
                                <h3 class="text-primary">
                                    {{ $estancia->title }}
                                </h3>
                                <div>
                                    {!! $estancia->descripcion !!}
                                </div>
                                <strong class="lead">
                                    Price:
                                    <span class="text-danger">
                                        ${{ $estancia->precio }}.00
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                <strong class="lead">
                                    {{ $estancia->cuotas }} Bi-Weekly:
                                    <span class="text-danger">
                                        ${{ $estancia->precio / $estancia->cuotas }}.00
                                    </span>
                                    {{ $estancia->divisa }}
                                </strong>
                                <br/>
                                <p>
                                    *The charges will be direct debited to the payment method entered
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <img alt="Logo" class="img-fluid" src="{{ asset('images/eu/my_travel.png') }}">
                                </img>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-5">
                <form action="{{ route('process-payment.store') }}"class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form" method="POST">

                    <input type="hidden" value="" id="token_id" name="token_id">
                    @csrf

                    <input type="hidden" value="" id="token_id" name="token_id">
                    <div class="cardt">
                        <div class="card-header text-center">
                            <h3>
                                Payment method
                            </h3>
                        </div>
                       {{--  @if ($tarjetas != false && count($tarjetas) != 0)
                        <div class="card-body">
                            <h6 class="card-title">
                                Select payment method
                            </h6>
                            <select class="form-control" id="tarjeta_id" name="tarjeta_id">
                                @foreach ($tarjetas as $tarjeta)
                                <option value="{{ $tarjeta->id }}">
                                    {{ $tarjeta->numeroTarjeta }}
                                </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary btn-sm mt-1" id="btnAddCard">
                                <i class="fas fa-credit-card">
                                </i>
                                Add card
                            </button>
                        </div>
                        @endif --}}
                        <div class="card-body" id="card_form">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="card-title">
                                        Credit cards
                                    </h6>
                                    <img alt="" class="img-fluid" src="{{ asset('images/cards1.png') }}">
                                    </img>
                                </div>
                                <div class="col-md-8" style="border-left: 1px solid #ccc;">
                                    <h6 class="card-title">
                                        Debit cards
                                    </h6>
                                    <img alt="" class="img-fluid" src="{{ asset('images/eu/card_eu.jpg') }}" width="150px">
                                    </img>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12 alert alert-danger" id="errors" style="display:none">
                                    
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label for="formGroupExampleInput">
                                        Card Holder
                                    </label>
                                    <input autocomplete="off" class="form-control" required data-openpay-card="holder_name" id="holder_name" name="holder_name" placeholder="Card Holder" type="text" value="{{ Auth::user()->fullName }}">
                                    </input>
                                    <span class="text-danger error-holder_name errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label for="formGroupExampleInput2">
                                        Card Number
                                    </label>
                                    <input autocomplete="off" class="form-control card-number" data-openpay-card="card_number" id="card_number"  required maxlength="20" name="card_number" placeholder="1111-2222-3333-4444" type="text" value="4242424242424242"/>
                                    <span class="text-danger error-card_number errors">
                                    </span>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="">
                                        Expiration date
                                    </label>
                                    <input class="form-control  card-expiry" id="expiration" name="expiration" value="05/26" placeholder="MM/YY" required type="text">
                                    </input>
                                    <span class="text-danger error-expiration errors">
                                    </span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="formGroupExampleInput2">
                                        Security Code
                                    </label>
                                    <input autocomplete="off" class="form-control card-cvc" data-openpay-card="cvv2" id="cvv2" value="123" required maxlength="4" name="cvv2" placeholder="CVV" type="password"/>
                                    <span class="text-danger error-cvv2 errors">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-1">
                            <div class="form-group col-md-11 ml-3">
                                <input class="form-check-input" required id="enganche" name="enganche" type="checkbox">
                                    <label class="form-check-label" for="enganche">
                                        Authorize My Travel Benefits by Optucorp to charge my credit/debit card for the stated price and I accept to get a
                                        <strong>
                                            {{ env('ENGANCHE') }}
                                        </strong>
                                        USD non refundable deposit payment deducted today from my account.
                                    </label>
                                </input>
                                <br/>
                                <span class="text-danger error-enganche errors">
                                </span>
                            </div>
                            <div class="form-group col-md-11 ml-3">
                                <input class="form-check-input" required id="terminos" name="terminos" type="checkbox">
                                    <label class="form-check-label" for="terminos">
                                        <button class="btn btn-link" data-target="#exampleModal" data-toggle="modal" type="button">
                                            I agree to the terms and conditions.
                                        </button>
                                    </label>
                                </input>
                                <br/>
                                <span class="text-danger error-terminos errors">
                                </span>
                            </div>
                            <div class="form-group col-md-12 mt-2">
                                {!! NoCaptcha::renderJs('en') !!}
                                    {!! NoCaptcha::display() !!}
                                <span class="text-danger error-g-recaptcha-response errors">
                                </span>
                            </div>
                            <div class="col-md-4 text-center">
                                <button class="btn btn-primary btn-block" id="pay-button" type="submit">
                                    <i class="fa fa-credit-card">
                                    </i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade mt-5 pt-5 mb-5 pb-5 " id="exampleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">
                    Terms and Conditions
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body m-4">
                <ol style="text-align: justify;">
                    <li>
                        This Vacation Certificate Package is valid for five (5) days and four (4) nights or three (3) days and two (2) nights based on double occupancy for standard 3 and 4 star hotel accommodations for any destination within the United States during any season. Certain restrictions apply.
                    </li>
                    <li>
                        All reservations are subject to space availability and to variations during holiday seasons, Easter week, recognized federal official holidays and special events in select locations.
                    </li>
                    <li>
                        This Vacation Package is valid for two adults, 21 years of age or older with a major credit card. Two children under 12 are allowed in the same room. When available, breakfast for two adults is included. There is additional charge per day for extra guests. No pets allowed. Additional room nights may be requested at discounted rates, subject to availability. This travel certificate cannot be used in conjunction with any other travel certificate unless authorized in writing by My Travel Benefits
                        <em>
                            by Optucorp
                        </em>
                        USA, LLC. (THE PROMOTER).
                    </li>
                    <li>
                        This Vacation Package is eligible including adults of 21 years of age or older, but not limited to sex, race, marital status, group association, residency or geographic limitations.
                    </li>
                    <li>
                        Once you have e-mailed your activation form and the reservation is confirmed in writing by THE PROMOTER, you may proceed with your transportation plans. We recommend not to book your means of transportation until your reservation has been validated for the dates and destination of your choice and you have received a confirmation code in writing via e-mail.
                    </li>
                    <li>
                        Whenever possible we try our best to accommodate your first requested reservation dates. When booking a reservation by phone, you must receive a confirmation code by e-mail within 48 hrs after receiving your request. Such request must comply with the established reservation process.c
                    </li>
                    <li>
                        My Travel Benefits
                        <em>
                            by Optucorp
                        </em>
                        USA, LLC (The Promoter) reserves the right to add/remove destinations without prior notice.
                    </li>
                    <li>
                        This Vacation Package is valid for accommodations only. You will be responsible for taxes, gratuities, transportation, service charges and incidental expenses.
                    </li>
                    <li>
                        This Vacation Package cannot be exchanged for cash, any monetary consideration, resold nor be reproduced. There are no refunds of unused portions of this Vacation Package and it expires 12 months from the purchase/issue date. Therefore, all travel must be completed before expiration date.
                    </li>
                    <li>
                        The Vacation Package is fully transferable at all times, should you use it as a gift, subject to all Terms and Conditions. The Purchaser shall request on writing to reservations@optucorp.com to transfer the Vacation Package to any person, with the only restriction of that person being 21 years of age or older and to be subject to the terms and conditions of this contract.
                    </li>
                    <li>
                        Whenever The Purchaser cancels This Contract for any reason not imputable to The Promoter, 31 days after the date of purchase or receipt of the vacation certificate, whichever occurs later, there will be no refunds.
                    </li>
                    <li>
                        While on vacation you may be offered exciting vacation opportunities by one of our hosting resorts in the hopes that you will vacation with them in the future. The Promoter is not affiliated with such offers, and bears no responsibility or liability for any claims or representations made in any such offers, nor is attending any presentation a requirement of the Vacation Package. Your check-in confirmation code and valid photo identification (passport and/or State issued ID) shall be required on check-in, and most hotels will require a valid major credit card to be presented to cover incidental charges. This is a standard procedure and no charge should be applied to your credit card unless otherwise specified by the hotel at the moment of your check-out. Check-in and continued occupancy shall at all times be subject to all requirements of participating hotels and applicable laws.
                    </li>
                    <li>
                        The Promoter is not to be held responsible for any inconvenience, delay, disappointment, frustration, accident, injury, loss of employment, or damage to persons, any whether physical or emotional distress, or any act of God, terrorism, or any liability whatsoever arising from or in conjunction with the services provided, or any other circumstances beyond its control which may cause the travel arrangements to become unavailable. In the event that a destination becomes unavailable, The Promoter will use commercially reasonable efforts to offer a substitute destination.
                    </li>
                    <li>
                        This Vacation Package is void where prohibited by law. All federal, state and local laws apply. No other representations, oral or otherwise, are valid in conjunction with this Vacation Package. The Promoter reserves the right to change, modify or revise these Terms and Conditions and/or fees without notice.
                    </li>
                    <li>
                        You may cancel your confirmed reservation up to 48 hrs before the selected date of your Vacation Package, and reschedule following the same designated reservation process. If you cancel in less than 48 hrs of the selected date of your Vacation Package, a no-show will considered and additional charges will apply for your new reservation, and those may vary depending on the date and/or destination chosen afterwards, and as long as the proper established reservation process is followed thoroughly.
                    </li>
                    <li>
                        Under no circumstance the use of discounts or complimentary coupons or tickets will apply.
                    </li>
                    <li>
                        Any violation of these Terms and Conditions will result in the Vacation Certificate Package becoming null and void. This contract is for the purchase of a vacation certificate an puts all assignees on notice of the consumer’s right to cancel under Section 559.933, Florida Statutes.
                    </li>
                    <div id="div_descripcion" style="display: none;">
                        <li id="descripcion">
                        </li>
                    </div>
                </ol>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var element = document.getElementById('card_number');
        var maskOptions = {
            mask: '0000-0000-0000-0000'
        };
        

        var mask = IMask(element, maskOptions);
        var element2 = document.getElementById('cvv2');
        var maskOptions2 = {
            mask: '0000'
        };
        var mask = IMask(element2, maskOptions2);
        var element3 = document.getElementById('expiration');
        var maskOptions3 = {
            mask: '00/00'
        };
        var mask = IMask(element3, maskOptions3);

        $('#btnAddCard').click(function(event) {
            event.preventDefault();
            $('#card_form').css('display', 'block');
        });
        
        $('body').on('submit', '#payment-form', function(e) {
            e.preventDefault();
            var holder_name = $('#holder_name').val();
            var card_number = $('#card_number').val();
            var expiration  = $('#expiration').val();
            var cvv2        = $('#cvv2').val();
            var expired     = expiration.split('/');
            var card        = card_number.replace(/-/gi, '');

            var expirationm = expired[0];
            var expirationy = expired[1];

            Stripe.setPublishableKey($(this).data('stripe-publishable-key'));
            Stripe.createToken({
                number: card,
                cvc: cvv2,
                exp_month: expirationm,
                exp_year: expirationy
            }, stripeResponseHandler); 
        });
        
    });

    function stripeResponseHandler(status, response) {
         $("#errors").css('display', 'none');
        if (response.error) {

            errorsCard(response.error)
            $("#errors").html(response.error.message);
            $("#errors").css('display', 'block');

        } else {
            var token = response['id'];
            $('#token_id').val(token)

            $.ajax({
                type: $('#payment-form').attr('method'),
                url: $('#payment-form').attr('action'),
                data: $('#payment-form').serialize(),
                dataType: "json",
                beforeSend: function() {
                    $("#overlay").css("display", "block");
                },
                success: function(res) {
                    $("#errors").css('display', 'none');
                    $("#overlay").css("display", "none");
                    if (res.payment == false) {
                        $("#errors").html(res.error_stripe);
                        $("#errors").css('display', 'block');
                    } else if (res.success == true && res.payment != null) {
                        window.location.href = res.url;
                    } else {
                        toastr['error']('Try later...');
                    }
                }
            })
            .always(function() {
                $("#overlay").css("display", "none");
            });
        }
       
    }

    function clearErrors() {
        $(document.getElementById('errors')).css("display", "none");
        $(document.getElementById("errors")).html('');
        $(document.getElementsByClassName("form-control")).removeClass('is-invalid');
    }

    function errorsCard(param) {
        switch (param.code) {
            case 'invalid_cvc':
            case 'incorrect-cvc':
                $(document.getElementsByClassName("form-errors-cvv")).addClass('is-invalid');
                $(document.getElementsByClassName("error-cvv")).html(param.message + ' <br/>');
                break;
            case 'invalid_expiry_month':
            case 'invalid_expiry_year':
                $(document.getElementsByClassName("form-errors-expiration")).addClass('is-invalid');
                $(document.getElementsByClassName("error-expiration")).html(param.message + ' <br/>');
                break;
            case 'incorrect_number':
                $(document.getElementsByClassName("form-errors-numberCard")).addClass('is-invalid');
                $(document.getElementsByClassName("error-numberCard")).html(param.message + ' <br/>');
                break;
            default:
                Swal.fire(
                    'Oops...',
                    param.message,
                    'error'
                );
                break;
        }

    }
</script>
@endsection
{{-- 
@section('script')
<script>
    var element = document.getElementById('card_number');
    var maskOptions = {
        mask: '0000-0000-0000-0000'
    };
    var mask = IMask(element, maskOptions);
    var element2 = document.getElementById('cvv2');
    var maskOptions2 = {
        mask: '0000'
    };
    var mask = IMask(element2, maskOptions2);
    var element3 = document.getElementById('expiration');
    var maskOptions3 = {
        mask: '00/00'
    };
    $('#btnAddCard').click(function(event) {
        event.preventDefault();
        $('#card_form').css('display', 'block');
    });
</script>
@endsection --}}
