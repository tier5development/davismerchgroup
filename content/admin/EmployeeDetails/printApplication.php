<?php
require('Application.php');
$page = "printApplication.php";
$app = 0;
if (isset($_GET['iid'])) {
    $app = $_GET['iid'];
}
extract($_POST);
?>
<?php
$aryCol1 = array(job_req, salary, "refferedid", "joiningDate",
    "UID", "nameLast", "nameSuffix", "nameFirst", "nameMiddle", "nickName");

$v2 = array('txtCurAdd', 'txtCurCity', 'txtCurState', 'txtCurZip', 'txtCurYrsLived',
    'txtTelNo', 'txtEmail', 'rdAgeLmt', 'rdLegAut', 'rdWorDMG', 'txtPosition',
    'rdFrndDMG', 'txtNameFrnd', 'rdTransWork', 'rdCrime', 'txtCrime');
$aryCol2 = array(curr_address, "curr_City", "curr_State", "cur_zipCode",
    "cur_YrLived", tel_no, emailid, age_lmt, leg_aut, "wokd_for_DMG",
    wrk_det, "frnd_in_DMG", frnd_name, trnspot_req, crime_chrgd,
    crime_det);
$v3 = array('txtSch1Name', 'txtSch1City', 'txtSch1State', 'txtSch1Zip', 'txtSch1Country', 'rdSch1Grd', 'txtSch1Frm', 'txtSch1To', 'txtSch1GrdDt',
    'txtSch1Title', 'txtSch1Main', 'txtSch1Extras', 'rdIsNameChng', 'txtNameDt', 'txtExp', 'rdIsCap');
$aryCol3 = array(school_name1, "s1_City", "s1_State", "s1_zipCode", s1_country,
    s1_is_graduate, s1_grd_prd_frm, is_nam_chgd, name_det,
    experience_det, is_capable);
$v4 = array('txtCurEmpName', 'txtCurEmpAdd', 'txtCurEmpCity', 'txtCurEmpState', 'txtCurEmpZip', 'txtCurEmpFrom', 'txtCurEmpTo', 'cmdCurEmpSSal',
    'cmdCurEmpFSal', 'txtCurEmpTel', 'txtCurEmpPos', 'txtCurEmpDut', 'txtCurEmpSup', 'txtCurEmpLeave', 'rdCurEmpWorking', 'rdCurEmpMayCont');

$aryCol4 = array(empr_name, empr_address, empr_city, empr_state, "empr_zipCode",
    empr_from, empr_to, empr_start_salary, empr_end_salary, empr_tel_no,
    empr_position, empr_duties_major, empr_name_supvr, empr_reason_leaving,
    empr_is_currly_working, empr_may_contact);
$v5 = array('rdCmtToOtr', 'txtOtrExpe', 'rdAskToRn', 'txtReasonRn', 'txtRef1Name', 'txtRef1Occ', 'txtRef1Add', 'txtRef1City', 'txtRef1State', 'txtRef1Zip', 'txtRef1TelNo', 'txtRef1YrKn');


$aryCol5 = array(any_comm, exp_comm, ask_to_resign, exp_reason, ref1_name,
    ref1_occ, ref1_address, "ref1_City", "ref1_State", "ref1_zipCode",
    "ref1_Tel_No", "ref1_no_Yrs");


$v6 = array('rdLic', 'rdLicSus', 'txtSusExp', 'rdLicVoil', 'txtOff1Off', 'txtOff1Dt', 'txtOff1Loc', 'txtOff1Com', 'rdAutIns', 'txtInsNo');
$aryCol6 = array(have_dri_licence, ever_susp, exp_susp, have_traf_violations,
    off1_det, off1_date, off1_location, off1_commts, have_per_aut_ins, ex_no_insurance);
