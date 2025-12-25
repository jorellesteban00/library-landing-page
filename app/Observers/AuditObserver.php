<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    /**
     * Handle the "created" event.
     */
    public function created(Model $model): void
    {
        AuditLog::log('created', $model);
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Model $model): void
    {
        $oldValues = array_intersect_key(
            $model->getOriginal(),
            $model->getDirty()
        );

        AuditLog::log('updated', $model, $oldValues);
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Model $model): void
    {
        AuditLog::log('deleted', $model, $model->getOriginal());
    }
}
