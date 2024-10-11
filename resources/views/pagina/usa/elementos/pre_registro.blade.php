<style>
    .fondomodal {
        background-image: url('https://media.istockphoto.com/photos/passport-airplane-tickets-yellow-suitcase-sun-hat-and-protective-face-picture-id1315152008?k=20&m=1315152008&s=612x612&w=0&h=fwOVEEzS9wRcRuUAjA7HFPZM-XQjmou1JOpL_j1CLCo=');
        color: white;
        /*display: block;*/
        margin-left: auto;
        margin-right: auto;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .overlay_h {
        background: rgba(0, 0, 0, 0.23);
    }

    .modal-title {
        color: white;
    }
    .overlay_h {
        opacity: .3; 
    }
</style>
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade mt-5 pt-5 mb-5 pb-5" data-backdrop="static" data-keyboard="false" id="moda_pre_registro_usa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="fondomodal">
                <div class="overlay_h">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Register to receive our special offers
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <form id="form_register_alert_usa">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputEmail4">
                                            First Name
                                        </label>
                                        <input class="form-control" id="first_name" name="first_name" placeholder="First Name" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputPassword4">
                                            Last Name
                                        </label>
                                        <input class="form-control" id="last_name" name="last_name" placeholder="Last Name" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputEmail4">
                                            Phone
                                        </label>
                                        <input class="form-control" id="phone" name="phone" placeholder="0123456789" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label for="inputPassword4">
                                            Email
                                        </label>
                                        <input class="form-control" id="email" name="email" placeholder="example@mail.com" type="text">
                                        </input>
                                    </div>
                                    {{--
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">
                                            Enter your Company Name
                                        </label>
                                        <input class="form-control" id="company" name="company" placeholder="Company Name" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">
                                            What destination would you like to visit?
                                        </label>
                                        <input class="form-control" id="place" name="place" placeholder="Destination" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-6">
                                        <label for="inputCity">
                                            People who travel?
                                        </label>
                                        <input class="form-control" id="num_people" name="num_people" type="text">
                                        </input>
                                    </div>
                                    <div class="form-group col-lg-5 col-md-6">
                                        <label for="inputZip">
                                            Date you want to travel?
                                        </label>
                                        <input class="form-control" id="date_travel" name="date_travel" type="date">
                                        </input>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
