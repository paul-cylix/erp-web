@extends('layouts.base')
@section('title', 'Petty Cash Request') 
@section('content')

<div class="row">
    @if(Session::get('form_submitted'))
    <Script>
        swal({
            text: "{!! Session::get('form_submitted') !!}",
            icon: "success",
            closeOnClickOutside: false,
            closeOnEsc: false,        
            })
            .then(okay => {
            if (okay) {
            window.location.href = "/in-progress";
            }});
        </Script> 
    @endif
    @if(Session::get('form_error'))
    <Script>
        swal({
            text: "{!! Session::get('form_error') !!}",
            icon: "error",
            closeOnClickOutside: false,
            closeOnEsc: false,               
            })
    </Script>
    @endif



{{-- Table Check First two editable all --}}
@if (!empty($tableCheck[0]->tableCheck))


        @if (!empty($initRecipientCheck))
        <div class="col-md-12" style="margin: -20px 0 20px 0 " >
            <div class="form-group" style="margin: 0 -5px 0 -5px;">
                    <div class="col-md-1 float-left"><a href="/clarifications" ><button type="button" style="width: 100%;" class="btn btn-dark" >Back</button></a></div>  
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-primary float-right" disabled>Restart</button></div>                   
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" data-toggle="modal" data-target="#replyModal" >Reply</button></div>     
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-info float-right" disabled>Clarify</button></div>                    
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-secondary float-right " data-toggle="modal" data-target="#withdrawModal" >Withdraw</button></div>        
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-danger float-right" disabled>Reject</button></div>      
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-success float-right" disabled >Approve</button></div>           
            </div> 
        </div> 

        <!-- Modal Withdraw-->
        <div class="modal fade"  id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark" >
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('cla.withdraw.pc') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                     
                                <label for="withdrawRemarks">Remarks</label>
                                <div class="card-body">
                                    <div class="form-floating">
                                        <input type="hidden" value="{{ $post->id }}" name="pcID">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="withdrawRemarks" id="withdrawRemarks" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        {{-- End Withdraw Modal --}}

        <!-- Modal Reply-->
        <div class="modal fade"  id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark" >
                <h5 class="modal-title" id="replyModalLabel">Reply Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
    <form action="{{ route('cla.reply.pc') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                     
                                <label for="replyRemarks">Remarks</label>
                                <div class="card-body">
                                    <div class="form-floating">
                                   
                                        <textarea class="form-control" placeholder="Leave a comment here" name="replyRemarks" id="replyRemarks" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
     
            </div>
            </div>
        </div>
        {{-- End Reply Modal --}}


        <div class="col-md-12">
            <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title">Petty Cash Request</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="referenceNumber">Reference Number</label>
                                <input type="text" class="form-control" value="{{ $post->REQREF }} " name="referenceNumber" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateRequested">Requested Date</label>
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" id="dateRequested" name="dateRequested" value="{{ date('m/d/Y') }}"  class="form-control datetimepicker-input" readonly>
                                    <div class="input-group-append" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <input id="RMName" name="RMName" type="hidden" value="{{ $post->REPORTING_MANAGER }}" class="form-control" placeholder="" >
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="reportingManager">Reporting Manager</label>
                                <select id="reportingManager" name="reportingManager" class="form-control select2 select2-default"  data-dropdown-css-class="select2-default" style="width: 100%;" onchange="getRMName(this)">
                                    <option selected value='{{ $mgrsId }}' >{{ $post->REPORTING_MANAGER }}</option>
                                    @foreach ($mgrs as $rm)
                                        <option value="{{$rm->RMID}}">{{$rm->RMName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('reportingManager'){{ $message }}@enderror</span>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="initiator">Initiator</label>
                                <input id="initiator" name="initiator" type="text" class="form-control" value="{{ $initName }}"  readonly >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="projectName">Project Name</label>
                                {{-- <input id="projectName" name="projectName" type="text" class="form-control" value="{{ $post->PROJECT }}"  > --}}
                                <select id="projectName" name="projectName" class="form-control select2 select2-default" data-dropdown-css-class="select2-default" style="width: 100%;" onchange="showDetails(this.value)">
                                    <option selected value='{{ $post->PRJID }}' >{{ $post->PROJECT }}</option>
                                    @foreach ($projects as $prj)
                                         <option value="{{$prj->project_id}}">{{$prj->project_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('projectName'){{ $message }}@enderror</span>

                            </div>
                        </div>
                        
                        {{-- Hidden elements --}}
                        <input type="hidden" name="guid" value="{{ $post->GUID }}">
                        <input type="hidden" name="pcID" value="{{ $post->id }}">
                        <input type="hidden" value="" name="deleteAttached" id="deleteAttached">
                        <input id="clientID" name="clientID" type="hidden" class="form-control" placeholder="" value="{{ $post->CLIENT_ID }}" >
                        <input id="mainID" name="mainID" type="hidden" class="form-control" placeholder="" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientName">Client Name</label>
                                <input id="clientName" name="clientName" type="text" class="form-control" value="{{ $post->CLIENT_NAME }}" readonly >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payeeName">Payee Name</label>
                                <input id="payeeName" name="payeeName" type="text" class="form-control" value="{{ $post->PAYEE }}"  >
                                <span class="text-danger">@error('payeeName'){{ $message }}@enderror</span>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateNeeded">Date Needed</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest" aria-readonly="true" data-date-format='YYYY-MM-DD'>
                                        <input type="input" id="dateNeeded"  name="dateNeeded" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $post->TRANS_DATE }}" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker"  >
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>                         
                                </div>
                                <span class="text-danger">@error('dateNeeded'){{ $message }}@enderror</span>

                            </div>         
                        </div>

         
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input id="amount" name="amount" type="text" class="form-control" value="{{ $post->REQUESTED_AMT }}">
                                <span class="text-danger">@error('amount'){{ $message }}@enderror</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="purpose">Purpose</label>
                                <textarea style="resize:none" class="form-control" id="purpose" name="purpose" rows="4" >{{ $post->DESCRIPTION }}</textarea>
                                <span class="text-danger">@error('purpose'){{ $message }}@enderror</span>
                            </div>                              
                        </div>
                    </div>

                    {{-- Attachments --}}
                    <label class="btn btn-primary" style="font-weight:normal;">
                        Attach files <input type="file" name="file[]" class="form-control-file" id="customFile" multiple hidden>
                    </label>
    </form>           

                    {{-- Attachments of no edit --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gray">
        
                                <div class="card-header" style="height:50px;">
                                    <div class="row ">
                                        <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                    </div>
                                </div>
                                {{-- Card body --}}
                                <div class="card-body" >
                
                                    {{-- Table attachments --}}
                                    <div class="table-responsive" style="max-height: 300px; overflow: auto; display:inline-block;"  >
                                        <table id= "attachmentsTable"class="table table-hover" >
                                            <thead >
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                {{-- <th>Size</th> --}}
                                                <th>Temporary Path</th>
                                                <th>Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody >
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- Table attachments End--}}                                                               
                                </div>
                                {{-- Card body END --}}                                  
                            </div>
                        </div>
                    </div>
                    {{-- End Attachments --}}

                    {{-- Show only if Not empty --}}
                    @if (!empty($attachmentsDetails))
                            {{-- Gallery --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-gray">

                                        <div class="card-header" style="height:50px;">
                                            <div class="row ">
                                                <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                            </div>
                                        </div>
                                        <div class="card-body" >
                                            <div class="row">       
                                                @foreach ($attachmentsDetails as $file)
                                                <div class="col-sm-2" >

                                                    <div class="dropdown show" >
                                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute; right: 0px; top: 0px; z-index: 999; "></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" target="_blank" >View</a>
                                                            <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" download="{{ $file->filename }}" >Download</a>
                                                            <a class="dropdown-item" onclick="removedAttached(this)" style="cursor: pointer;" >Delete<input type="hidden" value="{{ $file->id }}"><input type="hidden" value="{{ $file->filepath }}"><input type="hidden" value="{{ $file->filename }}"></a>
                                                        </div>
                                                    </div>
                                                    <div class="card">

                                                        <?php
                                                            if ($file->fileExtension == 'jpg' or $file->fileExtension == 'JPG' or $file->fileExtension == 'png' or $file->fileExtension == 'PNG') { ?>
                                                                <a href="#" style="padding: 10px;"><img src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" class="card-img-top"  style="width:100%; height:200px; object-fit: cover" alt="..."></a>
                                                        <?php
                                                            }if ($file->fileExtension == 'pdf' or $file->fileExtension == 'PDF' or $file->fileExtension == 'log' or $file->fileExtension == 'LOG' or $file->fileExtension == 'txt' or $file->fileExtension == 'TXT') { ?>
                                                            <a href="#" style="padding: 10px;"><iframe class="embed-responsive-item" src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" frameborder="0" scroll="no" style="height:200px; width:100%;"></iframe></a>
                                                        <?php
                                                            }if ($file->fileExtension == 'PDF' or $file->fileExtension == 'pdf') {
                                                                # code...
                                                            } 
                                                        ?>
                                    
                                                        <div class="card-body" style="padding: 5px; ">
                                                        <p class="card-text text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->filename }}</p>
                                                        </div>
                                                    </div>
                                                </div>  

                                                @endforeach
                                            </div>   
                                        </div>
                                        
                                        </div>
                                </div>
                            </div>
                            {{-- End Attachments --}}
                    @endif

        {{-- Not initiator  --}}
        @else


        <div class="col-md-12" style="margin: -20px 0 20px 0 " >
            <div class="form-group" style="margin: 0 -5px 0 -5px;">
                    <div class="col-md-1 float-left"><a href="/clarifications" ><button type="button" style="width: 100%;" class="btn btn-dark" >Back</button></a></div>  
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-primary float-right" disabled>Restart</button></div>
                    
                    @if (!empty($recipientCheck))
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" data-toggle="modal" data-target="#replyModal">Reply</button></div>
                    @elseif (!empty($senderCheck))         
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" data-toggle="modal" data-target="#replyModal">Reply</button></div>                  
                    @else
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" disabled >Reply</button></div>                            
                    @endif
                    
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-info float-right" disabled>Clarify</button></div>                    
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-secondary float-right " disabled >Withdraw</button></div>        
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-danger float-right" disabled>Reject</button></div>      
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-success float-right" disabled>Approve</button></div>   
            </div> 
        </div> 

        
        
        <!-- Modal Reply recipient -->
        <div class="modal fade"  id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark" >
                <h5 class="modal-title" id="replyModalLabel">Reply Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('cla.reply.pc.apprvr') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                     
                                <label for="replyRemarks">Remarks</label>
                                <div class="card-body">
                                    <div class="form-floating">
                                        <input type="hidden" value="{{ $post->id }}" name="pcID">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="replyRemarks" id="replyRemarks" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        {{-- End Reply Modal recipient --}}
      
 
        <div class="col-md-12">
            <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title">Petty Cash Request</h3>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referenceNumber">Reference Number</label>
                                    <input type="text" class="form-control" value="{{ $post->REQREF }} " readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateRequested">Requested Date</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateRequested" name="dateRequested" value="{{ date('m/d/Y') }}"  class="form-control datetimepicker-input" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <input id="RMName" name="RMName" type="hidden" class="form-control" placeholder="" readonly>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reportingManager">Reporting Manager</label>
                                    <input id="reportingManager" name="reportingManager" type="text" class="form-control" value="{{ $post->REPORTING_MANAGER }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="initiator">Initiator</label>
                                    <input id="initiator" name="initiator" type="text" class="form-control" value="{{ $initName }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="projectName">Project Name</label>
                                    <input id="projectName" name="projectName" type="text" class="form-control" value="{{ $post->PROJECT }}" readonly >
                                </div>
                            </div>
                            
                            <input id="clientID" name="clientID" type="hidden" class="form-control" placeholder="" readonly>
                            <input id="mainID" name="mainID" type="hidden" class="form-control" placeholder="" readonly>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clientName">Client Name</label>
                                    <input id="clientName" name="clientName" type="text" class="form-control" value="{{ $post->CLIENT_NAME }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payeeName">Payee Name</label>
                                    <input id="payeeName" name="payeeName" type="text" class="form-control" value="{{ $post->PAYEE }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateNeeded">Date Needed</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateNeeded" name="dateNeeded" class="form-control datetimepicker-input" value="{{ $post->TRANS_DATE }}" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>         
                            </div>

                


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input id="amount" name="amount" type="text" class="form-control" value="{{ $post->REQUESTED_AMT }}"  readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <textarea style="resize:none" class="form-control" id="purpose" name="purpose" rows="4"  readonly>{{ $post->DESCRIPTION }}</textarea>                              
                                </div>
                                
                            </div>
                        </div>

                        {{-- Attachments of no edit --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gray">
                                    <div class="card-header" style="height:50px;">
                                        <div class="row ">
                                            <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                        </div>
                                    </div>

                                    <div class="card-body" >
                                        <div class="row">       
                                            @forelse ($attachmentsDetails as $file)
                                            <div class="col-sm-2" >

                                                <div class="dropdown show" >
                                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute; right: 0px; top: 0px; z-index: 999; "></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" target="_blank" >View</a>
                                                        <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" download="{{ $file->filename }}" >Download</a>
                                                    </div>
                                                </div>
                                                <div class="card">

                                                    <?php
                                                        if ($file->fileExtension == 'jpg' or $file->fileExtension == 'JPG' or $file->fileExtension == 'png' or $file->fileExtension == 'PNG') { ?>
                                                            <a href="#" style="padding: 10px;"><img src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" class="card-img-top"  style="width:100%; height:200px; object-fit: cover" alt="..."></a>
                                                    <?php
                                                        }if ($file->fileExtension == 'pdf' or $file->fileExtension == 'PDF' or $file->fileExtension == 'log' or $file->fileExtension == 'LOG' or $file->fileExtension == 'txt' or $file->fileExtension == 'TXT') { ?>
                                                        <a href="#" style="padding: 10px;"><iframe class="embed-responsive-item" src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" frameborder="0" scroll="no" style="height:200px; width:100%;"></iframe></a>
                                                    <?php
                                                        }if ($file->fileExtension == 'PDF' or $file->fileExtension == 'pdf') {
                                                            # code...
                                                        } 
                                                    ?>
                                
                                                    <div class="card-body" style="padding: 5px; ">
                                                    <p class="card-text text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->filename }}</p>
                                                    </div>
                                                </div>
                                            </div>  
                                            @empty
                                            <span style="margin-left: 12px;">no attachments</span>
                                            @endforelse
                                        </div>   
                                    </div>
                                    </div>
                            </div>
                        </div>
                        {{-- End Attachments --}}


        @endif





        

                        
{{-- Table Check last two not editable all --}}
@else


        @if (!empty($initRecipientCheck))

        <div class="col-md-12" style="margin: -20px 0 20px 0 " >
            <div class="form-group" style="margin: 0 -5px 0 -5px;">
                    <div class="col-md-1 float-left"><a href="/clarifications" ><button type="button" style="width: 100%;" class="btn btn-dark" >Back</button></a></div>  
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-primary float-right" disabled>Restart</button></div>                   
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" onclick="submitAllDataInTables()" data-toggle="modal" data-target="#replyModal" >Reply</button></div>     
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-info float-right" disabled>Clarify</button></div>                    
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-secondary float-right " data-toggle="modal" data-target="#withdrawModal" >Withdraw</button></div>        
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-danger float-right" disabled>Reject</button></div>      
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-success float-right" disabled>Approve</button></div>   
            </div> 
        </div> 

        <!-- Modal Withdraw-->
        <div class="modal fade"  id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark" >
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('inp.withdraw.pc') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                     
                                <label for="withdrawRemarks">Remarks</label>
                                <div class="card-body">
                                    <div class="form-floating">
                                        <input type="hidden" value="{{ $post->id }}" name="pcID">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="withdrawRemarks" id="withdrawRemarks" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        {{-- End Withdraw Modal --}}





        <div class="col-md-12">
            <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title">Petty Cash Request</h3>
                </div>
<form action="{{ route('cla.reply.pc.init') }}" method="POST" enctype="multipart/form-data">
    @csrf


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referenceNumber">Reference Number</label>
                                    <input type="text" class="form-control" value="{{ $post->REQREF }} " name="referenceNumber" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateRequested">Requested Date</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateRequested" name="dateRequested" value="{{ date('m/d/Y') }}"  class="form-control datetimepicker-input" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <input id="RMName" name="RMName" type="hidden" class="form-control" placeholder="" readonly>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reportingManager">Reporting Manager</label>
                                    <input id="reportingManager" name="reportingManager" type="text" class="form-control" value="{{ $post->REPORTING_MANAGER }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="initiator">Initiator</label>
                                    <input id="initiator" name="initiator" type="text" class="form-control" value="{{ $initName }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="projectName">Project Name</label>
                                    <input id="projectName" name="projectName" type="text" class="form-control" value="{{ $post->PROJECT }}" readonly >
                                </div>
                            </div>

                            <input type="hidden" name="projectID" value="{{ $post->PRJID }}">
                            
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clientName">Client Name</label>
                                    <input id="clientName" name="clientName" type="text" class="form-control" value="{{ $post->CLIENT_NAME }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payeeName">Payee Name</label>
                                    <input id="payeeName" name="payeeName" type="text" class="form-control" value="{{ $post->PAYEE }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateNeeded">Date Needed</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateNeeded" name="dateNeeded" class="form-control datetimepicker-input" value="{{ $post->TRANS_DATE }}" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>         
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input id="amount" name="amount" type="text" class="form-control" value="{{ $post->REQUESTED_AMT }}"  readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <textarea style="resize:none" class="form-control" id="purpose" name="purpose" rows="4"  readonly>{{ $post->DESCRIPTION }}</textarea>                              
                                </div>
                                
                            </div>
                        </div>

                    {{-- Expense Details --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-header" style="padding: 5px 20px 5px 20px; ">
                                    <div class="row">
                                        <div class="col" style="font-size:18px; padding-top:5px;">Expense Details</div>                                          
                                        <div class="col"><a href="javascript:void(0);" class="btn btn-primary float-right" data-toggle="modal" data-target="#expenseDetail">Add Record</a></div>

                                    </div>                                       
                                </div> 

                                <div class="card-body table-responsive p-0" style="max-height: 300px; overflow: auto; display:inline-block;">
                                    <table class="table table-hover text-nowrap" id="xdTable">
                                        <thead>
                                            <tr>
                                                <th style="position: sticky; top: 0; background: white; ">Date</th>
                                                <th style="position: sticky; top: 0; background: white; ">Expense Type</th>
                                                <th style="position: sticky; top: 0; background: white; ">Remarks</th>
                                                <th style="position: sticky; top: 0; background: white; ">Amount</th>
                                                <th style="position: sticky; top: 0; background: white; ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="xdTbody">
                                            @foreach ($expenseDetails as $xdData)
                                                <tr>
                                                    <td>{{ $xdData->date_ }}</td>
                                                    <td>{{ $xdData->EXPENSE_TYPE }}</td>
                                                    <td>{{ $xdData->DESCRIPTION }}</td>
                                                    <td>{{ $xdData->AMOUNT }}</td>
                                                    <td><a class="btn btn-danger removeXDRow" onClick ="deleteXDRow()" >Delete</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- footer /Pagination part --}}
                                <div class="card-footer clearfix">
                                <div class="container">
                                <div class="row float-right" style="margin-right: 50px;">
                                {{-- <span >Total Amount:</span> --}}
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>                                    
                    </div>
                    {{-- Expense Details --}}

                    {{-- Transportation Details --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-header" style="padding: 5px 20px 5px 20px; ">

                                    <div class="row">
                                        <div class="col" style="font-size:18px; padding-top:5px;">Transportation Details</div>                                          
                                        <div class="col"><a href="javascript:void(0);" class="btn btn-primary float-right" data-toggle="modal" data-target="#transpoDetails">Add Record</a></div>

                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0" style="max-height: 300px; overflow: auto; display:inline-block;">
                                    <table class="table table-hover text-nowrap" id="tdTable" >
                                        <thead>
                                            <tr>
                                                <th style="position: sticky; top: 0; background: white;" >Date</th>
                                                <th style="position: sticky; top: 0; background: white;" >Destination From</th>
                                                <th style="position: sticky; top: 0; background: white;" >Destination To</th>
                                                <th style="position: sticky; top: 0; background: white;" >Mode of Transportation</th>
                                                <th style="position: sticky; top: 0; background: white;" >Remarks</th>
                                                <th style="position: sticky; top: 0; background: white;" >Amount</th>
                                                <th style="position: sticky; top: 0; background: white;" >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tdTbody">
                                            @foreach ($transpoDetails as $tdData)
                                                <tr>
                                                    <td>{{ $tdData->date_ }}</td>
                                                    <td>{{ $tdData->DESTINATION_FRM }}</td>
                                                    <td>{{ $tdData->DESTINATION_TO }}</td>
                                                    <td>{{ $tdData->MOT }}</td>
                                                    <td>{{ $tdData->DESCRIPTION }}</td>
                                                    <td>{{ $tdData->AMT_SPENT }}</td>
                                                    <td><a  class="btn btn-danger removeTDRow" onClick ="deleteTDRow()" >Delete</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- footer /Pagination part --}}
                                <div class="card-footer clearfix">
                                    <div class="container">
                                    <div class="row float-right" style="margin-right: 50px;">
                                    {{-- <span >Total Amount:</span> --}}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                    
                    </div>
                    {{-- Transportation details --}}


            <!-- Modal Reply-->
            <div class="modal fade"  id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark" >
                    <h5 class="modal-title" id="replyModalLabel">Reply Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

   
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">                     
                                    <label for="replyRemarks">Remarks</label>
                                    <div class="card-body">
                                        <div class="form-floating">
                                            {{-- Hidden Elements --}}
                                            <input type="hidden" value="{{ $post->id }}" name="pcID">
                                            <input type="hidden" name="xdData" id="xdData">
                                            <input type="hidden" name="tdData" id="tdData">
                                            <input type="hidden" value="" name="deleteAttached" id="deleteAttached">
                                            <input type="hidden" name="guid" value="{{ $post->GUID }}">
                                            <input id="clientID" name="clientID" type="hidden" class="form-control" value="{{ $post->CLIENT_ID }}">
                                            <input id="mainID" name="mainID" type="hidden" class="form-control" >
                               



                                            <textarea class="form-control" placeholder="Leave a comment here" name="replyRemarks" id="replyRemarks" style="height: 100px"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Proceed">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                
                </div>
                </div>
            </div>
            {{-- End Reply Modal --}}


            {{-- Attachments --}}
            <label class="btn btn-primary" style="font-weight:normal;">
                Attach files <input type="file" name="file[]" class="form-control-file" id="customFile" multiple hidden>
            </label>
            </form>

                    {{-- Attachments of no edit --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gray">
        
                                <div class="card-header" style="height:50px;">
                                    <div class="row ">
                                        <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                    </div>
                                </div>
                                {{-- Card body --}}
                                <div class="card-body" >
                
                                    {{-- Table attachments --}}
                                    <div class="table-responsive" style="max-height: 300px; overflow: auto; display:inline-block;"  >
                                        <table id= "attachmentsTable"class="table table-hover" >
                                            <thead >
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                {{-- <th>Size</th> --}}
                                                <th>Temporary Path</th>
                                                <th>Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody >
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- Table attachments End--}}                                                               
                                </div>
                                {{-- Card body END --}}                                  
                            </div>
                        </div>
                    </div>
                    {{-- End Attachments --}}
                    {{-- Attachments --}}    
                    

                    {{-- Attachments of no edit --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gray">

                                <div class="card-header" style="height:50px;">
                                    <div class="row ">
                                        <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                    </div>
                                </div>

                                <div class="card-body" >
                                    <div class="row">       
                                        @foreach ($attachmentsDetails as $file)
                                        <div class="col-sm-2" >

                                            <div class="dropdown show" >
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute; right: 0px; top: 0px; z-index: 999; "></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" target="_blank" >View</a>
                                                    <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" download="{{ $file->filename }}" >Download</a>
                                                    <a class="dropdown-item" onclick="removedAttached(this)" style="cursor: pointer;" >Delete<input type="hidden" value="{{ $file->id }}"><input type="hidden" value="{{ $file->filepath }}"><input type="hidden" value="{{ $file->filename }}"></a>
                                                </div>
                                            </div>
                                            <div class="card">

                                                <?php
                                                    if ($file->fileExtension == 'jpg' or $file->fileExtension == 'JPG' or $file->fileExtension == 'png' or $file->fileExtension == 'PNG') { ?>
                                                        <a href="#" style="padding: 10px;"><img src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" class="card-img-top"  style="width:100%; height:200px; object-fit: cover" alt="..."></a>
                                                <?php
                                                    }if ($file->fileExtension == 'pdf' or $file->fileExtension == 'PDF' or $file->fileExtension == 'log' or $file->fileExtension == 'LOG' or $file->fileExtension == 'txt' or $file->fileExtension == 'TXT') { ?>
                                                    <a href="#" style="padding: 10px;"><iframe class="embed-responsive-item" src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" frameborder="0" scroll="no" style="height:200px; width:100%;"></iframe></a>
                                                <?php
                                                    }if ($file->fileExtension == 'PDF' or $file->fileExtension == 'pdf') {
                                                        # code...
                                                    } 
                                                ?>
                            
                                                <div class="card-body" style="padding: 5px; ">
                                                <p class="card-text text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->filename }}</p>
                                                </div>
                                            </div>
                                        </div>  

                                        @endforeach
                                    </div>   
                                </div>
                                
                                </div>
                        </div>
                    </div>
                    {{-- End Attachments --}}


                    {{-- Modal --}}
                        <!-- Modal Expense Detail -->
                        <div class="modal fade" id="expenseDetail" tabindex="-1" aria-labelledby="expenseDetail" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="expenseDetailLabel">Expense Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                {{-- START ADD MODAL--}}
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                    
                                                <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="date" class="form-control" aria-describedby="helpId" id="dateXD">
                                                        <span class="text-danger" id="dateErrXD"></span>                                                  
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Expense Type</label>
                                                        <select class="form-control select2 select2-default" data-dropdown-css-class="select2-default" style="width: 100%;" id="typeXD">
                                                            @foreach ($expenseType as $xpType)
                                                            <option value="{{$xpType->type}}">{{$xpType->type}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{-- <span class="text-danger" id="typeErrXD"></span>--}}
                                                    </div>
                                                </div>

                        
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Amount</label>
                                                        <input type="number" class="form-control" placeholder="0.00" aria-describedby="helpId"  id="amountXD">
                                                        <span class="text-danger" id="amountErrXD"></span>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Remarks</label>
                                                            <textarea class="form-control" rows="5"  placeholder="input text here"  id="remarksXD"></textarea>
                                                            <span class="text-danger" id="remarksErrXD"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- END ADD--}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="getExpenseData()">Insert</button>

                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- End Modal Expense Detail --}}

                        <!-- Modal Transportation Details -->
                        <div class="modal fade" id="transpoDetails" tabindex="-1" aria-labelledby="transpoDetails" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="transpoDetailsLabel">Transportation Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                {{-- START ADD MODAL--}}
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">                                   
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="date" class="form-control" aria-describedby="helpId" id="dateTD">
                                                        <span class="text-danger" id="dateErrTD"></span>                                                  
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Mode of transportation</label>
                                                        <select class="form-control select2 select2-default" id="typeTD" data-dropdown-css-class="select2-default" style="width: 100%;" >
                                                            @foreach ($transpoSetup as $tdType)
                                                            <option value="{{$tdType->MODE}}">{{$tdType->MODE}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="typeErrTD"></span>                                                  
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Amount</label>
                                                        <input type="number" class="form-control" id="amountTD" placeholder="0.00" aria-describedby="helpId" >
                                                        <span class="text-danger" id="amountErrTD"></span>                                                  
                                                    </div>
                                                </div>                                               
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Destination from</label>
                                                        <input type="text" class="form-control" id="fromTD" placeholder="" aria-describedby="helpId" >
                                                        <span class="text-danger" id="fromErrTD"></span>                                                  
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Destination to</label>
                                                        <input type="text" class="form-control" id="toTD" placeholder="" aria-describedby="helpId" >
                                                        <span class="text-danger" id="toErrTD"></span>                                                  
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Remarks</label>
                                                            <textarea class="form-control" rows="5" id="remarksTD"  placeholder="input text here"></textarea>
                                                            <span class="text-danger" id="remarksErrTD"></span>                                                  
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- END ADD--}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="getTransportationData()">Insert</button>

                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- End Modal Transportation Details --}}
                        {{-- End Modal --}}


        

        @else

        <div class="col-md-12" style="margin: -20px 0 20px 0 " >
            <div class="form-group" style="margin: 0 -5px 0 -5px;">
                    <div class="col-md-1 float-left"><a href="/clarifications" ><button type="button" style="width: 100%;" class="btn btn-dark" >Back</button></a></div>  
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-primary float-right" disabled>Restart</button></div>                   
                    
                    @if (!empty($recipientCheck))
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" data-toggle="modal" data-target="#replyModal">Reply</button></div>
                    @elseif (!empty($senderCheck))         
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" data-toggle="modal" data-target="#replyModal">Reply</button></div>                  
                    @else
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-warning float-right" disabled >Reply</button></div>                            
                    @endif

                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-info float-right" disabled>Clarify</button></div>                    
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-secondary float-right " disabled >Withdraw</button></div>        
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-danger float-right" disabled>Reject</button></div>      
                    <div class="col-md-1 float-right"><button type="button" style="width: 100%;" class="btn btn-success float-right" disabled>Approve</button></div>   
            </div> 
        </div> 



        <!-- Modal reply-->
        <div class="modal fade"  id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark" >
                <h5 class="modal-title" id="replyModalLabel">Reply Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
        <form action="{{ route('cla.reply.pc.apprvr') }}" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                     
                                <label for="replyRemarks">Remarks</label>
                                <div class="card-body">
                                    <div class="form-floating">
                                        <input type="hidden" value="{{ $post->id }}" name="pcID">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="replyRemarks" id="replyRemarks" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </form>
            </div>
            </div>
        </div>
        {{-- End reply Modal --}}


        <div class="col-md-12">
            <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title">Petty Cash Request</h3>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referenceNumber">Reference Number</label>
                                    <input type="text" class="form-control" value="{{ $post->REQREF }} " readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateRequested">Requested Date</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateRequested" name="dateRequested" value="{{ date('m/d/Y') }}"  class="form-control datetimepicker-input" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <input id="RMName" name="RMName" type="hidden" class="form-control" placeholder="" readonly>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reportingManager">Reporting Manager</label>
                                    <input id="reportingManager" name="reportingManager" type="text" class="form-control" value="{{ $post->REPORTING_MANAGER }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="initiator">Initiator</label>
                                    <input id="initiator" name="initiator" type="text" class="form-control" value="{{ $initName }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="projectName">Project Name</label>
                                    <input id="projectName" name="projectName" type="text" class="form-control" value="{{ $post->PROJECT }}" readonly >
                                </div>
                            </div>
                            
         
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clientName">Client Name</label>
                                    <input id="clientName" name="clientName" type="text" class="form-control" value="{{ $post->CLIENT_NAME }}" readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payeeName">Payee Name</label>
                                    <input id="payeeName" name="payeeName" type="text" class="form-control" value="{{ $post->PAYEE }}" readonly >
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dateNeeded">Date Needed</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" id="dateNeeded" name="dateNeeded" class="form-control datetimepicker-input" value="{{ $post->TRANS_DATE }}" readonly/>
                                        <div class="input-group-append" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>         
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input id="amount" name="amount" type="text" class="form-control" value="{{ $post->REQUESTED_AMT }}"  readonly >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <textarea style="resize:none" class="form-control" id="purpose" name="purpose" rows="4"  readonly>{{ $post->DESCRIPTION }}</textarea>                              
                                </div>
                                
                            </div>
                        </div>

                        {{-- Expense Details --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header" style="padding: 5px 20px 5px 20px; ">
                                        <div class="row">
                                            <div class="col" style="font-size:18px; padding-top:5px;">Expense Details</div>                                          
                                            {{-- <div class="col"><a href="javascript:void(0);" class="btn btn-primary float-right" data-toggle="modal" data-target="#expenseDetail">Add Record</a></div> --}}
                                        </div>                                       
                                    </div> 

                                    <div class="card-body table-responsive p-0" style="max-height: 300px; overflow: auto; display:inline-block;">
                                        <table class="table table-hover text-nowrap" id="xdTable">
                                            <thead>
                                                <tr>
                                                    <th style="position: sticky; top: 0; background: white; ">Date</th>
                                                    <th style="position: sticky; top: 0; background: white; ">Expense Type</th>
                                                    <th style="position: sticky; top: 0; background: white; ">Remarks</th>
                                                    <th style="position: sticky; top: 0; background: white; ">Amount</th>
                                                    <th style="position: sticky; top: 0; background: white; ">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="xdTbody">
                                                @forelse ($expenseDetails as $xdData)
                                                    <tr>
                                                        <td>{{ $xdData->date_ }}</td>
                                                        <td>{{ $xdData->EXPENSE_TYPE }}</td>
                                                        <td>{{ $xdData->DESCRIPTION }}</td>
                                                        <td>{{ $xdData->AMOUNT }}</td>
                                                        <td><button type="button"  class="btn btn-danger " disabled>Delete</button></td>
                                                    </tr>
                                                @empty
                                                <tr><td colspan="5" style="padding-left: 25px;">no data</td></tr>                                                  
                                                @endforelse
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- footer /Pagination part --}}
                                    <div class="card-footer clearfix">
                                    <div class="container">
                                    <div class="row float-right" style="margin-right: 50px;">
                                    {{-- <span >Total Amount:</span> --}}
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                        {{-- Expense Details --}}
                    
                        {{-- Transportation Details --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header" style="padding: 5px 20px 5px 20px; ">

                                        <div class="row">
                                            <div class="col" style="font-size:18px; padding-top:5px;">Transportation Details</div>                                          
                                            {{-- <div class="col"><a href="javascript:void(0);" class="btn btn-primary float-right" data-toggle="modal" data-target="#transpoDetails">Add Record</a></div> --}}

                                        </div>
                                    </div>

                                    <div class="card-body table-responsive p-0" style="max-height: 300px; overflow: auto; display:inline-block;">
                                        <table class="table table-hover text-nowrap" id="tdTable" >
                                            <thead>
                                                <tr>
                                                    <th style="position: sticky; top: 0; background: white;" >Date</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Destination From</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Destination To</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Mode of Transportation</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Remarks</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Amount</th>
                                                    <th style="position: sticky; top: 0; background: white;" >Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tdTbody">
                                                @forelse ($transpoDetails as $tdData)
                                                    <tr>
                                                        <td>{{ $tdData->date_ }}</td>
                                                        <td>{{ $tdData->DESTINATION_FRM }}</td>
                                                        <td>{{ $tdData->DESTINATION_TO }}</td>
                                                        <td>{{ $tdData->MOT }}</td>
                                                        <td>{{ $tdData->DESCRIPTION }}</td>
                                                        <td>{{ $tdData->AMT_SPENT }}</td>
                                                        <td><button type="button"  class="btn btn-danger " disabled>Delete</button></td>
                                                    </tr>
                                                @empty
                                                <tr><td colspan="7" style="padding-left: 25px;">no data</td></tr>                                                  
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- footer /Pagination part --}}
                                    <div class="card-footer clearfix">
                                        <div class="container">
                                        <div class="row float-right" style="margin-right: 50px;">
                                        {{-- <span >Total Amount:</span> --}}
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                        {{-- Transportation details --}}


                        {{-- Attachments of no edit --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-gray">
                                    <div class="card-header" style="height:50px;">
                                        <div class="row ">
                                            <div  style="padding: 0 3px; 10px 3px; font-size:18px;"><h3 class="card-title">Attachments</h3></div>
                                        </div>
                                    </div>

                                    <div class="card-body" >
                                        <div class="row">       
                                            @forelse ($attachmentsDetails as $file)
                                            <div class="col-sm-2" >

                                                <div class="dropdown show" >
                                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute; right: 0px; top: 0px; z-index: 999; "></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" target="_blank" >View</a>
                                                        <a class="dropdown-item" href="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" download="{{ $file->filename }}" >Download</a>
                                                    </div>
                                                </div>
                                                <div class="card">

                                                    <?php
                                                        if ($file->fileExtension == 'jpg' or $file->fileExtension == 'JPG' or $file->fileExtension == 'png' or $file->fileExtension == 'PNG') { ?>
                                                            <a href="#" style="padding: 10px;"><img src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" class="card-img-top"  style="width:100%; height:200px; object-fit: cover" alt="..."></a>
                                                    <?php
                                                        }if ($file->fileExtension == 'pdf' or $file->fileExtension == 'PDF' or $file->fileExtension == 'log' or $file->fileExtension == 'LOG' or $file->fileExtension == 'txt' or $file->fileExtension == 'TXT') { ?>
                                                        <a href="#" style="padding: 10px;"><iframe class="embed-responsive-item" src="{{ asset('/'.$file->filepath.'/'.$file->filename) }}" frameborder="0" scroll="no" style="height:200px; width:100%;"></iframe></a>
                                                    <?php
                                                        }if ($file->fileExtension == 'PDF' or $file->fileExtension == 'pdf') {
                                                            # code...
                                                        } 
                                                    ?>
                                
                                                    <div class="card-body" style="padding: 5px; ">
                                                    <p class="card-text text-muted" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->filename }}</p>
                                                    </div>
                                                </div>
                                            </div>  
                                            @empty
                                            <span style="margin-left: 12px;">no attachments</span>
                                            @endforelse
                                        </div>   
                                    </div>
                                    </div>
                            </div>
                        </div>
                        {{-- End Attachments --}}

        @endif



@endif


                    </div> 
            </div>
        </section>
    </div>

<script>
    function submitAllDataInTables(){
        xdUpdateData();
        tdUpdateData();
        showDetails();
    }
</script>

{{-- Attachments --}}
<script>
    var main = [];
        $(document).ready(function() {
          $('input[type="file"]').on("change", function() {
            let files = this.files;
            console.log(files);
            console.dir(this.files[0]);
            $('#attachmentsTable tbody tr').remove();  
                for(var i = 0; i<files.length; i++){
                var tmppath = URL.createObjectURL(files[i]);   
                    var semi = [];
                    semi.push(files[i]['name'],files[i]['type'],files[i]['size'],tmppath);
                    main.push(semi);
                    console.log(main);
                                $('#attachmentsTable tbody').append('<tr>'+
                                                '<td>'+files[i]['name']+'</td>'+
                                                '<td>'+files[i]['type']+'</td>'+
                                                // '<td>'+files[i]['size']+'</td>'+
                                                '<td>'+tmppath+'</td>'+
                                                "<td><a href='"+tmppath+"' target='_blank' class='btn btn-secondary'>View</a></td>"+
                                                '</tr>'
                                );
    
                                //add code to copy to public folder in erp-web
                }
          });
        });
        $("#attachmentsTable").on('click', '.btnDelete', function () {
        $(this).closest('tr').remove();
    });
</script>

{{-- Remove Attachment in Gallery --}}
<script>
    objectAttached = [];
        function removedAttached(elem){
            var attachedArray = [];
    
            var x =  $(elem).parent("div").parent("div").parent("div").fadeOut(300);
            var idAttached = $(elem).children("input").val();
            var pathAttached = $(elem).children("input").next().val();
            var fileNameAttached = $(elem).children("input").next().next().val();
    
            
            attachedArray.push(idAttached,pathAttached,fileNameAttached);
    
            objectAttached.push(attachedArray);
            console.log(attachedArray);
            console.log(objectAttached);

            var attachedJson = JSON.stringify(objectAttached);
            document.getElementById("deleteAttached").value = attachedJson;

        }
</script>

{{-- Transportation Details --}}
<script>
    function getTransportationData(){
        var dateTD = $('#dateTD').val();
        var typeTD = $('#typeTD').val(); 
        var amountTD = $('#amountTD').val(); 
        var fromTD = $('#fromTD').val(); 
        var toTD = $('#toTD').val(); 
        var remarksTD = $('#remarksTD').val();
    
    
        var dateTDChecker = false;
        // var typeTDChecker = false;
        var amountTDChecker = false;
        var fromTDChecker = false;
        var toTDChecker = false;
        var remarksTDChecker = false;
    
    
        if(dateTD){
            dateTDChecker = true;
            $('#dateErrTD').text('');
        }else{
            $('#dateErrTD').text('Date is required!');
        }
    
    
        if(amountTD){
            amountTDChecker = true;
            $('#amountErrTD').text('');
    
        }else{
            $('#amountErrTD').text('Amount is required!');
        }
    
    
        if(fromTD){
            fromTDChecker = true;
            $('#fromErrTD').text('');
        }else{
            $('#fromErrTD').text('Destination from is required!');
        }
    
        if(toTD){
            toTDChecker = true;
            $('#toErrTD').text('');
        }else{
            $('#toErrTD').text('Destination to is required!');
        }
    
        if(remarksTD){
            remarksTDChecker = true;
            $('#remarksErrTD').text('');
        }else{
            $('#remarksErrTD').text('Remarks is required!');
        }
    
        if(dateTDChecker && amountTDChecker && fromTDChecker && toTDChecker && remarksTDChecker){
    
    
            $('#tdTable tbody').append('<tr>'+
                                                '<td>'+dateTD+'</td>'+
                                                '<td>'+fromTD+'</td>'+
                                                '<td>'+toTD+'</td>'+
                                                '<td>'+typeTD+'</td>'+
                                                '<td>'+remarksTD+'</td>'+
                                                '<td>'+amountTD+'</td>'+
                                                '<td>'+
                                                    '<a class="btn btn-danger removeTDRow" onClick ="deleteTDRow()" >Delete</a>'+
                                                '</td>'+
                                            '</tr>'
            );
            tdUpdateData()
            $('#dateErrTD').text('');
            $('#amountErrTD').text('');
            $('#fromErrTD').text('');
            $('#toErrTD').text('');
            $('#remarksErrTD').text('');
        }
    
    }
    
    
    function deleteTDRow(){
        $('#tdTable').on('click','tr a.removeTDRow',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        tdUpdateData()
        });
    
    }
    
    
    function tdUpdateData(){
    
    var objectTD = [];
    var myAmt = 0 ;
    
    $("#tdTable > #tdTbody > tr").each(function () {
            var dateTD = $(this).find('td').eq(0).text();
            var fromTD = $(this).find('td').eq(1).text();
            var toTD = $(this).find('td').eq(2).text();
            var typeTD = $(this).find('td').eq(3).text();
            var remarksTD = $(this).find('td').eq(4).text();
            var amountTD = $(this).find('td').eq(5).text();
         
            var listTD = [];
            listTD.push(dateTD,fromTD,toTD,typeTD,remarksTD,amountTD);
            objectTD.push(listTD);

        
            var tdJsonData = JSON.stringify(objectTD);
            $( "#tdData" ).val(tdJsonData);


        });

        console.log(objectTD);

    }
</script>

{{-- Expense Details --}}
<script>
    function getExpenseData(){
        var dateXD = $('#dateXD').val();
        var typeXD = $('#typeXD').val(); 
        var amountXD = $('#amountXD').val(); 
        var remarksXD = $('#remarksXD').val(); 
        // console.log(dateXD,typeXD,amountXD,remarksXD);
    
        var dateXDChecker = false;
        // var typeXDChecker = false;
        var amountXDChecker = false;
        var remarksXDChecker = false;
    
    
    if(dateXD){
        dateXDChecker = true;
        $('#dateErrXD').text('');
    
    }else{
        $('#dateErrXD').text('Date is required!');
        
    }
    
    if(amountXD){
        amountXDChecker = true;
        $('#amountErrXD').text('');
    
    }else{
        $('#amountErrXD').text('Amount is required!');
    }
    
    if(remarksXD){
        remarksXDChecker = true;
        $('#remarksErrXD').text('');
    
    }else{
        $('#remarksErrXD').text('Remarks is required!');
    }
    
    
    if(dateXDChecker && amountXDChecker && remarksXDChecker ){
    
        $('#xdTable tbody').append('<tr>'+
                                            '<td>'+dateXD+'</td>'+
                                            '<td>'+typeXD+'</td>'+
                                            '<td>'+remarksXD+'</td>'+
                                            '<td>'+amountXD+'</td>'+
                                            '<td>'+
                                                '<a class="btn btn-danger removeXDRow" onClick ="deleteXDRow()" >Delete</a>'+
                                            '</td>'+
                                        '</tr>'
            );
            xdUpdateData()
            $('#dateErrXD').text('');
            $('#amountErrXD').text('');
            $('#remarksErrXD').text('');
    
        }
    }
    
    
    
    function deleteXDRow(){
        $('#xdTable').on('click','tr a.removeXDRow',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        xdUpdateData()
        });

     
    }
    
    
    function xdUpdateData(){
    
        var objectXD = [];
        var myAmt = 0 ;
    
      
        

        $("#xdTable > #xdTbody > tr").each(function () {
                var dateXD = $(this).find('td').eq(0).text();
                var typeXD = $(this).find('td').eq(1).text();
                var remarksXD = $(this).find('td').eq(2).text();
                var amountXD = $(this).find('td').eq(3).text();
             
                var listXD = [];
                listXD.push(dateXD,typeXD,remarksXD,amountXD);
                objectXD.push(listXD);
    
                var xdJsonData = JSON.stringify(objectXD);
                $( "#xdData" ).val(xdJsonData);

            });

            console.log(objectXD);

    }
</script>
    
@endsection
{{-- Dropzone start --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
{{-- Sweet ALert --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>

{{-- Get Client --}}
<script>
    function showDetails(id) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var txt = xmlhttp.responseText.replace("[", "");
            txt = txt.replace("]", ""); 
            var res = JSON.parse(txt);
            document.getElementById("clientName").value = res.clientName;
            document.getElementById("clientID").value = res.clientID;
            document.getElementById("mainID").value = res.mainID;
        }
    }
    xmlhttp.open("GET","/get-client/"+id,true);
    xmlhttp.send();
}
</script>
{{-- Reporting Manager Name --}}
<script>
    function getRMName(sel) {
        var rm_txt = sel.options[sel.selectedIndex].text;
        document.getElementById("RMName").value = rm_txt;
    }
</script>


