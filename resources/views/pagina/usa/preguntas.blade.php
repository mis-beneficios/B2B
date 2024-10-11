@extends('layouts.pagina.app')
<style>
    .breadcrumb_faq {
        background-image: url("{{ asset('images/eu/faq.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
@section('content')
<section class="breadcrumb breadcrumb_faq">
    <div class="container">
        <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item text-center">
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row mt-5">
        <h1 class="ml-3">
            FAQ
        </h1>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample1" aria-expanded="true" c="" data-toggle="collapse" href="#collapseExample1" lass="" role="button" style="color:white">
                    1.- What is My Travel Benefits
                    <em>
                        by Optucorp
                    </em>
                    ?
                </a>
            </p>
            <div class="collapse show" id="collapseExample1" style="">
                <div class="card card-body">
                    <p class="text-justify">
                        My Travel Benefits by Optucorp is an international Travel Benefit Provider, who works with your employer, to bring you a stress
                    free vacation!
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample2" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample2" role="button" style="color:white">
                    2.- How is My Travel Benefits by Optucorp part of my employee benefits?
                </a>
            </p>
            <div class="collapse show" id="collapseExample2">
                <div class="card card-body">
                    <p class="text-justify">
                        You’re important to your employer and your vacation is important to them. Your employer and  My Travel Benefits by Optucorp firmly believe that every employee must take a yearly vacation, for their own mental state and productivity.
                    Through our program, your rate is locked in for an entire year no matter when or where your travels take
                    you during that year. The savings are gigantic during high season and holidays because while other travelers
                    are paying increased rates during said dates, you will ONLY pay your locked in rate.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample3" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample3" role="button" style="color:white">
                    3.- For how long is my rate locked in?
                </a>
            </p>
            <div class="collapse show" id="collapseExample3">
                <div class="card card-body">
                    <p class="text-justify">
                        Your rate is locked in for one year. After this time, you may request an extension to travel during low
                    season, subject to availability and possibly a rate increase.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample4" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample4" role="button" style="color:white">
                    4.- I am not traveling with children. Can I swap for an adult?
                </a>
            </p>
            <div class="collapse show" id="collapseExample4">
                <div class="card card-body">
                    <p class="text-justify">
                        No. Sorry, children are free at our affiliated hotels!
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample5" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample5" role="button" style="color:white">
                    5.- Can your hotels accommodate more than 4 people in one room?
                </a>
            </p>
            <div class="collapse show" id="collapseExample5">
                <div class="card card-body">
                    <p class="text-justify">
                        This is dependent on what hotel is available at the time of reservation. Each hotel has different
                    policies regarding maximum occupancy and rates for additional guests. Our reservation team will gladly assist you
                    with this at the time of reservation.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample6" aria-expanded="false" class="" data-toggle="collapse" href="#collapseExample6" role="button" style="color:white">
                    6.- What type of vacation plans do you offer?
                </a>
            </p>
            <div class="collapse show" id="collapseExample6">
                <div class="card card-body text-justify">
                    <p class="text-justify">
                        We currently have three packages available. Anywhere in the U.S., including its territories such as Puerto Rico, anywhere in Mexico, including its all-inclusive beach destinations such as Cancun and Cruises. If you are looking to travel elsewhere, such as Punta Cana, Dominican Republic or Madrid, Spain, we would be more than happy to prepare a quote for you. Both the U.S. and Mexico packages have 2 and 4 night packages. Additional nights can be quoted by calling us at (305) 447-2764.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample7" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample7" role="button" style="color:white">
                    7.- Do your vacation plans include transportation?
                </a>
            </p>
            <div class="collapse show " id="collapseExample7">
                <div class="card card-body">
                    <p class="text-justify">
                        Our program is an innovative open travel concept that permits you to lock in your rate without knowing
                    when or where you are traveling to. Hence, transportation can only be quoted to you once you select your
                    destination and dates of travel which we recommend that you do three months prior to traveling.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample8" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample8" role="button" style="color:white">
                    8.- Do your hotels include airport shuttle?
                </a>
            </p>
            <div class="collapse show " id="collapseExample8">
                <div class="card card-body">
                    <p class="text-justify">
                        This is dependent on what hotel is available at the time of reservation. Each hotel has different
                    amenities and services. If you specifically require a shuttle, kindly advise our reservation agent at that
                    time.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample9" aria-expanded="false" class=" " data-toggle="collapse" href="#collapseExample9" role="button" style="color:white">
                    9.- What if I already know when and where I am traveling to?
                </a>
            </p>
            <div class="collapse show " id="collapseExample9">
                <div class="card card-body">
                    <p class="text-justify">
                        Great! That makes you one prepared traveler! Call us at (305) 447-2764 and we will be happy to prepare a quote for you.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample10" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample10" role="button" s=" " style="color:white">
                    10.- What hotels do you work with?
                </a>
            </p>
            <div class="collapse show " id="collapseExample10">
                <div class="card card-body">
                    <p class="text-justify">
                        Our list of affiliated hotels is endless because we are international! As such, it is impossible for us
                    to list all of the hotels in all of the destinations on our site. Some of the names we currently work with
                    are Wyndham, Marriott, Intercontinental, Holiday Inn, Dream Hotels, Riu Hotels, Oasis Hotels, Kimpton
                    Hotels, Melia and local hotels, such as Fontainebleau Miami and Raffaelo Chicago.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample11" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample11" role="button" s=" " style="color:white">
                    11.- What Cruises do you work with?
                </a>
            </p>
            <div class="collapse show " id="collapseExample11">
                <div class="card card-body">
                    <p class="text-justify">
                        We gladly provide our clients with cruise options through Carnival, Royal Caribbean, Norwegian and Disney Cruise Line. Call our Sales Team and ask about the discounted rates we have with all major cruise lines! CALL (305) 447-2764!
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample12" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample12" role="button" s=" " style="color:white">
                    12.- What ports do your cruises visit?
                </a>
            </p>
            <div class="collapse show " id="collapseExample12">
                <div class="card card-body">
                    <p class="text-justify">
                        Many. This is dependent on what port you depart from. For example, if you would like to cruise through
                    Alaska, geographically the only port you could embark from would be Seattle, Washington.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample13" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample13" role="button" s=" " style="color:white">
                    13.- Can I choose a cruise that is not on your site?
                </a>
            </p>
            <div class="collapse show " id="collapseExample13">
                <div class="card card-body">
                    <p class="text-justify">
                        Of course! What’s on your Bucket List? A cruise to Hawaii or Alaska? Just give us a call at (305) 447-2764
                    and we will be more than happy to prepare a quote for you. Cruises that are not on our sire are subject
                    to a deposit and are non-transferrable or cancellable.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample14" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample14" role="button" s=" " style="color:white">
                    14.- Is this payroll deductible?
                </a>
            </p>
            <div class="collapse show " id="collapseExample14">
                <div class="card card-body">
                    <p class="text-justify">
                        Not at this time. We tailor your payments to your pay schedule (Example: if you get paid on the 14th and
                    28th of every month, we would schedule your payments on those dates) with either a Visa or MasterCard, Debit
                    or Credit.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-1 mb-3 btn-block wow bounceInRight text-justify" style="visibility: visible; animation-name: bounceInRight;">
            <p class="mb-2 alert alert-primary" style="background-color:#008dc7;">
                <a aria-controls="collapseExample15" aria-expanded="false" clas="" data-toggle="collapse" href="#collapseExample15" role="button" s=" " style="color:white">
                    15.- Can I transfer between packages?
                </a>
            </p>
            <div class="collapse show " id="collapseExample15">
                <div class="card card-body">
                    <p class="text-justify">
                        Absolutely! Again, we make travel stress free! You can transfer between packages any time prior to
                    reserving your hotel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
