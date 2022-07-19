@php $layout = 'layouts.super_user_layout'; @endphp

@auth
    @php
    if (Auth::user()->user_level_id == 1) {
        $layout = 'layouts.super_user_layout';
    } elseif (Auth::user()->user_level_id == 2) {
        $layout = 'layouts.admin_layout';
    } elseif (Auth::user()->user_level_id == 3) {
        $layout = 'layouts.user_layout';
    }
    @endphp
@endauth

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'Dashboard')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 mt-3">
                        <div class="info-box bg-info">
                            {{-- <span class="info-box-icon bg-info"><i class="nav-icon fas fa-users"></i></span> --}}
                            <div class="info-box-content">
                                {{-- <span class="info-box-title">Contractor List</span>  --}}
                                <div class="mb-6">
                                    <h2 class="card-title mb-0">Total Contractor
                                        <i class ="nav-icon fas fa-users"></i></h2> <br>
                                        <h2>
                                            <span class="totalContractors"></span>
                                        </h2>
                                </div>
                            </div>
                                <div class="col-6 text-right"><br>
                                    <a class="text-white" href="{{ route('contractors_management') }}"><i class="fa fa-3x fa-arrow-right bg-info"></i></a>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 mt-3">
                            <div class="info-box bg-danger">
                                <div class="info-box-content">
                                    <div class="mb-6">
                                    <h2 class="card-title mb-0">Urgent Work Pending List
                                        <i class ="nav-icon fas fa-clipboard-list"></i></h2> <br>
                                        <h2>
                                            <span class="totalUrgentWork"></span>
                                        </h2>
                                </div>  
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <span class="totalUsers"></span>
                                        </h2>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="text-white" href="{{ route('work_permit_management') }}"><i class="fa fa-3x fa-arrow-right"></i></a>
    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 mt-3">
                            <div class="info-box bg-primary">
                                <div class="info-box-content">
                                    <div class="mb-6">
                                    <h2 class="card-title mb-0">Normal Work List
                                        <i class ="nav-icon fas fa-clipboard-list"></i></h2> <br>
                                        <h2>
                                            <span class="totalNormalWork"></span>
                                        </h2>
                                </div>  
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            <span class="totalUsers"></span>
                                        </h2>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="text-white" href="{{ route('work_permit_management') }}"><i class="fa fa-3x fa-arrow-right"></i></a>
    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                 

                    
                    {{-- <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-file"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Claim</span>
                                <span class="info-box-number">233</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total CAPA</span>
                                <span class="info-box-number">9,139</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-black"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number">9,132</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pending</span>
                                <span class="info-box-number">139</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Records</span>
                                <span class="info-box-number">93,139</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        // $(document).ready(function () {
        //============================== GET TOTAL WORKLOADS FOR DASHBOARD ==============================
        // function totalWorkloads(){
        //     $.ajax({
        //         url: "get_total_workloads",
        //         method: "get",
        //         dataType: "json",
        //         success: function (response) {
        //             $('.totalWorkloads').text(response['totalWorkloads']);
        //             console.log(response['totalWorkloads']);
        //         }
        //     });
        // }
        // totalWorkloads();


        // //============================== GET TOTAL USERS FOR DASHBOARD ==============================
        function totalContractors(){
            $.ajax({
                url: "get_total_contractor",
                method: "get",
                dataType: "json",
                success: function (response) {
                    $('.totalContractors').text(response['totalContractors']);
                    // console.log(response['totalContractors']);
                }
            });
        }
        totalContractors();

        function totalUrgentWorkList(){
            $.ajax({
                url: "get_total_urgent_work_list",
                method: "get",
                dataType: "json",
                success: function (response) {
                    $('.totalUrgentWork').text(response['totalUrgentWork']);
                    // console.log(response['totalContractors']);
                }
            });
        }
        totalUrgentWorkList();

        function totalNormalWorkList(){
            $.ajax({
                url: "get_total_normal_work_list",
                method: "get",
                dataType: "json",
                success: function (response) {
                    $('.totalNormalWork').text(response['totalNormalWork']);
                    // console.log(response['totalContractors']);
                }
            });
        }
        totalNormalWorkList();

      


        // //============================== SIGN OUT ==============================
        // $(document).ready(function(){
        //     $("#formSignOut").submit(function(event){
        //         event.preventDefault();
        //         SignOut();
        //     });
        // });
        // });
    </script>
@endsection
