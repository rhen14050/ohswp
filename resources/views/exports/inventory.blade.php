<table>


    <tbody>
    <tr>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td rowspan="2" style="text-align: center;"></td>
        <td colspan="10" rowspan="2" style="text-align: center; font-weight: bold;">OHS WORK PERMIT</td>
        <td colspan ="5">Permit No: {{   $workpermit_soic->permit_number }}</td><br>
        <td></td>
    </tr>
    <tr>
        {{-- <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td> --}}
        <td colspan="1">Validity:</td>
    </tr>

    {{-- <tr>

    </tr> --}}

    <tr>
        <td colspan="23">This OHS Permit allows the Company/listed personnel to enter PMI and conduct required work: Please CHECK applicable WORK PERMIT below:</td>

    </tr>

    <tr>
        @php
           $exploded = explode(', ',  $workpermit_soic->work_permit_type);

        @endphp
        {{-- <td style="word-wrap: break-word;" rowspan="2" colspan="6">&#9744; &#9745; OHS WORK PERMIT Inside PMI Building</td> --}}
        <td style="word-wrap: break-word;" rowspan="2" colspan="6">
            <?php
                if(in_array("OHS Work Permit Inside PMI Bldg", $exploded)){
                    ?>
                        &#9745;
                    <?php
                }
                else{
                    ?>
                        &#9744;
                    <?php
                }
            ?>
            OHS WORK PERMIT Inside PMI Building
        </td>
        <td style="word-wrap: break-word;" rowspan="2" colspan="4">
            <?php
                if(in_array("OHS Work Permit Outside PMI Bldg", $exploded)){
                    ?>
                        &#9745;
                    <?php
                }
                else{
                    ?>
                        &#9744;
                    <?php
                }
            ?>
             OHS WORK PERMIT Outside PMI Building
        </td>
        <td style="word-wrap: break-word;" rowspan="2" colspan="3">
            <?php
            if(in_array("Working at HEIGHTS Permit", $exploded)){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            Working at HEIGHTS PERMIT
        </td>
        <td style="word-wrap: break-word;" rowspan="2" colspan="4">
            <?php
            if(in_array("HOT Works Permit", $exploded)){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            HOT Works PERMIT
        </td>
        <td style="word-wrap: break-word;" rowspan="2" colspan="6">
            <?php
            if(in_array("Confine Space Works Permit", $exploded)){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            Confine Space Works PERMIT
        </td>
    </tr>

    <tr>

    </tr>

    <tr>
        <td colspan="23">1.0 GENERAL INFORMATION(Project in charge to fill up)</td>
    </tr>

    <tr>
        <td colspan="12">NAME OF PMI IN CHARGE: {{  $workpermit_soic->person_in_charge }}</td>
        <td colspan="5">DEPT/SEC: {{   $workpermit_soic->department }}</td>
        <td colspan="6">Local No: {{   $workpermit_soic->local_number}}</td>
    </tr>

    <tr>
        <td colspan="16">NAME OF PROJECT/ACTIVITY: {{   $workpermit_soic->activity }}</td>
        <td colspan="7">LOCATION: {{   $workpermit_soic->location}}</td>
    </tr>

    <tr>
        <td colspan="16">CONTRACTOR COMPANY NAME: {{ $workpermit_soic->contractor_details->company }} </td>
        <td colspan="7">WORK SCHEDULE: {{   $workpermit_soic->work_schedule }}</td>
    </tr>

    <tr>
        <td colspan="15">CONTRACTOR PERSON IN-CHARGE: {{$workpermit_soic->contractor_person_in_charge->name}}</td>
        <td colspan="5">DATE:
            <?php

            if($workpermit_soic->status < 9){
                $date = $workpermit_soic->start_date;
                $e_date = $workpermit_soic->end_date;
                $start_date = date('F d, Y',strtotime($date));
                $end_date = date('F d, Y',strtotime($e_date));

                echo ($start_date."-".$end_date);
            }else{
                $prolong_date = $workpermit_soic->prolong_start_date;
                $prolong_e_date = $workpermit_soic->prolong_end_date;
                $prolong_start_date = date('F d, Y',strtotime($prolong_date));
                $prolong_end_date = date('F d, Y',strtotime($prolong_e_date));

                echo ($prolong_start_date."-".$prolong_end_date."(extend)");


            }


            ?>

        </td>

        <td colspan="3">TIME:
            <?php
            if ($workpermit_soic->status < 9){
            $start_time = $workpermit_soic->start_time;
            $end_time = ($workpermit_soic->end_time);

            echo ($start_time."-".$end_time);
            }else{
            $start_time = $workpermit_soic->prolong_start_time;
            $end_time = ($workpermit_soic->prolong_end_time);

            echo ($start_time."-".$end_time);
            }
            ?>
            </td>


    </tr>

    <tr>
        <td colspan="23">CONTRACTOR SAFETY IN-CHARGE: {{ $workpermit_soic->contractor_safety_officer_in_charge->name }}</td>
    </tr>

    <tr>
        <td colspan="23">2.0 OHS REQUIREMENTS (Please check applicable item; Must be complied before/during conduct of work) (PMI SO In charge to fill up)</td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement1 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            1. Discuss PMI EHS Policies and applicable health and safety programs
        </td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td colspan="21">1.1 Observe proper waste segregation and disposal</td>

    </tr>

    <tr>
    <td></td>
    <td></td>
    <td colspan="21">1.2 Material trimmings and debris should be brought along upon concluding the project</td>

    </tr>

    <tr>
        <td></td>
        <td></td>
        <td colspan="21">1.3 Isolate/cover and provide vacuum for those activities that will produce so much dust and ventilation for strong odor</td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td colspan="21">1.4 Seek EMS assessment first prior used of chemicals (if there's any)</td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement2 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            2. Discuss approved OHS Work Permit to all listed workers for the project before start of work; Secure copy of approved OHS Work Permit in the area;
            </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement3 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            3. Bring and wear basic Personal Protective Equipment(PPE), (1) Safety Shoes (2)Hard Hat (3)Goggles/Eye Protection Device (4)Reflective Safety Vest
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement4 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            4. Certified skilled workers are required to work only-Welder,Technician,Crane/Forklift Operator, Rigger, etc.;Submit Certificate to PMI
            </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement5 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
             5. Full body harness must be worn at all times; Fall arrester/protection must be anchored on a sturdy loation; Safety/support lifelines installed.
            </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement6 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            6. Scaffold strength is 4 times anticipated load. Guard railing installed. Platform is level; Wheeled type scaffolds have wheel locking mechanism.
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement7 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            7. Scaffold stability ensured and checked. Bracing and support adequate; Ensure firmness and rigidity of bracing, planks and rolling tower.
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement8 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            8. Strictly no passage of workers/people underneath the scaffolding;
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement9 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            9. Provide appropriate Barricade/enclosure of the area and post appropriate caution/signages; Do not obstruct emergency device
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement10 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            10. Provide appropriate Safety net if working overhead
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement11 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            11. Insulated PPE must be worn at all times. Tools must be insulated; Ensure proper grounding for electrical works; Implement Lock Out/ Tag Out
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement12 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            12. No lifting activity of heavy loads if raining or during high/strong winds when working outside
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">  <?php
            if($get_ohs_requirements->ohs_requirement13 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            13. Strictly tools and equipment to be brought inside and used must in good functioning condition. Have permits for Generator Sets and Cranes
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement14 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            14. Fire Extinguisher must be available in the area and operable; Workers know how to use the Fire Extinguishers
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">   <?php
            if($get_ohs_requirements->ohs_requirement15 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            15. Strictly No flammable and combustible items in the project and sorrounding area when hotworks is conducted; Area have good ventilation
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
            <?php
            if($get_ohs_requirements->ohs_requirement16 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            16. Fire blanket/welding mat must be available; Firewatch must be present all the times. Heat/smoke detectors in the area are disabled and protected
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">  <?php
            if($get_ohs_requirements->ohs_requirement17 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            17. Gas cylinders must be properly placed, stored in upright position and with safety caps.
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">  <?php
            if($get_ohs_requirements->ohs_requirement18 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            18. Strictly observed buddy system during conduct of work; For Confine Space Work, please comply the AREA CONTROL CHECK ITEMS:
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">   <?php
            if($get_ohs_requirements->ohs_requirement19 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            19. Conduct daily/weekly tool box meeting; Safety In-Charge to conduct compliance inspection; Strictly NO Smoking inside PMI Premises
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">  <?php
            if($get_ohs_requirements->ohs_requirement20 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            20. Practice Safety first and Discipline; Observe proper behaviour at hallways and common areas; Maintain Good Housekeeping /5S always
        </td>
    </tr>

    <tr>
        <td colspan="23" style="word-wrap: break-word;">
        <?php
            if($get_ohs_requirements->ohs_requirement21 != NULL){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            21. Others: Participate in company wide safety program such as emergency drills
        </td>
    </tr>

    <tr>
        <td colspan="23">workers must attend PMI Orientation for Contractors/Workers before allowed to start WORK in PMI (Contractor In charge to fill up)</td>
    </tr>



        <tr>
            <th style="text-align: center; font-weight: bold;">No</th>
            <th style="text-align: center; font-weight: bold;" colspan="6">NAME</th>
            <th style="text-align: center; font-weight: bold;" colspan="3">POSITION/SKILLS</th>
            <th style="text-align: center; font-weight: bold;" colspan="4">CONTRACTORS OHS TRAINING DATE</th>
            <th style="text-align: center; font-weight: bold;" colspan="4">SKILLS TRAINING CERTIFICATE DATE</th>
            <th style="text-align: center; font-weight: bold;" colspan="5">CERTIFICATE SUBMISSION DATE</th>

        </tr>

        <?php


           for($i = 0; $i < count($get_worker); $i++){
                ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td colspan="6"><?php echo $get_worker[$i]->name ?></td>
                        <td colspan="3"><?php echo $get_worker[$i]->position  ?></td>
                        <td colspan="4"><?php echo $get_worker[$i]->training_date ?></td>
                        <td colspan="4"><?php echo $get_worker[$i]->training_certificate_date ?></td>
                        <td colspan="5"><?php echo $get_worker[$i]->training_submission_date  ?></td>
                    </tr>
                <?php
            }

        ?>

    <tr>
        <td colspan="16">4.0 LIST OF TOOLS OR EQUIPMENT OR CHEMICALS: (attached additional sheet)( Contractor In charge to fill up) </td>
        <td style="text-align: center;" colspan="7">AFFECTED SAFETY DEVICES: (Please check)</td>
    </tr>

    <tr>
        {{-- <th></th> --}}
        <th style="text-align: center; font-weight: bold;" colspan="7">NAME</th>
        <th style="text-align: center; font-weight: bold;" colspan="2">QTY.</th>
        <th style="text-align: center; font-weight: bold;" colspan="6">OTHER REQUIREMENTS</th>
        <td colspan="8"></td>

    </tr>


    <?php

    for($y=0; $y < count($get_tools); $y++){
            $exploded_affected_devices = explode(',',  $get_tools[$y]->affected_safety_devices);
        }
    $twoRows = 2;
    // $affectedSafetyDevicesArray = ['☐ Fire alarm system', '☐ Paging system;Speaker,etc.'];
    $toolsNameCount = count($get_tools);
    // dd($get_tools[1]->name);
    // dd($exploded_affected_devices);
    // return;
    // exit(0);
    // dd($toolsNameCount);
    if($toolsNameCount <= 1){
        for($x = 0; $x <= $twoRows ; $x++){
            ?>
                <tr>
                    @if ($x == 0) {{-- Run once --}}
                        @for ($i = 0; $i < count($get_tools); $i++)
                            <td><?php echo $x+1; ?></td>
                            <td colspan="6"><?php echo $get_tools[$x]->name ?></td>
                            <td colspan="2" style="text-align: left;"><?php echo $get_tools[$x]->quantity ?></td>
                            <td colspan="5"></td>
                        @endfor
                    @endif

                    @if ($x != 0)
                        <td colspan="7"></td>
                        <td colspan="2"></td>
                        <td colspan="5"></td>
                    @endif

                    @if ($x == 0)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Fire Alarm System", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Fire alarm system
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("Emergency Lighting", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Emergency lighting
                        </td>
                    @elseif ($x == 1)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Paging System; Speaker etc", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Paging System; Speaker etc
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("Emergency Exit Door", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Emergency Exit Door
                        </td>
                    @elseif ($x == 2)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Fire extinguisher Fire hose", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Fire extinguisher,Fire hose
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("None", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            None
                        </td>
                    @endif

                </tr>
                <?php

        }
    }
    else if ($toolsNameCount == 2) {
        for($x = 0; $x <= $twoRows ; $x++){
            ?>
                <tr>
                    @if ($x == 0)
                        {{-- @for ($i = 0; $i < count($get_tools); $i++) --}}
                            <td><?php echo $x+1; ?></td>
                            <td colspan="6"><?php echo $get_tools[$x]->name ?></td>
                            <td colspan="2" style="text-align: center;"><?php echo $get_tools[$x]->quantity ?></td>
                            <td colspan="5"></td>
                        {{-- @endfor --}}
                    @elseif ($x == 1)
                            <td><?php echo $x+1; ?></td>
                            <td colspan="6"><?php echo $get_tools[$x]->name ?></td>
                            <td colspan="2" style="text-align: center;"><?php echo $get_tools[$x]->quantity ?></td>
                            <td colspan="5"></td>
                    @endif

                    @if ($x == 2)
                        <td colspan="7"></td>
                        <td colspan="2"></td>
                        <td colspan="5"></td>
                    @endif

                    @if ($x == 0)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Fire Alarm System", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Fire alarm system
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("Emergency Lighting", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Emergency lighting
                        </td>
                    @elseif ($x == 1)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Paging System; Speaker etc", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Paging System; Speaker etc
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("Emergency Exit Door", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Emergency Exit Door
                        </td>
                    @elseif ($x == 2)
                        <td colspan="5" style="word-wrap: break-word;">
                            @if (in_array("Fire extinguisher Fire hose", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            Fire extinguisher,Fire hose
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                            @if (in_array("None", $exploded_affected_devices))
                                &#9745;
                            @else
                                &#9744;
                            @endif
                            None
                        </td>
                    @endif

                </tr>
                <?php
        }
    }
    else{
        for($x = 0; $x < count($get_tools); $x++){
                ?>
                <tr>
                    <td><?php echo $x+1; ?></td>
                    <td colspan="6"><?php echo $get_tools[$x]->name ?></td>
                    <td colspan="2" style="text-align: center;"><?php echo $get_tools[$x]->quantity ?></td>
                    <td colspan="6"></td>

                    <?php
                        if($x == 0){
                        ?>
                        <td colspan="5" style="word-wrap: break-word;">
                            <?php
                                if(in_array("Fire Alarm System", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>
                            Fire alarm system
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                                <?php
                                if(in_array("Emergency Lighting", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>
                            Emergency lighting
                        </td>
                    <?php
                        }
                        elseif ($x == 1) {
                        ?>
                        <td colspan="5" style="word-wrap: break-word;">
                                <?php
                                if(in_array("Paging System; Speaker etc", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>
                            Paging system;Speaker,etc.
                        </td>

                        <td colspan="3" style="word-wrap: break-word;">
                                <?php
                                if(in_array("Emergency Exit Door", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>
                            Emergency exit door
                        </td>
                    <?php
                        }
                        elseif ($x == 2) {
                        ?>
                        <td colspan="5" style="word-wrap: break-word;">
                            <?php
                                if(in_array("Fire extinguisher Fire hose", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>Fire extinguisher,Fire hose
                        </td>
                        <td colspan="3" style="word-wrap: break-word;">
                            <?php
                                if(in_array("None", $exploded_affected_devices)){
                                    ?>
                                        &#9745;
                                    <?php
                                }
                                else{
                                    ?>
                                        &#9744;
                                    <?php
                                }
                            ?>NONE
                        </td>
                    <?php
                    ?>
                </tr>
                <?php
            }
        }
    }

    ?>


    <tr>
        <td colspan="23">5.0 CONTRACTOR CONFORMANCE OR COMMITMENT (Contractor in charge to fil up) </td>
    </tr>

    <tr>
        <td colspan="15">1. PMI OHS Work Permit requirements are discussed  and well understood by workers.</td>
        <td colspan="3">Date Conducted:</td>
        <td colspan="5">
            <?php
            echo date ('F d, Y', strtotime($workpermit_soic->start_date));
            ?>
        </td>

    </tr>

    <tr>
        <td colspan="23">2. We commit to practice SAFETY FIRST at all times, support the company's goal for Zero Accident Program and abide all applicable OHS policies implemented by PMI.</td>
        <td></td>
    </tr>

    <tr>
        <td colspan="16">3. We commit to maintain our work area clean, organized and hazard free at all times.</td>
        <td colspan="2">Conformed by:</td>
        {{-- <td></td> --}}
        <td colspan="5">{{ $workpermit_soic->contractor_safety_officer_in_charge->name }}</td>
    </tr>

    <tr>
        <td colspan="18">4. Work Clearance Inspection shall be conducted before expiration of permit and before turn over / end of the project.</td>
        <td colspan="5" style="word-break: break-word; text-align:center;">Contractor Safety In-Charge <br>Signature Over Printed Name</td>
    </tr>

    <tr>
        <td colspan="23">6.0 MANAGEMENT OF CHANGE (MOC) EVALUATION: (Division's Safety Officer In-Charge or Project In-Charge to do the assesment ) </td>
    </tr>

    <tr>
        <td colspan="15">1. Requires change in process or equipment? </td>
        <td colspan="4" style="word-wrap: break-word;">
        <?php
            if($workpermit_soic->moc1 == 1){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>Yes</td>

        <td colspan="4" style="word-wrap: break-word;">
        <?php
            if($workpermit_soic->moc1 == 0){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>No</td>
    </tr>

    <tr>
        <td style="word-break: break-word;" colspan="15" rowspan="2">2. Re-lay outing involves electrical rewiring or lighting, transfer of passage way or emergency exit,<br> transfer or provision of new exhaust or ventilation system, re-piping of gas or water supply?</td>
        <td colspan="4" style="word-wrap: break-word;" rowspan="2">
        <?php
            if($workpermit_soic->moc2 == 1){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>Yes</td>
        <td colspan="4" style="word-wrap: break-word;" rowspan="2">
            <?php
            if($workpermit_soic->moc2 == 0){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>No</td>
    </tr>

    <tr>

    </tr>

    <tr>
        <td colspan="15">3. Involves construction of new infrastructure and or installation of new facility or equipment?</td>
        <td colspan="4" style="word-wrap: break-word;">
        <?php
            if($workpermit_soic->moc3 == 1){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>Yes</td>
        <td colspan="4" style="word-wrap: break-word;">
        <?php
            if($workpermit_soic->moc3 == 0){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>No</td>
    </tr>

    <tr>
        <td colspan="23">7.0 PERMIT APPROVAL: (PMI in charge to fill up) </td>
    </tr>

    {{-- <tr>
        <td colspan="7"></td>
        <td colspan="4"></td>
        <td colspan="5"></td>
        <td colspan="5"></td>
    </tr> --}}


    <tr>
        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['project_in_charge'] .".png") }}" width="80" height="50"> --}}
        <td style="text-align: center;"colspan="8">{{$get_approver[0]->project_in_charge }}</td>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['safety_officer_in_charge_id'] .".png") }}" width="80" height="50"> --}}
        <td colspan="4" style="text-align: center;">{{$get_approver[0]->safety_officer_in_charge->name }}</td>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['over_all_safety_officer_id'] .".png") }}" width="80" height="50"> --}}
        <td colspan="5" style="text-align:center">{{$get_approver[0]->over_all_safety_officer->name }}</td>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['hrd_manager_id'] .".png") }}" width="80" height="50"> --}}
        <td colspan="6" style="text-align: center;">{{$get_approver[0]->hrd_manager->name }}</td>
    </tr>

    <tr>
        <td colspan="8" rowspan="2" style="word-break: break-word; text-align:center;">Project In-Charge <br>Signature Over Printed Name</td>
        <td colspan="4" rowspan="2" style="word-break: break-word; text-align:center;">Safety officer In-Charge<br>Signature Over Printed Name</td>
        <td colspan="5" rowspan="2" style="word-break: break-word; text-align:center;">Over-all Safety Officer<br>Signature Over Printed Name</td>
        <td colspan="6" rowspan="2" style="word-break: break-word; text-align:center;">HR / Administration<br>Signature Over Printed Name</td>
    </tr>

    <tr>

    </tr>


    <tr>
        <td colspan="23">8.0 WORK CLEARANCE (SO in charge to fill up; Note: Work must be completed and area is safe)</td>
    </tr>

    <tr>



        <td colspan="8">
            <?php
            if($workpermit_soic->clearance_status_clear == 'status_clear' ){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>
            Clear(No problem noted)</td>

        <td colspan="4">
        <?php
            if($workpermit_soic->clearance_status_clear == null ){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?> NOT Cleared (WITH problems noted)</td>
        <td colspan="5">
        <?php
            if($workpermit_soic->approver_in_charge->safety_officer_in_charge_remark != null ){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>Actions required:</td>
            {{-- <td></td> --}}
        <td colspan="6"><?php
            if($workpermit_soic->approver_in_charge->safety_officer_in_charge_remark != null ){
                ?>
                    &#9745;
                <?php
            }
            else{
                ?>
                    &#9744;
                <?php
            }
            ?>Date Completed:</td>

    </tr>

    {{-- <tr>
        <td colspan="7"></td>
        <td colspan="4"></td>
        <td colspan="5"></td>
        <td colspan="5"></td>
    </tr> --}}

    <tr>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['safety_officer_in_charge_id'] .".png") }}"  height="50"> --}}
        <td style="text-align: center;"colspan="8">{{$get_approver[0]->safety_officer_in_charge->name }}</td>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['ems_manager_id'] .".png") }}"  height="50"> --}}
        <td colspan="4" style="text-align: center;">{{$get_approver[0]->ems_manager->name }}</td>

        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['over_all_safety_officer_id'] .".png") }}"  height="50"> --}}
        <td colspan="5" style="text-align:center">{{$get_approver[0]->over_all_safety_officer->name }}</td>


        {{-- <img src="{{ storage_path() . ("/app/public/e-signature/". $e_signature['hrd_manager_id'] .".png") }}"  height="50"> --}}
        <td colspan="6" style="text-align: center;">{{$get_approver[0]->hrd_manager->name }}</td>

    </tr>

    <tr>
        <td colspan="8" rowspan="2" style="word-break: break-word; text-align:center;">Safety officer In-Charge <br>Signature Over Printed Name</td>
        <td colspan="4" rowspan="2" style="word-break: break-word; text-align:center;">Pollution Control Officer<br>Signature Over Printed Name</td>
        <td colspan="5" rowspan="2" style="word-break: break-word; text-align:center;">Over-all Safety Officer<br>Signature Over Printed Name</td>
        <td colspan="6" rowspan="2" style="word-break: break-word; text-align:center;">HR / Administration<br>Signature Over Printed Name</td>
    </tr>


    </tbody>



</table>
