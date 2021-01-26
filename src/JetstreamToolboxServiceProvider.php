<?php

namespace ActiveGenerator\JetstreamToolbox;

use ActiveGenerator\Core\Collections\BaseCollection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use ActiveGenerator\JetstreamToolbox\Console\PublishCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JetstreamToolboxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            PublishCommand::class
        ]);
    }

    public function boot(Filesystem $filesystem)
    {

        Builder::macro('search', function ($fields = [], $string) {
            if (!$string) return $this;

            $strings = explode(" ", $string);

            $query = $this;

            foreach ($strings as $string) {
                $query = $query->where(function ($query) use ($fields, $string) {
                    foreach ($fields as $field) {
                        if (str_contains($field, ".")) {
                            $relation = Str::before($field, '.');
                            $field = Str::after($field, '.');

                            $query = $query->with($relation)
                                ->orWhereHas($relation, function ($query) use ($field, $string) {
                                    $query->where($field, 'LIKE', '%' . $string . '%');
                                });
                        } else {
                            $query = $query->orWhere($field, 'like', '%' . $string . '%');
                        }
                    }
                });
            }

            return $query;
        });

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"' . $thing . '"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });

        /**
         * Detach any models not in the given array and attach any new models.
         *
         * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model|array $ids
         * @param bool $detaching
         *
         * @return array
         */
        HasMany::macro('sync', function ($ids, bool $detaching = true): array {
            $changes = [
                'attached' => [], 'detached' => [], 'updated' => [],
            ];

            $results = $this->getResults();

            $current = $results ? ($results instanceof Model ? [$results->getKey()] : $results->modelKeys()) : [];
            $records = $this->parseIds($ids);

            $detach = array_diff($current, $records);

            if ($detaching && count($detach) > 0) {
                $this->detach($detach);

                $changes['detached'] = $detach;
            }

            $changes = array_merge(
                $changes,
                $this->syncNew($records, $current)
            );

            return $changes;
        });

        /**0
         * Get all of the IDs from the given mixed value.
         *
         * @param mixed $value
         *
         * @return array
         */
        HasMany::macro('parseIds', function ($value) {
            if ($value instanceof Model) {
                return [$value->{$this->relatedKey}];
            }

            if ($value instanceof Collection) {
                return $value->pluck($this->relatedKey)->all();
            }

            if ($value instanceof BaseCollection) {
                return $value->toArray();
            }

            return (array) $value;
        });

        HasMany::macro('detach', function (array $detach): void {
            $related = $this->getRelated();

            $models = $related::withoutGlobalScopes()->findMany($detach);

            $models->each(function (Model $model): void {
                $model->{$this->getForeignKeyName()} = null;
                $model->save();
            });
        });

        /**
         * Attach all of the records that aren't in the given current records.
         *
         * @param array $records
         * @param array $current
         * @param bool $touch
         *
         * @return array
         */
        HasMany::macro('syncNew', function (array $records, array $current): array {
            $changes = ['attached' => [], 'updated' => []];

            $related = $this->getRelated();

            $models = $related::withoutGlobalScopes()->findMany($records);

            $this->saveMany($models);

            foreach ($models as $model) {
                if (!in_array($model->getKey(), $current)) {
                    $changes['attached'][] = $model->getKey();
                } else {
                    $changes['updated'][] = $model->getKey();
                }
            }

            return $changes;
        });


        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'box');

        $views = [
            __DIR__ . '/../resources/views' => resource_path('views/vendor/jetstream-toolbox'),
        ];

        $this->publishes($views, 'views');

        $this->publishes(array_merge($views), 'all');
    }
}
