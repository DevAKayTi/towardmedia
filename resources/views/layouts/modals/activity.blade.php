<div class="modal fade" id="modal-block-popout" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">

    <div class="modal-dialog modal-dialog-popout modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-capitalize" id="activit-title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="container">
                        <div class="form-group mt-3 ">
                            <label> Log Name</label>
                            <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2" id="log-name" disabled>
                        </div>
                        <div class="form-group mt-3 ">
                            <label> Event</label>
                            <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2" id="event" disabled>
                        </div>
                        <div class="form-group mt-3  d-none" id="deletedTitle-row">
                            <label> Deleted Title</label>
                            <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2 " id="deletedTitle" disabled>
                        </div>
                        <div class="form-group mt-3 mb-3 ">
                            <label> Description</label>
                            <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2" id="description" disabled>
                            <a href="" class="d-none  " id="desc-href"></a>
                            <span class=" text-danger d-none " id="already-delete-post">***This post has been already deleted.</span>
                        </div>
                        <div class="form-group mt-3 d-none " id="ip-row">
                            <label> Ip</label>
                            <div class=" d-flex justify-content-around align-items-center  ">
                                <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2" id="ip" disabled>
                                <button class=" ms-3 btn btn-primary" id="showIpInfo" href="#"> <i class="fa fa-eye nav-main-link-icon"></i> </button>
                            </div>
                        </div>
                        <div class="form-group mt-3 " id="ip-row">
                            <label> Date</label>
                            <input type="text" class="form-control mb-2 text-capitalize form-control-alt mt-2" id="date" disabled>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>
