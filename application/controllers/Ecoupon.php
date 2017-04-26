<?php
/**
 * Created by PhpStorm.
 * User: putra.liowono
 * Date: 8/31/2016
 * Time: 4:01 PM
 */
class ecoupon extends CI_Controller{

    function __construct() {
        parent::__construct();
    }

    function generate_ecoupon_code(){
        //variable from front end web
        $tempPrefix = $this->input->post("prefix");
        $tempOption = $this->input->post("listPromo");
        $tempNewPromo = $this->input->post("newPromo");
        $tempQty = $this->input->post("qty");
        $tempPromo = $tempOption == '' ? $tempNewPromo : $tempOption;

        //check promo event name has been added or not
        $exPromo = $this->ecoupon_model->promo_event_staging($tempNewPromo);
        if(count($exPromo) > 0){
            echo "<script>alert('Promo Name already added'); window.location.href='/index.php/index'; </script>";
        }

        //generate unique code
        $lengPrefix = strlen($tempPrefix);
        $limitCode = 15 - ($lengPrefix + 3);
        $code = array();
        for($i = 0; $i < $tempQty; $i++){
            $tempCode = strtoupper($tempPrefix . random_string('alpha',1) . random_string('alpha',1) . random_string('numeric',1) . random_string('alnum',$limitCode));
            $flag = $this->ecoupon_model->select_code_staging($tempCode);
            if(count($flag) > 0){
                $i--;
            }else{
                if(in_array($tempCode, $code)){
                    $i--;
                }else {
                    $code[] = $tempCode;
                }
            }
        }

        //make array for insert to database
        foreach($code as $value) {
            $codeToDb[] = array(
                'eCouponCode' => $value
                ,'eCouponID' => null
                ,'CreatorID' => 'SYSTEM'
                ,'CreatorIP' => 'SYSTEM'
                ,'CreatorDateTime' => date('Y-m-d H:i:s')
                ,'EditorID' => null
                ,'EditorIP' => null
                ,'EditorDateTime' => null
            );
        }
        foreach($code as $item) {
            $codeToLog[] = array(
                'eCouponCode' => $item
                ,'promoEvent' => $tempPromo
                ,'CreatorDateTime' => date('Y-m-d H:i:s')
            );
        }

        //insert to database
        $this->ecoupon_model->insert_code('azswd01.BI_Data.dbo.bhx_eCouponCode_staging',$codeToDb);
        // $this->ecoupon_model->insert_code('azswd01.BI_Data.dbo.BI_eCouponCode_staging',$codeToLog);
        // $this->export_code($tempPromo,$code);
    }

    function export_code($name, $code) {
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.date('Ymd') . ' ' . $name .'.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        //insert array code to output
        foreach ($code as $value) {
            fputcsv($output,array('eCouponCode'=> $value));
        }
        fclose($output);
    }
}
?>