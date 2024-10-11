@extends('layouts.pagina.app')
@section('content')
<section class="top_place">
    <div class="container">
        <div class="mb-5">
            <h2>
                Real benefits for employees
            </h2>
            <p>
                Optucorp is a company dedicated to provide   the best quality for the best employees and corporate companies.
            </p>
            <div class="mt-3">
                <img alt="" class="bordered flexible" src="{{ env('STORAGE_EU') }}/img/elements/world/us/trab_us.jpg " style="width: 100%;"/>
            </div>
            <p class="mt-3">
                These are some of the real benefits that employees of affiliated companies can obtain and enjoy:
            </p>
            <ol class="mt-3 ml-4">
                <li>
                    Open package to any destination within the United States
                </li>
                <li>
                    No need to set destination and days of vacation package at time of enrollment.
                </li>
                <li>
                    Effective for one year after purchasing a package
                </li>
                <li>
                    The Benefit is good in high and low season for the same price
                </li>
                <li>
                    Only 3, 4 and 5 stars hotels
                </li>
                <li>
                    12 easy monthly payments
                </li>
                <li>
                    Prices are below the rates of the hotels that we offer
                </li>
                <li>
                    Packages are fully transferable
                </li>
                <li>
                    The price of our benefits apply to family and friends (up to 3 packages per employee per year)
                </li>
                <li>
                    Easy to check your statements at any time on our website
                </li>
                <li>
                    Our service is guaranteed to be fulfilled since we have direct agreements with hotels
                </li>
            </ol>
            <p class="mt-3">
                If you still do not have these amazing benefits, please contact us:
                <strong>
                    <a href="mailto:sales@optucorp.com?&subject=My%20Benefit">
                        sales@optucorp.com
                    </a>
                </strong>
                .
            </p>
        </div>
    </div>
</section>
@endsection
@section('script')
@endsection
