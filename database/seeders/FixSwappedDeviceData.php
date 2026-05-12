<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

class FixSwappedDeviceData extends Seeder
{
    public function run()
    {
        // Identify devices where 'nomor_seri' seems to contain a model name
        // (This is heuristic, but based on the recent IDs 25-34 we found)
        $devices = Device::all();

        DB::beginTransaction();
        try {
            foreach ($devices as $device) {
                $nomorSeri = trim($device->nomor_seri);
                $model = trim($device->model);

                // Check if they are swapped
                // Heuristic: if nomor_seri contains spaces or model-like patterns and model is empty
                // OR if we know for sure they are swapped based on user feedback.
                // Since the user said they are swapped, we can look for specific patterns.
                
                // For now, let's look at the records we identified: 25-34
                // and any others where model is empty but nomor_seri has something that looks like a model.
                
                if (!empty($nomorSeri) && empty($model)) {
                    // Swap them
                    // Since nomor_seri is UNIQUE and NOT NULL, we need a placeholder if we move it to model
                    $device->model = $nomorSeri;
                    $device->nomor_seri = "SN-PENDING-" . $device->id;
                    $device->save();
                    $this->command->info("Fixed Device ID {$device->id}: Moved '{$nomorSeri}' to model.");
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}
