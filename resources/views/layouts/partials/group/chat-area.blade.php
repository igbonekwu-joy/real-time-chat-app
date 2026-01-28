<div class="main">
    <div class="tab-content" id="nav-tabContent">
        <!-- Start of Babble -->
        <div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
            <!-- Start of Chat -->
            <div class="chat" id="chat1">
                <div class="no-message-container">
                    <div class="no-message">
                        <p>Welcome!. Share what's on your mind with other people</p>
                    </div>
                </div>

                <div class="chat-container" style="display: none;">
                    <div class="top">
                        <div class="container">
                            <div class="col-md-12">
                                <div class="inside">
                                    <a href="#">
                                        <img class="avatar-md group-img" src="" data-toggle="tooltip" data-placement="top" title="Group Image" alt="avatar">
                                    </a>

                                    <div class="data">
                                        <h5>
                                            <a href="#" class="group-name"></a>
                                        </h5>
                                    </div>
                                    <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
                                    <div class="dropdown">
                                        <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" id="addMemberBtn" data-toggle="modal" data-target="#addMemberModal" class="dropdown-item">
                                                <i class="material-icons">person_add</i>Add Member
                                            </button>

                                            <button class="dropdown-item" id="clearHistory">
                                                <i class="material-icons">clear</i>Clear History
                                            </button>
                                            <button class="dropdown-item" id="leaveGroup">
                                                <i class="material-icons">block</i>Leave Group
                                            </button>
                                            <button class="dropdown-item" id="deleteGroup">
                                                <i class="material-icons">delete</i>Delete Group
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content" id="content">
                        <div class="container">
                            <div class="col-md-12 all-messages">
                                <div class="loader-container">
                                    <div class="loader">
                                        <span class="spinner-border spinner-border-sms" role="status"></span>
                                    </div>
                                </div>

                                {{-- messages go here --}}

                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="col-md-12">
                            <div class="chat-input-wrapper position-relative">
                                <div class="bottom">
                                    <form class="position-relative w-100">
                                        <textarea class="form-control message-content" placeholder="Start typing for reply..." rows="1"></textarea>
                                        <button type="submit" class="btn send send-message"><i class="material-icons">send</i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Chat -->
        </div>
        <!-- End of Babble -->
    </div>
</div>
