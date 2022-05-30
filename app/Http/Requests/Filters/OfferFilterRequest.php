<?php

namespace App\Http\Requests\Filters;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class OfferFilterRequest extends FormRequest implements Filter
{
    public function filter(Builder $builder)
    {

        $props = $this->all();

        if(isset($props['name'])) {
            $builder->where('name', 'like', '%'.$props['name'].'%');
        }

        if(isset($props['dateFrom']) or isset($props['dateTo'])){
            // if only one date is set, we need to set the other one as well, so it will be a valid range
            $dateFrom = $props['dateFrom'] ?? $props['dateTo'];
            $dateTo = $props['dateTo'] ?? $props['dateFrom'];


            // if dateForm and dateTo are set, we look for the offers where any reservation overlaps with the date range
            $builder->whereHas('rooms', function (Builder $builder) use ($dateTo, $dateFrom) {
                $builder->whereDoesntHave('reservations', function (Builder $builder) use ($dateTo, $dateFrom) {
                    $builder->where('date_from', '<', $dateTo)
                        ->Where('date_to', '>', $dateFrom);
                });
            });
        }

        if(isset($props['place'])) {
            $builder->where('place', 'like', '%'.$props['place'].'%');
        }

        if(isset($props['accommodationType'])) {
            $builder->where('accommodationType', 'like', '%'.$props['accommodationType'].'%');
        }

        if(isset($props['priceFrom'])) {
            $builder->whereHas('rooms', function (Builder $builder) use ($props) {
                $builder->where('price', '>=', $props['priceFrom']);
            });
        }

        if(isset($props['priceTo'])) {
            $builder->whereHas('rooms', function (Builder $builder) use ($props) {
                $builder->where('price', '<=', $props['priceTo']);
            });
        }

        if(isset($props['peopleAmount'])) {
            $builder->whereHas('rooms', function (Builder $builder) use ($props) {
                $builder->where('beds_amount', '>=', $props['peopleAmount']);
            });
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
