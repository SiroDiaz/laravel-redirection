<?php

namespace SiroDiaz\Redirection\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface RedirectionModelContract
{
    /**
     * @param string $value
     */
    public function setOldUrlAttribute(string $value);

    /**
     * @param string $value
     */
    public function setNewUrlAttribute(string $value);

    /**
     * @param Builder $query
     * @param string $url
     * @return Builder
     */
    public function scopeWhereOldUrl(Builder $query, string $url): Builder;

    /**
     * @param Builder $query
     * @param string $url
     * @return Builder
     */
    public function scopeWhereNewUrl(Builder $query, string $url): Builder;

    /**
     * @return array
     */
    public static function getStatuses(): array;

    /**
     * @param RedirectionModelContract $model
     * @param string $finalUrl
     * @return void
     */
    public function syncOldRedirects(self $model, string $finalUrl): void;

    /**
     * @param string $path
     * @return RedirectionModelContract|null
     */
    public static function findValidOrNull(string $path): ?RedirectionModelContract;
}
