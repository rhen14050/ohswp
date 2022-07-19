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
                                    {{-- <br><br> --}}
                                    {{-- <hr> --}}
                                </div>

                                <br>

                                <div class="col-sm-12">

                                    <div class="form-group row">
                                        <label style="font-size: 18px;">Please be informed that the work permit with permit number: <b>{{ $data[0]->permit_number }}</b> is extended as of today  {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}<br>
                                        </label>
                                    </div>
                                    <br>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Person In-Charge    : </b><span class="text-black">{{ $data[0]->person_in_charge }} </span></label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Contractor  : </b>
                                            <span class="text-black">{{ $data[0]['contractor_id_name']['company']}} </span>
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label style="font-size: 18px;">
                                            <?php
                                            $st_date = $data[0]->start_date;
                                            $en_date = $data[0]->end_date;

                                            $stt_date = date('M d, Y', strtotime($st_date));
                                            $enn_date = date('M d, Y', strtotime($en_date));

                                            $formatted_date = $stt_date."-".$enn_date;

                                            echo "<b>From: </b> ".$formatted_date;

                                            ?>
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label style="font-size: 18px;">
                                            <?php
                                            $pr_st_date = $data[0]->prolong_start_date;
                                            $pr_en_date = $data[0]->prolong_end_date;

                                            $prtt_date = date('M d, Y', strtotime($pr_st_date));
                                            $pren_date = date('M d, Y', strtotime($pr_en_date));

                                            $formatted_pr_date = $prtt_date."-".$pren_date;

                                            echo "<b>To: </b> ".$formatted_pr_date;


                                            ?>
                                        </label>
                                    </div>
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
