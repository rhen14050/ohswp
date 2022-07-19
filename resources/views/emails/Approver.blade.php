<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style type="text/css">
            body{
                font-family: Arial;
                font-size: 15px;
            }

            .text-green{
                color: green;
                font-weight: bold;
            }

            /*.input[type="radio"]{
                font
            }*/
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-12">
                <div class="row" style="margin: 1px 10px;">
                    <div class="col-sm-12">
                        <form id="frmSaveRecord">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label style="font-size: 18px;">Good day!</label><br>
                                    <label style="font-size: 18px;">Please be informed that you have Work Permit Request for approval as of today {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    <br><br>
                                    {{-- <hr> --}}
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Work Permit Details: </b></label>
                                    </div>
                                </div>

                                <br>

                                <div class="col-sm-12">

                                    <?php

                                    if ($data[0]->permit_number == null){
                                        echo "";
                                    }else {
                                        echo
                                        '<div class="form-group row">
                                            <label class="col-sm-12 col-form-label"><b>Work Permit Number   : </b><span class="text-black">'. $data[0]->permit_number .'</span></label>
                                        </div>';
                                    }

                                    ?>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Work Permit Classification           : </b><span class="text-black">
                                            <?php
                                                if ( $data[0]->classification == 0){
                                                    echo 'Normal';
                                                }else{
                                                    echo 'Urgent';
                                                }
                                            ?>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Work Permit Type    : </b><span class="text-black">{{ $data[0]->work_permit_type }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Person In-Charge    : </b><span class="text-black">{{ $data[0]->person_in_charge }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Activity   : </b><span class="text-black">{{ $data[0]->activity }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Location  : </b><span class="text-black">{{ $data[0]->location }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Start Date    : </b><span class="text-black">

                                            <?php
                                            $s_date = $data[0]->start_date;

                                            // echo date_format($s_date, 'M d, Y');
                                            echo $formattedSDate = date('M d, Y',strtotime($s_date));

                                            ?>

                                        </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>End Date    : </b><span class="text-black">
                                            <?php
                                            $e_date = $data[0]->end_date;

                                            // echo date_format($s_date, 'M d, Y');
                                            echo $formattedEDate = date('M d, Y',strtotime($e_date));

                                            ?>
                                        </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Start Time    : </b><span class="text-black">

                                        <?php
                                        $s_time = $data[0]->start_time;

                                        echo $formattedSTime = date('h:i A', strtotime($s_time));
                                        ?>

                                        </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>End Time   : </b><span class="text-black">

                                            <?php
                                            $e_time = $data[0]->end_time;

                                            echo $formattedETime = date('h:i A', strtotime($e_time));
                                            ?>

                                        </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Contractor  : </b><span class="text-black">{{ $data[0]['contractor_id_name']['company']}} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Contractor Person In-Charge  : </b><span class="text-black">{{ $data[0]['contractor_person_in_charge']['name'] }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Contractor Safety Officer In-Charge  : </b><span class="text-black">{{ $data[0]['contractor_safety_officer_in_charge']['name'] }} </span></label>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Contractor Worker/s : </b><span class="text-black">{{ $worker_data[0]->name }} </span></label>
                                    </div> --}}


                                </div>

                                <br>
                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">For more info, please log-in to your Rapidx account. Go to http://rapidx/ and OHS Work Permit </label>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b> Notice of Disclaimer: </b></label>
                                        <br>
                                        <label class="col-sm-12 col-form-label"></label>   This message contains confidential information intended for a specific individual and purpose. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.</label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br><br>
                                    <label style="font-size: 18px;"><b>For concerns on using the form, please contact ISS at local numbers 205, 206, or 208. You may send us e-mail at <a href="mailto: servicerequest@pricon.ph">servicerequest@pricon.ph</a></b></label>
                                </div>
                            </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </body>
</html>
