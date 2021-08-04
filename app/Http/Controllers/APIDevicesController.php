<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;
use App\User;
use App\Client;
use App\Gallery;
use App\Site;
use App\Schedule;
use App\Flow;
class APIDevicesController extends Controller
{
    public function index(Request $request) {

        if (empty($request->all()) || $request->filled("google") || $request->filled("flow") || $request->filled("site") || $request->filled("schedule")) {
            $data = [];
			if ($request->filled('title') && $request->title == "off") {
                $data['title'] = 'off';
            }
            if ($request->filled('clientname')) {
                $client = Client::where('name', $request->clientname)->first();

                if (!empty($client)) {
                    if ($client->users->isNotEmpty()) {
                        foreach ($client->users as $user) {

                            if (!empty($user)) {

                                if ($request->filled("google")) {
                                    $gallery = Gallery::where('user_id', $user->id)->where('name', $request->google)->first();
                                    if ($gallery) {
                                        $data['google_images'] = $gallery->sync_google_images;
    									$data['label'] = "";
                                        if ($gallery->sync_google_images()->first()) {
                                            $data['label'] = $gallery->sync_google_images()->first()->title;
                                        }
                                    }

                                    return view('google_gallery', ['data' => $data]);
                                } elseif ($request->filled("site")) {

                                    $data['site'] = Site::where('user_id', $user->id)->where('name', $request->site)->first();

                                    return view('site', $data);
                                } elseif ($request->filled("schedule")) {
									
									
									$data['schedules'] = Schedule::where('user_id', $user->id)->where('name', $request->schedule)->orderBy('date')->orderBy('time')->get();
									
                                    return view('schedule', $data);
                                } elseif ($request->filled("flow")) {
                                    
                                    $flow = Flow::where('name', $request->flow)->first();
                                    $flow_entries  = $flow->flow_entries()->whereDate('run_from', '<=', date('d.m.Y'))->whereDate('run_to', '>=', date('d.m.Y'))->get();

                                    foreach ($flow_entries as $flow_entry) {
                                        if ($flow_entry->flow_entriable_type == "App\Gallery") {
                                            $gallery = Gallery::find($flow_entry->flow_entriable_id);
                                            if ($gallery) {
                                                $data['google_images'][$flow_entry->id] = $gallery->sync_google_images;
                                            }
                                        } elseif ($flow_entry->flow_entriable_type == "App\Site") {
                                            $data['sites'][$flow_entry->id] = Site::find($flow_entry->flow_entriable_id);
                                        } elseif ($flow_entry->flow_entriable_type == "App\Schedule") {
                                            $data['schedules'][$flow_entry->id] = Schedule::where('name', $flow_entry->flow_entriable_id)->orderBy('date')->orderBy('time')->get();
                                        }
                                    }
                                    return view('flow', ['data' => $data]);
                                }
                                // dd($data);
                            }


                        }
                    }
                }
            }
            return view('welcome', ['data' => $data]);
        }
		
		date_default_timezone_set('Europe/Berlin');
        $current_timestamp = date('Y-m-d H:i:s');
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $current_ip = $_SERVER['HTTP_CLIENT_current_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $current_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $current_ip = $_SERVER['REMOTE_ADDR'];
        }

        switch ($request->api){
            case "register":

                if (!$request->filled('device_code')) {
                    return "Error: Device register";
                }

                $device = Device::where("device_code", $request->device_code)->first();
                
                if (empty($device)) {

                    $device = new Device();
                    $device->device_code = $request->device_code;
                    // $device->user_id
                    $device->enabled = 0;
                    $device->timestamp_registered = $current_timestamp;
                    // $device->eMail_of_admin
                    // $device->configuration
                    // $device->device_up_time
                    // $device->device_down_time
                    // $device->device_heartbeat_minutes
                    $device->timestamp_last_accessed = $current_timestamp;
                    $device->ip_address_of_last_access = $current_ip;
                    $device->save();

                    return response()->json(["info" => "New device registered, please wait for enabling"]);
                } else if($device->enabled) {
					if ($device->client_id) {
	                    return response()->json(["id"=>$device->client_id]);
					} else {
						return response()->json(["error" => "Not assign client"]);
					}
                }
                return response()->json(["error" => "Not yet enabled"]);

                break;
            case "setup":

               
                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

				
                $device = Device::select("device_code", "client_id", "enabled", "timestamp_registered", "eMail_of_admin", "configuration", "device_up_time", "device_down_time", "device_heartbeat_minutes", "timestamp_last_accessed", "ip_address_of_last_access")->where('device_code', $request->device_code)->where('client_id', $request->client_id)->first();
				
				if (empty($device)) {
					return response()->json(["error" => "Not register"]);
				}
				
                return response()->json(["configuration" => $device->configuration]);

                break;
            case "heartbeat":

                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

                $device = Device::where("device_code", $request->device_code)->where("client_id", $request->client_id)->first();

                if (empty($device)) {
                    return response()->json(["error" => "Not register"]);
                }
				
                $device->timestamp_last_accessed = $current_timestamp;

                // if ($request->filled("ip_address_of_last_access")) {
                //     $device->ip_address_of_last_access = $request->ip_address_of_last_access;
                // }

                $device->save();

				return response()->json([
					'status' => 'ok',
				]);
        }
    }
}
