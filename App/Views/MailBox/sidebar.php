<div class="menu-panel col-md-4 col-lg-3 col-xl-2 p-0 border-right">
    <div class="top-bar logo icon-lg align-self-center">
        <div class="float-left icon-lg">
            <i class="fas fa-envelope"></i>
        </div>
        <span class="side-ctn" ><b>mail</b>box</span>
    </div>

    <div class="left-panel p-20 text-center">
        <a  href="<?= BASE_URL . PANEL; ?>/compose" class="btn btn-lg btn-compose"> <i class="far fa-edit"></i><span class="side-ctn">compose</span> </a>

        <div class="widget menu text-left">
            <ul class="list-unstyled" >
                <li><a href="<?= BASE_URL.PANEL; ?>/inbox"><div> <i class="fas fa-inbox mr-1"></i> <span class="side-ctn">Inbox</span><span class="count">10</span> </div></a></li>
                <li><a href="<?= BASE_URL.PANEL; ?>/draft"><div> <i class="fas fa-folder mr-1"></i> <span class="side-ctn">Draft</span><span class="count">30</span></div></a></li>
                <li><a href="<?= BASE_URL.PANEL; ?>/sent"><div> <i class="fas fa-paper-plane mr-1"></i> <span class="side-ctn">Sent</span><span class="count">0</span></div></a></li>
                <li><a href="<?= BASE_URL.PANEL; ?>/trash"><div> <i class="fas fa-trash mr-1"></i> <span class="side-ctn">Trash</span></div></a></li>
            </ul>
        </div>

        <div class="widget folder text-left d-none d-xl-block">
            <a href="#" class="add">+ New Folder</a>

            <h6><b>My Folder</b></h6>

            <ul class="list-unstyled">
                <li><a href="#"> <i class="fas fa-inbox mr-1"></i> <span class="side-ctn">Social</span> <span class="count">0</span></a></li>
                <li><a href="#"> <i class="fas fa-folder mr-1"></i> <span class="side-ctn">Coding</span> <span class="count">0</span></a></li>
            </ul>
        </div>

        <div class="widget folder text-left d-none d-xl-block">
            <a href="#" class="add">+ Add User</a>
            <h6><b>Contacts</b></h6>

            <ul class="list-unstyled user">
                <li><a href="#"><i class="fas fa-circle active mr-1"></i> Louise<span class="side-ctn"> Kate Lumaad</span> </a></li>
                <li><a href="#"><i class="fas fa-circle busy mr-1"></i> Socrates<span class="side-ctn"> Itumay</span> </a></li>
                <li><a href="#"><i class="fas fa-circle offline mr-1"></i> Isidore<span class="side-ctn" > Dilao</span> </a></li>
            </ul>
        </div>


    </div>

</div>