$success = 0;
if (isset($_POST['SubFrm']) && $app > 0) {
    $aryValue1 = array("'" . $_POST['txtJob'] . "'", $_POST['txtSalary'], $_POST['cmdReff'],
        "'" . $_POST['cmdStDtday'] . "/" . $_POST['cmdStDtmonth'] . "/" . $_POST['cmdStDtyear'] . "'",
        "'" . $_POST['txtSSN1'] . $_POST['txtSSN2'] . $_POST['txtSSN3'] . "'",
        "'" . $_POST['txtLegName'] . "'", "'" . $_POST['txtSrName'] . "'", "'" . $_POST['txtFrstName'] . "'",
        "'" . $_POST['txtMdlName'] . "'", "'" . $_POST['txtNickName'] . "'");

    $wh = array("\"appID\"=$app");
    $success1 = $objDB->updateData($connection, "dtbl_jobapplicant", $aryCol1, $aryValue1, $wh);

    $aryValue2 = $objFrm->ChangeToPost($v2);
    $success2 = $objDB->updateData($connection, "dtbl_jobapplicantaddress", $aryCol2, $aryValue2, $wh);

    $aryValue3 = $objFrm->ChangeToPost($v3);
    $success3 = $objDB->updateData($connection, "dtbl_jobapplicanteducation", $aryCol3, $aryValue3, $wh);

    $aryValue4 = $objFrm->ChangeToPost($v4);
    $success4 = $objDB->updateData($connection, "dtbl_jobapplicantemployer", $aryCol4, $aryValue4, $wh);

    $aryValue5 = $objFrm->ChangeToPost($v5);
    $success5 = $objDB->updateData($connection, "dtbl_jobapplicantemp_hist", $aryCol5, $aryValue5, $wh);

    $aryValue6 = $objFrm->ChangeToPost($v6);
    $success6 = $objDB->updateData($connection, "dtbl_jobapplicantdri_det", $aryCol6, $aryValue6, $wh);

    if (isset($previous_address)) {
        for ($i = 0; $i < count($previous_address); $i++) {
            $sql = "Update dtbl_applicant_previous_address set status = 1";
            if ($previous_address[$i] != "")
                $sql .=",address = '" . $previous_address[$i] . "'";
            if ($city[$i] != "")
                $sql .=",city = '" . $city[$i] . "'";
            if ($state[$i] != "")
                $sql .=",state = '" . $state[$i] . "'";
            if ($zip[$i] != "")
                $sql .=",zip = '" . $zip[$i] . "'";
            if ($lived_here[$i] != "")
                $sql .=",years_lived = '" . $lived_here[$i] . "'";
            if ($app_id > 0)
                $sql .=",app_id = " . $app_id;
            $sql .=" where id = " . $previous_address_id[$i];
            //echo $sql;
            if (!($result = pg_query($connection, $sql))) {
                $return_arr['error'] = "Error while inserting address information to database!";
                echo json_encode($return_arr);
                return;
            }
            pg_free_result($result);
        }
    }
    if (isset($school_name)) {
        $sql = "";
        for ($i = 0; $i < count($school_name); $i++) {
            $sql = "Update dtbl_jobapplicant_education set status = 1";
            if ($school_name[$i] != "")
                $sql .=",school_name = '" . $school_name[$i] . "'";
            if ($school_city[$i] != "")
                $sql .=",school_city = '" . $school_city[$i] . "'";
            if ($school_state[$i] != "")
                $sql .=",school_state = '" . $school_state[$i] . "'";
            if ($school_zip[$i] != "")
                $sql .=",school_zip = '" . $school_zip[$i] . "'";
            if ($school_country[$i] != "")
                $sql .=",school_country = '" . $school_country[$i] . "'";
            if ($did_graduate[$i] != "")
                $sql .=",did_graduate = '" . $did_graduate[$i] . "'";
            if ($from_date[$i] != "")
                $sql .=",from_date = '" . $from_date[$i] . "'";
            if ($to_date[$i] != "")
                $sql .=",to_date = '" . $to_date[$i] . "'";
            if ($graduation_date[$i] != "")
                $sql .=",graduation_date = '" . $graduation_date[$i] . "'";
            if ($diploma[$i] != "")
                $sql .=",diploma = '" . $diploma[$i] . "'";
            if ($course[$i] != "")
                $sql .=",major_course = '" . $course[$i] . "'";
            if ($speacilization[$i] != "")
                $sql .=",describe_specialization = '" . $speacilization[$i] . "'";
            if ($app_id > 0)
                $sql .=",app_id = " . $app_id;
            $sql .="where education_id = " . $education_id[$i];
            if (!($result = pg_query($connection, $sql))) {
                $return_arr['error'] = "Error while inserting education information to database!";
                echo json_encode($return_arr);
                return;
            }
        }
    }
    if (isset($employer_name)) {
        $sql = "";
        for ($i = 0; $i < count($employer_name); $i++) {
            $sql = "Update dtbl_previous_employer set status = 1";
            if ($employer_name[$i] != "")
                $sql .=",employer_name = '" . $employer_name[$i] . "'";
            if ($employer_address[$i] != "")
                $sql .=",employer_address = '" . $employer_address[$i] . "'";
            if ($employer_city[$i] != "")
                $sql .=",employer_city = '" . $employer_city[$i] . "'";
            if ($employer_state[$i] != "")
                $sql .=",employer_state = '" . $employer_state[$i] . "'";
            if ($employer_zip[$i] != "")
                $sql .=",employer_zip = '" . $employer_zip[$i] . "'";
            if ($from_date[$i] != "")
                $sql .=",from_date = '" . $from_date[$i] . "'";
            if ($starting_salary[$i] != "")
                $sql .=",starting_salary = '" . $starting_salary[$i] . "'";
            if ($to_date[$i] != "")
                $sql .=",to_date = '" . $to_date[$i] . "'";
            if ($final_salary[$i] != "")
                $sql .=",final_salary = '" . $final_salary[$i] . "'";
            if ($employer_telephone[$i] != "")
                $sql .=",telephone = '" . $employer_telephone[$i] . "'";
            if ($title[$i] != "")
                $sql .=",title = '" . $title[$i] . "'";
            if ($last_supervisor[$i] != "")
                $sql .=",last_supervisor = '" . $last_supervisor[$i] . "'";
            if ($reason_leaving[$i] != "")
                $sql .=",reason_leaving = '" . $reason_leaving[$i] . "'";
            if ($working_employer[$i] != "")
                $sql .=",working_employer = '" . $working_employer[$i] . "'";
            if ($contact[$i] != "")
                $sql .=",contact = '" . $contact[$i] . "'";
            if ($app_id > 0)
                $sql .=",app_id = " . $app_id;
            $sql .="where id = " . $employer_id[$i];
            if (!($result = pg_query($connection, $sql))) {
                $return_arr['error'] = "Error while inserting employer information to database!";
                echo json_encode($return_arr);
                return;
            }
        }
    }
    if (isset($reference_name)) {
        $sql = "";
        for ($i = 0; $i < count($reference_name); $i++) {
            $sql = "Update dtbl_jobapplicant_references set status = 1";
            if ($reference_name[$i] != "")
                $sql .=",reference_name = '" . $reference_name[$i] . "'";
            if ($occupation[$i] != "")
                $sql .=",occupation = '" . $occupation[$i] . "'";
            if ($reference_address[$i] != "")
                $sql .=",address = '" . $reference_address[$i] . "'";
            if ($reference_city[$i] != "")
                $sql .=",city = '" . $reference_city[$i] . "'";
            if ($reference_state[$i] != "")
                $sql .=",state = '" . $reference_state[$i] . "'";
            if ($reference_zip[$i] != "")
                $sql .=",zip = '" . $reference_zip[$i] . "'";
            if ($reference_telephone[$i] != "")
                $sql .=",telephone = '" . $reference_telephone[$i] . "'";
            if ($years_known[$i] != "")
                $sql .=",years_known = '" . $years_known[$i] . "'";
            if ($app_id > 0)
                $sql .=",app_id = " . $app_id;
            $sql .="where reference_id = " . $reference_id[$i];
            if (!($result = pg_query($connection, $sql))) {
                $return_arr['error'] = "Error while inserting reference information to database!";
                echo json_encode($return_arr);
                return;
            }
        }
    }
    if (isset($offense)) {
        $sql = "";
        for ($i = 0; $i < count($offense); $i++) {
            $sql = "Update dtbl_jobapplicant_offences set status = 1";
            if ($offense[$i] != "")
                $sql .=",offense = '" . $offense[$i] . "'";
            if ($offense_date[$i] != "")
                $sql .=",offense_date = '" . $offense_date[$i] . "'";
            if ($offense_location[$i] != "")
                $sql .=",offense_location = '" . $offense_location[$i] . "'";
            if ($offense_comments[$i] != "")
                $sql .=",offense_comments = '" . $offense_comments[$i] . "'";
            if ($app_id > 0)
                $sql .=",app_id = " . $app_id;
            $sql .="where offense_id = " . $offense_id[$i];
            if (!($result = pg_query($connection, $sql))) {
                $return_arr['error'] = "Error while inserting offense information to database!";
                echo json_encode($return_arr);
                return;
            }
        }
    }
    if ($success1 != false && $success2 != false && $success3 != false && $success4 != false && $success5 != false && $success6 == false) {
        echo"<script>alert('successfully submited')</script>";
    }
}
?>


