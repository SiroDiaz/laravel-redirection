<?php

namespace SiroDiaz\Redirection\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use SiroDiaz\Redirection\Contracts\RedirectionModelContract;
use SiroDiaz\Redirection\Exceptions\RedirectionException;

/**
 * @property string $old_url
 * @property string $new_url
 * @property int $status_code
 */
class Redirection extends Model implements RedirectionModelContract
{
    protected $table = 'redirections';

    public $timestamps = true;

    protected $fillable = [
        'old_url',
        'new_url',
        'status_code',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(static function (self $model) {
            if (strtolower(trim($model->old_url, '/')) === strtolower(trim($model->new_url, '/'))) {
                throw RedirectionException::sameUrls();
            }

            // to prevent a redirection loop, we delete all that conflicting url
            static::whereOldUrl($model->new_url)->whereNewUrl($model->old_url)->delete();


            $model->syncOldRedirects($model, $model->new_url);
        });
    }

    /**
     * Get all redirect statuses defined inside the "config/redirects.php" file.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return (array) config('redirection.statuses', []);
    }

    /**
     * Filter the query by an old url.
     *
     * @param Builder $query
     * @param string $url
     *
     * @return Builder
     */
    public function scopeWhereOldUrl(Builder $query, string $url): Builder
    {
        return $query->where('old_url', config('redirection.case-sensitive') ? $url : strtolower($url));
    }

    /**
     * Filter the query by a new url.
     *
     * @param Builder $query
     * @param string $url
     *
     * @return Builder
     */
    public function scopeWhereNewUrl(Builder $query, string $url): Builder
    {
        return $query->where('new_url', config('redirection.case-sensitive') ? $url : strtolower($url));
    }

    /**
     * The mutator to set the "old_url" attribute.
     *
     * @param string $value
     * @returns void
     */
    public function setOldUrlAttribute(string $value): void
    {
        $value = trim(parse_url($value)['path'], '/');
        $this->attributes['old_url'] = config('redirection.case-sensitive') ? $value : strtolower($value);
    }

    /**
     * The mutator to set the "new_url" attribute.
     *
     * @param string $value
     * @returns void
     */
    public function setNewUrlAttribute(string $value): void
    {
        $value = trim(parse_url($value)['path'], '/');
        $this->attributes['new_url'] = config('redirection.case-sensitive') ? $value : strtolower($value);
    }

    /**
     * Sync old redirects to point to the new (final) url.
     *
     * @param RedirectionModelContract $model
     * @param string $finalUrl
     * @return void
     */
    public function syncOldRedirects(RedirectionModelContract $model, string $finalUrl): void
    {
        $items = static::whereNewUrl($model->old_url)->get();

        foreach ($items as $item) {
            $item->update(['new_url' => $finalUrl]);
            $item->syncOldRedirects($model, $finalUrl);
        }
    }

    /**
     * Return a valid redirect entity for a given path (old url).
     * A redirect is valid if:
     * - it has an url to redirect to (new url)
     * - it's status code is one of the statuses defined on this model.
     *
     * @param string $path
     * @return Redirection|null
     */
    public static function findValidOrNull(string $path): ?Redirection
    {
        $path = ($path === '/' ? $path : trim($path, '/'));

        return static::where('old_url', config('redirection.case-sensitive') ? $path : strtolower($path))
            ->whereNotNull('new_url')
            ->whereIn('status_code', array_keys(self::getStatuses()))
            ->latest()
            ->first();
    }
}
