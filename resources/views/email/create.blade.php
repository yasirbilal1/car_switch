@include('header')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h3>Email Compose</h3>
          
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">                                       <i data-feather="home"></i></a></li>
            <li class="breadcrumb-item">Email</li>
            <li class="breadcrumb-item active"> Email Compose</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="email-wrap">
      <div class="row">
        <div class="col-xl-3 col-md-6 box-col-6">
          <div class="email-left-aside">
            <div class="card">
              <div class="card-body">
                <div class="email-app-sidebar">
                  <div class="media">
                    <div class="media-size-email"><img class="me-3 rounded-circle" src="../assets/images/user/user.png" alt=""></div>
                    <div class="media-body">
                      <h6 class="f-w-600">{{Auth::user()->first_name}}</h6>
                      <p>{{Auth::user()->email}}</p>
                    </div>
                  </div>
                  <ul class="nav main-menu" role="tablist">
                    <li class="nav-item"><a class="btn-primary btn-block btn-mail" id="pills-darkhome-tab" data-bs-toggle="pill" href="#pills-darkhome" role="tab" aria-controls="pills-darkhome" aria-selected="true"><i class="icofont icofont-envelope me-2"></i> NEW MAIL</a></li>
                    <li class="nav-item"><a class="show" id="pills-darkprofile-tab" data-bs-toggle="pill" href="#pills-darkprofile" role="tab" aria-controls="pills-darkprofile" aria-selected="false"><span class="title"><i class="icon-import"></i> Inbox</span><span class="badge pull-right">(236)</span></a></li>
                    <li>
                      <hr>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-9 col-md-6">
          <div class="email-right-aside">
            <div class="card email-body">
              <div class="row">
                <div class="col-xl-4 col-md-12 box-md-12 pr-0">
                  <div class="pe-0 b-r-light"></div>
                  <div class="email-top">
                    <div class="row">
                      <div class="col">
                        <h5>Inbox</h5>
                      </div>
                      <div class="col text-end">
                        <div class="dropdown">
                          <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">More</button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="inbox">
                    @foreach($inbox as $key => $value)        
                      @if($value['is_owner'] == 0)
                        <div class="media active" id="inbox_click_event">
                          <div class="media-size-email"><img class="me-3 rounded-circle" src="../assets/images/user/user.png" alt=""></div>
                          <div class="media-body">
                            <h6>{{$value['user']['name']}}<small> <span>{{date('d-m-Y h:i:s', strtotime($value['created_at']))}}</span></small></h6>
                            <p>{{$value['email_content']['subject']}}</p>
                            <input type="hidden" id="email_parent_id" class="email_parent_id" name="email_parent_id" value="{{$value['email_id']}}" />
                          </div>
                        </div>
                      @endif
                      @if($value['is_owner'] == 1 && isset($value['email_details'][0]))
                        <div class="media active" id="inbox_click_event">
                          <div class="media-size-email"><img class="me-3 rounded-circle" src="../assets/images/user/user.png" alt=""></div>
                          <div class="media-body">
                            @if(isset($value['is_owner'])) 
                              <h6>{{$value['user']['name']}}<small><span>{{date('d-m-Y h:i:s', strtotime($value['user']['created_at']))}}</span></small></h6>
                            @endif
                            <p>{{$value['email_content']['subject']}}</p>
                            <input type="hidden" id="email_parent_id" name="email_parent_id" value="{{$value['email_id']}}" />
                          </div>
                        </div>
                      @endif
                    @endforeach 
                  </div>
                </div>
                <div class="col-xl-8 col-md-12 box-md-12 pl-0">
                  <div class="email-right-aside">
                    <div class="email-body radius-left">
                      <div class="ps-0">
                        <div class="tab-content">
                          <div class="tab-pane fade active show" id="pills-darkhome" role="tabpanel" aria-labelledby="pills-darkhome-tab">
                            <div class="email-compose">
                              <div class="email-top compose-border">
                                <div class="row">
                                  <div class="col-sm-8 xl-50">
                                    <h4 class="mb-0">New Message</h4>
                                  </div>
                                  <!-- <div class="col-sm-4 btn-middle xl-50">
                                    <button class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0 w-100" type="button"><i class="fa fa-paper-plane me-2"></i> SEND</button>
                                  </div> -->
                                </div>
                              </div>
                              <div class="email-wrapper">
                                <form class="theme-form" action="{{ route('email.store') }}" method="post" autocomplete="off">
                                  @csrf
                                  @if ($errors->any())
                                      <div class="alert alert-danger">
                                          <ul>
                                              @foreach ($errors->all() as $error)
                                                  <li>{{ $error }}</li>
                                              @endforeach
                                          </ul>
                                      </div>
                                  @endif
                                  <div class="mb-3">
                                    <label class="col-form-label pt-0" for="exampleInputEmail1">To</label>
                                    <input class="form-control" id="exampleInputEmail1" type="email" name="email_to" multiple>
                                  </div>
                                  <!-- <article class="fullScreen80Flex contactForm ">
                                    <div class="formContainer">
                                      <div class="heading ">
                                          <h1> Enter Emails </h1>
                                          <p>Hit <kbd>Enter</kbd> or type <kbd>,</kbd> or hit <kbd>space</kbd> after you enter an email</p>
                                      </div>
                                      <div id="contact-us" class="form ">
                                          <div id="emailsList">
                                            <ul>
                                            </ul>
                                          </div>
                                          <div id="contactForm">
                                            <p data-error="email" class="errors"></p>
                                            <input value="" placeholder="youare@awesome.com" type="text" id="email">
                                          </div>
                                          <p id="emailJson"></p>
                                      </div>
                                    </div>
                                  </article> -->
                                  <div class="mb-3">
                                    <label class="col-form-label pt-0" for="email_cc">CC</label>
                                    <input class="form-control" id="email_cc" type="email" name="email_cc" multiple>
                                  </div>
                                  <!-- <div class="mb-3">
                                    <label class="col-form-label pt-0" for="email_bcc">BCC</label>
                                    <input class="form-control" id="email_bcc" type="email" name="email_bcc" multiple>
                                  </div> -->
                                  <div class="mb-3">
                                    <label for="email_subject">Subject</label>
                                    <input class="form-control" id="email_subject" type="text" name="email_subject">
                                  </div>
                                  <div>
                                    <label class="">Message</label>
                                    <textarea id="email_content" name="email_content" cols="50" rows="5">                                                            </textarea>
                                  </div>
                                  <div class="col-sm-4 btn-middle xl-50">
                                    <input type="submit" class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0 w-100" />
                                    <!-- <button class="btn btn-primary btn-block btn-mail text-center mb-0 mt-0 w-100" type="button"><i class="fa fa-paper-plane me-2"></i> SEND</button> -->
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade " id="pills-darkprofile" role="tabpanel" aria-labelledby="pills-darkprofile-tab">
                            <div class="email-content">
                              <div class="email-top">
                                <div class="row">
                                  <div class="col-md-6 xl-100 col-sm-12">
                                    <div class="media"><img class="me-3 rounded-circle" src="../assets/images/user/user.png" alt="">
                                      <div class="media-body">
                                        <h6 id="sender_name"><small><span id="sender_time"></span></small></h6>
                                        <p id="sender_subject"></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-12 xl-100">
                                    <div class="float-end d-flex">
                                      <p class="user-emailid"></p><i class="fa fa-star-o f-18 mt-1"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="email-wrapper">
                                <p class="m-b-20" id="parent_email_content"></p>
                                <div class="m-b-20" id="email_replies_div"></div>
                                <div class="m-b-20" id="my_replies_div"></div>
                                <hr>
                                <div class="action-wrapper">
                                  <ul class="actions">
                                    <!-- <li><a class="text-muted" href="#"><i class="fa fa-reply me-2"></i>Reply</a></li> -->
                                    <li><a class="text-muted" id="reply_all_id"><i class="fa fa-reply-all me-2"></i>Reply All</a></li> <p>This will send a message to the users using the model class.</p>
                                    <!-- <li><a class="text-muted" href="#"><i class="fa fa-share me-2"></i></a>Forward</li> -->
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('footer')
      