<?php
if ($app > 0) {
    $aryRest = $objDB->getResultMulti($connection, "SELECT 
  dtbl_jobapplicant.\"appID\", 
  dtbl_jobapplicant.job_req, 
  dtbl_jobapplicant.salary, 
  dtbl_jobapplicant.refferedid, 
  dtbl_jobapplicant.\"joiningDate\", 
  dtbl_jobapplicant.\"UID\", 
  dtbl_jobapplicant.\"nameLast\", 
  dtbl_jobapplicant.\"nameSuffix\", 
  dtbl_jobapplicant.\"nameFirst\", 
  dtbl_jobapplicant.\"nameMiddle\", 
  dtbl_jobapplicant.\"nickName\", 
  dtbl_jobapplicantaddress.curr_address, 
  dtbl_jobapplicantaddress.\"curr_City\", 
  dtbl_jobapplicantaddress.\"curr_State\", 
  dtbl_jobapplicantaddress.\"cur_zipCode\", 
  dtbl_jobapplicantaddress.\"cur_YrLived\", 
  dtbl_jobapplicantaddress.pre_address1, 
  dtbl_jobapplicantaddress.\"pre_City1\", 
  dtbl_jobapplicantaddress.\"pre_State1\", 
  dtbl_jobapplicantaddress.\"pre_zipCode1\", 
  dtbl_jobapplicantaddress.\"pre_YrLived1\", 
  dtbl_jobapplicantaddress.pre_address2, 
  dtbl_jobapplicantaddress.\"pre_City2\", 
  dtbl_jobapplicantaddress.\"pre_State2\", 
  dtbl_jobapplicantaddress.\"pre_zipCode2\", 
  dtbl_jobapplicantaddress.\"pre_YrLived2\", 
  dtbl_jobapplicantaddress.pre_address3, 
  dtbl_jobapplicantaddress.\"pre_City3\", 
  dtbl_jobapplicantaddress.\"pre_State3\", 
  dtbl_jobapplicantaddress.\"pre_zipCode3\", 
  dtbl_jobapplicantaddress.\"pre_YrLived3\", 
  dtbl_jobapplicantaddress.tel_no, 
  dtbl_jobapplicantaddress.emailid, 
  dtbl_jobapplicantaddress.age_lmt, 
  dtbl_jobapplicantaddress.leg_aut, 
  dtbl_jobapplicantaddress.\"wokd_for_DMG\", 
  dtbl_jobapplicantaddress.wrk_det, 
  dtbl_jobapplicantaddress.\"frnd_in_DMG\", 
  dtbl_jobapplicantaddress.frnd_name, 
  dtbl_jobapplicantaddress.trnspot_req, 
  dtbl_jobapplicantaddress.crime_chrgd, 
  dtbl_jobapplicantaddress.crime_det, 
  dtbl_jobapplicanteducation.school_name1, 
  dtbl_jobapplicanteducation.\"s1_City\", 
  dtbl_jobapplicanteducation.\"s1_State\", 
  dtbl_jobapplicanteducation.\"s1_zipCode\", 
  dtbl_jobapplicanteducation.s1_country, 
  dtbl_jobapplicanteducation.s1_is_graduate, 
  dtbl_jobapplicanteducation.s1_grd_prd_frm, 
  dtbl_jobapplicanteducation.s1_grd_prd_to, 
  dtbl_jobapplicanteducation.s1_grd_dt, 
  dtbl_jobapplicanteducation.s1_grd_title, 
  dtbl_jobapplicanteducation.s1_grd_main, 
  dtbl_jobapplicanteducation.s1_desc_others, 
  dtbl_jobapplicanteducation.school_name2, 
  dtbl_jobapplicanteducation.\"s2_City\", 
  dtbl_jobapplicanteducation.\"s2_State\", 
  dtbl_jobapplicanteducation.\"s2_zipCode\", 
  dtbl_jobapplicanteducation.s2_country, 
  dtbl_jobapplicanteducation.s2_is_graduate, 
  dtbl_jobapplicanteducation.s2_grd_prd_frm, 
  dtbl_jobapplicanteducation.s2_grd_prd_to, 
  dtbl_jobapplicanteducation.s2_grd_dt, 
  dtbl_jobapplicanteducation.s2_grd_title, 
  dtbl_jobapplicanteducation.s2_grd_main, 
  dtbl_jobapplicanteducation.s2_desc_others, 
  dtbl_jobapplicanteducation.school_name3, 
  dtbl_jobapplicanteducation.\"s3_City\", 
  dtbl_jobapplicanteducation.\"s3_State\", 
  dtbl_jobapplicanteducation.\"s3_zipCode\", 
  dtbl_jobapplicanteducation.s3_country, 
  dtbl_jobapplicanteducation.s3_is_graduate, 
  dtbl_jobapplicanteducation.s3_grd_prd_frm, 
  dtbl_jobapplicanteducation.s3_grd_prd_to, 
  dtbl_jobapplicanteducation.s3_grd_dt, 
  dtbl_jobapplicanteducation.s3_grd_title, 
  dtbl_jobapplicanteducation.s3_grd_main, 
  dtbl_jobapplicanteducation.s3_desc_others, 
  dtbl_jobapplicanteducation.school_name4, 
  dtbl_jobapplicanteducation.\"s4_City\", 
  dtbl_jobapplicanteducation.\"s4_State\", 
  dtbl_jobapplicanteducation.\"s4_zipCode\", 
  dtbl_jobapplicanteducation.s4_country, 
  dtbl_jobapplicanteducation.s4_is_graduate, 
  dtbl_jobapplicanteducation.s4_grd_prd_frm, 
  dtbl_jobapplicanteducation.s4_grd_prd_to, 
  dtbl_jobapplicanteducation.s4_grd_dt, 
  dtbl_jobapplicanteducation.s4_grd_title, 
  dtbl_jobapplicanteducation.s4_grd_main, 
  dtbl_jobapplicanteducation.s4_desc_others, 
  dtbl_jobapplicanteducation.is_nam_chgd, 
  dtbl_jobapplicanteducation.name_det, 
  dtbl_jobapplicanteducation.experience_det, 
  dtbl_jobapplicanteducation.is_capable, 
  dtbl_jobapplicantemployer.empr_name, 
  dtbl_jobapplicantemployer.empr_address, 
  dtbl_jobapplicantemployer.empr_city, 
  dtbl_jobapplicantemployer.empr_state, 
  dtbl_jobapplicantemployer.\"empr_zipCode\", 
  dtbl_jobapplicantemployer.empr_from, 
  dtbl_jobapplicantemployer.empr_to, 
  dtbl_jobapplicantemployer.empr_start_salary, 
  dtbl_jobapplicantemployer.empr_end_salary, 
  dtbl_jobapplicantemployer.empr_tel_no, 
  dtbl_jobapplicantemployer.empr_position, 
  dtbl_jobapplicantemployer.empr_duties_major, 
  dtbl_jobapplicantemployer.empr_name_supvr, 
  dtbl_jobapplicantemployer.empr_reason_leaving, 
  dtbl_jobapplicantemployer.empr_is_currly_working, 
  dtbl_jobapplicantemployer.empr_may_contact, 
  dtbl_jobapplicantemployer.p1_name, 
  dtbl_jobapplicantemployer.p1_empr_address, 
  dtbl_jobapplicantemployer.p1_empr_city, 
  dtbl_jobapplicantemployer.p1_empr_state, 
  dtbl_jobapplicantemployer.p1_empr_zipcode, 
  dtbl_jobapplicantemployer.p1_from, 
  dtbl_jobapplicantemployer.p1_to, 
  dtbl_jobapplicantemployer.p1_empr_start_salary, 
  dtbl_jobapplicantemployer.p1_empr_end_salary, 
  dtbl_jobapplicantemployer.p1_empr_tel_no, 
  dtbl_jobapplicantemployer.p1_position, 
  dtbl_jobapplicantemployer.p1_empr_duties_major, 
  dtbl_jobapplicantemployer.p1_empr_name_supvr, 
  dtbl_jobapplicantemployer.p1_empr_reason_leaving, 
  dtbl_jobapplicantemployer.p2_name, 
  dtbl_jobapplicantemployer.p2_empr_address, 
  dtbl_jobapplicantemployer.p2_empr_city, 
  dtbl_jobapplicantemployer.p2_empr_state, 
  dtbl_jobapplicantemployer.p2_empr_zipcode, 
  dtbl_jobapplicantemployer.p2_from, 
  dtbl_jobapplicantemployer.p2_to, 
  dtbl_jobapplicantemployer.p2_empr_start_salary, 
  dtbl_jobapplicantemployer.p2_empr_end_salary, 
  dtbl_jobapplicantemployer.p2_empr_tel_no, 
  dtbl_jobapplicantemployer.p2_position, 
  dtbl_jobapplicantemployer.p2_empr_duties_major, 
  dtbl_jobapplicantemployer.p2_empr_name_supvr, 
  dtbl_jobapplicantemployer.p2_empr_reason_leaving, 
  dtbl_jobapplicantemployer.p3_name, 
  dtbl_jobapplicantemployer.p3_empr_address, 
  dtbl_jobapplicantemployer.p3_empr_city, 
  dtbl_jobapplicantemployer.p3_empr_state, 
  dtbl_jobapplicantemployer.p3_empr_zipcode, 
  dtbl_jobapplicantemployer.p3_from, 
  dtbl_jobapplicantemployer.p3_to, 
  dtbl_jobapplicantemployer.p3_empr_start_salary, 
  dtbl_jobapplicantemployer.p3_empr_end_salary, 
  dtbl_jobapplicantemployer.p3_empr_tel_no, 
  dtbl_jobapplicantemployer.p3_position, 
  dtbl_jobapplicantemployer.p3_empr_duties_major, 
  dtbl_jobapplicantemployer.p3_empr_name_supvr, 
  dtbl_jobapplicantemployer.p3_empr_reason_leaving, 
  dtbl_jobapplicantemp_hist.any_comm, 
  dtbl_jobapplicantemp_hist.exp_comm, 
  dtbl_jobapplicantemp_hist.ask_to_resign, 
  dtbl_jobapplicantemp_hist.exp_reason, 
  dtbl_jobapplicantemp_hist.ref1_name, 
  dtbl_jobapplicantemp_hist.ref1_occ, 
  dtbl_jobapplicantemp_hist.ref1_address, 
  dtbl_jobapplicantemp_hist.\"ref1_City\", 
  dtbl_jobapplicantemp_hist.\"ref1_State\", 
  dtbl_jobapplicantemp_hist.\"ref1_zipCode\", 
  dtbl_jobapplicantemp_hist.\"ref1_Tel_No\", 
  dtbl_jobapplicantemp_hist.\"ref1_no_Yrs\", 
  dtbl_jobapplicantemp_hist.ref2_name, 
  dtbl_jobapplicantemp_hist.ref2_occ, 
  dtbl_jobapplicantemp_hist.ref2_address, 
  dtbl_jobapplicantemp_hist.\"ref2_City\", 
  dtbl_jobapplicantemp_hist.\"ref2_State\", 
  dtbl_jobapplicantemp_hist.\"ref2_zipCode\", 
  dtbl_jobapplicantemp_hist.\"ref2_Tel_No\", 
  dtbl_jobapplicantemp_hist.\"ref2_no_Yrs\", 
  dtbl_jobapplicantemp_hist.ref3_name, 
  dtbl_jobapplicantemp_hist.ref3_occ, 
  dtbl_jobapplicantemp_hist.ref3_address, 
  dtbl_jobapplicantemp_hist.\"ref3_City\", 
  dtbl_jobapplicantemp_hist.\"ref3_State\", 
  dtbl_jobapplicantemp_hist.\"ref3_zipCode\", 
  dtbl_jobapplicantemp_hist.\"ref3_Tel_No\", 
  dtbl_jobapplicantemp_hist.\"ref3_no_Yrs\", 
  dtbl_jobapplicantemp_hist.ref4_name, 
  dtbl_jobapplicantemp_hist.ref4_occ, 
  dtbl_jobapplicantemp_hist.ref4_address, 
  dtbl_jobapplicantemp_hist.\"ref4_City\", 
  dtbl_jobapplicantemp_hist.\"ref4_State\", 
  dtbl_jobapplicantemp_hist.\"ref4_zipCode\", 
  dtbl_jobapplicantemp_hist.\"ref4_Tel_No\", 
  dtbl_jobapplicantemp_hist.\"ref4_no_Yrs\", 
  dtbl_jobapplicantdri_det.have_dri_licence, 
  dtbl_jobapplicantdri_det.ever_susp, 
  dtbl_jobapplicantdri_det.exp_susp, 
  dtbl_jobapplicantdri_det.have_traf_violations, 
  dtbl_jobapplicantdri_det.off1_det, 
  dtbl_jobapplicantdri_det.off1_date, 
  dtbl_jobapplicantdri_det.off1_location, 
  dtbl_jobapplicantdri_det.off1_commts, 
  dtbl_jobapplicantdri_det.off2_det, 
  dtbl_jobapplicantdri_det.off2_date, 
  dtbl_jobapplicantdri_det.off2_location, 
  dtbl_jobapplicantdri_det.off2_commts, 
  dtbl_jobapplicantdri_det.off3_det, 
  dtbl_jobapplicantdri_det.off3_date, 
  dtbl_jobapplicantdri_det.off3_location, 
  dtbl_jobapplicantdri_det.off3_commts, 
  dtbl_jobapplicantdri_det.off4_det, 
  dtbl_jobapplicantdri_det.off4_date, 
  dtbl_jobapplicantdri_det.off4_location, 
  dtbl_jobapplicantdri_det.off4_commts, 
  dtbl_jobapplicantdri_det.have_per_aut_ins, 
  dtbl_jobapplicantdri_det.ex_no_insurance
FROM public.dtbl_jobapplicant left join public.dtbl_jobapplicantaddress on public.dtbl_jobapplicant.\"appID\"=public.dtbl_jobapplicantaddress.\"appID\" 
         left join public.dtbl_jobapplicanteducation on public.dtbl_jobapplicant.\"appID\"=public.dtbl_jobapplicanteducation.\"appID\"  
         left join public.dtbl_jobapplicantemployer on public.dtbl_jobapplicant.\"appID\"=public.dtbl_jobapplicantemployer.\"appID\" 
         left join public.dtbl_jobapplicantemp_hist on public.dtbl_jobapplicant.\"appID\"=public.dtbl_jobapplicantemp_hist.\"appID\" 
         left join public.dtbl_jobapplicantdri_det on public.dtbl_jobapplicant.\"appID\"=public.dtbl_jobapplicantdri_det.\"appID\"  WHERE 
  dtbl_jobapplicant.\"appID\" = $app
ORDER BY
  dtbl_jobapplicant.\"appID\" ASC;
");
    $sql = "select * from dtbl_applicant_previous_address where app_id = $app";
    if (!($result = pg_query($connection, $sql))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $data_previous_address[] = $row;
    }
    pg_free_result($result);

    $sql = "select * from dtbl_jobapplicant_education where app_id = $app";
    if (!($result = pg_query($connection, $sql))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $data_education[] = $row;
    }
    pg_free_result($result);

    $sql = "select * from dtbl_jobapplicant_offences where app_id = $app";
    if (!($result = pg_query($connection, $sql))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $data_offences[] = $row;
    }
    pg_free_result($result);

    $sql = "select * from dtbl_jobapplicant_references where app_id = $app";
    if (!($result = pg_query($connection, $sql))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $data_references[] = $row;
    }
    pg_free_result($result);

    $sql = "select * from dtbl_previous_employer where app_id = $app";
    if (!($result = pg_query($connection, $sql))) {
        print("Failed query1: " . pg_last_error($connection));
        exit;
    }
    while ($row = pg_fetch_array($result)) {
        $data_employer[] = $row;
    }
    pg_free_result($result);
} else {
    if (count($aryRest) == 0) {
        for ($c = 0; $c < 209; $c++) {
            $aryRest[0][$c] = "";
        }
    }
}
//echo $aryRest[0][1];
?>

<style type="text/css">
    *{    margin: 0;
          padding: 0}
    </style>
    <table border="0" cellpadding="0" cellspacing="0"><tr><td width="650px">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="phase001">
                <tr>      
                    <td colspan="4" align="center" valign="top"><h3> <?php echo $aryRest[0][8] . " " . $aryRest[0][9] . " " . $aryRest[0][6] . " " . $aryRest[0][7]; ?></h3>
                    <br/></td></tr>
                <tr>
                    <td width="20%"></td> 
                    <td width="40%">                      
                        <?php echo $aryRest[0][11]; ?></br>
                        <?php echo $aryRest[0][12]; ?></br>
                        <?php echo $aryRest[0][13].' - '.$aryRest[0][14]; ?></br>
                        <?php //echo $aryRest[0][14]; ?></br>
                    </td>
                    <td width="1%" style="background-image: url('<?php echo $mydirectory; ?>/images/spacer.png')">&nbsp;</td>
                    <td><?php if ($data_previous_address[0]['address'] != "") { ?>Previous Address:<br/>
                            <?php if ($data_previous_address[0]['address'] != "") echo $data_previous_address[0]['address'] ?></br>
                            <?php if ($data_previous_address[0]['state'] != "") echo $data_previous_address[0]['state']; ?></br>
                            <?php if ($data_previous_address[0]['zip'] != "") echo $data_previous_address[0]['zip']; ?></br>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%"></td> 
                    <td colspan="3" align="left" height="20%" ><br/><h3>Education</h3>
                        <?php if (isset($aryRest[0][42])) { ?>
                            <strong> <?php echo $aryRest[0][42]; ?></strong><br/>
                            <?php if ($aryRest[0][51] != "") echo $aryRest[0][51] . " , " . $aryRest[0][49]; ?></br>
                            <b>  Major :</b> <?php if ($aryRest[0][52] != "") echo $aryRest[0][52]; ?></br>
                            <?php if ($aryRest[0][53] != "") echo $aryRest[0][53]; ?>

                        <?php } ?>

                        <?php
                        if (count($data_education) > 0) {
                            for ($i = 0; $i < count($data_education); $i++) {
                                ?>

                                <h3> <?php if ($data_education[$i]['school_name'] != "") echo $data_education[$i]['school_name']; ?></h3>
                                <?php if ($data_education[$i]['diploma'] != "") echo $data_education[$i]['diploma']; ?>
                                
                                   <?php if ($data_education[$i]['major_course'] != ""){
                                    echo "</br><b>Major :</b>".$data_education[$i]['major_course'];
                                       if($data_education[$i]['to_date']!="") echo " , " . $data_education[$i]['to_date'];
                                ?>
                                <?php if($data_education[$i]['describe_specialization']!="")echo $data_education[$i]['describe_specialization'];} ?>

    <?php }
}
?>
                    <br/><br/></td></tr>
                
                <?php if ($aryRest[0][94] != ""){?>

                <tr>
                    <td width="20%"></td> 
                    <td><br/><h3>Experience</h3>
                        <strong><?php  echo $aryRest[0][94]; ?></strong><br/>
                        
<?php if ($aryRest[0][104] != "") echo $aryRest[0][104]; ?><br/>
<?php if ($aryRest[0][105] != "") echo $aryRest[0][105]; ?><br/>
                        <?php if ($aryRest[0][99] != "")
                            echo "From " . $aryRest[0][99];
                        if ($aryRest[0][100] != "")
                            " To " . $aryRest[0][100];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%"></td> 
                    <td>
                        <?php for ($i = 0; $i < count($data_employer); $i++) {
                            ?> 
                            <h3><?php if ($data_employer[$i]['employer_name'] != "") echo $data_employer[$i]['employer_name']; ?></h3>
    <?php if ($data_employer[$i]['title'] != "") echo $data_employer[$i]['title']; ?><br/>
    <?php if ($data_employer[$i]['job_duties'] != "") echo $data_employer[$i]['job_duties']; ?></br>
                            <?php if ($data_employer[$i]['from_date'] != "")
                                echo "From " . $data_employer[$i]['from_date'];
                            if ($data_employer[$i]['to_date'] != "")
                                " To " . $data_employer[$i]['to_date'];
                            ?>

                        <?php } ?>
                    </td></tr>
                <?php } ?>
                <?php if ($aryRest[0][156] != ""){ ?>
                <tr>
                    <td width="20%"></td> 
                    <td colspan="3" align="left"><br/><br/><h3>Professional Refferences</h3>
                        <strong><?php  echo $aryRest[0][156]; ?></strong><br/>
<?php if ($aryRest[0][162] != "") echo $aryRest[0][162]; ?><br/>
<?php if ($aryRest[0][163] != "") echo $aryRest[0][163] . " years" ?>

                        <?php for ($i = 0; $i < count($data_references); $i++) {
                            ?>
                            <strong><?php if ($data_references[$i]['reference_name'] != "") echo $data_references[$i]['reference_name']; ?></strong>
                            <?php if ($data_references[$i]['telephone'] != "") echo $data_references[$i]['telephone']; ?><br/>
                            <?php if ($data_references[$i]['years_known'] != "") echo $data_references[$i]['years_known'] . " years."; ?>
                        <?php } ?>
                    </td>   
                </tr>
                <?php } ?>
                <?php if ($aryRest[0][192] != ""){ ?>
                <tr>
                    <td width="20%"></td> 
                    <td colspan="3" align="left"><h3><br/><br/>Driving Information</h3>
                        <strong><?php  echo $aryRest[0][192]; ?></strong>
<?php if ($aryRest[0][194] != "") echo $aryRest[0][194]; ?><br/>
<?php if ($aryRest[0][195] != "") echo $aryRest[0][195]; ?><br/>
<?php
for ($i = 0; $i < count($data_offences); $i++) {
    ?>
                            <strong><?php if ($data_offences[$i]['offense'] != "") echo $data_offences[$i]['offense']; ?></strong>
    <?php if ($data_offences[$i]['offense_location'] != "") echo $data_offences[$i]['offense_location']; ?><br/>
    <?php if ($data_offences[$i]['offense_comments'] != "") echo $data_offences[$i]['offense_comments']; ?>

<?php } ?>
                    </td></tr>
                <?php } ?>               
            </table>
        </td><td>&nbsp;</td></tr></table>


