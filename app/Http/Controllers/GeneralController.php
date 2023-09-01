<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceLog;
use App\Models\TakisikStatistics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class GeneralController extends Controller
{
    public function send_data_to_maintenance(Request $request){

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'log_type' =>  [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined','NULL', ' ']),
                ],
                'data' =>  [
                    "required",
                    "json",
                ],

            ]);
            if($validator->fails()){
                $resp = response(['result'=>-1,"msg"=>$validator->errors()->first(),'error' => $validator->errors() ,"function"=>__FUNCTION__,"data"=>$data],400);
                $request = new Request();
                $request['log_type'] = 'Takisik_Maintenance_validation_error';
                $request['data'] = $resp->getContent();
                $this->send_data_to_maintenance($request);
                return $resp;
            }
            $create_data = array();
            $create_data['log_type'] = $data['log_type'];
            $create_data['data'] = $data['data'];


            $record_id = MaintenanceLog::create($create_data)->record_id;

            return  response(['result'=>1,'record_id'=>$record_id],200);


        }catch (\Throwable $t) {

            $resp = response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,'given_data'=>$data['data'],'given_type'=>$data['log_type']],500);
            $req = new Request();
            $req['log_type'] = 'Takisik_Maintenance_500_error';
            $req['data'] = $resp->getContent();
            $this->send_data_to_maintenance($req);
            return $resp;

        }
    }

    public function send_data_to_statistics(Request $request){

        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'event_name' =>  [
                    "required",
                    "string",
                ],
                'data' =>  [
                    "required",
                    "json",
                ],
                'requester_id' =>  [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined','NULL', ' ']),
                ],
                'requester_type' =>  [
                    "required",
                    "alpha_dash",
                    Rule::notIn(['null', 'undefined','NULL', ' ']),
                ],
                'requester_ip' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined','NULL', ' ']),
                ]

            ]);
            if($validator->fails()){
                $resp = response(['result'=>-1,"msg"=>$validator->errors()->first(),'error' => $validator->errors() ,"function"=>__FUNCTION__,"data"=>$data],400);
                $request = new Request();
                $request['log_type'] = 'Takisik_Statistics_validation_error';
                if(isset($data['requester_type'])){
                    if(str_contains($data['requester_type'],'test')){
                        $request['log_type'] = $data['requester_type'];
                    }
                }
                $request['data'] = $resp->getContent();
                $this->send_data_to_maintenance($request);
                return $resp;
            }

            $ip_address = $data['requester_ip'];
            $json_location =   @file_get_contents("http://ipinfo.io/$ip_address/geo");

            $json_location = json_decode($json_location, true);
            if(isset($json_location["city"]) ){

                $data['country']  = $json_location['country'];
                $data['region']   = $json_location['region'];
                $data['city']  = $json_location['city'];

                //return response(['result' => -1, 'msg' => json_encode($json_location)], 201);
            }


            try{

                TakisikStatistics::create($data);

            }catch(QueryException $e){

                $response = response(['result' => -500, 'msg' => "Something went wrong","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                $request = new Request();
                $request['log_type'] = 'Takisik_Admin_query_error';
                $request['data'] = $response->getContent();
                $maintenance_controller = new GeneralController;
                $maintenance_controller->send_data_to_maintenance($request);
                return $response;
            }

            return response(['result' => 1, 'msg' => 'Success'], 200);

        }
        catch (\Throwable $t) {

            $resp = response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__],500);
            $request = new Request();
            $request['log_type'] = 'MGMT_Statistics_500_error';
            $request['data'] = $resp->getContent();
            $maintenance_controller = new GeneralController;
            $maintenance_controller->send_data_to_maintenance($request);
            if(env('APP_ENV') == 'local'){
                return $resp;
            }
            return response(['result' => -500, 'msg' => "Something went wrong. Contact with developer. "], 500);
        }


    }
}
