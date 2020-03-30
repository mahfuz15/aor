

<!-- <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div> -->

<div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRequestLabel">Request a Quote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="form-group">
                        <!-- <label for="appointment_name" class="text-black">Full Name</label> -->
                        <input type="text" class="form-control" id="appointment_name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <!-- <label for="appointment_email" class="text-black">Email</label> -->
                        <input type="text" class="form-control" id="appointment_email" placeholder="Email">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="appointment_date" class="text-black">Date</label> -->
                                <input type="text" class="form-control" id="appointment_date" placeholder="Date">
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="appointment_time" class="text-black">Time</label> -->
                                <input type="text" class="form-control" id="appointment_time" placeholder="Time">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <!-- <label for="appointment_message" class="text-black">Message</label> -->
                        <textarea name="" id="appointment_message" class="form-control" cols="30" rows="10" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Get a Quote" class="btn btn-primary">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
