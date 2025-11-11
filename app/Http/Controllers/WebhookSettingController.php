<?php

namespace App\Http\Controllers;

use App\Http\Requests\webhook\UpdateWebhookSettingRequest;
use App\Models\WebhookSetting;
use Illuminate\Http\Request;

class WebhookSettingController extends Controller
{

    public function updateWebhooks(UpdateWebhookSettingRequest $request)
    {
        // Get validated data
        $data = $request->validated();

        WebhookSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Webhook settings updated successfully!');
    }

}
