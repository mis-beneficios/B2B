@extends('layouts.pagina.app')
@section('content')
<style>
    .owl-alto{
        height: 60px;
    }
    .owl-alto img{
        max-height: 60px;
        max-width: 70%;
    }
</style>
<div class="container text-center">
    <div class="row mt-2">
        <div class="col-lg-12">
            <p class="lead text-muted mb-2">
                Here are some of the companies extending our packages to their employees. Don't wait any longer and share this opportunity with your family and friends.
            </p>
            <div class="owl-carousel owl-theme owl-alto" id="carouselExampleSlidesOnly">
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e20.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e21.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e22.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e23.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e24.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e25.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e26.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e28.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e29.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/Broward.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/cityofstpete.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/Miami-Dade-County.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/NYC_DOE_Logo_.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/Rollins-logo.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e1.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e12.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e13.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e16.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e17.png"/>
                <img alt="Companies" border="0" class="bordered" src="{{ env('STORAGE_EU') }}/img/elements/companies/e18.png"/>
            </div>
        </div>
    </div>
</div>
<section class="blog_area single-post-area mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <div class="carousel slide" data-ride="carousel" id="carouselExampleControls">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="/company/nasa" title="NASA">
                                        <img alt="NASA" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/nasa.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/military" title="ARMED FORCES">
                                        <img alt="ARMED FORCES" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/armed.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/mbb" title="MY BETTER BENEFITS">
                                        <img alt="MY BETTER BENEFITS" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/mbb.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/NJ" title="greatseal">
                                        <img alt="greatseal" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/greatseal.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/quickenloans" title="quickenloans">
                                        <img alt="quickenloans" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/quickenloans.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/broward" title="browardcountry">
                                        <img alt="bcountry" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/welcome_browardscountry.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/corporateshopping" title="CORPORATE SHOPPING">
                                        <img alt="CORPORATE SHOPPING" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/cshopping.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/benefithub" title="Benefit Hub">
                                        <img alt="Benefit Hub" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/benefit_hub.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/bestbenefits" title="Bestbenefits">
                                        <img alt="Bestbenefits" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/benefits-web.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/abenity" title="Abenity">
                                        <img alt="Abenity" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/abenity.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/perkscard" title="Perks Card">
                                        <img alt="Perks Card" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/perkscard.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/emfuze" title="Emfuze">
                                        <img alt="Emfuze" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/emfuze.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/employeenetwork" title="TEN">
                                        <img alt="TEN" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/TEN.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/UH" title="UH">
                                        <img alt="UH" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/UH.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/uky" title="UK">
                                        <img alt="UK" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/uk.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/unlv" title="UNLV">
                                        <img alt="UNLV" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/UNLV.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/pascoschools" title="pasco">
                                        <img alt="pasco" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/pasco.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/howardschools" title="HCPS">
                                        <img alt="HCPS" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/HCPS.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/sparkfly" title="Sparkfly">
                                        <img alt="Sparkfly" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/sparkfly.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/winstonsalem" title="Winston Salem">
                                        <img alt="Winston Salem" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/ws-fcs.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/fwisd" title="Fort Worth Independent School District">
                                        <img alt="Fort Worth Independent School District" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/fwisd.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/garlandisd" title="Garland Independent School District">
                                        <img alt="Garland Independent School District" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/gsid.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/vsu" title="VSU">
                                        <img alt="VSU" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/vsu.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/corporateperks" title="Corporate Perks">
                                        <img alt="Corporate Perks" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/perkscorp.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/OU" title="The University of Oklahoma">
                                        <img alt="The University of Oklahoma" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/UO.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/UTSA" title="UTSA">
                                        <img alt="UTSA" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/UTSA.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/intermountain" title="Intermountain Healthcare">
                                        <img alt="Intermountain Healthcare" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/Intermountain.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/umich" title="University of Michigan">
                                        <img alt="University of Michigan" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/Michigan.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/alachuacounty" title="Alachua County">
                                        <img alt="Alachua County" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/alachua-c.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/MDCPS" title="Miami Dade College Public Schools">
                                        <img alt="Miami Dade College Public Schools" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/Miami-schools.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/UHS" title="University Health System">
                                        <img alt="University Health System" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/UHS.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/aacps" title="Anne Arundel County Public Schools">
                                        <img alt="Anne Arundel County Public Schools" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/aacps.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/TEP" title="TEP">
                                        <img alt="TEP" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/TEP.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/tucson" title="City of Tucson">
                                        <img alt="City of Tucson" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/city-tucson.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/ESCC" title="Eastern Shore Community College">
                                        <img alt="Eastern Shore Community College" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/ESCC.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/VDOF" title="Virginia Department of Fire">
                                        <img alt="Virginia Department of Fire" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/VDOF.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/VDOC" title="Virginia Department of Corrections">
                                        <img alt="Virginia Department of Corrections" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/VDOC.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/usbrowardcollege" title="Broward College">
                                        <img alt="Broward College" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/broward-s.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/cwa3122" title="Communications Workers of America">
                                        <img alt="Communications Workers of America" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/cwa.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/aaamoving" title="AAA Moving">
                                        <img alt="AAA Moving" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/aaa.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/stateofutah" title="State Of Utah">
                                        <img alt="State of Utah" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/utah.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/nexteraenergy" title="Next Era Energy">
                                        <img alt="Next Era Energy" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/next.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/usjhs" title="Jackson Health">
                                        <img alt="Jackson Health" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/jackson.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/prinfinancial" title="Principal Financial">
                                        <img alt="Principal Financial" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/financial.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/stateofvirginia" title="State of Virginia">
                                        <img alt="State of Virginia" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/virginia.jpg"/>
                                    </a>
                                    >
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/orangecountyfl" title="Orange County Florida">
                                        <img alt="Orange County Florida" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/orange.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/nycdoe" title="NYC Department of Education">
                                        <img alt="NYC Department of Education" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/nyc.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/rollinscollege" title="Rollins College">
                                        <img alt="Rollins College" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/rollins.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/usstpetersburg" title="St Petersburg">
                                        <img alt="St Petersburg" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/st-petersb.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/company/miamidadecounty" title="Miami-Dade County">
                                        <img alt="Miami-dade County" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/miamidade.jpg"/>
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a href="/mybenefict" title="VISA">
                                        <img alt="VISA" border="0" class="img-fluid" src="{{ env('STORAGE_EU') }}/shared/home_pictures/en/VISA.jpg"/>
                                    </a>
                                </div>
                            </div>
                            <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleControls" role="button">
                                <span aria-hidden="true" class="carousel-control-prev-icon">
                                </span>
                                <span class="sr-only">
                                    Previous
                                </span>
                            </a>
                            <a class="carousel-control-next" data-slide="next" href="#carouselExampleControls" role="button">
                                <span aria-hidden="true" class="carousel-control-next-icon">
                                </span>
                                <span class="sr-only">
                                    Next
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            Testimonials
                        </h2>
                        <div class="">
                            <div class="row" style="height: 200px;">
                                <div class="col-md-12">
                                    <div class="carousel slide" data-ride="carousel" id="carouselExampleIndicators">
                                        <ol class="carousel-indicators">
                                            <li class="active" data-slide-to="0" data-target="#carouselExampleIndicators">
                                            </li>
                                            <li data-slide-to="1" data-target="#carouselExampleIndicators">
                                            </li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <h3>
                                                    Carlos Alberto Adame Soltero.
                                                </h3>
                                                <p class="lead text-justify">
                                                    This letter is to thank you for my wonderful trip.   My family and I had an awesome time and we are already planning our next vacation, so please keep sending us your amazing packages.   I am copying this letter to the HR department of the company I work for; they did a great job joining {{ env('APP_NAME_USA') }}.
                                                </p>
                                                <p class="lead">
                                                    Take care and I send you a big hug.
                                                </p>
                                            </div>
                                            <div class="carousel-item ">
                                                <h3>
                                                    Fam. Sandoval Jasso
                                                </h3>
                                                <p class="lead text-justify">
                                                    I really appreciate the benefits that {{ env('APP_NAME_USA') }} offers and provides.  Everybody was very helpful and friendly, and our trip was great.  There is no doubt that your company is trust worthy and I hope I will travel again soon with {{ env('APP_NAME_USA') }}.  I will definitely recommend your programs with my team mates.
                                                </p>
                                            </div>
                                            <div class="carousel-item ">
                                                <h3>
                                                    Fam. De la Garza
                                                </h3>
                                                <p class="lead text-justify">
                                                    Very good reservation service, I just had to wait one day after I made my reservation to get my confirmation. Travelling with my family to an excellent hotel my experience was unforgettable.
                                                </p>
                                            </div>
                                            <div class="carousel-item ">
                                                <h3>
                                                    Alejandro Ramírez Soto
                                                </h3>
                                                <p class="lead text-justify">
                                                    1 month ago I traveled with {{ env('APP_NAME_USA') }} and I just want to thank you for making my trip wonderful. Sent a greeting to the reservations department for their work and do it as quickly as possible ever.
                                                    <br/>
                                                    Thank you all and please keep me posted with your future products.
                                                </p>
                                            </div>
                                            <div class="carousel-item ">
                                                <h3>
                                                    Carla Gómez González
                                                </h3>
                                                <p class="lead text-justify">
                                                    I already bought 3 packs in 2 years and have never had a trouble of any cause, I love the organization and I hope to keep this way with {{ env('APP_NAME_USA') }}, very good hotels and excellent destinations that handle.
                                                    Congratulations
                                                </p>
                                            </div>
                                            <div class="carousel-item ">
                                                <h3>
                                                    Fam. Toscano Villanueva
                                                </h3>
                                                <p class="lead text-justify">
                                                    Excellent locations and affordable prices. As {{ env('APP_NAME_USA') }} never found one like it. Buy 4 packs for my whole family and they respected all formalities they committed to, 100% excellent advisers.
                                                    <br/>
                                                    Please keep in touch for more news.
                                                </p>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleIndicators" role="button">
                                            <span aria-hidden="true" class="carousel-control-prev-icon">
                                            </span>
                                            <span class="sr-only">
                                                Previous
                                            </span>
                                        </a>
                                        <a class="carousel-control-next" data-slide="next" href="#carouselExampleIndicators" role="button">
                                            <span aria-hidden="true" class="carousel-control-next-icon">
                                            </span>
                                            <span class="sr-only">
                                                Next
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            Encouraging travel withn your own country & abroad
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box info">
                                    <p class="text-justify mb-4">
                                        {{ env('APP_NAME_USA') }} we are committed to the workforce while promoting only domestic tourism. For the last 13 years we have partnered with world leading companies to offer their employees our unique benefit plan, the wonderful opportunity to travel. Our Program represents no cost to the company and more than a thousand agreements endorse us. Once enrolled in our Program, the employee will have a full year to visit any destination within the country during any season of the year for the same price, with 24 biweekly payments financed by {{ env('APP_NAME_USA') }} and no interest or additional charges.
                                    </p>
                                    <img alt="" class="img-fluid" src="{{ env('STORAGE_EU') }}shared/home_pictures/en/empleados.png"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section_tittle text-center">
                        <h2 class="mt-5">
                            News and Events
                        </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="carousel slide" data-ride="carousel" id="carouselNews">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a class="cycle-slide" href="-in-brazil" style="position: static; top: 0px; left: 0px; z-index: 100; opacity: 1; display: inline-block;">
                                                <img alt="Minister of Tourism in Brazil" src="{{ env('STORAGE_EU') }}img/blog/us_en/br-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-with-virginia-state-university" style="position: static; top: 0px; left: 0px; z-index: 99; display: inline-block;">
                                                <img alt="Raffle with VSU" src="{{ env('STORAGE_EU') }}img/blog/us_en/VSU.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-countys-superintendents-challenge-5k-runwalk" style="position: static; top: 0px; left: 0px; z-index: 97; display: inline-block;">
                                                <img alt="OPTUCORP ATTENDS MIAMI DADE COUNTY'S SUPERINTENDENT'S CHALLENGE 5K RUN/WAL" src="{{ env('STORAGE_EU') }}img/blog/us_en/race-5k.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-of-homestead" style="position: static; top: 0px; left: 0px; z-index: 96; display: inline-block;">
                                                <img alt="Optucorp supporting the City of Homestead" src="{{ env('STORAGE_EU') }}img/blog/us_en/homestead.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 95; display: inline-block;">
                                                <img alt="Florida department of health " src="{{ env('STORAGE_EU') }}img/blog/us_en/fl.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-event" style="position: static; top: 0px; left: 0px; z-index: 94; display: inline-block;">
                                                <img alt="Fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/fair-event.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide" href="-wellness-fair-event" style="position: static; top: 0px; left: 0px; z-index: 93; display: inline-block;">
                                                <img alt="Winners fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/w-fair.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-with-jackson-health-system" style="position: static; top: 0px; left: 0px; z-index: 92; display: inline-block;">
                                                <img alt="Winner raffle Jackson health" src="{{ env('STORAGE_EU') }}img/blog/us_en/jackson.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-the-raffle-with-miami-dade-county" style="position: static; top: 0px; left: 0px; z-index: 91; display: inline-block;">
                                                <img alt="Winner Raffle Miami-Dade" src="{{ env('STORAGE_EU') }}img/blog/us_en/miami-dade.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-lorenas-texas-links" style="position: static; top: 0px; left: 0px; z-index: 90; display: inline-block;">
                                                <img alt="Optucorp openings horizons" src="{{ env('STORAGE_EU') }}img/blog/us_en/texas_lorena_ochoa-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-in-florida" style="position: static; top: 0px; left: 0px; z-index: 89; display: inline-block;">
                                                <img alt="Excellency ambassador Florida" src="{{ env('STORAGE_EU') }}img/blog/us_en/fl-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-ambassadors" style="position: static; top: 0px; left: 0px; z-index: 88; display: inline-block;">
                                                <img alt="Strengthening ties with ambassadors" src="{{ env('STORAGE_EU') }}img/blog/us_en/embajadores-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 87; display: inline-block;">
                                                <img alt="Alliance Magazine" src="{{ env('STORAGE_EU') }}img/blog/us_en/alliance-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-america" style="position: static; top: 0px; left: 0px; z-index: 86; display: inline-block;">
                                                <img alt="Working trip to south america" src="{{ env('STORAGE_EU') }}img/blog/us_en/sudamerica-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-in-brazil" style="position: static; top: 0px; left: 0px; z-index: 100; opacity: 1; display: inline-block;">
                                                <img alt="Minister of Tourism in Brazil" src="{{ env('STORAGE_EU') }}img/blog/us_en/br-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-with-virginia-state-university" style="position: static; top: 0px; left: 0px; z-index: 99; display: inline-block;">
                                                <img alt="Raffle with VSU" src="{{ env('STORAGE_EU') }}img/blog/us_en/VSU.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-countys-superintendents-challenge-5k-runwalk" style="position: static; top: 0px; left: 0px; z-index: 97; display: inline-block;">
                                                <img alt="OPTUCORP ATTENDS MIAMI DADE COUNTY'S SUPERINTENDENT'S CHALLENGE 5K RUN/WAL" src="{{ env('STORAGE_EU') }}img/blog/us_en/race-5k.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-of-homestead" style="position: static; top: 0px; left: 0px; z-index: 96; display: inline-block;">
                                                <img alt="Optucorp supporting the City of Homestead" src="{{ env('STORAGE_EU') }}img/blog/us_en/homestead.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 95; display: inline-block;">
                                                <img alt="Florida department of health " src="{{ env('STORAGE_EU') }}img/blog/us_en/fl.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-event" style="position: static; top: 0px; left: 0px; z-index: 94; display: inline-block;">
                                                <img alt="Fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/fair-event.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-wellness-fair-event" style="position: static; top: 0px; left: 0px; z-index: 93; display: inline-block;">
                                                <img alt="Winners fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/w-fair.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-with-jackson-health-system" style="position: static; top: 0px; left: 0px; z-index: 92; display: inline-block;">
                                                <img alt="Winner raffle Jackson health" src="{{ env('STORAGE_EU') }}img/blog/us_en/jackson.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-the-raffle-with-miami-dade-county" style="position: static; top: 0px; left: 0px; z-index: 91; display: inline-block;">
                                                <img alt="Winner Raffle Miami-Dade" src="{{ env('STORAGE_EU') }}img/blog/us_en/miami-dade.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-lorenas-texas-links" style="position: static; top: 0px; left: 0px; z-index: 90; display: inline-block;">
                                                <img alt="Optucorp openings horizons" src="{{ env('STORAGE_EU') }}img/blog/us_en/texas_lorena_ochoa-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide cycle-slide-active" href="-in-florida" style="position: static; top: 0px; left: 0px; z-index: 89; display: inline-block;">
                                                <img alt="Excellency ambassador Florida" src="{{ env('STORAGE_EU') }}img/blog/us_en/fl-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-ambassadors" style="position: static; top: 0px; left: 0px; z-index: 88; display: inline-block;">
                                                <img alt="Strengthening ties with ambassadors" src="{{ env('STORAGE_EU') }}img/blog/us_en/embajadores-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 87; display: inline-block;">
                                                <img alt="Alliance Magazine" src="{{ env('STORAGE_EU') }}img/blog/us_en/alliance-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-america" style="position: static; top: 0px; left: 0px; z-index: 86; display: inline-block;">
                                                <img alt="Working trip to south america" src="{{ env('STORAGE_EU') }}img/blog/us_en/sudamerica-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-in-brazil" style="position: static; top: 0px; left: 0px; z-index: 100; opacity: 1; display: inline-block;">
                                                <img alt="Minister of Tourism in Brazil" src="{{ env('STORAGE_EU') }}img/blog/us_en/br-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="-with-virginia-state-university" style="position: static; top: 0px; left: 0px; z-index: 99; display: inline-block;">
                                                <img alt="Raffle with VSU" src="{{ env('STORAGE_EU') }}img/blog/us_en/VSU.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 97; display: inline-block;">
                                                <img alt="OPTUCORP ATTENDS MIAMI DADE COUNTY'S SUPERINTENDENT'S CHALLENGE 5K RUN/WAL" src="{{ env('STORAGE_EU') }}img/blog/us_en/race-5k.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 96; display: inline-block;">
                                                <img alt="Optucorp supporting the City of Homestead" src="{{ env('STORAGE_EU') }}img/blog/us_en/homestead.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 95; display: inline-block;">
                                                <img alt="Florida department of health " src="{{ env('STORAGE_EU') }}img/blog/us_en/fl.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 94; display: inline-block;">
                                                <img alt="Fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/fair-event.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 93; display: inline-block;">
                                                <img alt="Winners fall into wellness fair event" src="{{ env('STORAGE_EU') }}img/blog/us_en/w-fair.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 92; display: inline-block;">
                                                <img alt="Winner raffle Jackson health" src="{{ env('STORAGE_EU') }}img/blog/us_en/jackson.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 91; display: inline-block;">
                                                <img alt="Winner Raffle Miami-Dade" src="{{ env('STORAGE_EU') }}img/blog/us_en/miami-dade.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 90; display: inline-block;">
                                                <img alt="Optucorp openings horizons" src="{{ env('STORAGE_EU') }}img/blog/us_en/texas_lorena_ochoa-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 89; display: inline-block;">
                                                <img alt="Excellency ambassador Florida" src="{{ env('STORAGE_EU') }}img/blog/us_en/fl-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 88; display: inline-block;">
                                                <img alt="Strengthening ties with ambassadors" src="{{ env('STORAGE_EU') }}img/blog/us_en/embajadores-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 87; display: inline-block;">
                                                <img alt="Alliance Magazine" src="{{ env('STORAGE_EU') }}img/blog/us_en/alliance-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                            <a class="cycle-slide" href="" style="position: static; top: 0px; left: 0px; z-index: 86; display: inline-block;">
                                                <img alt="Working trip to south america" src="{{ env('STORAGE_EU') }}img/blog/us_en/sudamerica-en.png" style="width: 232px; height: 169px;"/>
                                            </a>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" data-slide="prev" href="#carouselNews" role="button">
                                        <span aria-hidden="true" class="carousel-control-prev-icon">
                                        </span>
                                        <span class="sr-only">
                                            Previous
                                        </span>
                                    </a>
                                    <a class="carousel-control-next" data-slide="next" href="#carouselNews" role="button">
                                        <span aria-hidden="true" class="carousel-control-next-icon">
                                        </span>
                                        <span class="sr-only">
                                            Next
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include('pagina.usa.elementos.aside')
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#carouselExampleSlidesOnly').owlCarousel({
            loop:true,
            center: true,
            responsiveClass:true,
            touchDrag:true,
            mouseDrag:true,
            nav:true,
            autoplay:true,
            smartSpeed:100,
            responsive:{
                0:{
                    items:4
                },
                600:{
                    items:8
                },
                1000:{
                    items:12
                }
            }
        });   

        $('#noticias').owlCarousel({
            loop:true,
            center: true,
            responsiveClass:true,
            touchDrag:true,
            mouseDrag:true,
            nav:true,
            autoplay:true,
            smartSpeed:100,
            responsive:{
                0:{
                    items:3
                },
                600:{
                    items:8
                },
                1000:{
                    items:12
                }
            }
        });   
    });
</script>
@endsection
