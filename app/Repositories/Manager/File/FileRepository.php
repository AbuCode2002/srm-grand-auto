<?php

namespace App\Repositories\Manager\File;

use App\Http\Controllers\Manager\File\Data\FileDeleteData;
use App\Models\Order;
use App\Models\OrderFile;
use App\Repositories\BaseRepository;
use DateTime;
use Illuminate\Support\Facades\Storage;

class FileRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = OrderFile::class;
    }

    public function acceptOrRejectFile(int $orderId, FileDeleteData $data)
    {
        $order = Order::query()->findOrFail($orderId);

        $orderFiles = OrderFile::query()->where('order_id', $orderId);

        if ($data->result === 'rejected') {

            foreach ($orderFiles->get() as $orderFile) {
                $path = $orderFile->file_name;

                Storage::disk('s3')->delete($path);

                $orderFiles->delete();
            }
        } elseif ($data->result === 'accepted') {
            $createdAt = $orderFiles->value('created_at');

            $dateNow = new DateTime();

            if (date_diff($dateNow, $createdAt)->h < 24) {
                $order->kpi3 = 1;
                $order->save();
            }
        }
    }
}
