<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

trait Meeting
{
    public $client;
    public $jwt;
    public $headers;
    private $api_url = 'https://api.zoom.us/v2/';

    public function generateZoomAccessToken()
    {
        $this->client = new Client();

        $apiKey     = env('ZOOM_CLIENT_KEY');
        $apiSecret  = env('ZOOM_CLIENT_SECRET');
        $account_id = env('ZOOM_ACCOUNT_ID');

        $base64Credentials = base64_encode("$apiKey:$apiSecret");

        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $account_id;

        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials",
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])->post($url);

        $responseData = $response->json();

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            \Log::error('Zoom OAuth Token Response: ' . json_encode($responseData));
            return null;
        }
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());

            return '';
        }
    }

    public function createMeet($data)
    {
        try {
            $res['success'] = false;
            $accessToken    = $this->generateZoomAccessToken();

            $post_time  = $data['start_date'] . " " . date("H:i:s", strtotime($data['start_time']));
            $start_time = date("Y-m-d\TH:i:s", strtotime($post_time));
            $duracion   = $data['duration_h'] + $data['duration_m'];
            // $doctor = User::findOrfail(auth()->user()->id);

            $url = 'https://api.zoom.us/v2/users/me/meetings';
            // $url = 'https://api.zoom.us/v2/users/'.$doctor->zoom_id.'/meetings';

            $createAMeetingArray['topic']      = $data['topic'];
            $createAMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
            $createAMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
            $createAMeetingArray['start_time'] = $start_time;
            $createAMeetingArray['timezone']   = $data['timezone'];
            $createAMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
            $createAMeetingArray['duration']   = $duracion;
            $createAMeetingArray['settings']   = array(
                'join_before_host'  => !empty($data['join_before_host']) ? true : false,
                'host_video'        => !empty($data['host_video']) ? true : false,
                'participant_video' => !empty($data['participant_video']) ? true : false,
                'mute_upon_entry'   => !empty($data['mute_upon_entry']) ? true : false,
                // 'enforce_login' => !empty($data['enforce_login']) ? true : false,
                'auto_recording'    => !empty($data['auto_recording']) ? $data['auto_recording'] : "none",
                'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : "",
            );

            $response = Http::withToken($accessToken)->post($url, $createAMeetingArray);

            if ($response->successful()) {
                $res['success'] = $response->getStatusCode() === 201;
                $res['meeting'] = json_decode($response->getBody(), true);
            } else {
                $res['success'] = $response->getStatusCode() === 201;
                $res['meeting'] = json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            $res['exception'] = $e->getMessage();
        }

        return $res;
    }

    public function updateMeet($id, $data)
    {
        $accessToken = $this->generateZoomAccessToken();
        $url         = 'https://api.zoom.us/v2/meetings/' . $id;

        $response = Http::withToken($accessToken)->patch($url, [
            'topic'      => 'Online Meeting',
            'type'       => self::MEETING_TYPE_SCHEDULE,
            'start_time' => $this->toZoomTimeFormat($data['start_time']),
            'duration'   => $data['duration'],
            'agenda'     => (!empty($data['agenda'])) ? $data['agenda'] : null,
            'timezone'   => 'Africa/Cairo',
        ]);

        if ($response->successful()) {
            // Meeting updated successfully
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } else {
            // Handle the error
            return response()->json(['error' => 'Failed to update the Zoom meeting'], 500);
        }
    }

    public function getMeet($id)
    {

        $url         = 'https://api.zoom.us/v2/meetings/' . $id;
        $accessToken = $this->generateZoomAccessToken();

        $response = Http::withToken($accessToken)->get($url);
        // $response =  $this->client->get($url . $path, $body);

        return [
            'success' => $response->getStatusCode() === 200,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */

    public function deleteMeet($id)
    {
        $accessToken = $this->generateZoomAccessToken();
        $url         = 'https://api.zoom.us/v2/meetings/' . $id;

        $response = Http::withToken($accessToken)->delete($url);

        if ($response->successful()) {
            // Meeting deleted successfully
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } else {
            // Handle the error
            return response()->json(['error' => 'Failed to delete the Zoom meeting'], 500);
        }
    }
}
