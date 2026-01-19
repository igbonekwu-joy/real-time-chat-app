<div class="container bootstrap snippets bootdey.com">
    <div class="row">
        <div class="col-md-12">
            <!-- start:chat room -->
            <div class="box">
                <div class="chat-room">
                    @if($showSidebar)
                        <div class="sidebar-backdrop" wire:click="toggleSidebar"></div>
                    @endif
                    <!-- start:aside kiri chat room -->
                    @include('layouts.partials.sidebar')
                    <!-- end:aside kiri chat room -->

                    <!-- start:aside tengah chat room -->
                    <aside class="tengah-side">
                        <div class="chat-room-head">
                            <button
                                wire:click="toggleSidebar"
                                class="mobile-nav-btn"
                            >
                                <i class="fa fa-bars"></i>
                            </button>

                            <h3>Air Koler</h3>
                            <form action="#" class="pull-right position">
                                <input type="text" placeholder="Search" class="form-control search-btn ">
                            </form>
                        </div>
                        <div class="group-rom">
                            <div class="first-part odd">Jonathan Smith</div>
                            <div class="second-part">Hello Cendy are you there?</div>
                            <div class="third-part">12:30</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part">Cendy Andrianto</div>
                            <div class="second-part">Yoman Smith. Please proceed</div>
                            <div class="third-part">12:31</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part odd">Jonathan Smith</div>
                            <div class="second-part">I want to share a file using chatroom</div>
                            <div class="third-part">12:32</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part">Cendy Andrianto</div>
                            <div class="second-part">oh sure. please send</div>
                            <div class="third-part">12:32</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part odd">Jonathan Smith</div>
                            <div class="second-part"><a href="##">search_scb_dialog.jpg</a> <span class="text-muted">46.8KB</span> <p>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" class="img-responsive"></p></div>
                            <div class="third-part">12:32</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part">Cendy Andrianto</div>
                            <div class="second-part">Fantastic job, love it :)</div>
                            <div class="third-part">12:32</div>
                        </div>
                        <div class="group-rom">
                            <div class="first-part odd">Jonathan Smith</div>
                            <div class="second-part">Thanks</div>
                            <div class="third-part">12:33</div>
                        </div>
                        <footer>
                            <div class="chat-txt">
                                <input type="text" class="form-control">
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-white" data-original-title="" title=""><i class="fa fa-meh-o"></i></button>
                                <button type="button" class="btn btn-white" data-original-title="" title=""><i class=" fa fa-paperclip"></i></button>
                            </div>
                            <button class="btn btn-danger" data-original-title="" title="">Send</button>
                        </footer>
                    </aside>
                    <!-- end:aside tengah chat room -->

                    <!-- start:aside kanan chat room -->
                    <aside class="kanan-side">
                        <div class="user-head">
                            <a href="##" class="chat-tools btn-success"><i class="fa fa-cog"></i> </a>
                            <a href="##" class="chat-tools btn-key"><i class="fa fa-key"></i> </a>
                        </div>
                        <div class="invite-row">
                            <h4 class="pull-left">People</h4>
                        </div>
                        <ul class="chat-available-user">
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-success"></i>
                                    Jonathan Smith
                                    <span class="text-muted">3h:22m</span>
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-success"></i>
                                    Jhone Due
                                    <span class="text-muted">1h:2m</span>
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-success"></i>
                                    Cendy Andrianto
                                    <span class="text-muted">2h:32m</span>
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-danger"></i>
                                    Surya Nug
                                    <span class="text-muted">3h:22m</span>
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-warning"></i>
                                    Monke Lutfy
                                    <span class="text-muted">1h:12m</span>
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-muted"></i>
                                    Steve Jobs
                                    <!--<span class="text-muted">3h:22m</span>-->
                                </a>
                            </li>
                            <li>
                                <a href="#chat-room.html">
                                    <i class="fa fa-circle text-muted"></i>
                                    Jonathan Smith
                                    <!--<span class="text-muted">3h:22m</span>-->
                                </a>
                            </li>
                        </ul>
                        <footer>
                            <a href="##" class="guest-on">
                                <i class="fa fa-check"></i>
                                Guest Access On
                            </a>
                        </footer>
                    </aside>
                    <!-- end:aside kanan chat room -->

                </div>
            </div>
            <!-- end:chat room -->
        </div>
    </div>
</div>
